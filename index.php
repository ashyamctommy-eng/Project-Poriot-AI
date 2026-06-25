<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Project Poriot AI Builder</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;450;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<style>
/* ── Reset ──────────────────────────────────────────────────────────── */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg:#f8f7f4;
  --surface:#fff;
  --surface-hover:#f3f2ef;
  --sidebar-bg:#f0efeb;
  --border:#e4e2dd;
  --border-light:#eeedea;
  --text:#1a1a2e;
  --text-secondary:#6b6b7b;
  --text-muted:#9a9aab;
  --accent:#4f46e5;
  --accent-light:rgba(79,70,229,0.06);
  --accent-soft:#818cf8;
  --green:#059669;
  --green-bg:rgba(5,150,105,0.06);
  --radius:10px;
  --radius-sm:6px;
  --shadow-sm:0 1px 2px rgba(0,0,0,.04);
  --shadow-md:0 4px 12px rgba(0,0,0,.05);
  --font:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen,Ubuntu,Cantarell,sans-serif;
  --mono:'JetBrains Mono','Fira Code','SF Mono',monospace;
  --sidebar-w:280px;
  --pre-bg:#1a1a2e;
  --pre-text:#e8e8f0;
  --code-inline-bg:rgba(79,70,229,0.08);
}
:root.dark{
  --bg:#0e0e14;
  --surface:#16161f;
  --surface-hover:#1e1e2a;
  --sidebar-bg:#12121a;
  --border:#26263a;
  --border-light:#1e1e30;
  --text:#e4e4f0;
  --text-secondary:#9494aa;
  --text-muted:#64647a;
  --accent:#818cf8;
  --accent-light:rgba(129,140,248,0.1);
  --accent-soft:#6366f1;
  --green:#34d399;
  --green-bg:rgba(52,211,153,0.08);
  --shadow-sm:0 1px 3px rgba(0,0,0,.2);
  --shadow-md:0 4px 16px rgba(0,0,0,.25);
  --pre-bg:#0a0a12;
  --pre-text:#d4d4e8;
  --code-inline-bg:rgba(129,140,248,0.12);
}
html{font-size:16px}
body{font-family:var(--font);background:var(--bg);color:var(--text);min-height:100vh;-webkit-font-smoothing:antialiased;display:flex;transition:background .2s,color .2s}

/* ── Layout ─────────────────────────────────────────────────────────── */
.app-layout{display:flex;width:100%;min-height:100vh}
.container{max-width:760px;margin:0 auto;padding:0 28px;width:100%}

/* ── Sidebar (Gemini-style) ─────────────────────────────────────────── */
.sidebar{width:var(--sidebar-w);background:var(--sidebar-bg);border-right:1px solid var(--border);display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh;z-index:200;transition:transform .25s cubic-bezier(.4,0,.2,1),background .2s,border .2s}
.sidebar-header{padding:16px 18px 10px;display:flex;align-items:center;justify-content:space-between}
.sidebar-brand{display:flex;align-items:center;gap:10px;font-weight:650;font-size:1rem;color:var(--text);letter-spacing:-.02em}
.sidebar-brand svg{color:var(--accent);flex-shrink:0}
.sidebar-close{background:none;border:none;color:var(--text-muted);width:32px;height:32px;border-radius:8px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1.2rem;transition:background .15s}
.sidebar-close:hover{background:var(--surface-hover);color:var(--text)}
/* Nav items group */
.sidebar-nav{display:flex;flex-direction:column;gap:2px;padding:6px 8px}
.nav-item{display:flex;align-items:center;gap:10px;padding:9px 10px;border-radius:8px;font-size:.82rem;font-weight:500;color:var(--text-secondary);text-decoration:none;cursor:pointer;transition:all .15s;border:none;background:none;font-family:var(--font);text-align:left;width:100}
.nav-item svg{flex-shrink:0;width:16px;height:16px}
.nav-item:hover{background:var(--surface-hover);color:var(--text)}
.nav-item.active{background:var(--surface);color:var(--text);box-shadow:var(--shadow-sm)}
.nav-item.active svg{color:var(--accent)}
/* Section label */
.sidebar-section-label{padding:14px 18px 6px;font-size:.68rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em}
/* Chat list */
.sidebar-list{flex:1;overflow-y:auto;padding:4px 8px;scrollbar-width:thin;scrollbar-color:var(--border) transparent}
.sidebar-list::-webkit-scrollbar{width:4px}
.sidebar-list::-webkit-scrollbar-thumb{background:var(--border);border-radius:4px}
.conv-item{display:flex;align-items:center;gap:8px;padding:10px 12px;border-radius:8px;cursor:pointer;transition:background .15s;margin-bottom:2px;font-size:.85rem;color:var(--text-secondary);word-break:break-word}
.conv-item:hover{background:var(--surface-hover)}
.conv-item.active{background:var(--surface);color:var(--text);box-shadow:var(--shadow-sm)}
.conv-item .conv-title{flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;line-height:1.4}
.conv-item .conv-del{opacity:0;background:transparent;border:none;color:var(--text-muted);width:24px;height:24px;border-radius:4px;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all .15s;font-size:1rem;line-height:1}
.conv-item:hover .conv-del{opacity:1}
.conv-item .conv-del:hover{background:#fee2e2;color:#dc2626}
:root.dark .conv-item .conv-del:hover{background:rgba(220,38,38,.15);color:#f87171}
.sidebar-empty{padding:32px 16px;text-align:center;color:var(--text-muted);font-size:.85rem;line-height:1.6}
.sidebar-footer{padding:12px 16px;border-top:1px solid var(--border);font-size:.72rem;color:var(--text-muted);text-align:center}
.sidebar-footer a{color:var(--accent);text-decoration:none}

/* ── Main content flex layout ──────────────────────────────────────── */
.main-content{flex:1;margin-left:var(--sidebar-w);min-height:100vh;display:flex;flex-direction:column}
.main-content .header{flex-shrink:0}
.main-content .main{flex:1;display:flex;flex-direction:column;min-height:0;position:relative}
.chat-section{flex:1;display:flex;flex-direction:column;position:relative;overflow-y:auto;scrollbar-width:thin;scrollbar-color:var(--border) transparent}
.chat-section::-webkit-scrollbar{width:4px}
.chat-section::-webkit-scrollbar-track{background:transparent}
.chat-section::-webkit-scrollbar-thumb{background:var(--border);border-radius:4px}

.sidebar-toggle{display:flex;background:transparent;border:1px solid var(--border);color:var(--text-secondary);width:36px;height:36px;border-radius:8px;cursor:pointer;align-items:center;justify-content:center;flex-shrink:0;transition:border .2s}
.sidebar-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.3);z-index:199}

