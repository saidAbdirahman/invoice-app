<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const password = ref('');
const passwordStrength = ref('');
const strengthClass = ref('');


const evaluatePasswordStrength = () => {
  const length = password.value.length;
  const hasNumbers = /\d/.test(password.value);
  const hasLetters = /[a-zA-Z]/.test(password.value);
  const hasSpecialChars = /[!@#$%^&*(),.?":{}|<>]/.test(password.value);

  if (length === 0) {
    passwordStrength.value = '';
    strengthClass.value = '';
  } else if (length < 8 || !hasNumbers || !hasLetters || !hasSpecialChars) {
    passwordStrength.value = 'Weak';
    strengthClass.value = 'weak';
  } else if (length < 12) {
    passwordStrength.value = 'Medium';
    strengthClass.value = 'medium';
  } else {
    passwordStrength.value = 'Strong';
    strengthClass.value = 'strong';
  }
};

const first_name = ref('');
const last_name = ref('');
const email = ref('');
const address = ref('');

const router = useRouter();

const onSave = async () => {

  const formData = new FormData();
  formData.append('first_name', first_name.value);
  formData.append('last_name', last_name.value);
  formData.append('email', email.value);
  formData.append('password', password.value);
  formData.append('address', address.value);

  try {
    const response = await axios.post('/api/add_new_customer', formData);
    alert(response.data.message);
    first_name.value = '';
    last_name.value = '';
    email.value = '';
    address.value = '';
    router.push('/invoices/get_all_customer');
  } catch (error) {
    console.error(error);
  }
};
</script>
  
<template>
    <div class="container">
      <div class="new-customer">
        <h2 class="customer__title">Add New Customer</h2>
        <div class="form-group">
          <label for="first_name">First Name</label>
          <input id="first_name" type="text" v-model="first_name" class="input">
        </div>
        <div class="form-group">
          <label for="last_name">Last Name</label>
          <input id="last_name" type="text" v-model="last_name" class="input">
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input id="email" type="email" v-model="email" class="input">
        </div>
        <div class="form-group">
          <label>Password:</label>
      <input class="input"
        type="password"
        v-model="password"
        @input="evaluatePasswordStrength"
        required
      />
      <p class="password-strength" :class="strengthClass">{{ passwordStrength }}</p>
        </div>
        <div class="form-group">
          <label for="address">Address</label>
          <input id="address" type="text" v-model="address" class="input">
        </div>
        <button class="btn btn-primary" @click="onSave">Save</button>
      </div>
    </div>
  </template>
  
  