<template>
  <div class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-bold text-center text-gray-800">
      Produtos da
      <span v-if="bakery?.name" class="text-pink-600">{{ bakery.name }}</span>
      <span v-else class="text-gray-500 text-base block mt-2">Carregando informações da confeitaria...</span>
    </h1>

    <!-- Botão de Desativar Confeitaria -->
    <div class="mt-6 text-center">
      <button
        v-if="bakery?.id"
        @click="deactivateBakery(bakery.id)"
        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition-all"
      >
        <i class="fa-solid fa-trash"></i> Desativar Confeitaria
      </button>
    </div>

    <!-- Produtos -->
    <div v-if="bakery.products?.length" class="space-y-8 mt-12">
      <div
        v-for="product in bakery.products"
        :key="product.id"
        class="bg-white rounded-lg shadow-lg p-6 transition-all hover:shadow-xl"
      >
        <div>
          <h2 class="text-2xl font-semibold text-gray-800">{{ product.name }}</h2>
          <p class="mt-2 text-gray-500">{{ product.description }}</p>
        </div>

        <div class="mt-4 flex justify-between items-center">
          <p class="text-green-600 font-bold text-lg">
            R$ {{ parseFloat(product.price).toFixed(2) }}
          </p>
          <div class="flex gap-4">
            <button
              @click="editProduct(product.id)"
              class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm transition-all"
            >
              <i class="fa-solid fa-pen-to-square"></i> Editar
            </button>
            <!-- Alteração no botão para desativar produto -->
            <button
             @click="deactivateProduct(product.id)"
              :disabled="!product.is_active" 
       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm transition-all"
>
              <i class="fa-solid fa-ban"></i> Desativar
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
import { defineProps } from 'vue' // Importando defineProps corretamente
import { router } from '@inertiajs/vue3' // Importando o router

const props = defineProps({
  bakery: Object,
  flash: Object,
})

const editProduct = (id) => {
  router.visit(`/bakeries/products/${id}/edit`)
}

const deactivateProduct = (id) => {
  if (confirm('Tem certeza que deseja desativar este produto?')) {
    // Alterando a URL para corresponder à tabela "produtos"
    router.put(`/produtos/${id}/desativar`, {}, {
      onSuccess: () => {
        // Atualizar a lista de produtos sem recarregar a página
        const product = props.bakery.products.find((p) => p.id === id);
        if (product) {
          product.is_active = false; // Atualiza o status do produto na interface
        }
        console.log('Produto desativado com sucesso!');
      },
      onError: () => {
        console.log('Erro ao desativar o produto');
      },
    });
  }
};


const deactivateBakery = (id) => {
  if (confirm('Tem certeza que deseja desativar esta confeitaria?')) {
    router.put(route('bakeries.desativar', id), {}, {
      onSuccess: () => {
        console.log('Confeitaria desativada com sucesso!');
        router.visit(route('home')); // Redireciona para a página inicial
      },
      onError: () => {
        console.log('Erro ao desativar a confeitaria');
      }
    })
  }
}
</script>

<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
</style>
