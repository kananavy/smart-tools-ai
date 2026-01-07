# SmartTools AI 🚀

SmartTools AI is a **professional SaaS platform** offering a suite of AI-powered tools for content generation and analysis. Built with **Laravel 11** and **Vue 3**, it features a robust subscription system, modern "Glassmorphism" UI, and premium capabilities.

![SmartTools Dashboard](https://raw.githubusercontent.com/kananavy/smart-tools-ai/main/screenshots/dashboard.png)

## ✨ Features

### 💎 Premium Experience
- **Modern UI/UX**: Dark mode with glassmorphism effects and smooth animations.
- **Subscription System**: Complete tiered access (Free vs Pro).
- **Dashboard**: Real-time usage statistics and account management.

### 🛠 AI Powered Tools
1.  **Text Generator**: Create blog posts, stories, and emails with adjustable phone and length.
2.  **Text Summarizer**: Condense long articles into concise summaries.
3.  **Image Analyzer**: Drag & drop images for AI-powered analysis.

### 💼 Pro Features ($9/mo)
- **Unlimited Generations**: No monthly caps.
- **Advanced Models**: Access to Llama 3.3 70B (via Groq).
- **Export Content**: Download your creations as TXT files.
- **Priority Support**: Faster response times.

## 🚀 fast Start

### Prerequisites
- PHP 8.2+
- Node.js 18+
- Composer
- MySQL

### Installation

1.  **Clone the repository**
    ```bash
    git clone https://github.com/kananavy/smart-tools-ai.git
    cd smart-tools-ai
    ```

2.  **Backend Setup (Laravel)**
    ```bash
    cd backend
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate --seed
    php artisan serve
    ```

3.  **Frontend Setup (Vue 3)**
    ```bash
    cd frontend
    npm install
    npm run dev
    ```

4.  **Access the App**
    Open [http://localhost:5173](http://localhost:5173) in your browser.

## 💳 Subscription Plans

| Feature | Free Plan | Pro Plan ($9/mo) |
| :--- | :---: | :---: |
| Monthly Generations | 50 | **Unlimited** |
| AI Model | Basic | **Advanced** |
| History | Last 10 | **Full History** |
| Export | ❌ | **✅ TXT Export** |
| File Upload | ❌ | **✅ Drag & Drop** |

## 🛠 Tech Stack

- **Backend**: Laravel 11, Sanctum (Auth), MySQL
- **Frontend**: Vue 3, Vite, TailwindCSS
- **AI Service**: Groq API (Llama 3.3)
- **Icons**: Lucide Vue Next

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
