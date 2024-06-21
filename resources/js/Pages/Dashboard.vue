<template>
  <AuthenticatedLayout>
    <Head title="Menú Principal" />
    <template #header>
    <h2 class="font-extrabold text-6xl text-gray-800 dark:text-gray-200 leading-tight text-shadow-custom">Menú principal</h2>
    </template>
    <div class="py-12 flex justify-center">
      <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100 flex flex-wrap justify-center items-center space-x-4 space-y-4">
        <Card 
          title="Ir al perfil" 
          image="perfil" 
          @click="irAlPerfil"
        />
        <Card 
          v-if="isAdmin" 
          title="Agregar suministros" 
          image="suministros" 
          @click="irASuministros"
        />
        <Card 
          v-if="!isAdmin" 
          title="Solicitar elotes" 
          image="pedidos" 
          @click="irAPedidos"
        />
        <Card 
          v-if="!isAdmin" 
          title="Historial" 
          image="historial" 
          @click="irHistorial"
        />
        <Card 
          v-if="isAdmin" 
          title="Administración" 
          image="administracion" 
          @click="irAdministracion"
        />
      </div>
    </div>

    <FooterComponent></FooterComponent>
  
  </AuthenticatedLayout>
</template>

<script setup>
import FooterComponent from '@/Components/Footer.vue';

import { ref } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue'; // A new component for the card
import { Head } from '@inertiajs/vue3';

const { props } = usePage();
const user = props.auth.user;

const isAdmin = user.email === 'admin@elote.mx';

const hoveredButton = ref(null);

const images = {
  perfil: '/storage/images/logo1.jpg',
  suministros: '/storage/images/elotes.jpg',
  pedidos: '/storage/images/elotes.jpg',
  historial: '/storage/images/historial.jpg',
  administracion:'/storage/images/historial.jpg',
};

const irAlPerfil = () => {
    router.visit('/profile');
};

const irASuministros = () => {
    router.visit('/supplies');
};

const irAPedidos = () => {
    router.visit('/solicitud');
};

const irHistorial = () => {
    router.visit('/historial');
};

const irAdministracion = () => {
    router.visit('/administracion');
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
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
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


<style scoped>
.text-shadow-custom {
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
}
</style>