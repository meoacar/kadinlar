import { createRouter, createWebHistory } from 'vue-router'
import BMICalculator from '../components/BMICalculator.vue'

const routes = [
  { path: '/bmi', name: 'BMICalculator', component: BMICalculator },
  { path: '/menstrual', name: 'MenstrualCalendar', component: () => import('../components/MenstrualCalendar.vue') },
  // Diğer sağlık/astroloji araçları buraya eklenecek
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
