# Project Poriot AI Builder

> Made with ♥️ by [P.o.Riot🇰🇪](https://t.me/Poriot_ke)

An AI-powered code builder that uses ChatGPT's models (gpt-5-3-mini) to generate code, designs, and solutions from natural language prompts.

## ✨ Features

- **Chat history** — Conversations auto-save to your browser (localStorage). Return anytime.
- **Conversation sidebar** — Switch between past chats, start new ones, delete old ones.
- **Context memory** — The AI remembers everything said in the current conversation.
- **Code with syntax** — Markdown rendering with copy buttons on code blocks.
- **Zero setup** — No database, no API keys, no config.

## Deploy to InfinityFree

1. **Download** these files:
   - `index.php`
   - `api.php`
   - `.htaccess`

2. **Upload** via FTP to your InfinityFree `htdocs/` folder.

3. **Set PHP to 8.0+** in the InfinityFree control panel.

4. **Visit** your domain — that's it!

## Local Testing

```bash
php -S localhost:8080
# Then open http://localhost:8080
```

## Files

| File        | Purpose                                      |
|-------------|----------------------------------------------|
| `index.php` | Frontend UI + sidebar + localStorage + JS    |
| `api.php`   | Backend proxy to ChatGPT Android API         |
| `.htaccess` | InfinityFree security & performance tweaks   |

## Requirements

- PHP 8.0+ with `curl` extension
- Internet connection (proxies to ChatGPT API)

## Credits

Built by [P.o.Riot🇰🇪](https://t.me/Poriot_ke) — Project Poriot
