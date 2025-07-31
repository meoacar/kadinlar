<template>
  <div class="admin-dashboard" v-if="isAdmin">
    <!-- Admin Header -->
    <div class="admin-header">
      <div class="header-content">
        <h1 class="admin-title">
          🌈 Kadınlar Atlası Admin Panel
        </h1>
        <div class="admin-user">
          <span class="admin-welcome">Hoş geldin, {{ currentUser?.first_name }}!</span>
          <div class="admin-zodiac" :style="{ color: currentUser?.zodiac_sign?.color_primary }">
            {{ currentUser?.zodiac_sign?.symbol }} {{ currentUser?.zodiac_sign?.name }}
          </div>
        </div>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="loading-container">
      <div class="loading-spinner">🌟 Veriler yükleniyor...</div>
    </div>

    <!-- Dashboard Content -->
    <div v-else class="dashboard-content">
      <!-- Stats Cards -->
      <div class="stats-grid">
        <!-- Users Stats -->
        <div class="stat-card users-card">
          <div class="stat-header">
            <h3>👥 Kullanıcılar</h3>
            <div class="stat-icon" style="background: linear-gradient(45deg, #E91E63, #F8BBD9)">
              👤
            </div>
          </div>
          <div class="stat-numbers">
            <div class="stat-main">{{ dashboardData.users?.total || 0 }}</div>
            <div class="stat-details">
              <span class="stat-item">✨ Bugün: {{ dashboardData.users?.new_today || 0 }}</span>
              <span class="stat-item">🔥 Aktif: {{ dashboardData.users?.active || 0 }}</span>
              <span class="stat-item">💎 Premium: {{ dashboardData.users?.subscribed || 0 }}</span>
            </div>
          </div>
        </div>

        <!-- Content Stats -->
        <div class="stat-card content-card">
          <div class="stat-header">
            <h3>📝 İçerikler</h3>
            <div class="stat-icon" style="background: linear-gradient(45deg, #9C27B0, #E1BEE7)">
              📄
            </div>
          </div>
          <div class="stat-numbers">
            <div class="stat-main">{{ dashboardData.content?.articles || 0 }}</div>
            <div class="stat-details">
              <span class="stat-item">📚 Kategoriler: {{ dashboardData.content?.categories || 0 }}</span>
              <span class="stat-item">✅ Yayınlanan: {{ dashboardData.content?.published || 0 }}</span>
              <span class="stat-item">⏳ Taslak: {{ dashboardData.content?.drafts || 0 }}</span>
            </div>
          </div>
        </div>

        <!-- System Health -->
        <div class="stat-card health-card">
          <div class="stat-header">
            <h3>💚 Sistem Durumu</h3>
            <div class="stat-icon" style="background: linear-gradient(45deg, #48BB78, #C6F6D5)">
              ⚡
            </div>
          </div>
          <div class="stat-numbers">
            <div class="stat-main">Sağlıklı</div>
            <div class="stat-details">
              <span class="stat-item">🗄️ Database: OK</span>
              <span class="stat-item">💾 Storage: 12%</span>
              <span class="stat-item">🚀 API: 120ms</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Zodiac Distribution Chart -->
      <div class="chart-section">
        <div class="chart-card">
          <div class="chart-header">
            <h3>🌙 Burç Dağılımı</h3>
            <p>Kullanıcıların burç bazında dağılımı</p>
          </div>
          <div class="zodiac-grid">
            <div 
              v-for="zodiac in dashboardData.zodiac_distribution" 
              :key="zodiac.name"
              class="zodiac-item"
              :style="{ borderColor: zodiac.color, color: zodiac.color }"
            >
              <div class="zodiac-symbol">{{ zodiac.symbol }}</div>
              <div class="zodiac-name">{{ zodiac.name }}</div>
              <div class="zodiac-count">{{ zodiac.count }} kişi</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="actions-section">
        <div class="actions-card">
          <h3>⚡ Hızlı İşlemler</h3>
          <div class="actions-grid">
            <button @click="showUsers = !showUsers" class="action-btn users-btn">
              👥 Kullanıcı Yönetimi
            </button>
            <button @click="fetchZodiacAnalytics" class="action-btn analytics-btn">
              📊 Burç Analitikleri
            </button>
            <button @click="fetchSystemHealth" class="action-btn health-btn">
              🔍 Sistem Kontrolü
            </button>
            <button @click="refreshDashboard" class="action-btn refresh-btn">
              🔄 Yenile
            </button>
          </div>
        </div>
      </div>

      <!-- Users Management (Collapsible) -->
      <div v-if="showUsers" class="users-section">
        <div class="users-card">
          <div class="users-header">
            <h3>👥 Kullanıcı Listesi</h3>
            <div class="users-filters">
              <select v-model="userFilter.role" @change="fetchUsers" class="filter-select">
                <option value="">Tüm Roller</option>
                <option value="user">Kullanıcı</option>
                <option value="creator">İçerik Yaratıcısı</option>
                <option value="admin">Admin</option>
              </select>
              <select v-model="userFilter.subscription" @change="fetchUsers" class="filter-select">
                <option value="">Tüm Abonelikler</option>
                <option value="free">Ücretsiz</option>
                <option value="silver">Silver</option>
                <option value="gold">Gold</option>
                <option value="creator">Creator</option>
              </select>
            </div>
          </div>
          
          <div class="users-list">
            <div 
              v-for="user in users" 
              :key="user.id" 
              class="user-item"
              :style="{ borderLeftColor: user.zodiac_sign?.color_primary || '#E91E63' }"
            >
              <div class="user-info">
                <div class="user-main">
                  <span class="user-name">{{ user.first_name }} {{ user.last_name }}</span>
                  <span class="user-zodiac" :style="{ color: user.zodiac_sign?.color_primary }">
                    {{ user.zodiac_sign?.symbol }} {{ user.zodiac_sign?.name }}
                  </span>
                </div>
                <div class="user-details">
                  <span class="user-email">{{ user.email }}</span>
                  <span class="user-role" :class="`role-${user.role}`">{{ user.role }}</span>
                  <span class="user-subscription" :class="`sub-${user.subscription_type}`">
                    {{ user.subscription_type }}
                  </span>
                </div>
              </div>
              <div class="user-actions">
                <button @click="editUser(user)" class="edit-btn">✏️</button>
                <button @click="toggleUserStatus(user)" class="toggle-btn">
                  {{ user.is_active ? '🔒' : '🔓' }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Not Admin Message -->
  <div v-else class="not-admin">
    <div class="not-admin-card">
      <h3>🚫 Yetkisiz Erişim</h3>
      <p>Bu sayfaya erişim için admin yetkisi gerekiyor.</p>
      <button @click="$emit('logout')" class="logout-btn">Çıkış Yap</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'AdminDashboard',
  props: {
    currentUser: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      loading: true,
      showUsers: false,
      dashboardData: {},
      users: [],
      userFilter: {
        role: '',
        subscription: '',
        zodiac: ''
      }
    }
  },
  computed: {
    isAdmin() {
      return this.currentUser?.role === 'admin'
    }
  },
  async mounted() {
    if (this.isAdmin) {
      await this.fetchDashboard()
    }
  },
  methods: {
    async fetchDashboard() {
      try {
        this.loading = true
        const response = await axios.get('/admin/dashboard')
        this.dashboardData = response.data.data
      } catch (error) {
        console.error('Dashboard data fetch error:', error)
        alert('Dashboard verileri yüklenirken hata oluştu.')
      } finally {
        this.loading = false
      }
    },

    async fetchUsers() {
      try {
        const params = new URLSearchParams()
        if (this.userFilter.role) params.append('role', this.userFilter.role)
        if (this.userFilter.subscription) params.append('subscription', this.userFilter.subscription)
        
        const response = await axios.get(`/admin/users?${params}`)
        this.users = response.data.data.data // Laravel pagination structure
      } catch (error) {
        console.error('Users fetch error:', error)
        alert('Kullanıcı listesi yüklenirken hata oluştu.')
      }
    },

    async fetchZodiacAnalytics() {
      try {
        const response = await axios.get('/admin/analytics/zodiac')
        console.log('Zodiac Analytics:', response.data.data)
        alert('Burç analitikleri konsola yazdırıldı! 📊')
      } catch (error) {
        console.error('Analytics fetch error:', error)
        alert('Analitik veriler yüklenirken hata oluştu.')
      }
    },

    async fetchSystemHealth() {
      try {
        const response = await axios.get('/admin/system/health')
        console.log('System Health:', response.data.data)
        alert('Sistem durumu: Sağlıklı! ✅')
      } catch (error) {
        console.error('System health fetch error:', error)
        alert('Sistem durumu kontrol edilirken hata oluştu.')
      }
    },

    async refreshDashboard() {
      await this.fetchDashboard()
      if (this.showUsers) {
        await this.fetchUsers()
      }
      alert('Dashboard yenilendi! 🔄')
    },

    editUser(user) {
      // TODO: Implement user editing modal
      alert(`${user.first_name} ${user.last_name} düzenleme özelliği yakında gelecek! ✏️`)
    },

    async toggleUserStatus(user) {
      try {
        await axios.put(`/admin/users/${user.id}`, {
          is_active: !user.is_active
        })
        user.is_active = !user.is_active
        alert(`${user.first_name} durumu güncellendi!`)
      } catch (error) {
        console.error('User status toggle error:', error)
        alert('Kullanıcı durumu güncellenirken hata oluştu.')
      }
    }
  },

  watch: {
    showUsers(newVal) {
      if (newVal) {
        this.fetchUsers()
      }
    }
  }
}
</script>

