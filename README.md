# 🐄 Livestock Tagging and Profiling Management System (LTPMS)

## 📌 Project Overview
The **Livestock Tagging and Profiling Management System Using Wireless Technology** is a web-based application built with Laravel.

It helps streamline livestock management by providing a **paperless, efficient, and accurate system** for tracking animal records.

### ✨ Features
- 📋 Record and manage livestock data digitally  
- 🏷️ Assign unique QR codes to each livestock  
- 📱 Quickly retrieve animal information via QR scanning  
- 📊 Improve tracking efficiency and data accuracy  

---

## ⚙️ Tech Stack
- **Framework:** Laravel  
- **Database:** PostgreSQL  
- **Frontend:** Blade / Vite  
- **Deployment:** Render  

---

## 🚀 Installation & Setup

### 1. Clone the Repository
```bash
git clone https://github.com/your-repo/ltpms.git
cd ltpms
```

### 2. Install Dependencies
```bash
composer install
npm install && npm run dev
```

### 3. Setup Environment File
Copy the default `.env` file:

```bash
cp .env.example .env
```

Then update your `.env` for local development:

```env
APP_ENV=local
APP_DEBUG=true

DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=ltpms
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

---

### 4. Generate Application Key
```bash
php artisan key:generate
```

---

### 5. Run Database Migrations
```bash
php artisan migrate
```

---

### 6. Start Development Server
```bash
php artisan serve
```

---

## 🌍 Environment Configuration

### 🔹 Local Development (`.env`)
Used when running the application locally.

**Key Settings:**
```env
APP_ENV=local
APP_DEBUG=true
```
- Uses local PostgreSQL database  
- Enables debugging for development  

---

### 🔹 Production (`.env.production` - Render)
Used for deployed application.

**Key Settings:**
```env
APP_ENV=production
APP_DEBUG=false
```
- Uses remote PostgreSQL (Render)  
- Debugging disabled for security  

---

## 📦 Deployment
This project is deployed using **Render**.

Make sure to:
- Set environment variables in Render dashboard  
- Configure PostgreSQL database connection  
- Run migrations in production  

---

## 🚀 Deployment & Maintenance
This project uses Laravel and Docker. To ensure the application stays in sync with environment changes and database migrations, follow these command guidelines.

---

### 🧪 Local Development
Run these commands in your local terminal during development to refresh your environment or apply database changes.
| Task	                          |  Command                     |
| Full Reset (The "Go-To" fix)    |  php artisan optimize:clear  |
| Run Migrations	              |  php artisan migrate         |
| Clear Config Cache	          |  php artisan config:clear    |
| Clear App Cache	              |  php artisan cache:clear     |

---

### 🐳 Docker & Production Workflow
In a containerized environment (like Render), commands are split between the Build Stage and the Runtime Stage.

1. Build Stage (Dockerfile)
These commands prepare the application during the image build. They do not require a database connection.
```bash
Dockerfile
# Clear any stale defaults before packaging the image
RUN php artisan config:clear && php artisan cache:clear
```

2. Runtime Stage (CMD)
These commands run every time the container starts. This ensures the production database is always up to date and the configuration is optimized.
```bash
# Recommended startup sequence
CMD php artisan optimize:clear && \
    php artisan migrate --force && \
    php artisan config:cache && \
    php artisan serve --host=0.0.0.0 --port=10000
```

---

## 🧠 Troubleshooting & Cache Management
Laravel caches aggressively. If your .env changes aren't reflecting or the UI is acting "weird," use this guide:

### The "Nuclear" Option
If something isn't updating after a fresh deploy:
```bash
php artisan optimize:clear
```
This clears: Config, Route, View, and Application cache in one go.

### Database Issues
If you switch database providers (e.g., MySQL to PostgreSQL) or update connection strings:
1. Clear config: php artisan config:clear
2. Clear cache: php artisan cache:clear
3. Run migrations: php artisan migrate --force

### Local Dev Optimization/Clear Cache
```bash
php artisan config:clear
php artisan route:clear
php artisan view: clear
```

### Production Optimization
Once the app is stable, always rebuild the cache for a performance boost:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
Note: Locally, you can run these commands manually. In production, these must be handled via your Docker CMD or entrypoint script because you do not have direct shell access to the running container.

---

## 📄 License
This project is for academic purposes.
 
## How to set up imagick for generating qrcode (extension imagick is needed aside from simplesoftware/simple-qrcode) 

1. check your php version
2. Check your phpinfo to check if thread safety is enabled or disabled as you will need to choose what version of imagick is for you(non thread safe or thread safe) 
3. Then visit pecl.php.net to download imagick(click dll for you to be directed to dll list and choose what version is your php that is suitable for imagick)
4. Extract the zip file
5. Open extracted zip file
6. Copy php_imagick.dll to your php/ext directory
7. Then go back to your extracted file and copy all the files(dont include the folders and the php_imagick.dll file since it was copied already to the php/ext directory
9. Open your php.ini file, then in the extensions area add extension=imagick restart your wamp/xamp/laragon servers(apache and mysql)
10. To check if imagick is running and installed
Go to your terminal type php -m and look for imagick
Done.

link imagick: https://pecl.php.net/
