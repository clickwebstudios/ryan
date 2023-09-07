import {createRouter, createWebHistory} from 'vue-router';

import FormLayout from '../vue/pages/FormLayout.vue';
import PageForm from '../vue/pages/PageForm.vue';

const router = createRouter({
  history: createWebHistory('/'),
  routes: [
    {
      path: '/',
      name: 'site',
      component: FormLayout,
      children: [
        {
          path: 'form',
          name: 'form',
          component: PageForm,
        },
      ]
    },
  ]
});

export default router;
