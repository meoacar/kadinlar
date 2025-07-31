
<template>
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
      <div class="nav-dropdown" @mouseenter="showTools = true" @mouseleave="showTools = false">
        <a href="#" class="nav-link nav-link-dropdown">Araçlar <span style="font-size:0.9em">▼</span></a>
        <div v-if="showTools" class="dropdown-menu">
          <router-link to="/bmi" class="dropdown-item">BMI Hesaplayıcı</router-link>
          <a href="#" class="dropdown-item">Regl Takvimi</a>
          <a href="#" class="dropdown-item">Gebelik Hesaplama</a>
          <a href="#" class="dropdown-item">Kalori Takibi</a>
        </div>
      </div>
      <a href="#" class="nav-link">Giriş</a>
    </nav>
  </header>
</template>

<script>
export default {
  name: 'Navbar',
  data() {
    return {
      showTools: false
    }
  }
}
</script>
/* Dropdown Menü */
.nav-dropdown {
  position: relative;
}
.nav-link-dropdown {
  cursor: pointer;
  display: flex;
  align-items: center;
}
.dropdown-menu {
  position: absolute;
  top: 2.2rem;
  left: 0;
  background: linear-gradient(135deg, #F3E5F5, #FFEBEE);
  border-radius: 12px;
  box-shadow: 0 4px 18px rgba(156,39,176,0.08);
  min-width: 180px;
  z-index: 10;
  padding: 0.5rem 0;
  animation: fadeIn 0.2s;
}
.dropdown-item {
  display: block;
  padding: 0.7rem 1.2rem;
  color: #9C27B0;
  text-decoration: none;
  font-size: 1.05rem;
  transition: background 0.2s, color 0.2s;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
}
.dropdown-item:hover {
  background: #FFE4E6;
  color: #E91E63;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

<style scoped>
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
@media (max-width: 700px) {
  .header {
    flex-direction: column;
    align-items: flex-start;
    padding: 1rem 1.2rem;
  }
  nav {
    gap: 1rem;
    margin-top: 0.7rem;
  }
  .logo-text {
    font-size: 1.3rem;
  }
}
</style>
