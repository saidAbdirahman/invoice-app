import { createRouter, createWebHistory } from "vue-router";
import invoiceIndex from '../components/invoices/index.vue';
import invoiceShow from '../components/invoices/show.vue';
import invoiceEdit from '../components/invoices/edit.vue';
import invoiceNew from '../components/invoices/new.vue';
import notFound from '../components/NotFound.vue';
import newCustomer from '../components/invoices/add_new_customer.vue';
import getCustomers from '../components/invoices/get_all_customer.vue';

const routes = [
  {
    path: '/',
    component: invoiceIndex
  },

  {
    path: '/invoices/get_all_customer.vue',
    component: getCustomers
  },

  {
    path:'/invoice/show/:id',
    component: invoiceShow,
    props : true
  },
  {
    path:'/invoices/add_new_customer.vue',
    component: newCustomer,
    
  },
  {
    path:'/invoice/edit/:id',
    component: invoiceEdit,
    props : true
  },
  {
    path: '/invoice/new',
    component: invoiceNew
  },
  {
    path: '/:pathMatch(.*)*',
    component: notFound
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;