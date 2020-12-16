const routes = [
  {
    path: '',
    component: () => import('../Pages/Index.vue'),
    children: [
      // TODO: validate here to go to dashboard if logged in
      {
        path: '',
        component: () => import('../Pages/Login.vue'),
        name: 'index'
      },
      {
        path: 'login',
        component: () => import('../Pages/Login.vue'),
        name: 'login-page'
      },
      {
        path: 'dashboard',
        component: () => import('../Pages/Dashboard.vue'),
        name: 'dashboard-page',
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'register',
        component: () => import('../Pages/Register.vue'),
        name: 'register-page'
      }
    ]
  },
]

export default routes;
