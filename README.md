# Project Poriot AI Builder

> Made with ♥️ by [P.oRiot 🇰🇪](https://t.me/Poriot_ke)

An AI-powered code builder with a Gemini-inspired UI. Streams responses from OpenAI-compatible APIs with automatic Groq fallback.

## ✨ Features

- **Gemini-style UI** — Sliding sidebar, floating input capsule, seamless chat bubbles, dark mode
- **Streaming responses** — Live SSE with cursor animation, truncation detection, abort mid-generation
- **Chat history** — Auto-saved to localStorage with sidebar switching and delete
- **Code rendering** — Syntax-highlighted markdown with copy-on-hover buttons
- **File uploads** — Drag or attach images and text files (text content auto-injected into prompt)
- **Toast notifications** — Subtle bottom-right alerts for copy, upload, errors, cancel
- **Dark mode** — Toggle persisted in localStorage
- **Chat / Builder modes** — Switch between WhatsApp-style bubbles and full builder view

## 🚀 Deploy to Railway

1. **Fork or clone** this repo
2. Go to [railway.app](https://railway.app) → **New Project** → **Deploy from GitHub**
3. Select this repo — Railway auto-detects PHP
4. Go to **Variables** and add:

| Variable | Required | What to set |
|---|---|---|
| `FALLBACK_KEY` | ✅ | Your [Groq API key](https://console.groq.com/keys) (`gsk_...`) — free, no credit card |
| `API_URL` | ❌ | Override primary endpoint (default: ChatGPT Android internal API) |
| `API_KEY` | ❌ | API key for custom endpoint (leave empty for default) |
| `API_MODEL` | ❌ | Model name shown in badge (default: `gpt-4o-mini`) |
| `FALLBACK_URL` | ❌ | Fallback endpoint (default: `api.groq.com`) |
| `FALLBACK_MODEL` | ❌ | Fallback model (default: `llama-3.3-70b-versatile`) |

5. **Set a custom domain** (optional):
   - In Railway → **Settings → Domains** → add your domain
   - Point a CNAME at `your-project.up.railway.app`

**Minimum viable setup:** just set `FALLBACK_KEY`. The primary tries the Android ChatGPT endpoint; Groq catches any failures.

## 🧪 Local Testing

```bash
php -S localhost:8080
# Open http://localhost:8080
```

## 📁 Files

| File | Purpose |
|---|---|
| `index.php` | Frontend UI (HTML/CSS/JS — no PHP inside) |
| `api.php` | PHP API proxy (Android endpoint + Groq fallback) |
| `Procfile` | Railway start command |
| `railway.json` | Railway build config |
| `.htaccess` | Apache config (InfinityFree fallback) |

## 🔧 Requirements

- PHP 8.0+ with `curl` and `json` extensions (for `api.php`)
- Internet connection

Built by [P.oRiot 🇰🇪](https://t.me/Poriot_ke) — Project Poriot
