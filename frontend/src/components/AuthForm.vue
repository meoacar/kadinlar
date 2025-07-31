<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-pink-100 to-purple-100">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
      <h2 class="text-2xl font-bold mb-6 text-center text-pink-600">Kayıt Ol</h2>
      <form @submit.prevent="register">
        <div class="mb-4">
          <label class="block text-gray-700">Ad Soyad</label>
          <input v-model="registerForm.name" type="text" class="w-full border rounded px-3 py-2 mt-1" required />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700">E-posta</label>
          <input v-model="registerForm.email" type="email" class="w-full border rounded px-3 py-2 mt-1" required />
        </div>
        <div class="mb-6">
          <label class="block text-gray-700">Şifre</label>
          <input v-model="registerForm.password" type="password" class="w-full border rounded px-3 py-2 mt-1" required />
        </div>
        <button type="submit" class="w-full bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded">Kayıt Ol</button>
      </form>
      <div v-if="registerError" class="mt-4 text-red-500 text-center">{{ registerError }}</div>
      <div v-if="registerSuccess" class="mt-4 text-green-500 text-center">Kayıt başarılı! Giriş yapabilirsiniz.</div>
      <hr class="my-8" />
      <h2 class="text-2xl font-bold mb-6 text-center text-purple-600">Giriş Yap</h2>
      <form @submit.prevent="login">
        <div class="mb-4">
          <label class="block text-gray-700">E-posta</label>
          <input v-model="loginForm.email" type="email" class="w-full border rounded px-3 py-2 mt-1" required />
        </div>
        <div class="mb-6">
          <label class="block text-gray-700">Şifre</label>
          <input v-model="loginForm.password" type="password" class="w-full border rounded px-3 py-2 mt-1" required />
        </div>
        <button type="submit" class="w-full bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded">Giriş Yap</button>
      </form>
      <div v-if="loginError" class="mt-4 text-red-500 text-center">{{ loginError }}</div>
      <div v-if="loginSuccess" class="mt-4 text-green-500 text-center">Giriş başarılı! Hoş geldiniz.</div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const registerForm = ref({ name: '', email: '', password: '' })
const loginForm = ref({ email: '', password: '' })
const registerError = ref('')
const registerSuccess = ref(false)
const loginError = ref('')
const loginSuccess = ref(false)

const API_URL = 'http://localhost:8000/api'

async function register() {
  registerError.value = ''
  registerSuccess.value = false
  try {
    await axios.post(`${API_URL}/register`, registerForm.value)
    registerSuccess.value = true
    registerForm.value = { name: '', email: '', password: '' }
  } catch (err) {
    registerError.value = err.response?.data?.message || 'Kayıt başarısız.'
  }
}

async function login() {
  loginError.value = ''
  loginSuccess.value = false
  try {
    const res = await axios.post(`${API_URL}/login`, loginForm.value)
    localStorage.setItem('token', res.data.token)
    loginSuccess.value = true
    loginForm.value = { email: '', password: '' }
  } catch (err) {
    loginError.value = err.response?.data?.error || 'Giriş başarısız.'
  }
}
</script>

