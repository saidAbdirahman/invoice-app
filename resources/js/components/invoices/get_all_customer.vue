<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();

const customers = ref([])

const goBack = () => {
  router.push('/');
};

const showCustomer = async () => {
    let response = await axios.get("/api/get_all_customer")
    customers.value = response.data;
}

const newCustomer = async () => {
    // let form = await axios.get("/api/add_new_customer")
    // console.log('form', form.data)
    router.push('/invoices/add_new_customer')
}

onMounted(showCustomer)
</script>

<template>
    <div class="invoices-container">
      <div class="invoices-wrapper">
        <div class="invoices-header">
          <div>
            <h2 class="invoices-title">Invoices</h2>
          </div>
          <div>
            <a class="invoices-btn3" @click="goBack()" style="margin-right:5px;">Go Back</a>
            <a class="invoices-btn3" @click="newCustomer">+ Add New</a>
          </div>
        </div>
  
        <div class="invoices-content">
          <div class="invoices-table-heading">
            <p>First name</p>
            <p>Last name</p>
            <p>Email</p>
            <p>Address</p>
          </div>
  
          <div class="invoices-table-items">
            <!-- Display each customer -->
            <div v-for="(customer, index) in customers" :key="index" class="invoices-table-row"> 
              <p>{{ customer.first_name }}</p>
              <p>{{ customer.last_name }}</p>
              <p>{{ customer.email }}</p>
              <p>{{ customer.address }}</p>
            </div>
            <!-- Show a message if no customers are found -->
            <div v-if="customers.length === 0" class="invoices-table-row-empty">
              <p>No Customers Found</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <style scoped>
  .invoices-container {
    width: 100%;
    max-width: 950px;
    margin-top: 5rem;
    margin-left: auto;
    margin-right: auto;
  }
  
  .invoices-wrapper {
    background-color: #f1f1f1;
    color: #454f5b;
    padding: 20px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    box-shadow: 0 6px 13px -12px rgba(50, 50, 93, 0.2), 0 3px 7px -3px rgba(110, 110, 110, 0.1);
  }
  
  .invoices-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }
  
  .invoices-title {
    margin: 0;
    font-size: 1.5em;
    font-weight: bold;
    color: #006fbb;
  }
  
  .invoices-btn1,
  .invoices-btn2,
  .invoices-btn3 {
    background-color: #5463c1;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  .invoices-btn1:hover,
  .invoices-btn2:hover,
  .invoices-btn3:hover {
    background-color: #354a9c;
  }
  
  .invoices-table-heading {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    background-color: #ddd;
    padding: 10px;
    font-weight: bold;
  }
  
  .invoices-table-items {
    background-color: #fff;
    padding: 20px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    margin-top: 20px;
  }
  
  .invoices-table-row,
  .invoices-table-row-empty {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    padding: 10px;
    align-items: center;
    border-bottom: 1px solid #e0e0e0;
  }
  
  .invoices-table-row-empty p {
    color: red;
    font-style: italic;
  }
  </style>
