<template>
    <div class="max-w-7xl mx-auto px-6 py-10">
      <!-- Título da Página -->
      <h1 class="text-4xl font-extrabold text-center text-gray-800 mb-12 tracking-tight">
        Lista de Confeitarias
      </h1>
  
      <!-- Mensagens de Flash -->
      <div v-if="flashSuccess" class="alert alert-success bg-green-100 text-green-800 border border-green-400 rounded-lg p-4 mb-4">
        {{ flashSuccess }}
      </div>
      <div v-if="flashError" class="alert alert-danger bg-red-100 text-red-800 border border-red-400 rounded-lg p-4 mb-4">
        {{ flashError }}
      </div>
  
      <!-- Lista de Confeitarias -->
      <div v-if="bakeries && bakeries.length > 0" class="mb-16">
        <h2 class="text-2xl font-bold text-gray-700 mb-6">🏪 Confeitarias</h2>
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
          <div
            v-for="bakery in bakeries"
            :key="bakery.id"
            class="bg-white rounded-2xl shadow-md hover:shadow-lg transition duration-300 overflow-hidden"
          >
            <img
              :src="bakery.image ? getBakeryImageUrl(bakery.image) : '/storage/bakeries/Bakery1.jpg'"
              alt="Imagem da confeitaria"
              class="h-40 w-full object-cover"
            />
            <div class="p-5">
              <h3 class="text-lg font-semibold text-gray-800">{{ bakery.name }}</h3>
              <p class="text-sm text-gray-500">{{ bakery.city }}, {{ bakery.state }}</p>
              <p class="text-sm text-gray-500">{{ bakery.street }}, {{ bakery.number }}</p>
  
              <!-- Botões de Editar e Excluir Confeitaria -->
              <div class="mt-4 flex justify-between">
                <a
                  :href="`/bakeries/${bakery.id}/edit`"
                  class="bg-yellow-500 text-white py-2 px-4 rounded-lg hover:bg-yellow-600"
                >
                  ✏️ Editar
                </a>
                <button
                  @click="deleteBakery(bakery.id)"
                  class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-700"
                >
                  🗑️ Excluir
                </button>
              </div>
            </div>
  
            <!-- Lista de Produtos da Confeitaria -->
            <div v-if="bakery.products && bakery.products.length > 0" class="p-5">
              <h4 class="text-xl font-semibold mb-4">Produtos</h4>
              <div
                v-for="product in bakery.products"
                :key="product.id"
                class="product-card bg-white shadow-lg rounded-lg p-4 mb-4"
              >
                <h3 class="text-lg font-semibold mb-2">{{ product.name || 'Produto sem nome' }}</h3>
                <p class="text-gray-700 mb-2">{{ product.description || 'Descrição não disponível' }}</p>
                <p class="text-gray-900 font-semibold">Preço: R$ {{ product.price ? parseFloat(product.price).toFixed(2) : 'Preço não informado' }}</p>
                <img
                  v-if="product.image"
                  :src="getProductImageUrl(product.image)"
                  alt="Imagem do produto"
                  class="w-full h-48 object-cover rounded-lg mt-4"
                />
                <img
                  v-else
                  src="/default-product-image.jpg"
                  alt="Imagem padrão do produto"
                  class="w-full h-48 object-cover rounded-lg mt-4"
                />
  
                <!-- Botões de Ação para o Produto -->
                <div class="mt-4 flex justify-between">
                  <button
                    @click="editProduct(product.id)"
                    class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700"
                  >
                    Editar
                  </button>
                  <button
                    @click="deleteProduct(product.id)"
                    class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-700"
                  >
                    Excluir
                  </button>
                </div>
              </div>
            </div>
            <p v-else class="text-gray-500">Nenhum produto nesta confeitaria.</p>
            <hr class="my-6" />
          </div>
        </div>
      </div>
  
      <!-- Caso não haja confeitarias -->
      <p v-else class="text-center text-gray-600">Nenhuma confeitaria cadastrada.</p>
  
      <!-- Exibe os produtos recentes (se houver) -->
      <section v-if="recentProducts && recentProducts.length > 0" class="mt-16">
        <h2 class="text-2xl font-semibold mb-4">Produtos Recentes</h2>
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
          <div
            v-for="product in recentProducts"
            :key="product.id"
            class="product-card bg-white shadow-lg rounded-lg p-4 mb-4"
          >
            <h3 class="text-lg font-semibold mb-2">{{ product.name || 'Produto sem nome' }}</h3>
            <p class="text-gray-700 mb-2">{{ product.description || 'Descrição não disponível' }}</p>
            <p class="text-gray-900 font-semibold">Preço: R$ {{ product.price ? parseFloat(product.price).toFixed(2) : 'Preço não informado' }}</p>
            <img
              v-if="product.image"
              :src="getProductImageUrl(product.image)"
              alt="Imagem do produto"
              class="w-full h-48 object-cover rounded-lg mt-4"
            />
            <img
              v-else
              src="/default-product-image.jpg"
              alt="Imagem padrão do produto"
              class="w-full h-48 object-cover rounded-lg mt-4"
            />
          </div>
        </div>
      </section>
    </div>
  </template>
  
  <script setup>
  import { ref, watch } from 'vue';
  import { usePage } from '@inertiajs/inertia-vue3';
  import { Inertia } from '@inertiajs/inertia';
  
  // Garantir que as variáveis sejam inicializadas corretamente
  const { bakeries = [], flash, recentProducts = [] } = usePage().props;
  
  const flashSuccess = ref(flash?.success || '');
  const flashError = ref(flash?.error || '');
  
  // Função para obter a URL da imagem da confeitaria
  function getBakeryImageUrl(image) {
    return image ? `/storage/bakeries/${image}` : '/storage/bakeries/Bakery1.jpg';
  }
  
  // Função para obter a URL da imagem do produto
  function getProductImageUrl(image) {
    return image ? `/storage/products/${image}` : '/default-product-image.jpg';
  }
  
  // Função para editar um produto
  function editProduct(id) {
    Inertia.visit(`/products/${id}/edit`);
  }
  
  // Função para excluir um produto
  function deleteProduct(id) {
    if (confirm('Tem certeza que deseja excluir este produto?')) {
      Inertia.delete(`/products/${id}`, {
        onSuccess: () => {
          flashSuccess.value = 'Produto excluído com sucesso!';
        },
        onError: () => {
          flashError.value = 'Erro ao excluir o produto.';
        }
      });
    }
  }
  
  // Função para excluir uma confeitaria
  function deleteBakery(id) {
    if (confirm('Tem certeza que deseja excluir esta confeitaria?')) {
      Inertia.delete(`/bakeries/${id}`, {
        onSuccess: () => {
          flashSuccess.value = 'Confeitaria excluída com sucesso!';
        },
        onError: () => {
          flashError.value = 'Erro ao excluir a confeitaria.';
        }
      });
    }
  }
  
  // Limpa mensagens flash depois de 5 segundos
  watch([flashSuccess, flashError], () => {
    setTimeout(() => {
      flashSuccess.value = '';
      flashError.value = '';
    }, 5000);
  });
  </script>
  
  <style scoped>
  .alert {
    padding: 1rem;
    border-radius: 5px;
  }
  
  .product-card img {
    object-fit: cover;
  }
  </style>
  