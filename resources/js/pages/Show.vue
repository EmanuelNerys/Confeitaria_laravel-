<template>
  <div class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-bold text-center text-gray-800">
      Produtos da Confeitaria:
      <span v-if="bakery?.nome" class="text-pink-600">{{ bakery.nome }}</span>
      <span v-else class="text-gray-500 text-base block mt-2">Carregando informações da confeitaria...</span>
    </h1>

    <!-- Produtos -->
    <div v-if="products?.length" class="space-y-8 mt-12">
      <div
        v-for="product in products"
        :key="product.id"
        class="bg-white rounded-lg shadow-lg p-6 transition-all hover:shadow-xl"
      >
        <div>
          <h2 class="text-2xl font-semibold text-gray-800">{{ product.name }}</h2>
          <p class="mt-2 text-gray-500">{{ product.description }}</p>
        </div>

        <div class="mt-4 flex justify-between items-center">
          <p class="text-green-600 font-bold text-lg">R$ {{ product.price }}</p>
          <div class="flex gap-4">
            <button
              @click="editProduct(product.id)"
              class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm transition-all"
            >
              <i class="fa-solid fa-pen-to-square"></i> Editar
            </button>
            <button
              @click="deleteProduct(product.id)"
              class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition-all"
            >
              <i class="fa-solid fa-trash"></i> Excluir
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Mensagem quando não houver produtos -->
    <div v-else class="text-center mt-12 text-gray-500 text-lg">
      Nenhum produto
    </div>

    <!-- Flash Messages -->
    <div v-if="flash?.success" class="mt-10 text-green-600 text-center text-lg">
      {{ flash.success }}
    </div>
    <div v-if="flash?.error" class="mt-10 text-red-600 text-center text-lg">
      {{ flash.error }}
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  products: Array,
  bakery: Object,
  flash: Object,
})

const editProduct = (id) => {
  router.visit(`/bakeries/products/${id}/edit`)
}

const deleteProduct = (id) => {
  if (confirm('Tem certeza que deseja excluir este produto?')) {
    router.delete(`/bakeries/products/${id}`)
  }
}
</script>

<!-- Font Awesome CDN para ícones -->
<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
</style>