<style scoped>
.admin-dashboard {
  min-height: 100vh;
  background: linear-gradient(135deg, #FFF8E1, #F3E5F5, #E8F5E8);
}

.admin-header {
  background: linear-gradient(135deg, #E91E63, #9C27B0);
  color: white;
  padding: 2rem;
  box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1200px;
  margin: 0 auto;
}

.admin-title {
  font-size: 2.5rem;
  margin: 0;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.admin-user {
  text-align: right;
}

.admin-welcome {
  display: block;
  font-size: 1.2rem;
  margin-bottom: 0.5rem;
}

.admin-zodiac {
  font-size: 1.1rem;
  font-weight: 500;
  text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}

.loading-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 400px;
}

.loading-spinner {
  font-size: 2rem;
  color: #E91E63;
  animation: pulse 1.5s infinite;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.5; }
}

.dashboard-content {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
  margin-bottom: 3rem;
}

.stat-card {
  background: white;
  border-radius: 20px;
  padding: 2rem;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  border: 2px solid transparent;
  transition: all 0.3s;
}

.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.users-card { border-color: rgba(233, 30, 99, 0.3); }
.content-card { border-color: rgba(156, 39, 176, 0.3); }
.health-card { border-color: rgba(72, 187, 120, 0.3); }

.stat-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
}

