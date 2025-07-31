<template>
  <div class="bmi-tool">
    <h2 class="bmi-title">Vücut Kitle İndeksi (BMI) Hesaplayıcı</h2>
    <form @submit.prevent="calculateBMI" class="bmi-form">
      <div class="bmi-field">
        <label>Kilo (kg):</label>
        <input v-model.number="weight" type="number" min="20" max="300" required />
      </div>
      <div class="bmi-field">
        <label>Boy (cm):</label>
        <input v-model.number="height" type="number" min="100" max="250" required />
      </div>
      <button class="bmi-btn" :disabled="loading">Hesapla</button>
    </form>
    <div v-if="result" class="bmi-result">
      <div class="bmi-value">BMI: <b>{{ result.bmi }}</b></div>
      <div class="bmi-status">Durum: <span :class="statusClass(result.status)">{{ result.status }}</span></div>
    </div>
    <div v-if="error" class="bmi-error">{{ error }}</div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'BMICalculator',
  data() {
    return {
      weight: '',
      height: '',
      result: null,
      error: '',
      loading: false
    }
  },
  methods: {
    async calculateBMI() {
      this.error = ''
      this.result = null
      this.loading = true
      try {
        const res = await axios.post('/api/health/bmi', {
          weight: this.weight,
          height: this.height
        })
        this.result = res.data
      } catch (e) {
        this.error = e.response?.data?.message || 'Bir hata oluştu.'
      } finally {
        this.loading = false
      }
    },
    statusClass(status) {
      if (status === 'Zayıf') return 'bmi-weak'
      if (status === 'Normal') return 'bmi-normal'
      if (status === 'Fazla Kilolu') return 'bmi-over'
      return 'bmi-obese'
    }
  }
}
</script>

<style scoped>
.bmi-tool {
  background: linear-gradient(135deg, #F3E5F5, #FFEBEE);
  border-radius: 18px;
  padding: 2rem 1.5rem;
  max-width: 400px;
  margin: 2rem auto;
  box-shadow: 0 4px 18px rgba(156,39,176,0.08);
}
.bmi-title {
  color: #E91E63;
  font-size: 1.4rem;
  margin-bottom: 1.2rem;
  text-align: center;
}
.bmi-form {
  display: flex;
  flex-direction: column;
  gap: 1.1rem;
}
.bmi-field label {
  color: #9C27B0;
  font-weight: 500;
  margin-bottom: 0.3rem;
  display: block;
}
.bmi-field input {
  width: 100%;
  padding: 0.5rem 0.7rem;
  border-radius: 8px;
  border: 1px solid #E1F5FE;
  font-size: 1rem;
}
.bmi-btn {
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
.bmi-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}
.bmi-result {
  margin-top: 1.5rem;
  text-align: center;
}
.bmi-value {
  font-size: 1.2rem;
  color: #2D3748;
}
.bmi-status {
  font-size: 1.1rem;
  margin-top: 0.4rem;
}
.bmi-weak { color: #F56565; }
.bmi-normal { color: #48BB78; }
.bmi-over { color: #FF9800; }
.bmi-obese { color: #E91E63; }
.bmi-error {
  color: #F56565;
  margin-top: 1rem;
  text-align: center;
}
</style>
