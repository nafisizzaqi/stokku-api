# Panduan Deployment Laravel ke Railway

## 📋 Overview

Dokumentasi deployment aplikasi Laravel dari environment lokal (Laravel Sail) ke production (Railway) dengan MySQL dan Redis.

---

## 🎯 Prerequisites

- Laravel project
- Akun GitHub
- Akun Railway (gratis dengan trial $5)
- Railway CLI: `npm install -g @railway/cli`

---

## 📦 Langkah 1: Setup Environment Lokal dengan Sail

### 1. Stop Service yang Konflik
```bash
# Stop Apache, Redis, MySQL lokal yang pakai port 80, 6379, 3306
sudo systemctl stop apache2 redis-server
docker stop mysql-container 2>/dev/null || true
docker rm mysql-container 2>/dev/null || true
```

### 2. Install & Start Sail
```bash
# Install Sail dengan MySQL + Redis
php artisan sail:install

# Start containers
./vendor/bin/sail up -d

# Run migrations
./vendor/bin/sail artisan migrate
```

---

## ⚙️ Langkah 2: Konfigurasi Production

### 1. Update Queue Driver

Edit `.env`:
```env
QUEUE_CONNECTION=redis
```

### 2. Buat Nixpacks Config

Buat file `nixpacks.toml`:
```toml
[phases.setup]
nixPkgs = ["php82", "php82Extensions.pdo", "php82Extensions.pdo_mysql", "php82Extensions.redis"]

[phases.install]
cmds = ["composer install --optimize-autoloader --no-dev"]

[phases.build]
cmds = [
  "chmod -R 777 storage bootstrap/cache",
  "php artisan config:cache",
  "php artisan route:cache",
  "php artisan view:cache"
]

[start]
cmd = "php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"
```

### 3. Test Production Commands
```bash
./vendor/bin/sail artisan route:cache
./vendor/bin/sail artisan config:cache
./vendor/bin/sail artisan optimize
```

---

## 🚀 Langkah 3: Deploy ke Railway

### 1. Push ke GitHub
```bash
git add .
git commit -m "Add Railway deployment config"
git push origin main
```

### 2. Setup Railway Project
```bash
# Login
railway login

# Initialize project
railway init
```

### 3. Add Services via Dashboard

Buka Railway dashboard:
```bash
railway open
```

Di dashboard:
1. Klik **"+ New"** → **"Database"** → Pilih **MySQL**
2. Klik **"+ New"** → **"Database"** → Pilih **Redis**
3. Klik **"+ New"** → **"GitHub Repo"** → Pilih repository

### 4. Configure Environment Variables

Klik service aplikasi → Tab **"Variables"** → Tambahkan:

**Manual:**
```env
APP_NAME=Your App
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:your-key-here
APP_URL=https://your-app.up.railway.app
DB_CONNECTION=mysql
QUEUE_CONNECTION=redis
```

**Add Database References:**
1. Klik **"New Variable"** → **"Add Reference"**
2. Pilih **MySQL service** → Centang semua variables
3. Ulangi untuk **Redis service**

Railway auto-map variables:
- `MYSQLHOST` → `DB_HOST`
- `MYSQLUSER` → `DB_USERNAME`
- `MYSQLPASSWORD` → `DB_PASSWORD`
- dst.

---

## 🗄️ Langkah 4: Setup Database

### 1. Run Migrations
```bash
railway run php artisan migrate --force
```

### 2. Seed Data (Optional)
```bash
railway run php artisan db:seed --force
```

---

## 🌐 Langkah 5: Get Public URL

```bash
railway domain
```

Output: `https://your-app-production.up.railway.app`

---

## 🧪 Langkah 6: Testing

### Test dengan cURL
```bash
# Login
curl -X POST https://your-app.up.railway.app/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password"}'

# Get data (dengan token dari response login)
curl https://your-app.up.railway.app/api/endpoint \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### Test dengan Postman

**Base URL:** `https://your-app.up.railway.app`

**POST** `/api/login`
- Body: `{"email":"admin@example.com","password":"password"}`

**GET** `/api/endpoint`
- Authorization: Bearer Token (dari response login)

---

## 🔄 Auto-Deploy

Railway sudah configured untuk auto-deploy setiap push ke GitHub:

```bash
git add .
git commit -m "Update feature"
git push origin main
```

Railway akan otomatis rebuild dan deploy.

---

## 📊 Monitoring

### Via Railway Dashboard
- **Deployments**: History & logs
- **Metrics**: CPU, Memory, Network
- **Logs**: Real-time application logs

### Via CLI
```bash
# View logs
railway logs

# Check status
railway status
```

---

## 🛠️ Troubleshooting

### Storage Permission Error
**Fix:** Update `nixpacks.toml`:
```toml
[phases.build]
cmds = ["chmod -R 777 storage bootstrap/cache", "php artisan config:cache"]
```

### Database Connection Error
**Fix:** Pastikan variable references benar di Railway dashboard.

### Route Not Found
**Fix:**
```bash
railway run php artisan route:clear
railway run php artisan config:clear
```

---

## ✅ Checklist Deployment

- [ ] Setup Sail lokal
- [ ] Update queue driver ke Redis
- [ ] Buat `nixpacks.toml`
- [ ] Push ke GitHub
- [ ] Initialize Railway project
- [ ] Add MySQL & Redis services
- [ ] Deploy dari GitHub
- [ ] Configure environment variables
- [ ] Run migrations
- [ ] Get public domain
- [ ] Test API

---

## 💰 Cost (Railway)

**Trial:** $5 credit gratis (~1-2 minggu)

**After Trial:**
- MySQL: ~$5/month
- Redis: ~$5/month
- App: ~$5-10/month
- **Total:** ~$15-20/month

**Alternatif Gratis:** Oracle Cloud Free Tier (permanent)

---

## 📚 Resources

- [Railway Docs](https://docs.railway.app)
- [Laravel Sail](https://laravel.com/docs/sail)
- [Nixpacks](https://nixpacks.com)

---

**Status:** ✅ Production Ready