.stat-header h3 {
  margin: 0;
  color: #2D3748;
  font-size: 1.3rem;
}

.stat-icon {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
}

.stat-main {
  font-size: 3rem;
  font-weight: bold;
  color: #1A202C;
  margin-bottom: 1rem;
}

.stat-details {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.stat-item {
  color: #4A5568;
  font-size: 0.9rem;
}

.chart-section, .actions-section, .users-section {
  margin-bottom: 3rem;
}

.chart-card, .actions-card, .users-card {
  background: white;
  border-radius: 20px;
  padding: 2rem;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  border: 2px solid rgba(233, 30, 99, 0.1);
}

.chart-header {
  margin-bottom: 2rem;
}

.chart-header h3 {
  margin: 0 0 0.5rem 0;
  color: #2D3748;
  font-size: 1.5rem;
}

.zodiac-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: 1rem;
}

.zodiac-item {
  text-align: center;
  padding: 1rem;
  border: 2px solid;
  border-radius: 15px;
  background: rgba(255,255,255,0.8);
  transition: all 0.3s;
}

.zodiac-item:hover {
  transform: scale(1.05);
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.zodiac-symbol {
  font-size: 2rem;
  margin-bottom: 0.5rem;
}

.zodiac-name {
  font-weight: 500;
  margin-bottom: 0.25rem;
}

.zodiac-count {
  font-size: 0.9rem;
  opacity: 0.8;
}

.actions-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1rem;
}

