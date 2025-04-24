<template>
  <div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Título -->
    <h1 class="text-4xl font-bold text-pink-600 mb-6">
      Produtos da Confeitaria
    </h1>

    <!-- Lista de Produtos -->
    <div v-if="products.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="product in products"
        :key="product.id"
        class="bg-white shadow-md rounded-2xl p-6 border hover:shadow-lg transition"
      >
        <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ product.name }}</h2>
        <p class="text-gray-600 mb-2">{{ product.description }}</p>
        <p class="text-lg font-bold text-green-600 mb-4">R$ {{ product.price }}</p>
        <img
          :src="product.image || 'https://via.placeholder.com/150'"
          alt="Imagem do produto"
          class="w-full h-48 object-cover rounded-md"
        />
      </div>
    </div>

    <!-- Sem Produtos -->
    <div v-else class="text-gray-500 text-center mt-16 text-lg">
      Nenhum produto encontrado para esta confeitaria.
    </div>

    <!-- Flash Message -->
    <div v-if="flash?.success || flash?.error" class="mt-6 text-center">
      <p
        :class="flash.success ? 'text-green-600' : 'text-red-600'"
        class="text-lg font-medium"
      >
        {{ flash.success || flash.error }}
      </p>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  products: Array,
  flash: Object,
})
</script>
