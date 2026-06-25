<?php
/**
 * Poriot AI Builder — API Proxy
 * Default: Android ChatGPT endpoint (no key needed). Env-overridable. Groq fallback.
 *
 * ENV VARS (set in Railway dashboard → Variables):
 *   API_URL       - Override endpoint (default: Android ChatGPT internal API)
 *   API_KEY       - API key (leave empty for Android endpoint; set for custom endpoints)
 *   API_MODEL     - Model name shown in badge (default: gpt-4o-mini)
 *   FALLBACK_KEY  - Groq/fallback API key ← this is all you need to set for free working
 *   FALLBACK_URL  - Default: https://api.groq.com/openai/v1/chat/completions
 *   FALLBACK_MODEL- Default: llama-3.3-70b-versatile
 */

error_reporting(0);
ini_set('display_errors', '0');

$action   = $_GET['action'] ?? '';
$isUpload = ($action === 'upload');
$isConfig = ($action === 'config');
$isStream = ($_GET['stream'] ?? '') === '1';

// ── Config ─────────────────────────────────────────────────────────────────
$PRIMARY_URL    = getenv('API_URL') ?: 'https://android.chat.openai.com/backend-api/f/conversation';
$PRIMARY_KEY    = getenv('API_KEY') ?: '';
$PRIMARY_MODEL  = getenv('API_MODEL') ?: 'gpt-4o-mini';
$FALLBACK_URL   = getenv('FALLBACK_URL') ?: 'https://api.groq.com/openai/v1/chat/completions';
$FALLBACK_KEY   = getenv('FALLBACK_KEY') ?: '';
$FALLBACK_MODEL = getenv('FALLBACK_MODEL') ?: 'llama-3.3-70b-versatile';

// Detect if using standard OpenAI API vs Android endpoint
$IS_OPENAI = str_contains($PRIMARY_URL, 'chat/completions');

function cors() {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }
}
function sendJSON(int $code, array $data): void {
    if (headers_sent()) return;
    http_response_code($code);
    header('Content-Type: application/json');
    cors();
    echo json_encode($data);
    exit;
}
function uuid(): string {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0,0xffff),mt_rand(0,0xffff),mt_rand(0,0xffff),
        mt_rand(0,0x0fff)|0x4000,mt_rand(0,0x3fff)|0x8000,
        mt_rand(0,0xffff),mt_rand(0,0xffff),mt_rand(0,0xffff));
}

// ── Build Android payload (original format) ────────────────────────────────
function buildAndroidPayload(string $prompt, string $system, array $history): string {
    $msgs = [];
    $msgs[] = ['id' => uuid(), 'author' => ['role' => 'system'], 'content' => ['content_type' => 'text', 'parts' => [$system]], 'status' => 'finished_successfully'];
    foreach ($history as $h) {
        $msgs[] = ['id' => uuid(), 'author' => ['role' => $h['role'] ?? 'user'], 'content' => ['content_type' => 'text', 'parts' => [$h['content'] ?? '']], 'status' => 'finished_successfully'];
    }
    $msgs[] = ['id' => uuid(), 'author' => ['role' => 'user'], 'content' => ['content_type' => 'text', 'parts' => [$prompt]], 'status' => 'finished_successfully'];
    return json_encode([
        'action' => 'next', 'messages' => $msgs, 'model' => 'auto', 'parent_message_id' => uuid(),
        'stream' => true, 'max_tokens' => 4096, 'timezone' => 'Africa/Cairo', 'timezone_offset_min' => -180,
    ]);
}

function androidHeaders(): array {
    return [
        'User-Agent: ChatGPT/1.2027.000 (Android 15; RMX3834; build 2700000)',
        'Accept: application/json', 'Accept-Encoding: gzip', 'Content-Type: application/json',
        'oai-package-name: com.Modderme', 'oai-client-type: android',
        'oai-device-id: 84329164059103383964',
        'accept-language: en-US,en;q=0.9,ar-EG;q=0.8,ar;q=0.7',
        'x-device-tier: lower_mid', 'chatgpt-account-id: 84329164059103383964',
        'chatgpt-residency-region: no_constraint',
        'Conduit-Token: ', 'x-oai-convo-session-id: ' . uuid(), 'x-oai-turn-trace-id: ' . uuid(),
        'x-openai-target-path: /backend-api/f/conversation',
    ];
}

