<template>
  <AuthenticatedLayout>
    <Head title="Pago con PayPal" />
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Pago con PayPal</h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <div id="paypal-button-container" ref="paypalRef"></div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';

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
  pedido_id: string;
  ciudad: string;
  colonia: string;
  calle: string;
  numero_exterior: string;
  numero_interior: string;
  email_paypal: string;
  paypal_id: string;
  estado: string;
}

interface PageProps {
  auth: {
    user: {
      id: number;
      name: string;
      email: string;
    };
  };
  carritos: CarritoItem[];
  pedido_id: string;
  ciudad: string;
  colonia: string;
  calle: string;
  numero_exterior: string;
  numero_interior: string;
  email_paypal: string;
  estado: string;
}

const { props } = usePage<PageProps>();
const carrito = props.carritos || [];
const form = useForm<Form>({
  pedido_id: props.pedido_id || '',
  ciudad: props.ciudad || '',
  colonia: props.colonia || '',
  calle: props.calle || '',
  numero_exterior: props.numero_exterior || '',
  numero_interior: props.numero_interior || '',
  email_paypal: props.email_paypal || '',
  paypal_id: '',
  estado: props.estado || 'pendiente'
});

// PayPal setup
const paypalRef = ref<HTMLDivElement | null>(null);

onMounted(() => {
  if (window.paypal) {
    window.paypal.Buttons({
      createOrder: (data, actions) => {
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: carrito.reduce((total, item) => total + item.precioTotal, 0).toFixed(2)
            }
          }]
        });
      },
      onApprove: (data, actions) => {
        return actions.order.capture().then(details => {
          form.paypal_id = details.id;
          form.post(route('confirmarPago'), {
            onSuccess: () => {
              alert('Pago realizado con éxito');
            },
            onError: () => {
              alert('Error al procesar el pago con PayPal');
            }
          });
        });
      },
      onError: (err) => {
        console.error(err);
        alert('Error al procesar el pago con PayPal');
      }
    }).render(paypalRef.value);
  }
});
</script>

<style scoped>
/* Agrega cualquier estilo específico aquí */
</style>
