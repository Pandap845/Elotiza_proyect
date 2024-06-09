<template>
  <AuthenticatedLayout>
    <Head title="Solicitudes en Espera" />
    <template #header>
      <h2 class="font-extrabold text-4xl text-gray-800 dark:text-gray-200 leading-tight text-shadow-custom">Solicitudes en Espera</h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <FlashMessage v-if="flash" :message="flash.message" :status="flash.status" />
            <table class="min-w-full bg-white dark:bg-gray-900">
              <thead>
                <tr>
                  <th class="py-2">Pedido ID</th>
                  <th class="py-2">Usuario</th>
                  <th class="py-2">Fecha</th>
                  <th class="py-2">Total</th>
                  <th class="py-2">Estado</th>
                  <th class="py-2">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="solicitud in solicitudesEnEspera" :key="solicitud.id" class="bg-gray-100 dark:bg-gray-700">
                  <td class="py-2 px-4">{{ solicitud.id }}</td>
                  <td class="py-2 px-4">{{ solicitud.user.name }}</td>
                  <td class="py-2 px-4">{{ new Date(solicitud.created_at).toLocaleDateString() }}</td>
                  <td class="py-2 px-4">${{ solicitud.total }}</td>
                  <td class="py-2 px-4">{{ solicitud.estado }}</td>
                  <td class="py-2 px-4">
                    <button @click="verDetalle(solicitud.id)" class="bg-blue-500 text-white px-2 py-1 rounded mr-2">Ver Detalle</button>
                    <button @click="aprobarSolicitud(solicitud.id)" class="bg-green-500 text-white px-2 py-1 rounded mr-2">Aprobar</button>
                    <button @click="rechazarSolicitud(solicitud.id)" class="bg-red-500 text-white px-2 py-1 rounded">Rechazar</button>
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
import { usePage, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FlashMessage from '@/Components/FlashMessage.vue';

const { props } = usePage();
const solicitudesEnEspera = props.solicitudesEnEspera || [];
const flash = props.flash || null;

const verDetalle = (id) => {
  router.get(route('administracion.detalle', id));
};

const aprobarSolicitud = (id) => {
  if (confirm('¿Estás seguro de que deseas aprobar esta solicitud?')) {
    router.put(route('paypal.aceptar', id));
  }
};

const rechazarSolicitud = (id) => {
  if (confirm('¿Estás seguro de que deseas rechazar esta solicitud?')) {
    router.put(route('paypal.rechazar', id));
  }
};
</script>

<style scoped>
.text-shadow-custom {
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
}
</style>
