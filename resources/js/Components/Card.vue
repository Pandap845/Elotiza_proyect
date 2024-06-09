<template>
    <div class="card" @click="$emit('click')">
      <img :src="images[image]" :alt="title" />
      <button>{{ title }}</button>
    </div>
  </template>
  
  <script setup>
  import { defineProps } from 'vue';
  
  const props = defineProps({
    title: String,
    image: String,
  });
  
  const images = {
    perfil: '/storage/images/logo1.jpg',
    suministros: '/storage/images/elotes.jpg',
    pedidos: '/storage/images/elotes.jpg',
    historial: '/storage/images/historial.jpg',
    administracion: '/storage/images/administracion.jpg',
  };
  </script>
  
  <style scoped>
  .card {
    width: 250px;
    height: 350px;
    border-radius: 15px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border: 2px solid white; /* Borde blanco */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out, border-color 0.3s ease-in-out;
  }
  
  .card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    border-color: #2563eb; /* Cambia el color del borde al hacer hover */
  }
  
  .card img {
    width: 100%;
    height: 70%;
    object-fit: cover;
  }
  
  .card button {
    width: 80%;
    padding: 10px;
    margin-top: 10px;
    font-size: 18px;
    border: none;
    border-radius: 5px;
    transition: background-color 0.3s ease-in-out;
  }
  
  .card button:hover {
    background-color: #2563eb;
    color: white;
  }
  </style>
  