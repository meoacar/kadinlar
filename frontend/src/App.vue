<template>
  <div class="app">
    <!-- Modern Header -->
    <header class="header">
      <div class="logo-area">
        <img src="/logo.png" alt="KadinAtlasi Logo" class="logo-img" />
        <h1 class="logo-text">KadinAtlasi.com</h1>
      </div>
      <nav>
        <a href="#" class="nav-link">Ana Sayfa</a>
        <a href="#" class="nav-link">Burçlar</a>
        <a href="#" class="nav-link">Kategoriler</a>
        <a href="#" class="nav-link">Forum</a>
        <a href="#" class="nav-link">Giriş</a>
      </nav>
    </header>

    <!-- Hero Section: Gradient, animasyonlu, büyük -->
    <section class="hero">
      <div class="hero-content">
        <h2 class="hero-title">Kadınlara Özel Dijital Yaşam ve Astroloji Platformu</h2>
        <p class="hero-text">Astroloji, kişisel gelişim, sağlık, moda ve daha fazlası tek bir platformda!</p>
        <button class="hero-btn">Hemen Başla</button>
        <div class="hero-astro">
          <span v-for="z in zodiacs" :key="z.name" :style="{color: z.color}" class="zodiac-anim">{{ z.symbol }}</span>
        </div>
      </div>
    </section>

    <!-- Motivasyon Modülü -->
    <section class="motivation">
      <div class="motivation-card">
        <div class="motivation-icon">✨</div>
        <div class="motivation-text">{{ dailyMotivation }}</div>
      </div>
    </section>

    <!-- Kategoriler: Pastel kartlar -->
    <section class="categories">
      <div v-for="cat in categories" :key="cat.name" class="category-card" :style="{background: cat.bg}">
        <div class="category-icon">{{ cat.icon }}</div>
        <div class="category-title">{{ cat.name }}</div>
      </div>
    </section>

    <!-- Burç Kartları: Renkli, gradientli, animasyonlu -->
    <section class="zodiac-cards">
      <div v-for="z in zodiacs" :key="z.name" class="zodiac-card" :style="{background: z.bg}">
        <div class="zodiac-symbol">{{ z.symbol }}</div>
        <div class="zodiac-name">{{ z.name }}</div>
      </div>
    </section>

    <!-- Kullanıcı Girişi ve Dashboard ana sayfadan kaldırıldı -->
  </div>
</template>

<script>
import ZodiacCalculator from './components/ZodiacCalculator.vue'
import AuthForm from './components/AuthForm.vue'
import AdminDashboard from './components/AdminDashboard.vue'
import axios from 'axios'

