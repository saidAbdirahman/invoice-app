<script>
import axios from 'axios';

export default {
  data() {
    return {
      first_name: '',
      last_name: '',
      email: '',
      address: '',
    };
  },
  methods: {
    onSave() {
      const formData = new FormData();
      formData.append('first_name', this.first_name);
      formData.append('last_name', this.last_name);
      formData.append('email', this.email);
      formData.append('address', this.address);

      axios.post('/api/add_new_customer', formData)
        .then(response => {
          alert(response.data.message);
          this.first_name = '';
          this.last_name = '';
          this.email = '';
          this.address = '';
        })
        .catch(error => {
          console.error('There was an error!', error);
          let errorMessage = 'There was an error submitting the form. Please try again.';

          if (error.response) {
            errorMessage = `Error: ${error.response.data.message || error.response.statusText}`;
          } else if (error.request) {
            errorMessage = 'No response received from the server.';
          } else {
            errorMessage = `Error: ${error.message}`;
          }

          alert(errorMessage);
        });
    }
  }
}
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
          <label for="address">Address</label>
          <input id="address" type="text" v-model="address" class="input">
        </div>
        <button class="btn btn-primary" @click="onSave">Save</button>
      </div>
    </div>
  </template>
  
  