<template>
  <div class="app">
    <!-- Header -->
    <header class="header">
      <h1 class="logo">🌟 KadinAtlasi.com</h1>
      <nav>
        <a href="#" class="nav-link">Ana Sayfa</a>
        <a href="#" class="nav-link">Burç Yorumları</a>
        <a href="#" class="nav-link">Forum</a>
        <a href="#" class="nav-link">Giriş</a>
      </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-content">
        <h2 class="hero-title">Kadınlara Özel Dijital Yaşam Platformu</h2>
        <p class="hero-text">Astroloji, kişisel gelişim, sağlık ve daha fazlası...</p>
        <button class="hero-btn">Hemen Başla</button>
      </div>
    </section>

    <!-- Admin Dashboard for admin users -->
    <AdminDashboard 
      v-if="currentUser && currentUser.role === 'admin'"
      :currentUser="currentUser"
      @logout="logout"
    />

    <!-- Regular content for non-admin users -->
    <div v-else>
      <!-- Authentication Form -->
      <AuthForm v-if="!currentUser" @auth-success="handleAuthSuccess" />

      <!-- User Dashboard or Zodiac Calculator -->
      <div v-else>
        <div class="user-welcome">
          <h2>Hoş geldin, {{ currentUser.first_name }}! {{ currentUser.zodiac_sign?.symbol }}</h2>
          <button @click="logout" class="logout-btn">Çıkış Yap</button>
        </div>
        
        <!-- Zodiac Calculator -->
        <ZodiacCalculator />
      </div>
    </div>

    <!-- Features -->
    <section class="features">
      <div class="feature-card">
        <div class="feature-icon">♈</div>
        <h3>Burç Hesaplama</h3>
        <p>Doğum tarihinize göre otomatik burç hesaplama</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">💝</div>
        <h3>Kişisel Gelişim</h3>
        <p>Size özel gelişim önerileri</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">👥</div>
        <h3>Topluluk</h3>
        <p>Kadınlarla deneyim paylaşımı</p>
      </div>
    </section>
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
      currentUser: null
    }
  },
  methods: {
    handleAuthSuccess(data) {
      this.currentUser = data.user
      console.log('User logged in:', data.user)
      
      // Set axios authorization header
      axios.defaults.headers.common['Authorization'] = `Bearer ${data.token}`
      
      // Show success message based on role
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
  
  // Check for existing token on app load
  mounted() {
    const token = localStorage.getItem('auth_token')
    if (token) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
      // TODO: Verify token validity and get user data
    }
  }
}
</script>

<style scoped>
/* Ana uygulama */
.app {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(135deg, #FFE4E6 0%, #E8F4FD 50%, #FFF0E1 100%);
  min-height: 100vh;
}

/* Header */
.header {
  background: linear-gradient(90deg, #FFEBEE, #F3E5F5);
  padding: 1rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.logo {
  color: #E91E63;
  font-size: 1.8rem;
  font-weight: bold;
  margin: 0;
}

nav {
  display: flex;
  gap: 2rem;
}

.nav-link {
  color: #9C27B0;
  text-decoration: none;
  font-weight: 500;
  transition: color 0.3s;
}

.nav-link:hover {
  color: #E91E63;
}

/* Hero Section */
.hero {
  text-align: center;
  padding: 4rem 2rem;
  background: linear-gradient(45deg, #FCE4EC, #E1F5FE);
  margin: 2rem;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.hero-title {
  font-size: 3rem;
  color: #2D3748;
  margin-bottom: 1rem;
  background: linear-gradient(45deg, #E91E63, #9C27B0);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.hero-text {
  font-size: 1.2rem;
  color: #4A5568;
  margin-bottom: 2rem;
}

.hero-btn {
  background: linear-gradient(45deg, #E91E63, #FF9800);
  color: white;
  border: none;
  padding: 1rem 2rem;
  font-size: 1.1rem;
  border-radius: 50px;
  cursor: pointer;
  transition: transform 0.3s;
  box-shadow: 0 5px 15px rgba(233, 30, 99, 0.3);
}

.hero-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(233, 30, 99, 0.4);
}

/* Features */
.features {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
  padding: 4rem 2rem;
}

.feature-card {
  background: linear-gradient(135deg, #FFF8E1, #F1F8E9);
  padding: 2rem;
  border-radius: 15px;
  text-align: center;
  box-shadow: 0 5px 20px rgba(0,0,0,0.1);
  transition: transform 0.3s;
  border: 2px solid rgba(233, 30, 99, 0.1);
}

.feature-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.feature-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
}

.feature-card h3 {
  color: #E91E63;
  margin-bottom: 1rem;
  font-size: 1.3rem;
}

.feature-card p {
  color: #4A5568;
  line-height: 1.6;
}

/* Global styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* User Welcome Section */
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