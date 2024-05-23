<template>
  <div>
    <section id="productos" class="productos">
      <form @submit.prevent="addToCart">
        <div class="container">
          <h2>¿Cuántos Elotes te gustaría ordenar?</h2>
          <input type="number" v-model="order.quantity" required placeholder="0" min="1" />
        </div>
        <h2>Elige el tipo de Elote</h2>
        <div class="Elote-container">
          <!-- Bucle para mostrar los tipos de elote -->
          <div class="Elote-card" v-for="elote in elotes" :key="elote.id">
            <input type="checkbox" v-model="order.elotes" :value="elote.id">
            <img :src="elote.imagen" :alt="elote.nombre" class="Elote-img">
            <div class="Elote-info">
              <h3>{{ elote.nombre }}</h3>
              <p class="precio">${{ elote.precio }}</p>
            </div>
          </div>
        </div>
        <h2>Elige los Toppings</h2>
        <div class="Elote-container">
          <!-- Bucle para mostrar los toppings -->
          <div class="Elote-card" v-for="topping in toppings" :key="topping.id">
            <input type="checkbox" v-model="order.toppings" :value="topping.id">
            <img :src="topping.imagen" :alt="topping.nombre" class="Elote-img">
            <div class="Elote-info">
              <h3>{{ topping.nombre }}</h3>
              <p class="precio">${{ topping.precio }}</p>
            </div>
          </div>
        </div>
        <button type="submit">Añadir al carrito</button>
      </form>
    </section>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      order: {
        quantity: 1,
        elotes: [],
        toppings: []
      },
      elotes: [],
      toppings: []
    };
  },
  created() {
    this.fetchElotes();
    this.fetchToppings();
  },
  methods: {
    fetchElotes() {
      axios.get('/api/elotes')
        .then(response => {
          this.elotes = response.data;
        })
        .catch(error => {
          console.error('Error fetching elotes:', error);
        });
    },
    fetchToppings() {
      axios.get('/api/toppings')
        .then(response => {
          this.toppings = response.data;
        })
        .catch(error => {
          console.error('Error fetching toppings:', error);
        });
    },
    addToCart() {
      axios.post('/api/cart/add', this.order)
        .then(response => {
          console.log('Order added to cart:', response);
        })
        .catch(error => {
          console.error('Error adding to cart:', error);
        });
    }
  }
};
</script>
