<template>
  <div class="max-w-7xl mx-auto px-6 py-10">
    <!-- Título principal -->
    <h1 class="text-4xl font-extrabold text-center text-gray-800 mb-12 tracking-tight">
      Bem-vindo ao <span class="text-blue-600">Confeitaria Marketplace</span>!
    </h1>

    <!-- Mapa de Confeitarias -->
    <section v-if="bakeries.length" class="mb-16">
      <h2 class="text-2xl font-bold text-gray-700 mb-6">📍 Mapa das Confeitarias</h2>
      <Map :bakeries="bakeries" />
    </section>

    <!-- Confeitarias em Destaque -->
    <section v-if="bakeries.length" class="mb-16">
      <h2 class="text-2xl font-bold text-gray-700 mb-6">🏪 Confeitarias em Destaque</h2>
      <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <Link
          v-for="bakery in bakeries"
          :key="bakery.id"
          :href="`/bakeries/${bakery.id}/show`"
          class="bg-white rounded-2xl shadow-md hover:shadow-lg transition duration-300 overflow-hidden"
        >
          <img
            :src="getBakeryImageUrl(bakery)"
            alt="Imagem da confeitaria"
            class="h-40 w-full object-cover"
          />
          <div class="p-5">
            <h3 class="text-lg font-semibold text-gray-800">{{ bakery.name }}</h3>
            <p class="text-sm text-gray-500">{{ bakery.city }}, {{ bakery.state }}</p>
            <p class="text-sm text-gray-500">{{ bakery.street }}, {{ bakery.number }}</p>
          </div>
        </Link>
      </div>
    </section>
    
    <!-- Produtos Recentes -->
    <section v-if="recentProducts.length" class="mb-16">
      <h2 class="text-2xl font-bold text-gray-700 mb-6">🧁 Produtos Mais Recentes</h2>
      <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <div
          v-for="product in recentProducts"
          :key="product.id"
          class="bg-white rounded-2xl shadow-md hover:shadow-lg transition duration-300 overflow-hidden"
        >
          <img
            :src="product.image ? `/storage/${product.image}` : '/storage/bakeries/cupcakemorango.jpg'"
            alt="Imagem do produto"
            class="h-40 w-full object-cover"
          />
          <div class="p-5">
            <h3 class="text-lg font-semibold text-gray-800">{{ product.name }}</h3>
            <!-- Verificando o preço -->
            <p v-if="isPriceValid(product.price)" class="text-blue-600 font-bold mt-2 text-lg">
              R$ {{ formatPrice(product.price) }}
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Botões de Cadastro e Edição -->
    <div class="text-center mt-12 flex justify-center space-x-4">
      <Link
        href="bakeries/create"
        class="inline-block bg-green-600 text-white text-lg font-medium py-3 px-6 rounded-full shadow-lg hover:bg-green-700 transition-all duration-300"
      >
        ➕ Cadastrar uma Confeitaria
      </Link>

      <Link
        v-if="bakeries.length"
        :href="`/bakeries/${bakeries[0].id}/edit`"
        class="inline-block bg-yellow-500 text-white text-lg font-medium py-3 px-6 rounded-full shadow-lg hover:bg-yellow-600 transition-all duration-300"
      >
        ✏️ Editar Confeitaria
      </Link>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import Map from './Map.vue'; // Caminho correto


defineProps({
  bakeries: Array,
  recentProducts: Array,
})

// Função para obter a imagem correta da confeitaria
function getBakeryImageUrl(bakery) {
  if (bakery.name === 'Confeitaria Nordeste Delights') {
    return '/storage/bakeries/Confeitaria2.jpg'; // Imagem específica para Nordeste Delights
  }
  if (bakery.name === 'Confeitaria Sabor') {
    return '/storage/bakeries/confeitaria3.jpg'; // Imagem específica para Sabor
  }
  if (bakery.name === 'Confeitaria Sabor Nordestino') {
    return '/storage/bakeries/confeitarianordestina.jpg'; // Imagem específica para Sabor Nordestino
  }
  return bakery.image ? `/storage/${bakery.image}` : '/storage/bakeries/Bakery1.jpg'; // Imagem padrão
}

// Função para verificar se o preço é válido
function isPriceValid(price) {
  console.log('Preço do produto:', price); // Adicionando o log para debugar
  return price !== null && price !== undefined && price !== '' && !isNaN(price);
}

// Função para formatar o preço
function formatPrice(price) {
  // Se o preço é uma string com vírgulas, converte para número
  const numericPrice = Number(price.toString().replace(',', '.'));
  return numericPrice.toFixed(2); // Formata o preço com 2 casas decimais
}
</script>