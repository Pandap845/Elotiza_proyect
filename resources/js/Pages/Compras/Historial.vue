<template>
  <AuthenticatedLayout>
    <Head title="Historial de Pedidos" />
    <template #header>
      <h2 class="font-extrabold text-4xl text-gray-800 dark:text-gray-200 leading-tight text-shadow-custom">Historial de Pedidos</h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <div>
              <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Filtrar por estado:</label>
              <select id="estado" v-model="filtroEstado" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-700 dark:border-gray-600">
                <option value="">Todos</option>
                <option value="pendiente">Pendiente</option>
                <option value="aceptado">Aceptado</option>
                <option value="cancelado">Cancelado</option>
                <option value="rechazado">Rechazado</option>
                
              </select>
            </div>
            <div v-if="filtrarPedidos.length === 0">
              <p class="mt-4">No se encontraron pedidos.</p>
            </div>
            <div v-else>
              <div v-for="(pedido, index) in filtrarPedidos" :key="pedido.id" class="mb-8 bg-white dark:bg-gray-900 p-4 rounded-lg shadow-md">
                <div class="flex justify-between items-center">
                  <h3 class="text-2xl font-bold text-black dark:text-white">Pedido #{{ index + 1 }}</h3>
                  <div v-if="pedido.estado === 'pendiente'">
                    <button @click="cancelarPedido(pedido.id)" class="bg-red-500 text-white px-2 py-1 rounded">Cancelar</button>
                  </div>
                </div>
                <p class="mb-2"><strong>Fecha:</strong> {{ new Date(pedido.created_at).toLocaleString() }}</p>
                <p class="mb-2"><strong>Total:</strong> ${{ pedido.total }}</p>
                <p class="mb-2"><strong>Estado:</strong> {{ pedido.estado }}</p>
                <div class="mt-4">
                  <h4 class="text-xl font-semibold mb-2">Detalles:</h4>
                  <div v-for="detalle in pedido.detalle_pedidos" :key="detalle.id" class="mb-4">
                    <p class="mb-2"><strong>Tipo de Elote:</strong> {{ detalle.elote.nombre }}</p>
                    <p class="mb-2"><strong>Cantidad de elotes:</strong> {{ detalle.cantidad }}</p>
                    <p class="mb-2"><strong>Toppings:</strong></p>
                    <ul class="mb-2">
                      <li v-for="topping in detalle.toppings" :key="topping.id">{{ topping.nombre }}</li>
                    </ul>
                    <p><strong>Precio:</strong> ${{ detalle.precio }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const { props } = usePage();
const pedidos = ref(props.pedidos || []);
const filtroEstado = ref('');

const filtrarPedidos = computed(() => {
  if (!filtroEstado.value) {
    return pedidos.value;
  }
  return pedidos.value.filter(pedido => pedido.estado === filtroEstado.value);
});

const cancelarPedido = (id) => {
  if (confirm('¿Estás seguro de que deseas cancelar este pedido?')) {
    router.put(route('paypal.cancelar', id), {}, {
      onSuccess: () => {
        // Actualizar el estado del pedido localmente o volver a cargar la página
        pedidos.value = pedidos.value.map(pedido => {
          if (pedido.id === id) {
            pedido.estado = 'cancelado';
          }
          return pedido;
        });
      },
    });
  }
};
</script>



<style scoped>
.text-shadow-custom {
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
}
</style>