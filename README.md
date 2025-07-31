# 🌟 KadinAtlasi.com

Türkiye'de **kadınlara özel**, **astroloji odaklı** dijital yaşam platformu.

## ✨ Özellikler

- 🌙 **Burç Hesaplama**: Doğum tarihi ile otomatik burç hesaplama
- 🎨 **Kişiselleştirilmiş Renkler**: Her burç için özel renk paleti
- 📱 **Responsive Tasarım**: Mobil öncelikli, modern arayüz
- 🚀 **API-First**: RESTful API mimarisi
- 🔒 **Güvenli**: CORS, CSRF, XSS korumaları

## 🛠 Teknolojiler

### Backend
- **Laravel 12.21.0** - PHP Framework
- **MySQL** - Database
- **JWT** - Authentication

### Frontend  
- **Vue.js 3** - Progressive Framework
- **Vite** - Build Tool
- **Tailwind CSS** - Utility-First CSS
- **Axios** - HTTP Client

## 🚀 Kurulum

### Backend Kurulumu
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed --class=ZodiacSignsSeeder
php artisan serve --port=8000
```

### Frontend Kurulumu
```bash
cd frontend
npm install
npm run dev
```

## 📊 API Endpoints

### Burç Hesaplama
```bash
POST /api/zodiac/calculate
{
  "birth_date": "1990-07-15"
}
```

### Tüm Burcları Listele
```bash
GET /api/zodiac/signs
```

### Burç Uyumluluğu
```bash
POST /api/zodiac/compatibility
{
  "sign1_id": 1,
  "sign2_id": 5
}
```

## 🌈 Burç Renkleri

| Burç | Sembol | Renk | Element |
|------|--------|------|---------|
| Koç | ♈ | #FFB3BA | Ateş |
| Boğa | ♉ | #BAFFC9 | Toprak |
| İkizler | ♊ | #FFFFBA | Hava |
| Yengeç | ♋ | #BAE1FF | Su |
| Aslan | ♌ | #FFD700 | Ateş |
| Başak | ♍ | #E6E6FA | Toprak |
| Terazi | ♎ | #F0F8FF | Hava |
| Akrep | ♏ | #DDA0DD | Su |
| Yay | ♐ | #F5DEB3 | Ateş |
| Oğlak | ♑ | #D2B48C | Toprak |
| Kova | ♒ | #B0E0E6 | Hava |
| Balık | ♓ | #F5F5DC | Su |

## 🎯 Gelecek Özellikler

- [ ] User Authentication
- [ ] Admin Panel  
- [ ] İçerik Yönetimi
- [ ] Ödeme Sistemi (Iyzico)
- [ ] Mobile App
- [ ] AI Destekli İçerik
- [ ] Canlı Yayın

## 📋 Proje Yapısı

```
kadinlar/
├── backend/          # Laravel API
├── frontend/         # Vue.js SPA  
├── PRD.MD           # Proje Gereksinimleri
└── README.md        # Bu dosya
```

## 🤝 Katkıda Bulunma

1. Fork edin
2. Feature branch oluşturun (`git checkout -b feature/amazing-feature`)
3. Commit edin (`git commit -m 'Add amazing feature'`)
4. Push edin (`git push origin feature/amazing-feature`)
5. Pull Request açın

## 📄 Lisans

Bu proje MIT lisansı altında lisanslanmıştır.

---

**Made with 💜 for Turkish Women** 🇹🇷