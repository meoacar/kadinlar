<template>
  <div class="tool-card">
    <h2 class="tool-title">Regl Takvimi</h2>
    <form @submit.prevent="calculate">
      <div class="form-group">
        <label>Son regl başlangıç tarihi</label>
        <input type="date" v-model="last_period_start" required />
      </div>
      <div class="form-group">
        <label>Döngü uzunluğu (gün)</label>
        <input type="number" v-model.number="cycle_length" min="20" max="40" required />
      </div>
      <div class="form-group">
        <label>Regl süresi (gün)</label>
        <input type="number" v-model.number="period_length" min="2" max="10" required />
      </div>
      <button class="tool-btn" type="submit">Hesapla</button>
    </form>
    <div v-if="result" class="result-box">
      <p><b>Sonraki regl başlangıcı:</b> {{ result.next_period_start }}</p>
      <p><b>Döngü uzunluğu:</b> {{ result.cycle_length }} gün</p>
      <p><b>Regl süresi:</b> {{ result.period_length }} gün</p>
    </div>
    <div v-if="error" class="error-msg">{{ error }}</div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  name: 'MenstrualCalendar',
  data() {
    return {
      last_period_start: '',
      cycle_length: 28,
      period_length: 5,
      result: null,
      error: ''
    }
  },
  methods: {
    async calculate() {
      this.result = null;
      this.error = '';
      try {
        const res = await axios.post('/health/menstrual', {
          last_period_start: this.last_period_start,
          cycle_length: this.cycle_length,
          period_length: this.period_length
        });
        this.result = res.data;
      } catch (err) {
        this.error = err.response?.data?.error || 'Bir hata oluştu.';
      }
    }
  }
}
</script>

<style scoped>
.tool-card {
  max-width: 400px;
  margin: 2rem auto;
  background: #F3E5F5;
  border-radius: 18px;
  box-shadow: 0 4px 18px rgba(156,39,176,0.08);
  padding: 2rem 2.2rem 1.5rem 2.2rem;
}
.tool-title {
  color: #E91E63;
  font-size: 1.5rem;
  margin-bottom: 1.2rem;
  text-align: center;
}
.form-group {
  margin-bottom: 1.1rem;
}
label {
  color: #9C27B0;
  font-weight: 500;
  margin-bottom: 0.3rem;
  display: block;
}
input[type="date"],
input[type="number"] {
  width: 100%;
  padding: 0.5rem 0.7rem;
  border-radius: 8px;
  border: 1.5px solid #E1F5FE;
  background: #fff;
  margin-top: 0.2rem;
  font-size: 1rem;
}
.tool-btn {
  width: 100%;
  background: linear-gradient(90deg, #E91E63, #9C27B0);
  color: #fff;
  border: none;
  border-radius: 8px;
  padding: 0.7rem 0;
  font-size: 1.1rem;
  font-weight: 600;
  margin-top: 0.7rem;
  cursor: pointer;
  transition: background 0.2s;
}
.tool-btn:hover {
  background: linear-gradient(90deg, #9C27B0, #E91E63);
}
.result-box {
  background: #E1F5FE;
  border-radius: 10px;
  padding: 1rem;
  margin-top: 1.2rem;
  color: #2D3748;
  font-size: 1.08rem;
}
.error-msg {
  color: #F56565;
  margin-top: 1rem;
  text-align: center;
}
</style>
