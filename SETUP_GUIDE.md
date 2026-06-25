# 🚀 Setup Guide: Project Poriot AI Builder on InfinityFree

---

## Step 1 — Create InfinityFree Account

1. Go to **[infinityfree.com](https://infinityfree.com)** and sign up
2. Verify your email
3. Log in to the control panel

---

## Step 2 — Create a Website / Domain

1. Click **"Add Account"**
2. Choose a **subdomain** (e.g. `poriot-ai-builder.infinityfreeapp.com`) or use your own domain
3. Click **"Create"**
4. Note your **Login URL** (e.g. `epizy.com` or `byet.hk`) — you'll use this for FTP

---

## Step 3 — Upload Files via FTP

You'll need an **FTP client** — recommend [FileZilla](https://filezilla-project.org/) (free).

### Get your FTP credentials

1. In InfinityFree control panel, click **"Accounts"** → your account
2. Find the **FTP Details** section:
   - **FTP Host:** Usually `ftpupload.net`
   - **FTP Username:** Your InfinityFree username
   - **FTP Password:** Your InfinityFree password
   - **Port:** 21

### Upload

1. Open FileZilla → File → Site Manager → New Site
2. Enter the FTP details above
3. Click **Connect**
4. Navigate to the `htdocs/` folder on the server
5. **Delete** any existing files inside it (the default index.php)
6. **Extract** `poriot-ai-builder.zip` on your computer
7. **Drag** all 3 files (`index.php`, `api.php`, `.htaccess`) into the server's `htdocs/` folder

---

## Step 4 — Set PHP Version

InfinityFree defaults to an older PHP. You need **PHP 8.0+** for the `str_starts_with()` function.

1. In InfinityFree control panel, find your domain
2. Click the **⚙️ Settings** icon (or "Manage")
3. Look for **PHP Version** or **PHP Configuration**
4. Set it to **PHP 8.2** (or any 8.x)
5. Save

---

## Step 5 — Enable cURL

cURL is usually enabled by default on InfinityFree, but verify:

1. In the same **PHP Configuration** area
2. Check that **cURL** is **enabled** (it's usually listed under "Loaded Extensions")
3. If not, enable it from the dropdown/checkboxes

---

## Step 6 — Visit Your Site

Open your domain in a browser:

```
https://your-domain.infinityfreeapp.com
```

You should see:

- **Sidebar** on the left with your saved conversations
- **Header:** Project Poriot AI Builder with a green "gpt-5-3-mini" badge and dark mode toggle (🌙/☀️)
- **Hero:** "Build anything with code"
- **Preset selector** — choose the AI's role: Code Expert, UI Designer, Python Guru, Debugger, or Explainer
- **Suggestion chips** to try out
- **📎 File upload** — attach code files, images, or documents
- **Input box** to type your prompts
- **Footer:** Made with ♥️ by P.o.Riot🇰🇪 (clickable Telegram link)

### New Features in v2

| Feature | How to use |
|---------|-----------|
| **🌙 Dark mode** | Click the moon/sun icon in the header — preference is saved automatically |
| **🎯 Preset roles** | Click a preset above the suggestions to change how the AI responds |
| **⚡ Live streaming** | Responses appear token-by-token as they're generated (no more waiting) |
| **📎 File upload** | Click the paperclip icon to attach files (code, images, PDFs, etc.) |
| **📁 Uploads folder** | Uploaded files are stored in `/htdocs/uploads/` — accessible via URL |
| **📱 Mobile-first layout** | Input bar stays at bottom like a chat app. `/` FAB button for quick actions |
| **🛑 Stop / New Chat** | Tap the **`/`** button → Stop generating or New conversation |

### Mobile Layout

On phones:
- The **input bar is fixed at the bottom** of the screen — always accessible
- Messages scroll above it, filling the screen like a chat app
- The **`/`** button floats above the input — tap it to open a quick menu:
  - **New conversation** — start fresh without scrolling to the sidebar
  - **Stop generating** — cancel the current AI response mid-stream
- Hero section hides automatically once you send a message
- **Sidebar opens as a full overlay** when you tap the hamburger icon

### How Chat History Works

- Conversations **auto-save** to your browser (localStorage) after every message
- The **sidebar** on the left shows all your past conversations
- Click **+** (top of sidebar) to start a new chat
- Click any conversation in the sidebar to switch back to it
- Hover over a conversation and click **✕** to delete it
- The AI remembers the full conversation context (it gets the entire history with each prompt)
- **Nothing is stored on the server** — all data stays in your browser

---

## Troubleshooting

| Problem | Fix |
|---|---|
| **Blank page** | Check PHP version is 8.0+ (Step 4) |
| **"cURL error"** | Enable cURL in PHP settings (Step 5) |
| **API returns 500** | Check the PHP error log in cPanel |
| **CORS errors** | The `api.php` already sends CORS headers — should work fine on the same domain |
| **"Connection timed out"** | ChatGPT API may be throttling. Wait a minute and try again |
| **CSS looks broken** | Clear browser cache (Ctrl+F5) |

---

## Files Overview

```
htdocs/
├── index.php      # The web page (UI + CSS + JavaScript)
├── api.php        # Backend API proxy → ChatGPT
└── .htaccess      # Security & performance settings
```

That's it — no database, no API keys, no config files. Just upload and go.

> Made with ♥️ by [P.o.Riot🇰🇪](https://t.me/Poriot_ke) — Project Poriot
