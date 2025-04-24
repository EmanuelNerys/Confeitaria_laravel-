<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">{{ products.name }}</h1>

    <div v-if="products.length">
      console.log(products)
      <ul class="space-y-4">
        <li v-for="product in products" :key="product.id" class="p-4 border rounded">
          <h2 class="text-lg font-semibold">{{ product.name }}</h2>
          <p>{{ product.description }}</p>
          <p class="text-green-600 font-bold">R$ {{ product.price }}</p>
          <img :src="product.image" alt="Imagem do produto" class="w-32 h-32 object-cover mt-2" />
        </li>
      </ul>
    </div>

    <div v-else class="text-gray-500 mt-6">
      Nenhum produto encontrado para esta confeitaria.
    </div>

    <div v-if="flash" class="mt-6 text-green-600">
      {{ flash }}
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue'

const props = defineProps({
  products: Object,
  bakery: Object,
  bakeries: Array,
  flash: String,
})

// Pode acessar os produtos assim:
const products = props.bakery.products ?? []
</script>