// ── Build OpenAI-compatible payload (for overridden URL or fallback) ───────
function buildOpenAIPayload(string $prompt, string $system, array $history, string $model): string {
    $msgs = [['role' => 'system', 'content' => $system]];
    foreach ($history as $h) $msgs[] = ['role' => $h['role'] ?? 'user', 'content' => $h['content'] ?? ''];
    $msgs[] = ['role' => 'user', 'content' => $prompt];
    return json_encode(['model' => $model, 'messages' => $msgs, 'stream' => true, 'max_tokens' => 4096]);
}

// ── cURL call ──────────────────────────────────────────────────────────────
function callAPI(string $url, ?string $key, string $payload, bool $stream, ?array $extraHeaders = null): array {
    $ch = curl_init();
    $headers = $extraHeaders ?? ['Content-Type: application/json'];
    if ($key) $headers[] = 'Authorization: Bearer ' . $key;
    curl_setopt_array($ch, [
        CURLOPT_URL => $url, CURLOPT_POST => true, CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => $headers, CURLOPT_TIMEOUT => 300, CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => true, CURLOPT_FOLLOWLOCATION => true, CURLOPT_MAXREDIRS => 3,
    ]);
    if ($stream) {
        $output = '';
        curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $chunk) use (&$output) {
            echo $chunk; flush(); $output .= $chunk; return strlen($chunk);
        });
        curl_exec($ch);
    } else {
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
    }
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err = curl_error($ch);
    curl_close($ch);
    return ['http' => $http, 'body' => $output, 'error' => $err];
}

// ── MODE: Config ───────────────────────────────────────────────────────────
if ($isConfig) {
    header('Content-Type: application/json; charset=utf-8');
    cors();
    echo json_encode(['model' => $PRIMARY_MODEL]);
    exit;
}

// ── MODE: Upload ───────────────────────────────────────────────────────────
if ($isUpload) {
    cors();
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') sendJSON(405, ['error' => 'Method not allowed']);
    if (empty($_FILES['file'])) sendJSON(400, ['error' => 'No file uploaded']);
    $file = $_FILES['file'];
    if ($file['error'] !== UPLOAD_ERR_OK) sendJSON(400, ['error' => 'Upload error: ' . $file['error']]);
    if ($file['size'] > 10*1024*1024) sendJSON(413, ['error' => 'File too large (max 10MB)']);
    $uploadDir = __DIR__ . '/uploads';
    if (!is_dir($uploadDir) && !@mkdir($uploadDir, 0755, true))
        sendJSON(500, ['error' => 'Create uploads/ dir (755 permissions)']);
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $safeName = uuid() . ($ext ? '.' . $ext : '');
    $dest = $uploadDir . '/' . $safeName;
    if (!move_uploaded_file($file['tmp_name'], $dest))
        sendJSON(500, ['error' => 'Failed to save file. Check uploads/ permissions.']);
    $url = 'uploads/' . $safeName;
    $textContent = '';
    $textExts = ['txt','html','css','js','json','xml','php','py','rb','go','rs','ts','jsx','tsx','sql','sh','bash','yaml','yml','md','csv','env','ini','toml'];
    if (in_array(strtolower($ext), $textExts)) {
        $textContent = file_get_contents($dest);
        if (strlen($textContent) > 50000) $textContent = substr($textContent, 0, 50000) . "\n\n[...truncated]";
    }
    sendJSON(200, ['url' => $url, 'name' => $file['name'], 'size' => $file['size'], 'type' => $file['type'], 'textContent' => $textContent]);
}

