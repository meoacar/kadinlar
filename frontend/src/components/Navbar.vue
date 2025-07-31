
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
      <a href="#" class="nav-link">Giriş</a>
    </nav>
  </header>
</template>

<script>
export default {
  name: 'Navbar'
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
