<template>
  <div class="payment-tool">
    <h2 class="payment-title">Ödeme Yap</h2>
    <form @submit.prevent="submitPayment" class="payment-form">
      <div class="payment-field">
        <label>Tutar (₺):</label>
        <input v-model.number="amount" type="number" min="1" required />
      </div>
      <div class="payment-field">
        <label>Açıklama:</label>
        <input v-model="description" type="text" maxlength="100" />
      </div>
      <button class="payment-btn" :disabled="loading">Ödeme Oluştur</button>
    </form>
    <div v-if="result" class="payment-result">
      <div class="payment-value">Ödeme kaydı oluşturuldu. Durum: <b>{{ result.status }}</b></div>
      <div class="payment-id">ID: {{ result.id }}</div>
    </div>
    <div v-if="error" class="payment-error">{{ error }}</div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'PaymentForm',
  data() {
    return {
      amount: '',
      description: '',
      result: null,
      error: '',
      loading: false
    }
  },
  methods: {
    async submitPayment() {
      this.error = ''
      this.result = null
      this.loading = true
      try {
        const res = await axios.post('/api/payments', {
          amount: this.amount,
          description: this.description,
          provider: 'iyzico',
          currency: 'TRY'
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
.payment-tool {
  background: linear-gradient(135deg, #F3E5F5, #FFEBEE);
  border-radius: 18px;
  padding: 2rem 1.5rem;
  max-width: 400px;
  margin: 2rem auto;
  box-shadow: 0 4px 18px rgba(156,39,176,0.08);
}
.payment-title {
  color: #E91E63;
  font-size: 1.4rem;
  margin-bottom: 1.2rem;
  text-align: center;
}
.payment-form {
  display: flex;
  flex-direction: column;
  gap: 1.1rem;
}
.payment-field label {
  color: #9C27B0;
  font-weight: 500;
  margin-bottom: 0.3rem;
  display: block;
}
.payment-field input {
  width: 100%;
  padding: 0.5rem 0.7rem;
  border-radius: 8px;
  border: 1px solid #E1F5FE;
  font-size: 1rem;
}
.payment-btn {
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
.payment-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}
.payment-result {
  margin-top: 1.5rem;
  text-align: center;
}
.payment-value {
  font-size: 1.2rem;
  color: #2D3748;
}
.payment-id {
  font-size: 1.1rem;
  margin-top: 0.4rem;
}
.payment-error {
  color: #F56565;
  margin-top: 1rem;
  text-align: center;
}
</style>