/* ── Header (Gemini-style) ──────────────────────────────────────────── */
.header{padding:10px 0;background:var(--surface);border-bottom:1px solid var(--border-light);position:sticky;top:0;z-index:100;transition:background .2s,border .2s}
.header-inner{display:flex;align-items:center;gap:10px}
.header-brand{display:flex;align-items:center;gap:8px;font-weight:600;font-size:.95rem;color:var(--text);letter-spacing:-.01em}
.header-brand svg{color:var(--accent);flex-shrink:0}
.header-spacer{flex:1}
.badge-dot{width:5px;height:5px;border-radius:50%;background:var(--green)}
.header-badge{display:flex;align-items:center;gap:5px;font-size:.68rem;color:var(--green);background:var(--green-bg);padding:3px 10px;border-radius:999px;font-weight:600;white-space:nowrap;transition:background .2s}
.header-actions{display:flex;align-items:center;gap:6px;position:relative}
.mode-btn{background:transparent;border:1px solid var(--border);color:var(--text-secondary);padding:4px 10px;border-radius:8px;cursor:pointer;display:flex;align-items:center;gap:4px;font-family:var(--font);font-size:.7rem;font-weight:500;transition:all .15s;flex-shrink:0;white-space:nowrap}
.mode-btn:hover{background:var(--surface-hover);color:var(--accent);border-color:var(--accent)}
.mode-btn.active{background:var(--accent);color:#fff;border-color:var(--accent);box-shadow:0 0 0 2px var(--accent-light)}
.mode-btn svg{flex-shrink:0}
/* Chat mode — hide builder-specific UI */
.chat-mode .hero,
.chat-mode .preset-bar,
.chat-mode .suggestions{display:none!important}
/* WhatsApp-style chat bubble tweaks */
.chat-mode .message-bubble{border-radius:18px!important;max-width:78%!important}
.chat-mode .message.user .message-bubble{border-bottom-right-radius:4px!important}
.chat-mode .message.assistant .message-bubble{border-bottom-left-radius:4px!important}
.chat-mode .message-avatar{width:28px;height:28px;border-radius:50%!important;font-size:.7rem}
.chat-mode .message.user .message-avatar{background:var(--accent)}
.chat-mode .message.assistant .message-avatar{background:var(--surface);border:1px solid var(--border)}

/* ── Hero ───────────────────────────────────────────────────────────── */
.hero{text-align:center;padding:40px 0 20px;flex-shrink:0}
.hero-title{font-size:2rem;font-weight:700;letter-spacing:-.03em;line-height:1.2}
.gradient-text{background:linear-gradient(135deg,var(--accent),#7c3aed);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.hero-desc{color:var(--text-secondary);font-size:.95rem;margin-top:8px;max-width:480px;margin-left:auto;margin-right:auto;line-height:1.7}

/* ── Preset selector ────────────────────────────────────────────────── */
.preset-bar{display:flex;flex-wrap:wrap;gap:5px;justify-content:center;margin-bottom:16px;flex-shrink:0}
.preset-btn{display:inline-flex;align-items:center;gap:4px;background:var(--surface);border:1px solid var(--border-light);color:var(--text-secondary);padding:5px 12px;border-radius:999px;font-size:.75rem;font-family:var(--font);cursor:pointer;transition:all .2s;font-weight:450}
.preset-btn svg{flex-shrink:0}
.preset-btn:hover{border-color:var(--accent);color:var(--accent);background:var(--accent-light)}
.preset-btn.active{background:var(--accent);color:#fff;border-color:var(--accent)}

/* ── Suggestions ────────────────────────────────────────────────────── */
.suggestions{display:flex;flex-wrap:wrap;gap:6px;justify-content:center;margin-bottom:20px;flex-shrink:0}
.suggestion-chip{display:inline-flex;align-items:center;gap:5px;background:var(--surface);border:1px solid var(--border-light);color:var(--text-secondary);padding:6px 14px;border-radius:999px;font-size:.78rem;font-family:var(--font);cursor:pointer;transition:all .2s;white-space:nowrap;font-weight:450}
.suggestion-chip svg{flex-shrink:0}
.suggestion-chip:hover{border-color:var(--accent);color:var(--accent);background:var(--accent-light);box-shadow:var(--shadow-sm)}

/* ── Conversation (Gemini-style scroller) ─────────────────────────── */
.conversation{flex:1;padding:16px 20px 120px;max-width:720px;margin:0 auto;width:100%}
.empty-state{text-align:center;padding:60px 20px 40px;color:var(--text-muted)}
.empty-icon{margin-bottom:14px;opacity:.3;color:var(--text-muted)}
.empty-state h3{font-weight:600;font-size:1rem;margin-bottom:6px;color:var(--text-secondary)}
.empty-state p{font-size:.85rem;color:var(--text-muted)}

/* ── Messages (Gemini-style) ──────────────────────────────────────── */
.message{display:flex;gap:12px;padding:16px 0;animation:fadeIn .25s ease}
@keyframes fadeIn{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}
.message.user{flex-direction:row-reverse}
.message-avatar{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:.72rem;flex-shrink:0;margin-top:4px}
.message.user .message-avatar{background:var(--accent);color:#fff}
.message.assistant .message-avatar{background:var(--surface);border:1px solid var(--border);color:var(--accent);font-size:.85rem}
/* User bubble — compact, colored, right-aligned */
.message.user .message-bubble{background:var(--accent);color:#fff;padding:8px 16px;border-radius:18px 18px 4px 18px;font-size:.88rem;line-height:1.55;max-width:72%;box-shadow:0 1px 4px rgba(0,0,0,.06)}
:root.dark .message.user .message-bubble{box-shadow:0 1px 4px rgba(0,0,0,.18)}
/* Assistant bubble — seamless, no box, on page background */
.message.assistant .message-bubble{background:transparent;padding:0;font-size:.92rem;line-height:1.7;color:var(--text);max-width:100%}
.message-bubble pre{background:var(--pre-bg)!important;color:var(--pre-text);border-radius:10px;padding:14px 16px;margin:14px 0;overflow-x:auto;font-size:.82rem;line-height:1.55;border:none;position:relative}
.message-bubble code{font-family:var(--mono);font-size:.84em}
.message-bubble :not(pre)>code{background:var(--code-inline-bg);color:var(--accent);padding:2px 7px;border-radius:5px;font-size:.84em;font-weight:500}
.copy-btn{position:absolute;top:8px;right:8px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.5);padding:3px 10px;border-radius:5px;font-size:.65rem;cursor:pointer;font-family:var(--font);transition:all .15s;opacity:0}
pre:hover .copy-btn{opacity:1}
.copy-btn:hover{background:rgba(255,255,255,.15);color:#fff}
.stream-cursor::after{content:'▊';animation:cursorBlink .8s infinite;color:var(--accent)}
@keyframes cursorBlink{0%,50%{opacity:1}51%,100%{opacity:0}}
.message-bubble p{margin-bottom:10px}
.message-bubble p:last-child{margin-bottom:0}
.message-bubble ul,.message-bubble ol{margin:8px 0;padding-left:22px}
.message-bubble li{margin-bottom:4px}
.message-bubble h1,.message-bubble h2,.message-bubble h3,.message-bubble h4{margin:18px 0 8px;font-weight:600;color:var(--text)}
.message-bubble h1{font-size:1.25rem}
.message-bubble h2{font-size:1.15rem}
.message-bubble h3{font-size:1.05rem}
.message-bubble strong{font-weight:600}
.message-bubble blockquote{border-left:3px solid var(--accent-soft);padding-left:16px;margin:10px 0;color:var(--text-secondary);font-style:italic}
.message-bubble hr{border:none;border-top:1px solid var(--border-light);margin:16px 0}
.message-bubble table{border-collapse:collapse;width:100%;margin:10px 0;font-size:.84rem}
.message-bubble th,.message-bubble td{border:1px solid var(--border);padding:6px 12px;text-align:left}
.message-bubble th{background:var(--surface-hover);font-weight:600}
.error .message-bubble{background:transparent;color:#dc2626;border:1px solid rgba(220,38,38,.2);border-radius:10px;padding:10px 16px}
:root.dark .error .message-bubble{border-color:rgba(239,68,68,.25);color:#fca5a5}
.message-bubble .file-attach{display:flex;align-items:center;gap:8px;padding:8px 14px;background:var(--accent-light);border-radius:8px;margin:8px 0;font-size:.82rem;color:var(--accent);text-decoration:none}
.message-bubble .file-attach:hover{text-decoration:underline}
.message-bubble .chat-image{max-width:100%;border-radius:12px;margin:6px 0 10px;display:block;box-shadow:var(--shadow-sm)}

/* ── Thinking ───────────────────────────────────────────────────────── */
.thinking{display:flex;align-items:center;gap:10px;padding:8px 0;max-width:160px;margin:4px 0;animation:fadeIn .25s ease}
.thinking-dots{display:flex;gap:4px}
.thinking-dots span{width:5px;height:5px;background:var(--accent);border-radius:50%;animation:bounce 1.4s ease-in-out infinite}
.thinking-dots span:nth-child(2){animation-delay:.2s}
.thinking-dots span:nth-child(3){animation-delay:.4s}
@keyframes bounce{0%,80%,100%{transform:scale(.6);opacity:.4}40%{transform:scale(1);opacity:1}}
.thinking-text{font-size:.78rem;color:var(--text-muted)}

/* ── Input Area (Gemini-style floating capsule) ────────────────────── */
.input-area{flex-shrink:0;position:sticky;bottom:0;padding:12px 20px 20px;background:linear-gradient(to top,var(--bg) 60%,transparent);z-index:50;max-width:760px;margin:0 auto;width:100%;pointer-events:none}
.input-area>*{pointer-events:auto}
.input-form{display:flex;align-items:flex-end;gap:4px;background:var(--surface);border:1px solid var(--border);border-radius:999px;padding:4px 4px 4px 4px;transition:border-color .2s,box-shadow .2s,background .2s;box-shadow:0 2px 12px rgba(0,0,0,.04)}
:root.dark .input-form{box-shadow:0 2px 12px rgba(0,0,0,.15)}
.input-form:focus-within{border-color:var(--accent-soft);box-shadow:0 0 0 3px var(--accent-light),0 2px 16px rgba(0,0,0,.06);background:var(--surface)}
.input-row{display:flex;align-items:flex-end;gap:6px;flex:1}
.prompt-input{flex:1;background:transparent;border:none;outline:none;color:var(--text);font-family:var(--font);font-size:.92rem;padding:9px 4px;resize:none;line-height:1.5;max-height:150px;white-space:pre-wrap;overflow-wrap:break-word;word-break:break-word}
.prompt-input::placeholder{color:var(--text-muted)}
.upload-btn{background:transparent;border:none;color:var(--text-muted);width:34px;height:34px;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .18s;flex-shrink:0}
.upload-btn svg{width:18px;height:18px}
.upload-btn:hover{background:var(--surface-hover);color:var(--accent);transform:scale(1.1)}
.send-btn{background:var(--accent);border:none;color:#fff;width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .25s;flex-shrink:0}
.send-btn:hover:not(:disabled){background:#4338ca;transform:scale(1.08)}
:root.dark .send-btn:hover:not(:disabled){background:#6366f1}
.send-btn:disabled{background:var(--border);color:var(--text-muted);opacity:.5;cursor:not-allowed;transform:none}
.send-btn:disabled svg{opacity:.4}
.send-btn.loading svg{animation:spin .8s linear infinite;opacity:0;width:0;height:0}
.send-btn.loading{position:relative}
.send-btn.loading::after{content:'';position:absolute;width:16px;height:16px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .8s linear infinite}
@keyframes spin{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}
.footer-credit{text-align:center;color:var(--text-muted);font-size:.72rem;margin-top:6px;padding-bottom:2px;font-weight:450}
.footer-credit a{color:var(--accent);text-decoration:none;font-weight:500}
.footer-credit a:hover{text-decoration:underline}

/* ── Thinking dots ──────────────────────────────────────────────────── */
.thinking-dots{display:flex;gap:4px}
.fab-wrap{position:fixed;bottom:90px;right:16px;z-index:150;display:flex;flex-direction:column;align-items:center;gap:8px}
.fab-btn{width:48px;height:48px;border-radius:50%;border:none;background:var(--accent);color:#fff;font-size:1.3rem;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:var(--shadow-md);transition:all .2s;font-family:var(--font);position:relative}
.fab-btn:hover{transform:scale(1.05);box-shadow:0 6px 24px rgba(79,70,229,.35)}
:root.dark .fab-btn:hover{box-shadow:0 6px 24px rgba(129,140,248,.35)}
.fab-menu{position:absolute;bottom:56px;right:0;display:none;flex-direction:column;gap:4px;min-width:180px}
.fab-menu.open{display:flex}
.fab-menu-item{display:flex;align-items:center;gap:8px;padding:10px 14px;background:var(--surface);border:1px solid var(--border-light);border-radius:10px;color:var(--text);font-size:.85rem;font-family:var(--font);cursor:pointer;transition:all .15s;box-shadow:var(--shadow-md);white-space:nowrap}
.fab-menu-item:hover{background:var(--surface-hover);color:var(--accent)}
.fab-menu-item svg{flex-shrink:0}
.fab-menu-item.danger{color:#dc2626}
.fab-menu-item.danger:hover{background:#fef2f2}
:root.dark .fab-menu-item.danger:hover{background:rgba(220,38,38,.1)}

/* ── Upload preview ─────────────────────────────────────────────────── */
.upload-preview{display:none;align-items:center;gap:8px;padding:6px 10px;background:var(--accent-light);border-radius:var(--radius-sm);margin-bottom:6px;font-size:.8rem;color:var(--text-secondary)}
.upload-preview.show{display:flex}
.upload-preview .up-name{flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.upload-preview .up-remove{background:transparent;border:none;color:var(--text-muted);cursor:pointer;font-size:1rem;line-height:1;padding:2px}
.upload-preview .up-remove:hover{color:#dc2626}

/* ── Responsive ─────────────────────────────────────────────────────── */
@media(max-width:768px){
  .sidebar{transform:translateX(-100%)}
  .sidebar.open{transform:translateX(0)}
  .sidebar-overlay.open{display:block}
  .main-content{margin-left:0}
  .header{padding:8px 0}
  .header-actions{gap:4px}
  .header-badge{font-size:.62rem;padding:2px 8px}
  .container{padding:0 20px}
  .hero{padding:24px 0 14px}
  .hero-title{font-size:1.4rem}
  .message{padding:14px 0}
  .message-bubble{max-width:92%;font-size:.85rem}
  .message-avatar{width:24px;height:24px;font-size:.65rem}
  .input-area{padding:10px 16px 16px}
  .conversation{padding:12px 16px 8px}
}
@media(max-width:640px){
  .container{padding:0 16px}
  .main-content .main{padding-bottom:0}
  .chat-section{gap:0}
  .hero{padding:20px 0 12px}
  .hero-title{font-size:1.2rem}
  .hero-desc{font-size:.82rem}
  .preset-bar{gap:4px;margin-bottom:10px}
  .preset-btn{font-size:.65rem;padding:3px 8px;gap:3px}
  .preset-btn svg{width:11px;height:11px}
  .suggestions{margin-bottom:10px;gap:4px}
  .suggestion-chip{font-size:.7rem;padding:4px 10px;gap:4px}
  .suggestion-chip svg{width:10px;height:10px}
  .input-area{padding:8px 14px 14px}
  .input-form{padding:4px;border-radius:999px}
  .prompt-input{font-size:.88rem;padding:8px 4px}
  .send-btn{width:34px;height:34px}
  .send-btn svg{width:16px;height:16px}
  .upload-btn{width:30px;height:30px}
  .upload-btn svg{width:16px;height:16px}
  .footer-credit{font-size:.68rem;margin-top:4px;padding-bottom:4px}
  .fab-wrap{bottom:70px;right:8px}
  .fab-btn{width:38px;height:38px;font-size:1.05rem}
  .fab-menu{min-width:160px;bottom:46px}
  .fab-menu-item{font-size:.8rem;padding:8px 12px}
  .empty-state{padding:40px 16px 24px}
  .empty-state h3{font-size:.9rem}
  .empty-state p{font-size:.8rem}
  .empty-icon svg{width:32px;height:32px}
}
  .input-form{padding:4px;border-radius:999px}
  .prompt-input{font-size:.85rem;padding:6px 4px}
  .send-btn{width:34px;height:34px}
  .send-btn svg{width:16px;height:16px}
  .upload-btn{width:32px;height:32px}
  .upload-btn svg{width:14px;height:14px}
  .footer-credit{font-size:.68rem;margin-top:4px;padding-bottom:4px}
  .fab-wrap{bottom:70px;right:8px}
  .fab-btn{width:38px;height:38px;font-size:1.05rem}
  .fab-menu{min-width:160px;bottom:46px}
  .fab-menu-item{font-size:.8rem;padding:8px 12px}
  .empty-state{padding:24px 16px 16px}
  .empty-state h3{font-size:.9rem}
  .empty-state p{font-size:.8rem}
  .empty-icon svg{width:32px;height:32px}
}

/* ── Desktop sidebar collapse ───────────────────────────────────────── */
@media(min-width:769px){
  body.sidebar-collapsed .sidebar{transform:translateX(-100%)}
  body.sidebar-collapsed .main-content{margin-left:0}
}
</style>
</head>
<body>

<div class="app-layout">

<!-- ── Sidebar (Gemini-style) ────────────────────────────────────── -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <div class="sidebar-brand">
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
        <rect x="2" y="2" width="16" height="16" rx="4" stroke="currentColor" stroke-width="1.8"/>
        <path d="M6 7h8M6 10.5h5M6 14h3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
      </svg>
      Poriot AI
    </div>
    <button class="sidebar-close" id="sidebarClose" aria-label="Close sidebar">✕</button>
  </div>

  <nav class="sidebar-nav">
    <button class="nav-item" id="navNewChat">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 2v12M2 8h12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
      New chat
    </button>
    <button class="nav-item active" id="navBuilder">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><rect x="2" y="2" width="12" height="12" rx="3" stroke="currentColor" stroke-width="1.3"/><path d="M5 6h6M5 8.5h4M5 11h2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
      Builder
    </button>
    <a class="nav-item" href="https://t.me/nativecodes" target="_blank" rel="noopener">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 000 12a12 12 0 0012 12 12 12 0 0012-12A12 12 0 0012 0a12 12 0 00-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 01.171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
      Telegram
    </a>
    <button class="nav-item" id="navDarkMode">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 1v2M8 13v2M1 8h2M13 8h2M2.93 2.93l1.41 1.41M11.66 11.66l1.41 1.41M2.93 13.07l1.41-1.41M11.66 4.34l1.41-1.41M8 4a4 4 0 100 8 4 4 0 000-8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
      Appearance
    </button>
  </nav>

  <div class="sidebar-section-label">Conversations</div>
  <div class="sidebar-list" id="convList">
    <div class="sidebar-empty" id="sidebarEmpty">No conversations yet.<br>Start a new chat to begin.</div>
  </div>

  <div class="sidebar-footer"><svg width="12" height="12" viewBox="0 0 12 12" fill="none" style="vertical-align:-2px;margin-right:3px"><path d="M3 4l2 2-2 2M7 8h2" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg><a href="https://t.me/Poriot_ke" target="_blank" rel="noopener">P.oRiot</a> &middot; Project Poriot</div>
</aside>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ── Main ────────────────────────────────────────────────────────── -->
<div class="main-content">

<header class="header">
  <div class="container header-inner">
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
      <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M2 4h14M2 9h14M2 14h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
    </button>
    <div class="header-brand">
      <svg width="18" height="18" viewBox="0 0 20 20" fill="none">
        <rect x="2" y="2" width="16" height="16" rx="4" stroke="currentColor" stroke-width="1.8"/>
        <path d="M6 7h8M6 10.5h5M6 14h3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
      </svg>
      Poriot AI
    </div>
    <div class="header-spacer"></div>
    <div class="header-actions">
      <button class="mode-btn" id="modeBtn" title="Toggle chat mode">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3 1h8a2 2 0 012 2v5a2 2 0 01-2 2H7l-3 3v-3H3a2 2 0 01-2-2V3a2 2 0 012-2z" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Chat
      </button>
      <div class="header-badge"><span class="badge-dot"></span><span id="modelBadge">AI</span></div>
    </div>
  </div>
</header>

<main class="main container">

  <section class="hero" id="heroSection">
    <h1 class="hero-title">Build <span class="gradient-text">anything</span> with code</h1>
    <p class="hero-desc">Describe what you want to build — a component, a full app, a script, or a design. Poriot AI will craft it for you.</p>
  </section>

  <section class="chat-section">

    <!-- Preset selector -->
    <div class="preset-bar" id="presetBar">
      <button class="preset-btn active" data-preset="code"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M4 10L1 7l3-3M10 4l3 3-3 3M8 1l-2 12" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg> Code Expert</button>
      <button class="preset-btn" data-preset="design"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M12 2a1.5 1.5 0 01-2 2l-7 7-1 1-.5-1.5L3 9l7-7a1.5 1.5 0 012 0v0zM7 6l1 1" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg> UI Designer</button>
      <button class="preset-btn" data-preset="python"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="2" y="1" width="10" height="12" rx="1.5" stroke="currentColor" stroke-width="1.3"/><path d="M5 4h4M5 7h3M5 10h2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg> Python Guru</button>
      <button class="preset-btn" data-preset="debug"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="6" cy="6" r="4" stroke="currentColor" stroke-width="1.3"/><path d="M9 9l4 4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/><path d="M6 4v4M4 6h4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg> Debugger</button>
      <button class="preset-btn" data-preset="explain"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 3h10M2 6h7M2 9h5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/><path d="M10 8l2 2-2 2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg> Explainer</button>
    </div>

    <div class="suggestions" id="suggestions">
      <button class="suggestion-chip" data-prompt="Build a responsive navbar with HTML, CSS and JS. Dark theme, glassmorphism style, with a hamburger menu for mobile"><svg width="12" height="12" viewBox="0 0 12 12" fill="none"><rect x="1" y="2" width="10" height="8" rx="1" stroke="currentColor" stroke-width="1.2"/><path d="M4 5h4M4 7h2" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg> Responsive Navbar</button>
      <button class="suggestion-chip" data-prompt="Write a Python script that scrapes product prices from a webpage and saves them to a CSV"><svg width="12" height="12" viewBox="0 0 12 12" fill="none"><rect x="2" y="1" width="8" height="10" rx="1.2" stroke="currentColor" stroke-width="1.2"/><path d="M4 3h4M4 5h3M4 7h2" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg> Price Scraper</button>
      <button class="suggestion-chip" data-prompt="Create a React component for a real-time clock with alarm, styled with Tailwind CSS"><svg width="12" height="12" viewBox="0 0 12 12" fill="none"><circle cx="6" cy="6" r="4.5" stroke="currentColor" stroke-width="1.2"/><path d="M6 4v2l1.5 1" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg> React Clock</button>
      <button class="suggestion-chip" data-prompt="Design a SQL schema for a blog platform with users, posts, comments, likes, and tags. Include indexes and foreign keys."><svg width="12" height="12" viewBox="0 0 12 12" fill="none"><ellipse cx="6" cy="3" rx="4.5" ry="1.5" stroke="currentColor" stroke-width="1.2"/><path d="M1.5 3v3c0 .8 2 1.5 4.5 1.5S10.5 6.8 10.5 6V3" stroke="currentColor" stroke-width="1.2"/><path d="M1.5 6v3c0 .8 2 1.5 4.5 1.5S10.5 9.8 10.5 9V6" stroke="currentColor" stroke-width="1.2"/></svg> Blog DB Schema</button>
      <button class="suggestion-chip" data-prompt="Write a bash script that monitors disk usage and sends a telegram alert when it exceeds 80%"><svg width="12" height="12" viewBox="0 0 12 12" fill="none"><circle cx="6" cy="6" r="4.5" stroke="currentColor" stroke-width="1.2" stroke-dasharray="2 2"/><path d="M6 2v4l3 1" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg> Disk Monitor</button>
    </div>

    <div class="conversation" id="conversation">
      <div class="empty-state" id="emptyState">
        <div class="empty-icon">
          <svg width="44" height="44" viewBox="0 0 44 44" fill="none">
            <rect x="4" y="4" width="36" height="36" rx="8" stroke="currentColor" stroke-width="1.5" opacity=".3"/>
            <path d="M16 18h12M16 24h8M16 30h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity=".3"/>
            <circle cx="32" cy="32" r="5" fill="currentColor" opacity=".08" stroke="currentColor" stroke-width="1.2"/>
          </svg>
        </div>
        <h3>Your code canvas is empty</h3>
        <p>Type a prompt or pick a suggestion above to get started.</p>
      </div>
    </div>

    <div class="input-area">
      <div class="upload-preview" id="uploadPreview">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M7 1v8M3 5l4-4 4 4M1 10v2a1 1 0 001 1h10a1 1 0 001-1v-2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <span class="up-name" id="uploadName"></span>
        <button class="up-remove" id="uploadRemove"><svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M3 3l6 6M9 3l-6 6" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg></button>
      </div>
      <form id="promptForm" class="input-form">
        <button type="button" class="upload-btn" id="uploadBtn" title="Attach file">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 2v12M2 8h12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
        </button>
        <input type="file" id="fileInput" style="display:none" accept="*/*">
        <div class="input-row">
          <textarea id="promptInput" class="prompt-input" placeholder="Describe what you want to build..." rows="1" autofocus></textarea>
        </div>
        <button type="submit" class="send-btn" id="sendBtn" disabled>
          <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M9 2v14M4 7l5-5 5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
      </form>
      <p class="footer-credit">Made with <svg width="12" height="12" viewBox="0 0 12 12" fill="none" style="vertical-align:-1px"><path d="M6 10.5C6 10.5 1.5 7.5 1.5 4.5C1.5 3 2.5 2 4 2c.8 0 1.5.4 2 1 .5-.6 1.2-1 2-1 1.5 0 2.5 1 2.5 2.5 0 3-4.5 6-4.5 6z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg> by <a href="https://t.me/Poriot_ke" target="_blank" rel="noopener" style="color:var(--accent);text-decoration:none;font-weight:500;">P.oRiot</a></p>
    </div>

  </section>
</main>
</div>

<!-- ── FAB Command Menu ────────────────────────────────────────── -->
<div class="fab-wrap" id="fabWrap">
  <div class="fab-menu" id="fabMenu">
    <button class="fab-menu-item" id="fabNewChat">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 2v12M2 8h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      New conversation
    </button>
    <button class="fab-menu-item danger" id="fabStop" style="display:none">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><rect x="3" y="3" width="10" height="10" rx="2" fill="currentColor"/></svg>
      Stop generating
    </button>
  </div>
  <button class="fab-btn" id="fabBtn">/</button>
</div>

</div>

<script>
// ── Presets ───────────────────────────────────────────────────────────────
const PRESETS = {
  code: {
    name: 'Code Expert',
    prompt: 'You are an expert programming assistant. Help users write clean, efficient, well-documented code. Provide explanations when helpful. When writing code, always specify the language in a markdown code block.'
  },
  design: {
    name: 'UI Designer',
    prompt: 'You are a UI/UX designer who writes production-ready HTML, CSS, and JavaScript. Focus on beautiful, responsive, accessible designs. Use modern CSS (flexbox, grid, custom properties). Suggest color palettes and typography. Write complete, polished code.'
  },
  python: {
    name: 'Python Guru',
    prompt: 'You are a senior Python developer. Write clean, idiomatic Python following PEP 8. Use type hints. Prefer standard library solutions when possible. Include docstrings and explain your logic concisely.'
  },
  debug: {
    name: 'Debugger',
    prompt: 'You are a debugging expert. Analyze code carefully, identify bugs, explain root causes, and provide fixed versions. Be thorough — check edge cases, type issues, off-by-one errors, and logic flaws.'
  },
  explain: {
    name: 'Explainer',
    prompt: 'You are a programming teacher. Explain concepts clearly with analogies and examples. Break down complex topics into simple steps. Use beginner-friendly language but don\'t oversimplify. Include visual descriptions and code snippets.'
  }
};

// ── State ─────────────────────────────────────────────────────────────────
const STORAGE_KEY = 'poriot_conversations';
const ACTIVE_KEY  = 'poriot_active_id';
const THEME_KEY   = 'poriot_theme';
const PRESET_KEY  = 'poriot_preset';

let conversations = [];
let activeId = null;
let currentPreset = 'code';
let suppressSave = false;
let uploadedFile = null; // { url, name, textContent, type }
let isStreaming = false;
let abortController = null;
const MODE_KEY = 'poriot_mode';
let chatMode = false;
const CHAT_PROMPT = 'You are a friendly, helpful AI assistant. Chat naturally. Keep responses concise and conversational — like messaging a smart friend. Use simple language. Only give code if the user explicitly asks for it.';

// ── DOM refs ──────────────────────────────────────────────────────────────
const form          = document.getElementById('promptForm');
const input         = document.getElementById('promptInput');
const sendBtn       = document.getElementById('sendBtn');
const conversation  = document.getElementById('conversation');
const chatSection   = document.querySelector('.chat-section');
const emptyState    = document.getElementById('emptyState');
const suggestions   = document.getElementById('suggestions');
const convList      = document.getElementById('convList');
const sidebarEmpty  = document.getElementById('sidebarEmpty');
const newChatBtn    = document.getElementById('navNewChat');
const sidebarToggle = document.getElementById('sidebarToggle');
const sidebar       = document.getElementById('sidebar');
const sidebarOverlay= document.getElementById('sidebarOverlay');
const heroSection   = document.getElementById('heroSection');
const navDarkMode   = document.getElementById('navDarkMode');
const modeBtn       = document.getElementById('modeBtn');
const presetBar     = document.getElementById('presetBar');
const uploadBtn     = document.getElementById('uploadBtn');
const fileInput     = document.getElementById('fileInput');
const uploadPreview = document.getElementById('uploadPreview');
const uploadName    = document.getElementById('uploadName');
const uploadRemove  = document.getElementById('uploadRemove');
const modelBadge    = document.getElementById('modelBadge');
const body          = document.body;

// ── Fetch model name from backend ──────────────────────────────────────────
fetch('api.php?action=config').then(r=>r.json()).then(d=>{if(d.model)modelBadge.textContent=d.model}).catch(()=>{});

let thinkingEl = null;

// ── Theme ─────────────────────────────────────────────────────────────────
function getTheme() { return localStorage.getItem(THEME_KEY) || 'light'; }
function setTheme(t) {
  document.documentElement.classList.toggle('dark', t === 'dark');
  localStorage.setItem(THEME_KEY, t);
  // Update Appearance nav icon
  const icon = navDarkMode.querySelector('svg');
  if(icon)icon.innerHTML = t === 'dark'
    ? '<path d="M6 2a6 6 0 00-6 6 6 6 0 0010.44 4.02A6 6 0 016 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>'
    : '<path d="M8 1v2M8 13v2M1 8h2M13 8h2M2.93 2.93l1.41 1.41M11.66 11.66l1.41 1.41M2.93 13.07l1.41-1.41M11.66 4.34l1.41-1.41M8 4a4 4 0 100 8 4 4 0 000-8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>';
}
navDarkMode.addEventListener('click', () => setTheme(getTheme() === 'dark' ? 'light' : 'dark'));
setTheme(getTheme());

// ── Chat Mode Toggle ──────────────────────────────────────────────────────
function getMode() { return localStorage.getItem(MODE_KEY) === 'chat' ? 'chat' : 'builder'; }
function applyMode() {
  const isChat = chatMode;
  document.querySelector('.main-content').classList.toggle('chat-mode', isChat);
  modeBtn.classList.toggle('active', isChat);
  modeBtn.innerHTML = isChat
    ? '<svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3 1h8a2 2 0 012 2v5a2 2 0 01-2 2H7l-3 3v-3H3a2 2 0 01-2-2V3a2 2 0 012-2z" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg> Chat'
    : '<svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="2" y="2" width="10" height="10" rx="2" stroke="currentColor" stroke-width="1.3"/><path d="M5 5h4M5 8h3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg> Builder';
  input.placeholder = isChat ? 'Ask anything...' : 'Describe what you want to build...';
  // Refresh the conversation view to apply new bubble styles
  renderConv();
}
modeBtn.addEventListener('click', () => {
  chatMode = getMode() === 'chat' ? false : true;
  localStorage.setItem(MODE_KEY, chatMode ? 'chat' : 'builder');
  applyMode();
});
// Init mode
chatMode = getMode() === 'chat';
applyMode();

// ── Sidebar Nav Interactions ──────────────────────────────────────────────
navNewChat.addEventListener('click',()=>{createConv();closeSidebar();input.focus()});
creditTrigger.addEventListener('click', (e) => {
  e.stopPropagation();
  creditCard.classList.toggle('open');
});
document.addEventListener('click', () => creditCard.classList.remove('open'));
creditCard.addEventListener('click', (e) => e.stopPropagation());

// ── Presets ───────────────────────────────────────────────────────────────
function getSystemPrompt() {
  if(chatMode) return CHAT_PROMPT;
  return PRESETS[currentPreset]?.prompt || PRESETS.code.prompt;
}
presetBar.addEventListener('click', (e) => {
  const btn = e.target.closest('.preset-btn');
  if (!btn) return;
  presetBar.querySelectorAll('.preset-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  currentPreset = btn.dataset.preset;
  localStorage.setItem(PRESET_KEY, currentPreset);
});
const savedPreset = localStorage.getItem(PRESET_KEY);
if (savedPreset && PRESETS[savedPreset]) {
  currentPreset = savedPreset;
  presetBar.querySelectorAll('.preset-btn').forEach(b => {
    b.classList.toggle('active', b.dataset.preset === savedPreset);
  });
}

// ── Storage ───────────────────────────────────────────────────────────────
function loadConvs() { try { return JSON.parse(localStorage.getItem(STORAGE_KEY))||[]; }catch{return[]} }
function saveConvs() { if(suppressSave)return; try{localStorage.setItem(STORAGE_KEY,JSON.stringify(conversations));if(activeId)localStorage.setItem(ACTIVE_KEY,activeId)}catch{} }
function genId(){return'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g,c=>{const r=Math.random()*16|0;return(c=='x'?r:(r&0x3|0x8)).toString(16)})}

// ── Conversation CRUD ─────────────────────────────────────────────────────
function getActive(){return conversations.find(c=>c.id===activeId)||null}
function createConv(){
  const id=genId(),conv={id,title:'New conversation',messages:[],createdAt:Date.now(),updatedAt:Date.now()};
  conversations.unshift(conv);activeId=id;saveConvs();renderSidebar();renderConv();return conv;
}
function switchConv(id){
  if(id===activeId)return;
  if(isStreaming&&abortController){abortController.abort();isStreaming=false;hideThinking()}
  activeId=id;saveConvs();renderSidebar();renderConv();closeSidebar();
}
function deleteConv(id,e){
  e.stopPropagation();if(!confirm('Delete this conversation?'))return;
  const i=conversations.findIndex(c=>c.id===id);if(i===-1)return;
  conversations.splice(i,1);
  if(id===activeId)activeId=conversations.length>0?conversations[Math.min(i,conversations.length-1)].id:null;
  saveConvs();renderSidebar();renderConv();
}
function updateTitle(id){
  const c=conversations.find(x=>x.id===id);if(!c||!c.messages.length)return;
  const f=c.messages[0].content;c.title=f.length>50?f.substring(0,50)+'…':f;c.updatedAt=Date.now();saveConvs();renderSidebar();
}

// ── Sidebar ───────────────────────────────────────────────────────────────
function renderSidebar(){
  if(!conversations.length){convList.innerHTML='<div class="sidebar-empty">No conversations yet.<br>Start a new chat to begin.</div>';return}
  convList.innerHTML=conversations.map(c=>
    `<div class="conv-item${c.id===activeId?' active':''}" onclick="switchConv('${c.id}')">
      <span class="conv-title">${esc(c.title)}</span>
      <button class="conv-del" onclick="deleteConv('${c.id}',event)" title="Delete"><svg width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M2 2l6 6M8 2l-6 6" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg></button>
    </div>`
  ).join('');
}
window.switchConv=switchConv;window.deleteConv=deleteConv;

// ── Render conversation ───────────────────────────────────────────────────
function renderConv(){
  conversation.querySelectorAll('.message').forEach(el=>el.remove());
  const conv=getActive();
  if(conv&&conv.messages.length>0){heroSection.style.display='none'}else{heroSection.style.display='block'}
  if(!conv||!conv.messages.length){emptyState.style.display='block';return}
  emptyState.style.display='none';
  conv.messages.forEach(m=>{addMsgDOM(m.role,m.content,false,m.imageUrl)});
  if(chatSection)chatSection.scrollTop=chatSection.scrollHeight;
}
function addMsgDOM(role,content,isError,imageUrl){
  const div=document.createElement('div');
  div.className='message '+role+(isError?' error':'');
  const a=document.createElement('div');a.className='message-avatar';
  if(role==='user')a.textContent='U';
  else a.innerHTML='<svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 1l1.5 5.5L15 8l-5.5 1.5L8 15l-1.5-5.5L1 8l5.5-1.5L8 1z" fill="currentColor"/></svg>';
  const b=document.createElement('div');b.className='message-bubble';
  if(isError)b.textContent=content;
  else if(role==='user'){
    if(imageUrl)b.innerHTML='<img src="'+imageUrl+'" class="chat-image" alt="image" loading="lazy"><p>'+esc(content)+'</p>';
    else b.textContent=content;
  }
  else b.innerHTML=renderMD(content);
  div.appendChild(a);div.appendChild(b);conversation.appendChild(div);
}
function pushMsg(role,content,isError,imageUrl){
  let conv=getActive();
  if(!conv){conv=createConv()}
  const isNew=!conv.messages.length;
  conv.messages.push({role,content,imageUrl:imageUrl||undefined});conv.updatedAt=Date.now();
  if(role==='user'&&isNew)updateTitle(conv.id);
  addMsgDOM(role,content,!!isError,imageUrl);saveConvs();renderSidebar();
  if(chatSection)chatSection.scrollTop=chatSection.scrollHeight;
  if(isNew)heroSection.style.display='none';
}

// ── Streaming append ──────────────────────────────────────────────────────
let streamBuffer='';
function appendStreamText(text){
  streamBuffer+=text;
  // Find the last assistant bubble, or create one
  let bubble=conversation.querySelector('.message.assistant:last-child .message-bubble');
  if(!bubble){
    const div=document.createElement('div');div.className='message assistant';
    const a=document.createElement('div');a.className='message-avatar';a.innerHTML='<svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 1l1.5 5.5L15 8l-5.5 1.5L8 15l-1.5-5.5L1 8l5.5-1.5L8 1z" fill="currentColor"/></svg>';
    const b=document.createElement('div');b.className='message-bubble stream-cursor';
    div.appendChild(a);div.appendChild(b);conversation.appendChild(div);
    bubble=b;
  }
  bubble.className='message-bubble stream-cursor';
  bubble.innerHTML=renderMD(streamBuffer);
  if(chatSection)chatSection.scrollTop=chatSection.scrollHeight;
}
function finalizeStream(){
  const bubble=conversation.querySelector('.message.assistant:last-child .message-bubble');
  if(bubble){bubble.classList.remove('stream-cursor')}
}
// Save partial stream progress so page reloads don't lose everything
function saveStreamProgress(conv, content){
  if(!conv)return;
  const last=conv.messages[conv.messages.length-1];
  if(last&&last.role==='assistant'){
    last.content=content;
  }else{
    conv.messages.push({role:'assistant',content:content});
  }
  conv.updatedAt=Date.now();
  saveConvs();
}

// ── Markdown ──────────────────────────────────────────────────────────────
function esc(s){return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')}
function renderMD(t){
  if(typeof t!=='string')return'';
  try{
    t=t.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    t=t.replace(/```(\w*)\n([\s\S]*?)```/g,(_,l,c)=>'<pre><button class="copy-btn" onclick="copyCode(this)">Copy</button><code>'+esc(c.trim())+'</code></pre>');
    t=t.replace(/`([^`]+)`/g,'<code>$1</code>');
    t=t.replace(/^### (.+)$/gm,'<h4>$1</h4>');
    t=t.replace(/^## (.+)$/gm,'<h3>$1</h3>');
    t=t.replace(/^# (.+)$/gm,'<h2>$1</h2>');
    t=t.replace(/\*\*(.+?)\*\*/g,'<strong>$1</strong>');
    t=t.replace(/\*(.+?)\*/g,'<em>$1</em>');
    t=t.replace(/~~(.+?)~~/g,'<del>$1</del>');
    t=t.replace(/^---$/gm,'<hr>');
    t=t.replace(/^> (.+)$/gm,'<blockquote>$1</blockquote>');
    t=t.replace(/^- (.+)$/gm,'<li>$1</li>');
    t=t.replace(/(<li>.*<\/li>\n?)+/g,'<ul>$&</ul>');
    t=t.replace(/^\d+\. (.+)$/gm,'<li>$1</li>');
    const paras=t.split(/\n\n+/);
    t=paras.map(p=>{p=p.trim();if(!p)return'';if(p.startsWith('<h')||p.startsWith('<pre')||p.startsWith('<blockquote')||p.startsWith('<ul')||p.startsWith('<ol')||p.startsWith('<hr')||p.startsWith('<li'))return p;return'<p>'+p.replace(/\n/g,'<br>')+'</p>'}).join('\n');
    return t;
  }catch(e){return esc(t)}
}
window.copyCode=function(b){
  const pre=b.closest('pre'),code=pre.querySelector('code'),txt=code.textContent;
  navigator.clipboard.writeText(txt).then(()=>{b.textContent='Copied!';setTimeout(()=>{b.textContent='Copy'},2000)}).catch(()=>{
    const ta=document.createElement('textarea');ta.value=txt;document.body.appendChild(ta);ta.select();document.execCommand('copy');document.body.removeChild(ta);
    b.textContent='Copied!';setTimeout(()=>{b.textContent='Copy'},2000);
  });
};

// ── Thinking ──────────────────────────────────────────────────────────────
function showThinking(){
  if(thinkingEl)return;
  emptyState.style.display='none';
  thinkingEl=document.createElement('div');thinkingEl.className='thinking';
  thinkingEl.innerHTML='<div class="thinking-dots"><span></span><span></span><span></span></div><span class="thinking-text">Thinking...</span>';
  const w=document.createElement('div');w.className='message assistant';
  w.innerHTML='<div class="message-avatar"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 1l1.5 5.5L15 8l-5.5 1.5L8 15l-1.5-5.5L1 8l5.5-1.5L8 1z" fill="currentColor"/></svg></div>';w.appendChild(thinkingEl);
  conversation.appendChild(w);
  if(chatSection)chatSection.scrollTop=chatSection.scrollHeight;
}
function hideThinking(){
  conversation.querySelectorAll('.thinking').forEach(el=>{const w=el.closest('.message');if(w)w.remove()});
  thinkingEl=null;
}

// ── Sidebar toggle ────────────────────────────────────────────────────────
function isDesktop(){return window.innerWidth>=769}
function closeSidebar(){
  if(isDesktop()){body.classList.add('sidebar-collapsed')}
  else{sidebar.classList.remove('open');sidebarOverlay.classList.remove('open')}
}
function toggleSidebar(){
  if(isDesktop()){body.classList.toggle('sidebar-collapsed')}
  else{sidebar.classList.toggle('open');sidebarOverlay.classList.toggle('open')}
}
sidebarToggle.addEventListener('click',toggleSidebar);
sidebarOverlay.addEventListener('click',closeSidebar);
const sidebarClose=document.getElementById('sidebarClose');
if(sidebarClose)sidebarClose.addEventListener('click',closeSidebar);
newChatBtn.addEventListener('click',()=>{createConv();closeSidebar();input.focus()});

// ── FAB Command Menu ──────────────────────────────────────────────────────
const fabBtn=document.getElementById('fabBtn');
const fabMenu=document.getElementById('fabMenu');
const fabNewChat=document.getElementById('fabNewChat');
const fabStop=document.getElementById('fabStop');

fabBtn.addEventListener('click',(e)=>{e.stopPropagation();fabMenu.classList.toggle('open')});
document.addEventListener('click',()=>fabMenu.classList.remove('open'));
fabMenu.addEventListener('click',(e)=>e.stopPropagation());

fabNewChat.addEventListener('click',()=>{
  fabMenu.classList.remove('open');
  if(isStreaming&&abortController){abortController.abort();isStreaming=false;hideThinking();sendBtn.classList.remove('loading')}
  createConv();
  closeSidebar();
  input.focus();
});

fabStop.addEventListener('click',()=>{
  if(isStreaming&&abortController){
    abortController.abort();
    isStreaming=false;
    hideThinking();
    sendBtn.classList.remove('loading');
    finalizeStream();
    fabStop.style.display='none';
  }
  fabMenu.classList.remove('open');
});

// Show/hide stop button when streaming
const origShowThinking=showThinking;
showThinking=function(){
  origShowThinking();
  fabStop.style.display='flex';
};
const origHideThinking=hideThinking;
hideThinking=function(){
  origHideThinking();
  fabStop.style.display='none';
};

// ── Textarea ──────────────────────────────────────────────────────────────
input.addEventListener('input',()=>{
  input.style.height='auto';input.style.height=Math.min(input.scrollHeight,200)+'px';
  sendBtn.disabled=isStreaming||!(input.value.trim().length>0||uploadedFile);
  console.log('input fired',{disabled:sendBtn.disabled,val:input.value.trim().length,isStreaming,uploadedFile});
});
input.addEventListener('keydown',e=>{if(e.key==='Enter'&&!e.shiftKey){e.preventDefault();form.dispatchEvent(new Event('submit'))}});

// ── Suggestions ───────────────────────────────────────────────────────────
suggestions.addEventListener('click',e=>{
  const chip=e.target.closest('.suggestion-chip');if(!chip)return;
  input.value=chip.dataset.prompt;input.style.height='auto';input.style.height=Math.min(input.scrollHeight,200)+'px';
  sendBtn.disabled=false;input.focus();
});

// ── File upload ───────────────────────────────────────────────────────────
uploadBtn.addEventListener('click',()=>{
  if(isStreaming)return;
  fileInput.click()
});
fileInput.addEventListener('change',async()=>{
  const file=fileInput.files[0];if(!file)return;
  const fd=new FormData();fd.append('file',file);
  uploadPreview.classList.add('show');
  uploadName.textContent='Uploading...';
  try{
    const res=await fetch('api.php?action=upload',{method:'POST',body:fd});
    const data=await res.json();
    if(data.error){uploadName.textContent='Error: '+data.error;return}
    uploadedFile=data;
    const isImage=data.type.startsWith('image/');
    if(isImage){
      // Show image thumbnail in the preview bar
      const existing=uploadPreview.querySelector('img');
      if(!existing){
        const img=document.createElement('img');
        img.src=data.url;
        img.style.cssText='height:40px;width:auto;border-radius:4px;object-fit:cover';
        uploadPreview.insertBefore(img, uploadPreview.firstChild);
      }
      uploadName.textContent=data.name;
      // Add checkmark SVG
      const check=document.createElement('span');
      check.innerHTML=' <svg width="12" height="12" viewBox="0 0 12 12" fill="none" style="vertical-align:-2px;color:var(--green)"><path d="M2 6l3 3 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
      uploadName.appendChild(check);
      sendBtn.disabled=false;
      input.focus();
    }else if(data.textContent){
      const ext=data.name.split('.').pop().toLowerCase();
      let hint='';
      if(data.textContent.length<30000)hint='\n\n```\n// File: '+data.name+'\n'+data.textContent+'\n```';
      else hint='\n\n[Attached file: '+data.name+' ('+(data.size/1024).toFixed(0)+' KB)]';
      if(input.value.trim())input.value+=hint;
      else input.value='Review this file:\n'+hint;
      input.style.height='auto';input.style.height=Math.min(input.scrollHeight,200)+'px';
      sendBtn.disabled=false;
    }
  }catch(e){
    uploadName.textContent='Upload failed';
    setTimeout(()=>uploadPreview.classList.remove('show'),2000);
  }
});
uploadRemove.addEventListener('click',()=>{
  const img=uploadPreview.querySelector('img');
  if(img)img.remove();
  uploadedFile=null;fileInput.value='';uploadPreview.classList.remove('show');
  sendBtn.disabled=!input.value.trim();
});

// ── Submit (streaming) ────────────────────────────────────────────────────
form.addEventListener('submit',async(e)=>{
  e.preventDefault();
  const prompt=input.value.trim();
  if(!prompt||sendBtn.disabled||isStreaming)return;

  let conv=getActive();
  if(!conv){conv=createConv();renderSidebar()}

  // Handle attached image: build prompt with image reference
  let imageUrl=null;
  let finalPrompt=prompt;
  if(uploadedFile&&uploadedFile.type.startsWith('image/')){
    imageUrl=uploadedFile.url;
    finalPrompt='[Attached image: '+uploadedFile.url+']\n\n'+prompt;
    // Clear upload state
    const img=uploadPreview.querySelector('img');
    if(img)img.remove();
    uploadedFile=null;fileInput.value='';uploadPreview.classList.remove('show');
  }else if(uploadedFile){
    // Non-image attachment
    finalPrompt=prompt+'\n\n[Attached file: '+uploadedFile.name+' ('+uploadedFile.url+')]';
    uploadedFile=null;fileInput.value='';uploadPreview.classList.remove('show');
  }

  // Push user message (with image preview if applicable)
  pushMsg('user',finalPrompt,false,imageUrl);
  input.value='';input.style.height='auto';sendBtn.disabled=true;

  // Show thinking
  showThinking();
  sendBtn.classList.add('loading');
  isStreaming=true;
  abortController=new AbortController();

  try{
    const history=conv.messages.slice(0,-1).map(m=>({role:m.role,content:m.content}));
    const sysPrompt=getSystemPrompt();

    const res=await fetch('api.php?stream=1',{
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body:JSON.stringify({prompt,system_prompt:sysPrompt,history}),
      signal:abortController.signal,
    });

    hideThinking();

    if(!res.ok){
      pushMsg('assistant','API error: '+res.status,true);
      isStreaming=false;sendBtn.classList.remove('loading');return;
    }

    const reader=res.body.getReader();
    const decoder=new TextDecoder();
    let buf='',fullReply='';
    streamBuffer='';           // reset render buffer
    let doneReading=false;
    let lastSaveTs=Date.now();

    while(true){
      const{done,value}=await reader.read();
      if(done)break;
      buf+=decoder.decode(value,{stream:true});
      // Split on newlines — each complete line is one SSE event
      const lines=buf.split('\n');
      buf=lines.pop()||'';     // save incomplete line for next chunk
      for(const line of lines){
        const t=line.trim();
        if(!t.startsWith('data: '))continue;
        const payload=t.substring(6);
        // [DONE] is the official stream terminator
        if(payload==='[DONE]'){doneReading=true;continue}
        // Parse the JSON — every complete data: line should be valid JSON
        let d;
        try{d=JSON.parse(payload)}catch(e){continue}
        if(d.type==='error'){pushMsg('assistant',d.error||'Error',true);continue}
        const msg=d.message;
        if(msg&&msg.content?.parts){
          for(const part of msg.content.parts){
            if(typeof part==='string'&&part){
              fullReply+=part;
              appendStreamText(part);
            }
          }
        }
        // Mid-stream save every 5 seconds — survive a page refresh
        const now=Date.now();
        if(now-lastSaveTs>5000&&fullReply){
          saveStreamProgress(conv,fullReply);
          renderSidebar();
          lastSaveTs=now;
        }
      }
      if(doneReading)break;
    }

    finalizeStream();

    // Detect truncation: stream ended without [DONE] or finish_reason === "length"
    let wasTruncated=false;
    if(!doneReading && fullReply){
      wasTruncated=true;
    }

    // Final save — the complete assistant reply
    if(fullReply){
      saveStreamProgress(conv,fullReply);
      if(wasTruncated){
        conv.messages[conv.messages.length-1].content+='\n\n_⚠️ Response was truncated. Try "continue" or rephrase your prompt._';
        saveStreamProgress(conv,conv.messages[conv.messages.length-1].content);
        // Append truncation warning to the DOM bubble
        const bubble=conversation.querySelector('.message.assistant:last-child .message-bubble');
        if(bubble)bubble.innerHTML+=renderMD('\n\n_⚠️ Response was truncated. Try "continue" or rephrase your prompt._');
      }
    }
    renderSidebar();

    isStreaming=false;
    sendBtn.classList.remove('loading');

  }catch(err){
    if(err.name==='AbortError'){/* user switched conversations */}
    else{
      hideThinking();
      pushMsg('assistant','Network error. Check your connection.',true);
    }
    isStreaming=false;
    sendBtn.classList.remove('loading');
  }
});

// ── Init ──────────────────────────────────────────────────────────────────
(function init(){
  suppressSave=true;
  conversations=loadConvs();
  activeId=localStorage.getItem(ACTIVE_KEY)||null;
  if(activeId&&!conversations.find(c=>c.id===activeId))activeId=null;
  if(!activeId||!conversations.length)createConv();
  renderSidebar();renderConv();
  suppressSave=false;
})();
</script>
</body>
</html>
