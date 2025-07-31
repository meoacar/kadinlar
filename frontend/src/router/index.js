import { createRouter, createWebHistory } from 'vue-router'
import BMICalculator from '../components/BMICalculator.vue'

const routes = [
  { path: '/bmi', name: 'BMICalculator', component: BMICalculator },
  { path: '/menstrual', name: 'MenstrualCalendar', component: () => import('../components/MenstrualCalendar.vue') },
  { path: '/pregnancy', name: 'PregnancyCalculator', component: () => import('../components/PregnancyCalculator.vue') },
  { path: '/calorie', name: 'CalorieTracker', component: () => import('../components/CalorieTracker.vue') },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