<style scoped>
body {
  font-family: 'Inter', sans-serif;
}
</style>
<template>
  <div class="auth-container">
    <div class="auth-card">
      <div class="auth-header">
        <h2 class="auth-title">
          {{ isLogin ? '🌟 Giriş Yap' : '✨ Kayıt Ol' }}
        </h2>
        <p class="auth-subtitle">
          {{ isLogin ? 'Hesabına giriş yap' : 'Burcunu keşfetmeye başla!' }}
        </p>
      </div>

      <form @submit.prevent="handleSubmit" class="auth-form">
        <!-- Registration fields -->
        <div v-if="!isLogin" class="form-row">
          <div class="form-group">
            <label>Adın</label>
            <input 
              type="text" 
              v-model="form.first_name" 
              required 
              class="form-input"
              placeholder="Adınız"
            />
          </div>
          <div class="form-group">
            <label>Soyadın</label>
            <input 
              type="text" 
              v-model="form.last_name" 
              required 
              class="form-input"
              placeholder="Soyadınız"
            />
          </div>
        </div>

        <!-- Email -->
        <div class="form-group">
          <label>E-posta</label>
          <input 
            type="email" 
            v-model="form.email" 
            required 
            class="form-input"
            placeholder="ornek@email.com"
          />
        </div>

        <!-- Password -->
        <div class="form-group">
          <label>Şifre</label>
          <input 
            type="password" 
            v-model="form.password" 
            required 
            class="form-input"
            :placeholder="isLogin ? 'Şifreniz' : 'En az 8 karakter'"
          />
        </div>

        <!-- Password confirmation for registration -->
        <div v-if="!isLogin" class="form-group">
          <label>Şifre Tekrar</label>
          <input 
            type="password" 
            v-model="form.password_confirmation" 
            required 
            class="form-input"
            placeholder="Şifreyi tekrar girin"
          />
        </div>

        <!-- Birth date for registration -->
        <div v-if="!isLogin" class="form-group">
          <label>Doğum Tarihin 🌙</label>
          <input 
            type="date" 
            v-model="form.birth_date" 
            required 
            class="form-input"
          />
          <small class="form-help">Burcunu hesaplayabilmek için gerekli</small>
        </div>

        <!-- Optional birth details for registration -->
        <div v-if="!isLogin" class="form-row">
          <div class="form-group">
            <label>Doğum Saati (opsiyonel)</label>
            <input 
              type="time" 
              v-model="form.birth_time" 
              class="form-input"
            />
          </div>
          <div class="form-group">
            <label>Doğum Yeri (opsiyonel)</label>
            <input 
              type="text" 
              v-model="form.birth_place" 
              class="form-input"
              placeholder="İstanbul"
            />
          </div>
        </div>

        <!-- Error display -->
        <div v-if="error" class="error-message">
          {{ error }}
        </div>

        <!-- Success display -->
        <div v-if="success" class="success-message">
          {{ success }}
        </div>

        <!-- Submit button -->
        <button 
          type="submit" 
          :disabled="loading" 
          class="auth-submit"
        >
          <span v-if="loading">{{ isLogin ? 'Giriş yapılıyor...' : 'Kayıt olunuyor...' }} ⏳</span>
          <span v-else>{{ isLogin ? 'Giriş Yap 🚀' : 'Kayıt Ol 🌟' }}</span>
        </button>
      </form>

      <!-- Toggle between login/register -->
      <div class="auth-toggle">
        <p v-if="isLogin">
          Hesabın yok mu? 
          <button @click="isLogin = false" class="toggle-btn">Kayıt ol</button>
        </p>
        <p v-else>
          Zaten hesabın var mı? 
          <button @click="isLogin = true" class="toggle-btn">Giriş yap</button>
        </p>
      </div>

      <!-- User info display after success -->
      <div v-if="user" class="user-info">
        <div class="user-card" :style="userCardStyle">
          <h3>Hoş Geldin, {{ user.first_name }}! 🎉</h3>
          <div class="zodiac-info">
            <span class="zodiac-symbol">{{ user.zodiac_sign?.symbol }}</span>
            <div>
              <strong>{{ user.zodiac_sign?.name }}</strong>
              <p>{{ user.zodiac_sign?.element }} elementi</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'AuthForm',
  data() {
    return {
      isLogin: true,
      loading: false,
      error: null,
      success: null,
      user: null,
      form: {
        first_name: '',
        last_name: '',
        email: '',
        password: '',
        password_confirmation: '',
        birth_date: '',
        birth_time: '',
        birth_place: ''
      }
    }
  },
  computed: {
    userCardStyle() {
      if (!this.user?.zodiac_sign) return {}
      return {
        background: `linear-gradient(135deg, ${this.user.zodiac_sign.color_primary}20, ${this.user.zodiac_sign.color_secondary || this.user.zodiac_sign.color_primary}20)`,
        borderColor: this.user.zodiac_sign.color_primary
      }
    }
  },
  methods: {
    async handleSubmit() {
      this.loading = true
      this.error = null
      this.success = null

      try {
        const endpoint = this.isLogin ? '/auth/login' : '/auth/register'
        const data = this.isLogin 
          ? { email: this.form.email, password: this.form.password }
          : this.form

        const response = await axios.post(endpoint, data)

        if (response.data.status === 'success') {
          this.success = response.data.message
          this.user = response.data.data.user
          
          // Store token
          localStorage.setItem('auth_token', response.data.data.token)
          
          // Set axios default header
          axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.data.token}`
          
          // Emit success event
          this.$emit('auth-success', response.data.data)
          
          if (!this.isLogin) {
            this.success += ` Burcun: ${this.user.zodiac_sign?.name} ${this.user.zodiac_sign?.symbol}`
          }
        }
      } catch (err) {
        console.error('Auth Error:', err)
        if (err.response?.data?.message) {
          this.error = err.response.data.message
        } else if (err.response?.data?.errors) {
          const errors = Object.values(err.response.data.errors).flat()
          this.error = errors.join(', ')
        } else {
          this.error = 'Bir hata oluştu. Lütfen tekrar deneyin.'
        }
      } finally {
        this.loading = false
      }
    },
    
    resetForm() {
      this.form = {
        first_name: '',
        last_name: '',
        email: '',
        password: '',
        password_confirmation: '',
        birth_date: '',
        birth_time: '',
        birth_place: ''
      }
      this.error = null
      this.success = null
      this.user = null
    }
  },
  watch: {
    isLogin() {
      this.resetForm()
    }
  }
}
</script>

<style scoped>
.auth-container {
  max-width: 500px;
  margin: 2rem auto;
  padding: 0 1rem;
}

.auth-card {
  background: linear-gradient(135deg, #FFF8E1, #F1F8E9);
  border-radius: 20px;
  padding: 2rem;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  border: 2px solid rgba(233, 30, 99, 0.1);
}

.auth-header {
  text-align: center;
  margin-bottom: 2rem;
}

.auth-title {
  font-size: 2rem;
  color: #E91E63;
  margin-bottom: 0.5rem;
  background: linear-gradient(45deg, #E91E63, #9C27B0);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.auth-subtitle {
  color: #4A5568;
}

.auth-form {
  margin-bottom: 2rem;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  color: #2D3748;
  font-weight: 500;
  margin-bottom: 0.5rem;
}

.form-input {
  width: 100%;
  padding: 0.75rem;
  border: 2px solid #E2E8F0;
  border-radius: 10px;
  font-size: 1rem;
  transition: border-color 0.3s;
  background: white;
}

.form-input:focus {
  outline: none;
  border-color: #E91E63;
  box-shadow: 0 0 0 3px rgba(233, 30, 99, 0.1);
}

.form-help {
  color: #718096;
  font-size: 0.85rem;
  margin-top: 0.25rem;
}

.auth-submit {
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

.auth-submit:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(233, 30, 99, 0.4);
}

.auth-submit:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.error-message {
  background: linear-gradient(135deg, #FED7D7, #FEB2B2);
  border: 2px solid #F56565;
  color: #C53030;
  padding: 1rem;
  border-radius: 10px;
  margin-bottom: 1rem;
  text-align: center;
}

.success-message {
  background: linear-gradient(135deg, #C6F6D5, #9AE6B4);
  border: 2px solid #48BB78;
  color: #2F855A;
  padding: 1rem;
  border-radius: 10px;
  margin-bottom: 1rem;
  text-align: center;
}

.auth-toggle {
  text-align: center;
  margin-top: 2rem;
}

.toggle-btn {
  background: none;
  border: none;
  color: #E91E63;
  cursor: pointer;
  font-weight: 500;
  text-decoration: underline;
}

.user-info {
  margin-top: 2rem;
}

.user-card {
  padding: 1.5rem;
  border-radius: 15px;
  border: 2px solid;
  text-align: center;
}

.zodiac-info {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 1rem;
  margin-top: 1rem;
}

.zodiac-symbol {
  font-size: 2rem;
}

@media (max-width: 768px) {
  .form-row {
    grid-template-columns: 1fr;
  }
  
  .auth-card {
    padding: 1.5rem;
  }
}
</style>