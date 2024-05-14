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
              <input type="radio" v-model="order.eloteId" :value="elote.id">
              <img :src="elote.image" :alt="elote.name" class="Elote-img">
              <div class="Elote-info">
                <h3>{{ elote.name }}</h3>
                <p class="precio">${{ elote.price }}</p>
              </div>
            </div>
          </div>
          <h2>Elige los Toppings</h2>
          <div class="Elote-container">
            <!-- Bucle para mostrar los toppings -->
            <div class="Elote-card" v-for="topping in toppings" :key="topping.id">
              <input type="checkbox" v-model="order.toppings" :value="topping.id">
              <img :src="topping.image" :alt="topping.name" class="Elote-img">
              <div class="Elote-info">
                <h3>{{ topping.name }}</h3>
                <p class="precio">${{ topping.price }}</p>
              </div>
            </div>
          </div>
          <button type="submit">Añadir al carrito</button>
        </form>
      </section>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        order: {
          quantity: 1,
          eloteId: null,
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
        // Llamada al backend para obtener los elotes
        this.$inertia.visit('/api/elotes', {
          method: 'get',
          onSuccess: page => {
            this.elotes = page.props.elotes;
          }
        });
      },
      fetchToppings() {
        // Llamada al backend para obtener los toppings
        this.$inertia.visit('/api/toppings', {
          method: 'get',
          onSuccess: page => {
            this.toppings = page.props.toppings;
          }
        });
      },
      addToCart() {
        // Llamada al backend para agregar al carrito
        this.$inertia.post('/api/cart/add', this.order);
      }
    }
  };
  </script>
  
