<template>
  <div class="calorie-tool">
    <h2 class="calorie-title">Günlük Kalori Takibi</h2>
    <form @submit.prevent="calculateCalories" class="calorie-form">
      <div class="calorie-field">
        <label>Kilo (kg):</label>
        <input v-model.number="weight" type="number" min="20" max="300" required />
      </div>
      <div class="calorie-field">
        <label>Boy (cm):</label>
        <input v-model.number="height" type="number" min="100" max="250" required />
      </div>
      <div class="calorie-field">
        <label>Yaş:</label>
        <input v-model.number="age" type="number" min="10" max="120" required />
      </div>
      <div class="calorie-field">
        <label>Cinsiyet:</label>
        <select v-model="gender" required>
          <option value="">Seçiniz</option>
          <option value="female">Kadın</option>
          <option value="male">Erkek</option>
        </select>
      </div>
      <div class="calorie-field">
        <label>Aktivite Seviyesi:</label>
        <select v-model="activity" required>
          <option value="1.2">Hareketsiz</option>
          <option value="1.375">Az Aktif</option>
          <option value="1.55">Orta Aktif</option>
          <option value="1.725">Çok Aktif</option>
        </select>
      </div>
      <button class="calorie-btn" :disabled="loading">Hesapla</button>
    </form>
    <div v-if="result" class="calorie-result">
      <div class="calorie-value">Tahmini Günlük Kalori: <b>{{ result.calories }}</b> kcal</div>
    </div>
    <div v-if="error" class="calorie-error">{{ error }}</div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'CalorieTracker',
  data() {
    return {
      weight: '',
      height: '',
      age: '',
      gender: '',
      activity: '1.2',
      result: null,
      error: '',
      loading: false
    }
  },
  methods: {
    async calculateCalories() {
      this.error = ''
      this.result = null
      this.loading = true
      try {
        const res = await axios.post('/api/health/calorie', {
          weight: this.weight,
          height: this.height,
          age: this.age,
          gender: this.gender,
          activity: this.activity
        })
        this.result = res.data
      } catch (e) {
        this.error = e.response?.data?.message || 'Bir hata oluştu.'
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped>
.calorie-tool {
  background: linear-gradient(135deg, #F3E5F5, #FFEBEE);
  border-radius: 18px;
  padding: 2rem 1.5rem;
  max-width: 400px;
  margin: 2rem auto;
  box-shadow: 0 4px 18px rgba(156,39,176,0.08);
}
.calorie-title {
  color: #E91E63;
  font-size: 1.4rem;
  margin-bottom: 1.2rem;
  text-align: center;
}
.calorie-form {
  display: flex;
  flex-direction: column;
  gap: 1.1rem;
}
.calorie-field label {
  color: #9C27B0;
  font-weight: 500;
  margin-bottom: 0.3rem;
  display: block;
}
.calorie-field input, .calorie-field select {
  width: 100%;
  padding: 0.5rem 0.7rem;
  border-radius: 8px;
  border: 1px solid #E1F5FE;
  font-size: 1rem;
}
.calorie-btn {
  background: linear-gradient(45deg, #E91E63, #FF9800);
  color: white;
  border: none;
  padding: 0.8rem 0;
  border-radius: 50px;
  font-size: 1.1rem;
  cursor: pointer;
  margin-top: 0.5rem;
  transition: background 0.2s;
}
.calorie-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}
.calorie-result {
  margin-top: 1.5rem;
  text-align: center;
}
.calorie-value {
  font-size: 1.2rem;
  color: #2D3748;
}
.calorie-error {
  color: #F56565;
  margin-top: 1rem;
  text-align: center;
}
</style>
