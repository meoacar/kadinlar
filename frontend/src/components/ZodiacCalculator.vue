<template>
  <div class="zodiac-calculator">
    <div class="calculator-card">
      <h2 class="title">🌟 Burcunu Öğren</h2>
      <p class="subtitle">Doğum tarihinle burcunu ve renklerini keşfet!</p>
      
      <form @submit.prevent="calculateZodiac" class="form">
        <div class="input-group">
          <label for="birthDate" class="label">Doğum Tarihin:</label>
          <input 
            type="date" 
            id="birthDate" 
            v-model="birthDate" 
            required 
            class="date-input"
          />
        </div>
        
        <button type="submit" :disabled="loading" class="calculate-btn">
          <span v-if="loading">Hesaplanıyor... ⏳</span>
          <span v-else">Burcumu Hesapla ✨</span>
        </button>
      </form>

      <!-- Result Display -->
      <div v-if="result" class="result-card" :style="resultStyle">
        <div class="zodiac-symbol">{{ result.zodiac_sign.symbol }}</div>
        <div class="zodiac-info">
          <h3 class="zodiac-name">{{ result.zodiac_sign.name }}</h3>
          <p class="zodiac-element">{{ result.zodiac_sign.element }} Elementi</p>
          <p class="zodiac-description">{{ result.zodiac_sign.description }}</p>
          
          <div class="traits">
            <div class="strengths">
              <strong>Güçlü Yönlerin:</strong>
              <p>{{ result.zodiac_sign.strengths }}</p>
            </div>
            <div class="weaknesses">
              <strong>Dikkat Etmen Gerekenler:</strong>
              <p>{{ result.zodiac_sign.weaknesses }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Error Display -->
      <div v-if="error" class="error-card">
        <p>{{ error }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'ZodiacCalculator',
  data() {
    return {
      birthDate: '',
      result: null,
      error: null,
      loading: false
    }
  },
  computed: {
    resultStyle() {
      if (!this.result) return {}
      return {
        background: `linear-gradient(135deg, ${this.result.zodiac_sign.color_primary}20, ${this.result.zodiac_sign.color_secondary || this.result.zodiac_sign.color_primary}20)`,
        borderColor: this.result.zodiac_sign.color_primary
      }
    }
  },
  methods: {
    async calculateZodiac() {
      this.loading = true
      this.error = null
      this.result = null

      try {
        const response = await axios.post('/zodiac/calculate', {
          birth_date: this.birthDate
        })

        if (response.data.status === 'success') {
          this.result = response.data.data
        } else {
          this.error = response.data.message || 'Burç hesaplanamadı'
        }
      } catch (err) {
        console.error('API Error:', err)
        this.error = 'Bağlantı hatası. Lütfen tekrar deneyin.'
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped>
.zodiac-calculator {
  max-width: 600px;
  margin: 2rem auto;
  padding: 0 1rem;
}

.calculator-card {
  background: linear-gradient(135deg, #FFF8E1, #F1F8E9);
  border-radius: 20px;
  padding: 2rem;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  border: 2px solid rgba(233, 30, 99, 0.1);
}

.title {
  font-size: 2rem;
  color: #E91E63;
  text-align: center;
  margin-bottom: 0.5rem;
  background: linear-gradient(45deg, #E91E63, #9C27B0);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.subtitle {
  text-align: center;
  color: #4A5568;
  margin-bottom: 2rem;
}

.form {
  margin-bottom: 2rem;
}

.input-group {
  margin-bottom: 1.5rem;
}

.label {
  display: block;
  color: #2D3748;
  font-weight: 500;
  margin-bottom: 0.5rem;
}

.date-input {
  width: 100%;
  padding: 1rem;
  border: 2px solid #E2E8F0;
  border-radius: 10px;
  font-size: 1rem;
  transition: border-color 0.3s;
  background: white;
}

.date-input:focus {
  outline: none;
  border-color: #E91E63;
  box-shadow: 0 0 0 3px rgba(233, 30, 99, 0.1);
}

.calculate-btn {
  width: 100%;
  background: linear-gradient(45deg, #E91E63, #FF9800);
  color: white;
  border: none;
  padding: 1rem 2rem;
  font-size: 1.1rem;
  border-radius: 50px;
  cursor: pointer;
  transition: all 0.3s;
  box-shadow: 0 5px 15px rgba(233, 30, 99, 0.3);
}

.calculate-btn:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(233, 30, 99, 0.4);
}

.calculate-btn:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.result-card {
  margin-top: 2rem;
  padding: 2rem;
  border-radius: 15px;
  border: 2px solid;
  display: flex;
  gap: 1.5rem;
  align-items: center;
}

.zodiac-symbol {
  font-size: 4rem;
  text-align: center;
  min-width: 80px;
}

.zodiac-info {
  flex: 1;
}

.zodiac-name {
  font-size: 1.8rem;
  color: #2D3748;
  margin-bottom: 0.5rem;
}

.zodiac-element {
  color: #4A5568;
  font-weight: 500;
  margin-bottom: 1rem;
}

.zodiac-description {
  color: #718096;
  line-height: 1.6;
  margin-bottom: 1.5rem;
}

.traits {
  display: grid;
  gap: 1rem;
}

.strengths, .weaknesses {
  padding: 1rem;
  border-radius: 10px;
  background: rgba(255, 255, 255, 0.7);
}

.strengths strong, .weaknesses strong {
  color: #E91E63;
  display: block;
  margin-bottom: 0.5rem;
}

.error-card {
  margin-top: 2rem;
  padding: 1rem;
  background: linear-gradient(135deg, #FED7D7, #FEB2B2);
  border: 2px solid #F56565;
  border-radius: 10px;
  color: #C53030;
  text-align: center;
}

@media (max-width: 768px) {
  .result-card {
    flex-direction: column;
    text-align: center;
  }
  
  .zodiac-symbol {
    min-width: auto;
  }
}
</style>