// ── MODE: Stream ───────────────────────────────────────────────────────────
if ($isStream) {
    cors();
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    header('Connection: keep-alive');
    header('X-Accel-Buffering: no');
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;

    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    if (!$data || empty($data['prompt'])) { echo "data: " . json_encode(['error' => 'Missing prompt']) . "\n\n"; flush(); exit; }

    $prompt = trim($data['prompt']);
    $system = $data['system_prompt'] ?? 'You are an expert programming assistant. Help users write clean, efficient, well-documented code. Provide explanations when helpful. When writing code, always specify the language in a markdown code block.';
    $history = $data['history'] ?? [];

    // ── Primary call ───────────────────────────────────────────────────
    if ($IS_OPENAI) {
        $payload = buildOpenAIPayload($prompt, $system, $history, $PRIMARY_MODEL);
        $res = callAPI($PRIMARY_URL, $PRIMARY_KEY, $payload, true);
    } else {
        $payload = buildAndroidPayload($prompt, $system, $history);
        $res = callAPI($PRIMARY_URL, null, $payload, true, androidHeaders());
    }

    $failed = ($res['error'] !== '' || $res['http'] < 200 || $res['http'] >= 300);

    // ── Fallback to Groq ───────────────────────────────────────────────
    if ($failed && !empty($FALLBACK_KEY)) {
        $fbPayload = buildOpenAIPayload($prompt, $system, $history, $FALLBACK_MODEL);
        $res = callAPI($FALLBACK_URL, $FALLBACK_KEY, $fbPayload, true);
        if ($res['error'] || $res['http'] < 200 || $res['http'] >= 300) {
            $err = $res['error'] ?: "HTTP {$res['http']}";
            echo "data: " . json_encode(['type' => 'error', 'error' => "Fallback failed: $err"]) . "\n\n";
        }
    } elseif ($failed) {
        $err = $res['error'] ?: "HTTP {$res['http']}";
        echo "data: " . json_encode(['type' => 'error', 'error' => "API error: $err"]) . "\n\n";
    }

    echo "data: [DONE]\n\n";
    flush();
    exit;
}

// ── MODE: Non-streaming (legacy) ───────────────────────────────────────────
cors();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') sendJSON(405, ['error' => 'Method not allowed']);
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!$data || empty($data['prompt'])) sendJSON(400, ['error' => 'Missing prompt']);

$prompt = trim($data['prompt']);
$system = $data['system_prompt'] ?? 'You are an expert...';
$history = $data['history'] ?? [];

if ($IS_OPENAI) {
    $payload = buildOpenAIPayload($prompt, $system, $history, $PRIMARY_MODEL);
    $res = callAPI($PRIMARY_URL, $PRIMARY_KEY, $payload, false);
} else {
    $payload = buildAndroidPayload($prompt, $system, $history);
    $res = callAPI($PRIMARY_URL, null, $payload, false, androidHeaders());
}

if ($res['error'] || $res['http'] < 200 || $res['http'] >= 300) {
    if (!empty($FALLBACK_KEY)) {
        $fbPayload = buildOpenAIPayload($prompt, $system, $history, $FALLBACK_MODEL);
        $res = callAPI($FALLBACK_URL, $FALLBACK_KEY, $fbPayload, false);
    }
}
if ($res['error']) sendJSON(500, ['reply' => '', 'error' => $res['error']]);
if ($res['http'] !== 200) sendJSON(500, ['reply' => '', 'error' => "HTTP {$res['http']}: " . substr($res['body'], 0, 300)]);

$reply = '';
foreach (explode("\n", $res['body']) as $line) {
    $line = trim($line);
    if (!str_starts_with($line, 'data: ')) continue;
    $d = json_decode(substr($line, 6), true);
    if (!$d || empty($d['choices'][0]['delta']['content'])) continue;
    $reply .= $d['choices'][0]['delta']['content'];
}
sendJSON(200, ['reply' => $reply, 'conversation_id' => null, 'model' => $PRIMARY_MODEL]);
