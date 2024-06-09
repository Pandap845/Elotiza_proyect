<template>
    <div v-if="message" :class="`alert ${alertClass}`">
      {{ message }}
    </div>
  </template>
  
  <script>
  export default {
    props: {
      message: {
        type: String,
        required: true,
      },
      status: {
        type: String,
        required: true,
      },
    },
    computed: {
      alertClass() {
        return this.status === 'success' ? 'alert-success' : 'alert-danger';
      },
    },
  };
  </script>
  
  <style scoped>
  .alert {
    padding: 1rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: 0.375rem;
  }
  .alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
  }
  .alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
  }
  </style>
  