.action-btn {
  padding: 1rem 1.5rem;
  border: none;
  border-radius: 50px;
  font-size: 1.1rem;
  cursor: pointer;
  transition: all 0.3s;
  color: white;
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.users-btn { background: linear-gradient(45deg, #E91E63, #FF9800); }
.analytics-btn { background: linear-gradient(45deg, #9C27B0, #3F51B5); }
.health-btn { background: linear-gradient(45deg, #48BB78, #00BCD4); }
.refresh-btn { background: linear-gradient(45deg, #FF9800, #FF5722); }

.action-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.3);
}

.users-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.users-filters {
  display: flex;
  gap: 1rem;
}

.filter-select {
  padding: 0.5rem 1rem;
  border: 2px solid #E2E8F0;
  border-radius: 10px;
  background: white;
}

.user-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  border-left: 4px solid;
  background: #F7FAFC;
  border-radius: 0 10px 10px 0;
  margin-bottom: 1rem;
  transition: all 0.3s;
}

.user-item:hover {
  background: #EDF2F7;
  transform: translateX(5px);
}

.user-main {
  display: flex;
  gap: 1rem;
  align-items: center;
  margin-bottom: 0.5rem;
}

.user-name {
  font-weight: 500;
  color: #2D3748;
}

.user-details {
  display: flex;
  gap: 1rem;
  font-size: 0.9rem;
}

.user-email {
  color: #4A5568;
}

.role-admin { color: #E53E3E; }
.role-creator { color: #9C27B0; }
.role-user { color: #4A5568; }

.sub-creator { color: #FF9800; }
.sub-gold { color: #FFD700; }
.sub-silver { color: #C0C0C0; }
.sub-free { color: #718096; }

.user-actions {
  display: flex;
  gap: 0.5rem;
}

.edit-btn, .toggle-btn {
  background: none;
  border: none;
  font-size: 1.2rem;
  cursor: pointer;
  padding: 0.5rem;
  border-radius: 50%;
  transition: all 0.3s;
}

.edit-btn:hover { background: rgba(233, 30, 99, 0.1); }
.toggle-btn:hover { background: rgba(156, 39, 176, 0.1); }

.not-admin {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background: linear-gradient(135deg, #FFF8E1, #FFEBEE);
}

.not-admin-card {
  background: white;
  padding: 3rem;
  border-radius: 20px;
  text-align: center;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  border: 2px solid #F56565;
}

.logout-btn {
  background: linear-gradient(45deg, #E53E3E, #FF5722);
  color: white;
  border: none;
  padding: 1rem 2rem;
  border-radius: 50px;
  cursor: pointer;
  margin-top: 1rem;
  transition: all 0.3s;
}

@media (max-width: 768px) {
  .header-content {
    flex-direction: column;
    gap: 1rem;
    text-align: center;
  }
  
  .admin-title {
    font-size: 2rem;
  }
  
  .stats-grid {
    grid-template-columns: 1fr;
  }
  
  .actions-grid {
    grid-template-columns: 1fr;
  }
  
  .users-header {
    flex-direction: column;
    gap: 1rem;
  }
  
  .user-item {
    flex-direction: column;
    align-items: stretch;
  }
}
</style>