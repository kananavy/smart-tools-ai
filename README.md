# SmartTools AI

A modern web platform featuring AI-powered tools for content generation, text summarization, and image analysis. Built with Laravel (backend) and Vue.js (frontend).

## Features

- 🔐 **Secure Authentication** - User registration and login with Laravel Sanctum
- 🤖 **AI Tools Suite**
  - Text Generator - Create creative content from prompts
  - Text Summarizer - Condense long texts into summaries
  - Image Analyzer - Analyze image content with AI
- 📊 **Usage History** - Track all your AI generations
- 👤 **User Profile** - Manage your account settings
- 🎨 **Modern UI** - Beautiful, responsive design with Tailwind CSS

## Tech Stack

### Backend
- **Laravel 11** - PHP framework
- **SQLite** - Database
- **Laravel Sanctum** - API authentication
- **Groq API** - Real AI integration with Llama 3.3 70B model

### Frontend
- **Vue 3** - Progressive JavaScript framework
- **TypeScript** - Type-safe development
- **Vite** - Fast build tool
- **Tailwind CSS** - Utility-first CSS
- **Axios** - HTTP client
- **Pinia** - State management
- **Vue Router** - Client-side routing
- **Lucide Vue** - Icon library

## Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 18+
- npm

### Installation

1. **Clone the repository**
```bash
git clone https://github.com/kananavy/smart-tools-ai.git
cd smart-tools-ai
```

2. **Backend Setup**
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
```

3. **Configure Groq API** (for real AI generation)
   - Get a free API key from [Groq Console](https://console.groq.com)
   - Add to your `.env` file:
   ```
   GROQ_API_KEY=your_groq_api_key_here
   ```

4. **Frontend Setup**
```bash
cd ../frontend
npm install
```

### Running the Application

1. **Start the backend server**
```bash
cd backend
php artisan serve
# Server runs on http://localhost:8000
```

2. **Start the frontend dev server**
```bash
cd frontend
npm run dev
# Server runs on http://localhost:5173
```

3. **Access the application**
- Open your browser to `http://localhost:5173`
- Login with test credentials:
  - Email: `test@example.com`
  - Password: `password`

## Project Structure

```
smart-tools-ai/
├── backend/              # Laravel backend
│   ├── app/
│   │   ├── Http/Controllers/Api/
│   │   ├── Models/
│   │   └── Services/Ai/
│   ├── database/
│   │   ├── migrations/
│   │   └── seeders/
│   └── routes/api.php
│
└── frontend/            # Vue.js frontend
    ├── src/
    │   ├── views/       # Page components
    │   ├── layouts/     # Layout components
    │   ├── stores/      # Pinia stores
    │   ├── services/    # API services
    │   └── router/      # Route definitions
    └── public/
```

## API Endpoints

### Authentication
- `POST /api/register` - Register new user
- `POST /api/login` - Login user
- `POST /api/logout` - Logout user (authenticated)
- `GET /api/user` - Get current user (authenticated)

### Tools
- `GET /api/tools` - List available tools (authenticated)
- `POST /api/tools/{slug}/generate` - Generate content (authenticated)
- `GET /api/history` - Get user's generation history (authenticated)

## AI Services

The application supports multiple AI service providers. Currently configured to use **Groq** with Llama 3.3 70B:

### Available Services
- **Groq** (Active) - Ultra-fast inference with Llama 3.3 70B
- **Google Gemini** - Multimodal AI (text + images)
- **DeepSeek** - Powerful language model

### Switching AI Services
To change the AI service, update `ToolController.php`:
```php
public function __construct(GroqAiService $aiService) // Change to GeminiAiService or DeepSeekAiService
```

## Development

### Database Seeding
The database comes pre-seeded with:
- Test user account
- Three AI tools (Text Generator, Summarizer, Image Analyzer)

To re-seed:
```bash
cd backend
php artisan migrate:fresh --seed
```

### CORS Configuration
CORS is configured to allow requests from `http://localhost:5173`. Update `backend/config/cors.php` if using different ports.

## Future Enhancements

- [ ] Integration with real AI APIs (OpenAI, Anthropic, etc.)
- [ ] File upload for image analysis
- [ ] Export generation results
- [ ] Usage analytics dashboard
- [ ] Team collaboration features
- [ ] API rate limiting
- [ ] Payment integration

## License

This project is open-source and available under the MIT License.

## Author

**Kananavy Dev**
- GitHub: [@kananavy](https://github.com/kananavy)

## Acknowledgments

Built with modern web technologies and best practices for a scalable, maintainable application architecture.
