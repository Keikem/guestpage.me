import Vue from 'vue'
import Router from 'vue-router'
import store from './store'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: '/public',
  routes: [
    {
      path: '/',
      name: 'main',
      component: () => import('./components/KMain')
    },
  ]
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (store.getters.isLogged) {
      next()
    } else {
      next('/')
    }
  } else {
    next()
  }
})

export default router;