export default {
  name: 'App',
  components: {
    ZodiacCalculator,
    AuthForm,
    AdminDashboard
  },
  data() {
    return {
      currentUser: null,
      dailyMotivation: 'Bugün kendin için bir iyilik yap! ✨',
      categories: [
        { name: 'Moda & Güzellik', icon: '💄', bg: 'linear-gradient(135deg, #FFEBEE, #F3E5F5)' },
        { name: 'Aşk & İlişkiler', icon: '💖', bg: 'linear-gradient(135deg, #FCE4EC, #E1F5FE)' },
        { name: 'Kariyer & Girişimcilik', icon: '💼', bg: 'linear-gradient(135deg, #FFF8E1, #F1F8E9)' },
        { name: 'Kişisel Gelişim', icon: '🌱', bg: 'linear-gradient(135deg, #E8F4FD, #FFE4E6)' },
        { name: 'Kadın Sağlığı', icon: '🩺', bg: 'linear-gradient(135deg, #F3E5F5, #FFF0E1)' },
        { name: 'Annelik & Bebek', icon: '👶', bg: 'linear-gradient(135deg, #E1F5FE, #FCE4EC)' },
        { name: 'Beslenme & Diyet', icon: '🥗', bg: 'linear-gradient(135deg, #FFF8E1, #F1F8E9)' },
        { name: 'Astroloji & Tarot', icon: '🔮', bg: 'linear-gradient(135deg, #FCE4EC, #E1F5FE)' },
        { name: 'Forum & Topluluk', icon: '👥', bg: 'linear-gradient(135deg, #E8F4FD, #FFE4E6)' },
        { name: 'Akademi', icon: '🎓', bg: 'linear-gradient(135deg, #F3E5F5, #FFF0E1)' },
      ],
      zodiacs: [
        { name: 'Koç', symbol: '♈', color: '#FFB3BA', bg: 'linear-gradient(135deg, #FFB3BA, #FFE4E6)' },
        { name: 'Boğa', symbol: '♉', color: '#BAFFC9', bg: 'linear-gradient(135deg, #BAFFC9, #F1F8E9)' },
        { name: 'İkizler', symbol: '♊', color: '#FFFFBA', bg: 'linear-gradient(135deg, #FFFFBA, #FFF8E1)' },
        { name: 'Yengeç', symbol: '♋', color: '#BAE1FF', bg: 'linear-gradient(135deg, #BAE1FF, #E1F5FE)' },
        { name: 'Aslan', symbol: '♌', color: '#FFD700', bg: 'linear-gradient(135deg, #FFD700, #FFF0E1)' },
        { name: 'Başak', symbol: '♍', color: '#E6E6FA', bg: 'linear-gradient(135deg, #E6E6FA, #F3E5F5)' },
        { name: 'Terazi', symbol: '♎', color: '#F0F8FF', bg: 'linear-gradient(135deg, #F0F8FF, #E1F5FE)' },
        { name: 'Akrep', symbol: '♏', color: '#DDA0DD', bg: 'linear-gradient(135deg, #DDA0DD, #F3E5F5)' },
        { name: 'Yay', symbol: '♐', color: '#F5DEB3', bg: 'linear-gradient(135deg, #F5DEB3, #FFF8E1)' },
        { name: 'Oğlak', symbol: '♑', color: '#D2B48C', bg: 'linear-gradient(135deg, #D2B48C, #FFF0E1)' },
        { name: 'Kova', symbol: '♒', color: '#B0E0E6', bg: 'linear-gradient(135deg, #B0E0E6, #E1F5FE)' },
        { name: 'Balık', symbol: '♓', color: '#F5F5DC', bg: 'linear-gradient(135deg, #F5F5DC, #E8F4FD)' },
      ]
    }
  },
  methods: {
    handleAuthSuccess(data) {
      this.currentUser = data.user
      axios.defaults.headers.common['Authorization'] = `Bearer ${data.token}`
      if (data.user.role === 'admin') {
        alert(`🌈 Admin olarak hoş geldin ${data.user.first_name}! Admin paneline yönlendiriliyorsun...`)
      } else {
        alert(`Hoş geldin ${data.user.first_name}! Burcun: ${data.user.zodiac_sign?.name} ${data.user.zodiac_sign?.symbol}`)
      }
    },
    logout() {
      this.currentUser = null
      localStorage.removeItem('auth_token')
      delete axios.defaults.headers.common['Authorization']
      alert('Başarıyla çıkış yaptın! 👋')
    }
  },
  mounted() {
    const token = localStorage.getItem('auth_token')
    if (token) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
    }
  }
}
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
.app {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(135deg, #FFE4E6 0%, #E8F4FD 50%, #FFF0E1 100%);
  min-height: 100vh;
}
.header {
  background: linear-gradient(90deg, #FFEBEE, #F3E5F5);
  padding: 1.2rem 2.5rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 2px 10px rgba(0,0,0,0.07);
}
.logo-area {
  display: flex;
  align-items: center;
  gap: 0.7rem;
}
.logo-img {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: #FFE4E6;
  border: 2px solid #E91E63;
}
.logo-text {
  color: #E91E63;
  font-size: 2rem;
  font-weight: bold;
  letter-spacing: 1px;
}
nav {
  display: flex;
  gap: 2rem;
}
.nav-link {
  color: #9C27B0;
  text-decoration: none;
  font-weight: 500;
  font-size: 1.1rem;
  transition: color 0.3s;
}
.nav-link:hover {
  color: #E91E63;
}
.hero {
  text-align: center;
  padding: 5rem 2rem 3rem 2rem;
  background: linear-gradient(45deg, #FCE4EC, #E1F5FE);
  margin: 2.5rem 1rem 2rem 1rem;
  border-radius: 30px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
  position: relative;
  overflow: hidden;
}
.hero-title {
  font-size: 2.7rem;
  color: #2D3748;
  margin-bottom: 1.2rem;
  background: linear-gradient(45deg, #E91E63, #9C27B0);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}
.hero-text {
  font-size: 1.3rem;
  color: #4A5568;
  margin-bottom: 2.2rem;
}
.hero-btn {
  background: linear-gradient(45deg, #E91E63, #FF9800);
  color: white;
  border: none;
  padding: 1.1rem 2.5rem;
  font-size: 1.2rem;
  border-radius: 50px;
  cursor: pointer;
  transition: transform 0.3s;
  box-shadow: 0 5px 15px rgba(233, 30, 99, 0.18);
}
.hero-btn:hover {
  transform: translateY(-2px) scale(1.04);
  box-shadow: 0 8px 25px rgba(233, 30, 99, 0.25);
}
.hero-astro {
  margin-top: 2.5rem;
}
.zodiac-anim {
  font-size: 2.2rem;
  margin: 0 0.5rem;
  animation: float 2.5s infinite ease-in-out alternate;
  filter: drop-shadow(0 2px 8px #fff3);
}
@keyframes float {
  0% { transform: translateY(0); }
  100% { transform: translateY(-18px); }
}
.motivation {
  display: flex;
  justify-content: center;
  margin: 2rem 0 1rem 0;
}
.motivation-card {
  background: linear-gradient(135deg, #F3E5F5, #FFEBEE);
  border-radius: 18px;
  padding: 1.5rem 2.5rem;
  box-shadow: 0 4px 18px rgba(156,39,176,0.08);
  display: flex;
  align-items: center;
  gap: 1.2rem;
  font-size: 1.3rem;
}
.motivation-icon {
  font-size: 2.2rem;
}
.categories {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 1.5rem;
  padding: 2rem 1.5rem 1rem 1.5rem;
}
.category-card {
  border-radius: 16px;
  padding: 1.5rem 1rem;
  text-align: center;
  box-shadow: 0 2px 10px rgba(0,0,0,0.07);
  font-size: 1.1rem;
  transition: transform 0.2s;
  cursor: pointer;
}
.category-card:hover {
  transform: scale(1.04);
  box-shadow: 0 6px 18px rgba(233, 30, 99, 0.13);
}
.category-icon {
  font-size: 2.1rem;
  margin-bottom: 0.7rem;
}
.category-title {
  color: #9C27B0;
  font-weight: 600;
  font-size: 1.1rem;
}
.zodiac-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
  gap: 1.2rem;
  padding: 2rem 1.5rem 1rem 1.5rem;
}
.zodiac-card {
  border-radius: 18px;
  padding: 1.2rem 0.5rem;
  text-align: center;
  box-shadow: 0 2px 10px rgba(0,0,0,0.07);
  font-size: 1.1rem;
  transition: transform 0.2s;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}
.zodiac-card:hover {
  transform: scale(1.05);
  box-shadow: 0 6px 18px rgba(233, 30, 99, 0.13);
}
.zodiac-symbol {
  font-size: 2.3rem;
  margin-bottom: 0.5rem;
}
.zodiac-name {
  color: #E91E63;
  font-weight: 600;
  font-size: 1.1rem;
}
.user-area {
  margin: 2.5rem 0 1.5rem 0;
}
.user-welcome {
  max-width: 600px;
  margin: 2rem auto;
  padding: 2rem;
  background: linear-gradient(135deg, #E8F4FD, #FFE4E6);
  border-radius: 20px;
  text-align: center;
  border: 2px solid rgba(233, 30, 99, 0.2);
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
.user-welcome h2 {
  color: #E91E63;
  margin-bottom: 1rem;
  font-size: 1.8rem;
}
.logout-btn {
  background: linear-gradient(45deg, #E91E63, #FF9800);
  color: white;
  border: none;
  padding: 0.75rem 2rem;
  border-radius: 50px;
  cursor: pointer;
  font-size: 1rem;
  transition: all 0.3s;
  box-shadow: 0 5px 15px rgba(233, 30, 99, 0.3);
}
.logout-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(233, 30, 99, 0.4);
}
body {
  margin: 0;
}
</style>