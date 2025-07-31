<template>
  <div class="pregnancy-tool">
    <h2 class="pregnancy-title">Gebelik Haftası Hesaplama</h2>
    <form @submit.prevent="calculatePregnancy" class="pregnancy-form">
      <div class="pregnancy-field">
        <label>Son Adet Tarihi:</label>
        <input v-model="lastPeriod" type="date" required />
      </div>
      <button class="pregnancy-btn" :disabled="loading">Hesapla</button>
    </form>
    <div v-if="result" class="pregnancy-result">
      <div class="pregnancy-value">Gebelik Haftası: <b>{{ result.week }}</b></div>
      <div class="pregnancy-status">Tahmini Doğum: <b>{{ result.dueDate }}</b></div>
    </div>
    <div v-if="error" class="pregnancy-error">{{ error }}</div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'PregnancyCalculator',
  data() {
    return {
      lastPeriod: '',
      result: null,
      error: '',
      loading: false
    }
  },
  methods: {
    async calculatePregnancy() {
      this.error = ''
      this.result = null
      this.loading = true
      try {
        const res = await axios.post('/api/health/pregnancy', {
          lastPeriod: this.lastPeriod
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
.pregnancy-tool {
  background: linear-gradient(135deg, #F3E5F5, #FFEBEE);
  border-radius: 18px;
  padding: 2rem 1.5rem;
  max-width: 400px;
  margin: 2rem auto;
  box-shadow: 0 4px 18px rgba(156,39,176,0.08);
}
.pregnancy-title {
  color: #E91E63;
  font-size: 1.4rem;
  margin-bottom: 1.2rem;
  text-align: center;
}
.pregnancy-form {
  display: flex;
  flex-direction: column;
  gap: 1.1rem;
}
.pregnancy-field label {
  color: #9C27B0;
  font-weight: 500;
  margin-bottom: 0.3rem;
  display: block;
}
.pregnancy-field input {
  width: 100%;
  padding: 0.5rem 0.7rem;
  border-radius: 8px;
  border: 1px solid #E1F5FE;
  font-size: 1rem;
}
.pregnancy-btn {
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
.pregnancy-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}
.pregnancy-result {
  margin-top: 1.5rem;
  text-align: center;
}
.pregnancy-value {
  font-size: 1.2rem;
  color: #2D3748;
}
.pregnancy-status {
  font-size: 1.1rem;
  margin-top: 0.4rem;
}
.pregnancy-error {
  color: #F56565;
  margin-top: 1rem;
  text-align: center;
}
</style>
