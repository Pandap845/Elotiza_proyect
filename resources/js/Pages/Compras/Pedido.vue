<template>
  <AuthenticatedLayout>
    <Head title="Confirmar Pedido" />
    <template #header>
      <h2 class="font-extrabold text-6xl text-gray-800 dark:text-gray-200 leading-tight text-shadow-custom">Confirmar Pedido</h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="mb-4">
            <p v-if="backendErrors.general" class="text-red-600 text-sm">{{ backendErrors.general }}</p>
          </div>
          <div class="p-6 text-gray-900 dark:text-gray-100 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="carrito-container">
              <h2 class="font-semibold text-4xl text-gray-800 dark:text-gray-200 leading-tight mb-4">Tu carrito de compras</h2>
              <div v-if="carrito.length === 0">
                <p>El carrito está vacío</p>
              </div>
              <div v-else class="overflow-x-auto">
                <div class="Carrito-container flex gap-4">
                  <div v-for="(item, index) in carrito" :key="index" class="Elote-card flex flex-col items-center justify-center border-2 rounded-md p-4 bg-white dark:bg-gray-700 text-black dark:text-white shadow-md">
                    <h3 class="text-2xl font-bold mb-4 text-black">Orden</h3>
                    <p class="mb-2 text-black"><strong>Tipo de Elote:</strong> {{ item.elote.nombre }}</p>
                    <p class="mb-2 text-black"><strong>Cantidad de elotes:</strong> {{ item.cantidad }}</p>
                    <p class="mb-2 text-black"><strong>Toppings:</strong></p>
                    <ul class="mb-4 text-black">
                      <li v-for="topping in item.toppings" :key="topping.id"><strong>{{ topping.nombre }}</strong></li>
                    </ul>
                    <p class="mb-4 text-black"><strong>Precio total:</strong> ${{ item.precioTotal }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div>
              <form @submit.prevent="confirmarPedido">
                <div class="mb-4">
                  <label for="ciudad" class="block text-2xl font-medium text-gray-700 dark:text-gray-300">Ciudad</label>
                  <input type="text" id="ciudad" v-model="form.ciudad" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                  <span v-if="validationErrors.ciudad" class="text-red-600 text-sm">{{ validationErrors.ciudad }}</span>
                  <span v-if="backendErrors.ciudad" class="text-red-600 text-sm">{{ backendErrors.ciudad }}</span>
                </div>
                <div class="mb-4">
                  <label for="colonia" class="block text-2xl font-medium text-gray-700 dark:text-gray-300">Colonia</label>
                  <input type="text" id="colonia" v-model="form.colonia" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                  <span v-if="validationErrors.colonia" class="text-red-600 text-sm">{{ validationErrors.colonia }}</span>
                  <span v-if="backendErrors.colonia" class="text-red-600 text-sm">{{ backendErrors.colonia }}</span>
                </div>
                <div class="mb-4">
                  <label for="calle" class="block text-2xl font-medium text-gray-700 dark:text-gray-300">Calle</label>
                  <input type="text" id="calle" v-model="form.calle" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                  <span v-if="validationErrors.calle" class="text-red-600 text-sm">{{ validationErrors.calle }}</span>
                  <span v-if="backendErrors.calle" class="text-red-600 text-sm">{{ backendErrors.calle }}</span>
                </div>
                <div class="mb-4">
                  <label for="numero_exterior" class="block text-2xl font-medium text-gray-700 dark:text-gray-300">Número Exterior</label>
                  <input type="text" id="numero_exterior" v-model="form.numero_exterior" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                  <span v-if="validationErrors.numero_exterior" class="text-red-600 text-sm">{{ validationErrors.numero_exterior }}</span>
                  <span v-if="backendErrors.numero_exterior" class="text-red-600 text-sm">{{ backendErrors.numero_exterior }}</span>
                </div>
                <div class="mb-4">
                  <label for="numero_interior" class="block text-2xl font-medium text-gray-700 dark:text-gray-300">Número Interior</label>
                  <input type="text" id="numero_interior" v-model="form.numero_interior" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                  <span v-if="validationErrors.numero_interior" class="text-red-600 text-sm">{{ validationErrors.numero_interior }}</span>
                  <span v-if="backendErrors.numero_interior" class="text-red-600 text-sm">{{ backendErrors.numero_interior }}</span>
                </div>
              </form>
              <div id="paypal-button-container" ref="paypalRef" class="mt-4"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">

// Librerias
import { ref, reactive, onMounted, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// Interfaces y formularios
interface CarritoItem {
  elote: {
    nombre: string;
  };
  cantidad: number;
  toppings: {
    id: number;
    nombre: string;
  }[];
  precioTotal: number;
}

interface Form {
  ciudad: string;
  colonia: string;
  calle: string;
  numero_exterior: string;
  numero_interior: string;
  paypal_id: string;
  estado: string;
}

const validationErrors = reactive({
  ciudad: '',
  colonia: '',
  calle: '',
  numero_exterior: '',
  numero_interior: ''
});

interface Auth {
  user: {
    id: number;
    name: string;
    email: string;
  };
}

interface PageProps {
  auth: Auth;
  carritos: CarritoItem[];
}

const backendErrors = reactive({
  general: '',
  ciudad: '',
  colonia: '',
  calle: '',
  numero_exterior: '',
  numero_interior: '',
});

const { props } = usePage<PageProps>();
const carrito = ref<CarritoItem[]>(props.carritos || []);
const form = reactive<Form>({
  ciudad: '',
  colonia: '',
  calle: '',
  numero_exterior: '',
  numero_interior: '',
  paypal_id: '',
  estado: 'pendiente'
});

// Validaciones básicas
const validateForm = () => {
  validationErrors.ciudad = form.ciudad.length < 2 ? 'Ciudad debe tener al menos 2 caracteres.' : '';
  validationErrors.colonia = form.colonia.length < 3 || form.colonia.length > 60 || /[^a-zA-Z\s]/.test(form.colonia) ? 'Colonia debe tener entre 3 y 60 caracteres alfabéticos.' : '';
  validationErrors.calle = form.calle.length < 3 || form.calle.length > 80 || /[^a-zA-Z\s]/.test(form.calle) ? 'Calle debe tener entre 3 y 80 caracteres alfabéticos.' : '';
  validationErrors.numero_exterior = form.numero_exterior.length === 0 || form.numero_exterior.length > 10 || /\D/.test(form.numero_exterior) ? 'Número Exterior debe tener entre 1 y 10 caracteres numéricos.' : '';
  validationErrors.numero_interior = form.numero_interior.length > 0 && (form.numero_interior.length > 10 || /\D/.test(form.numero_interior)) ? 'Número Interior debe tener entre 1 y 10 caracteres numéricos.' : '';
};

const isFormValid = computed(() => {
  return !Object.values(validationErrors).some(error => error !== '');
});

const confirmarPedido = async () => {
  validateForm();

  if (!isFormValid.value) {
    alert('Por favor corrige los errores en el formulario.');
    return;
  }

  initializePayPalButton();
};

// Configuración de PayPal
const paypalRef = ref<HTMLDivElement | null>(null);
const initializePayPalButton = () => {
  if (window.paypal) {
    window.paypal.Buttons({
      createOrder: (data, actions) => {
        return actions.order.create({
          purchase_units: [{
            amount: {
              currency_code: 'MXN',
              value: carrito.value.reduce((total, item) => total + item.precioTotal, 0).toFixed(2)
            }
          }]
        });
      },
      onApprove: (data, actions) => {
        return actions.order.capture().then(details => {
          form.paypal_id = details.purchase_units[0].payments.captures[0].id;
          finalizarPedido();
        });
      },
      onError: (err) => {
        console.error(err);
        alert('Error al procesar el pago con PayPal');
      }
    }).render(paypalRef.value);
  }
};

const finalizarPedido = async () => {
  try {
    console.log('Form data:', form);
    const response = await axios.post(route('confirmarPedido'), form);
    if (response.data.success) {
      alert('Pago realizado con éxito y pedido confirmado');
    } else {
      alert(`Error al confirmar el pedido: ${response.data.message}`);
    }
  } catch (error) {
    console.error('Error al confirmar el pedido:', error.response.data);
    alert(`Error al confirmar el pedido: ${error.response.data.message}`);
  }
};


const showText = ref(true);

onMounted(() => {
  setTimeout(() => {
    showText.value = false;
  }, 100); // Duración antes de que el texto desaparezca
});

onMounted(() => {
  if (paypalRef.value) {
    initializePayPalButton();
  }
});

</script>


<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 1s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}

.banner-container {
  width: 100%;
  height: 400px; /* Aumenta la altura del banner */
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}

.banner-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.Carrito-container {
  display: flex;
  flex-wrap: nowrap;
  gap: 1rem;
  overflow-x: auto;
}

.Elote-card {
  background-color: #fff;
  border-radius: 0.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  padding: 1rem;
  width: 300px;
  transition: background-color 0.3s ease;
  flex: 0 0 auto;
}

.Elote-card:hover {
  background-color: #f0f0f0;
}

.Elote-card h3 {
  font-size: 1.25rem;
  margin-bottom: 0.5rem;
}

.Elote-card p {
  margin: 0.25rem 0;
}

.Elote-card ul {
  list-style: none;
  padding: 0;
}

.Elote-card li {
  background-color: #e0e0e0;
  border-radius: 0.25rem;
  display: inline-block;
  margin: 0.25rem;
  padding: 0.25rem 0.5rem;
}

.text-shadow-custom {
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
}
</style>
