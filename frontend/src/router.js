import { createRouter, createWebHistory } from 'vue-router'

// Dummy page components for demonstration
const Home = { template: '<div>Ana Sayfa</div>' }
const Zodiac = { template: '<div>Burçlar</div>' }
const Categories = { template: '<div>Kategoriler</div>' }
const Forum = { template: '<div>Forum</div>' }
const Login = { template: '<div>Giriş</div>' }

const routes = [
  { path: '/', component: Home },
  { path: '/zodiac', component: Zodiac },
  { path: '/categories', component: Categories },
  { path: '/forum', component: Forum },
  { path: '/login', component: Login },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
