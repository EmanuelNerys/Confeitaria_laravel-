<template>
  <div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Produtos das Confeitarias</h1>

    <!-- Exibe mensagem de sucesso -->
    <div v-if="flashSuccess" class="alert alert-success bg-green-100 text-green-800 border border-green-400 rounded-lg p-4 mb-4">
      {{ flashSuccess }}
    </div>

    <!-- Exibe mensagem de erro -->
    <div v-if="flashError" class="alert alert-danger bg-red-100 text-red-800 border border-red-400 rounded-lg p-4 mb-4">
      {{ flashError }}
    </div>

    <!-- Lista de Confeitarias -->
    <div v-if="bakeries?.length > 0">
      <div v-for="bakery in bakeries" :key="bakery.id">
        <h2 class="text-xl font-bold mb-2">{{ bakery.nome }}</h2> <!-- Alterado para 'nome' -->

        <!-- Verifica se a confeitaria tem produtos -->
        <div v-if="bakery.products && bakery.products.length > 0">
          <div v-for="product in bakery.products" :key="product.id" class="product-card bg-white shadow-lg rounded-lg p-4">
            <h3 class="text-xl font-semibold mb-2">{{ product.nome }}</h3> <!-- Alterado para 'nome' -->
            <p class="text-gray-700 mb-2">{{ product.descricao }}</p> <!-- Alterado para 'descricao' -->
            <p class="text-gray-900 font-semibold">Preço: R$ {{ product.preco }}</p> <!-- Alterado para 'preco' -->
            <img v-if="product.imagem" :src="getProductImageUrl(product.imagem)" alt="Imagem do produto" class="w-full h-48 object-cover rounded-lg mt-4" />
            
            <!-- Botões de Ação -->
            <div class="mt-4 flex justify-between">
              <button @click="editProduct(product.id)" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700">
                Editar
              </button>
              <button @click="deleteProduct(product.id)" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-700">
                Excluir
              </button>
            </div>
          </div>
        </div>

        <p v-else class="text-gray-500">Nenhum produto nesta confeitaria.</p>
        <hr class="my-6">
      </div>
    </div>

    <!-- Caso não haja padarias -->
    <p v-else class="text-center text-gray-600">Nenhuma confeitaria cadastrada.</p>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import { ref, watch } from 'vue'

// Recuperando os dados passados para o Vue via Inertia
const { bakeries, flash } = usePage().props

// Garantir que flash tenha valores padrão caso não seja passado
const flashSuccess = ref(flash?.success || '')
const flashError = ref(flash?.error || '')

// Função para exibir a imagem do produto
function getProductImageUrl(image) {
  return image ? `/storage/products/${image}` : '/default-image.jpg'; // Imagem padrão caso não haja imagem
}

// Função para editar um produto
function editProduct(id) {
  Inertia.visit(`/products/${id}/edit`)
}

// Função para excluir um produto
function deleteProduct(id) {
  if (confirm('Tem certeza que deseja excluir este produto?')) {
    Inertia.delete(`/products/${id}`, {
      onSuccess: () => {
        flashSuccess.value = 'Produto excluído com sucesso!'
      },
      onError: () => {
        flashError.value = 'Erro ao excluir o produto.'
      }
    })
  }
}

// Limpar o flash quando os dados forem acessados
watch([flashSuccess, flashError], () => {
  setTimeout(() => {
    flashSuccess.value = ''
    flashError.value = ''
  }, 5000)
})
</script>

<style scoped>
/* Adicione seus estilos personalizados aqui */
.alert {
  padding: 1rem;
  border-radius: 5px;
}
</style>
