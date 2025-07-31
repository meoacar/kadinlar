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
      <div class="nav-dropdown" ref="dropdown">
        <button class="nav-link nav-link-dropdown" @click="toggleDropdown">
          Araçlar <span style="font-size:0.9em">▼</span>
        </button>
        <transition name="fade-slide">
          <div v-if="showTools" class="dropdown-menu">
            <router-link to="/bmi" class="dropdown-item" @click="closeDropdown">BMI Hesaplayıcı</router-link>
            <router-link to="/menstrual" class="dropdown-item" @click="closeDropdown">Regl Takvimi</router-link>
            <router-link to="/pregnancy" class="dropdown-item" @click="closeDropdown">Gebelik Hesaplama</router-link>
            <router-link to="/calorie" class="dropdown-item" @click="closeDropdown">Kalori Takibi</router-link>
            <router-link to="/payment" class="dropdown-item" @click="closeDropdown">Ödeme Sistemi</router-link>
          </div>
        </transition>
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
  },
  mounted() {
    document.addEventListener('click', this.handleClickOutside)
  },
  beforeUnmount() {
    document.removeEventListener('click', this.handleClickOutside)
  },
  methods: {
    toggleDropdown(e) {
      e.stopPropagation()
      this.showTools = !this.showTools
    },
    closeDropdown() {
      this.showTools = false
    },
    handleClickOutside(e) {
      if (this.showTools && this.$refs.dropdown && !this.$refs.dropdown.contains(e.target)) {
        this.showTools = false
      }
    }
  }
}
</script>

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
.nav-dropdown {
  position: relative;
}
.nav-link-dropdown {
  cursor: pointer;
  display: flex;
  align-items: center;
  background: none;
  border: none;
  outline: none;
  font: inherit;
  padding: 0;
}
.dropdown-menu {
  position: absolute;
  top: 2.2rem;
  left: 0;
  background: linear-gradient(135deg, #F3E5F5, #FFEBEE);
  border-radius: 16px;
  box-shadow: 0 8px 32px rgba(156,39,176,0.13), 0 1.5px 8px #E1F5FE;
  min-width: 210px;
  z-index: 20;
  padding: 0.7rem 0;
  animation: fadeIn 0.22s;
  border: 1.5px solid #E1F5FE;
}
.dropdown-item {
  display: block;
  padding: 0.85rem 1.3rem;
  color: #9C27B0;
  text-decoration: none;
  font-size: 1.08rem;
  transition: background 0.18s, color 0.18s;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  border-radius: 8px;
}
.dropdown-item:hover {
  background: #FFE4E6;
  color: #E91E63;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
.fade-slide-enter-active, .fade-slide-leave-active {
  transition: all 0.22s cubic-bezier(.4,0,.2,1);
}
.fade-slide-enter-from, .fade-slide-leave-to {
  opacity: 0;
  transform: translateY(10px);
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
  .dropdown-menu {
    left: 0;
    right: auto;
    min-width: 170px;
    top: 2.5rem;
  }
}
</style>

.dropdown-item:hover {
  background: #FFE4E6;
  color: #E91E63;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
.fade-slide-enter-active, .fade-slide-leave-active {
  transition: all 0.22s cubic-bezier(.4,0,.2,1);
}
.fade-slide-enter-from, .fade-slide-leave-to {
  opacity: 0;
  transform: translateY(10px);
}
@media (max-width: 700px) {
  .dropdown-menu {
    left: 0;
    right: auto;
    min-width: 170px;
    top: 2.5rem;
  }
}



<style scoped>
/* Dropdown Menü ve Navbar stilleri */
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
.nav-dropdown {
  position: relative;
}
.nav-link-dropdown {
  cursor: pointer;
  display: flex;
  align-items: center;
  background: none;
  border: none;
  outline: none;
  font: inherit;
  padding: 0;
}
.dropdown-menu {
  position: absolute;
  top: 2.2rem;
  left: 0;
  background: linear-gradient(135deg, #F3E5F5, #FFEBEE);
  border-radius: 16px;
  box-shadow: 0 8px 32px rgba(156,39,176,0.13), 0 1.5px 8px #E1F5FE;
  min-width: 210px;
  z-index: 20;
  padding: 0.7rem 0;
  animation: fadeIn 0.22s;
  border: 1.5px solid #E1F5FE;
}
.dropdown-item {
  display: block;
  padding: 0.85rem 1.3rem;
  color: #9C27B0;
  text-decoration: none;
  font-size: 1.08rem;
  transition: background 0.18s, color 0.18s;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  border-radius: 8px;
}
.dropdown-item:hover {
  background: #FFE4E6;
  color: #E91E63;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
.fade-slide-enter-active, .fade-slide-leave-active {
  transition: all 0.22s cubic-bezier(.4,0,.2,1);
}
.fade-slide-enter-from, .fade-slide-leave-to {
  opacity: 0;
  transform: translateY(10px);
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
  .dropdown-menu {
    left: 0;
    right: auto;
    min-width: 170px;
    top: 2.5rem;
  }
}
</style>
