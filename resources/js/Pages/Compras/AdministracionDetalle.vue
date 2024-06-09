<template>
    <AuthenticatedLayout>
      <Head title="Detalle del Pedido" />
      <template #header>
      <h2 class="font-extrabold text-4xl text-gray-800 dark:text-gray-200 leading-tight text-shadow-custom">
        Detalle del Pedido
      </h2>
    </template>
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
              <h3 class="text-2xl font-bold mb-4">Pedido #{{ pedido.id }}</h3>
              <p><strong>Usuario:</strong> {{ pedido.user.name }}</p>
              <p><strong>Fecha:</strong> {{ new Date(pedido.created_at).toLocaleDateString() }}</p>
              <p><strong>Total:</strong> ${{ pedido.total }}</p>
              <p><strong>Estado:</strong> {{ pedido.estado }}</p>
              <h4 class="text-xl font-semibold mt-6 mb-2">Detalles del Pedido:</h4>
              <table class="min-w-full bg-white dark:bg-gray-900">
                <thead>
                  <tr>
                    <th class="py-2">Elote</th>
                    <th class="py-2">Cantidad</th>
                    <th class="py-2">Precio</th>
                    <th class="py-2">Toppings</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="detalle in pedido.detalle_pedidos" :key="detalle.id" class="bg-gray-100 dark:bg-gray-700">
                    <td class="py-2 px-4">{{ detalle.elote.nombre }}</td>
                    <td class="py-2 px-4">{{ detalle.cantidad }}</td>
                    <td class="py-2 px-4">${{ detalle.precio }}</td>
                    <td class="py-2 px-4">
                      <ul>
                        <li v-for="topping in detalle.toppings" :key="topping.id">
                          {{ topping.nombre }} ({{ topping.pivot.cantidad }}): ${{ topping.pivot.precio}}
                        </li>
                      </ul>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import { usePage } from '@inertiajs/vue3';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  
  const { props } = usePage();
  const pedido = props.pedido;
  </script>
  
  <style scoped>
  .text-shadow-custom {
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
  }
  </style>