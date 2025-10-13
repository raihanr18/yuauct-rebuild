# Deployment Guide - YuAUCT ke Vercel

## ⚠️ Peringatan
Laravel adalah framework PHP full-stack yang memerlukan server PHP tradisional. Vercel dirancang untuk frontend dan serverless functions. 

## 🚀 Opsi Deployment yang Direkomendasikan

### 1. Railway (Paling Mudah)
```bash
# Install Railway CLI
npm install -g @railway/cli

# Login dan deploy
railway login
railway init
railway up
```

### 2. Heroku
```bash
# Install Heroku CLI
# Login dan deploy
heroku login
heroku create your-app-name
git push heroku main
```

### 3. DigitalOcean App Platform
- Upload code ke GitHub
- Connect ke DigitalOcean App Platform
- Pilih PHP sebagai runtime

## 🔧 Jika Tetap Ingin Menggunakan Vercel

### Prerequisites
1. Database eksternal (PlanetScale, Supabase, atau MySQL hosting)
2. Vercel CLI
3. Environment variables yang sudah disiapkan

### Langkah-langkah

1. **Setup Database Eksternal**
   - Buat database di PlanetScale atau Supabase
   - Dapatkan connection string

2. **Install Vercel CLI**
   ```bash
   npm install -g vercel
   ```

3. **Login ke Vercel**
   ```bash
   vercel login
   ```

4. **Setup Environment Variables**
   ```bash
   vercel env add APP_KEY
   vercel env add DB_HOST
   vercel env add DB_DATABASE
   vercel env add DB_USERNAME
   vercel env add DB_PASSWORD
   ```

5. **Deploy**
   ```bash
   vercel --prod
   ```

6. **Setup Database**
   ```bash
   vercel env pull .env.local
   php scripts/setup-vercel.php
   ```

## 📝 Environment Variables yang Diperlukan

```
APP_NAME=YuAUCT
APP_ENV=production
APP_KEY=base64:your-generated-key
APP_DEBUG=false
APP_URL=https://your-app.vercel.app

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your-db-name
DB_USERNAME=your-db-username
DB_PASSWORD=your-db-password

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

## 🎯 Rekomendasi Akhir

Untuk aplikasi Laravel seperti YuAUCT, saya sangat merekomendasikan menggunakan **Railway** atau **Heroku** karena:

1. **Native PHP support** - Tidak perlu workaround
2. **Database integration** - Mudah setup database
3. **File storage** - Mendukung file upload
4. **Background jobs** - Mendukung queue workers
5. **SSL/HTTPS** - Otomatis tersedia

Vercel lebih cocok untuk frontend applications atau API yang menggunakan Node.js/Python.
