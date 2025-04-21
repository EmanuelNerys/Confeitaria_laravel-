<template>
    <div>
      <h1>Produtos da Confeitaria</h1>
  
      <!-- Exibe mensagem de sucesso -->
      <div v-if="flashSuccess" class="alert alert-success">
        {{ flashSuccess }}
      </div>
  
      <!-- Exibe mensagem de erro -->
      <div v-if="flashError" class="alert alert-danger">
        {{ flashError }}
      </div>
  
      <!-- Lista de Produtos -->
      <div class="products-container">
        <div v-if="products.length > 0">
          <div v-for="product in products" :key="product.id" class="product-card">
            <h3>{{ product.name }}</h3>
            <p>{{ product.description }}</p>
            <p>Preço: R$ {{ product.price }}</p>
            <img v-if="product.image" :src="getProductImageUrl(product.image)" alt="Imagem do produto" />
    
            <!-- Botões de Ação -->
            <div class="actions">
              <button @click="editProduct(product.id)">Editar</button>
              <button @click="deleteProduct(product.id)">Excluir</button>
            </div>
          </div>
        </div>
  
        <!-- Caso não haja produtos cadastrados -->
        <p v-else>Nenhum produto cadastrado ainda.</p>
      </div>
    </div>
  </template>
  
  <script setup>
  import { usePage } from '@inertiajs/inertia-vue3'
  import { Inertia } from '@inertiajs/inertia'
  import { ref, watch } from 'vue'
  
  const { bakery, flash } = usePage().props
  
  // Lista de produtos da confeitaria
  const products = bakery.products
  
  // Mensagens de Flash
  const flashSuccess = ref(flash.success || '')
  const flashError = ref(flash.error || '')
  
  // Função para exibir a imagem do produto (assegura que a URL seja correta)
  function getProductImageUrl(image) {
    return `/storage/products/${image}` // Certifique-se de que os produtos são armazenados na pasta `public/storage/products`
  }
  
  // Função para editar um produto
  function editProduct(id) {
    Inertia.visit(`/products/${id}/edit`) // Redireciona para a página de edição do produto
  }
  
  // Função para excluir um produto
  function deleteProduct(id) {
    if (confirm('Tem certeza que deseja excluir este produto?')) {
      Inertia.delete(`/products/${id}`, {
        onSuccess: () => {
          flashSuccess.value = 'Produto excluído com sucesso!'
          // Limpar a mensagem de sucesso após 5 segundos
          setTimeout(() => flashSuccess.value = '', 5000)
        },
        onError: () => {
          flashError.value = 'Erro ao excluir o produto.'
          // Limpar a mensagem de erro após 5 segundos
          setTimeout(() => flashError.value = '', 5000)
        }
      })
    }
  }
  
  // Limpar as mensagens de flash assim que a página for carregada
  watch(flash, () => {
    flashSuccess.value = flash.success || ''
    flashError.value = flash.error || ''
  })
  </script>
  
  <style scoped>
  .products-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-around;
  }
  
  .product-card {
    border: 1px solid #ddd;
    padding: 1em;
    margin-bottom: 1em;
    border-radius: 8px;
    background-color: #f9f9f9;
    width: 300px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }
  
  .product-card h3 {
    margin-top: 0;
    font-size: 1.25em;
  }
  
  .product-card p {
    margin: 0.5em 0;
  }
  
  .actions button {
    padding: 0.5em 1em;
    margin: 0.5em 0;
    border: none;
    border-radius: 5px;
    background-color: #007bff;
    color: white;
    cursor: pointer;
    font-size: 0.9em;
  }
  
  .actions button:hover {
    background-color: #0056b3;
  }
  
  .actions button:nth-child(2) {
    background-color: #dc3545;
  }
  
  .actions button:nth-child(2):hover {
    background-color: #c82333;
  }
  
  .alert {
    margin: 1em 0;
    padding: 1em;
    border-radius: 5px;
    text-align: center;
    font-size: 1.1em;
  }
  
  .alert-success {
    background-color: #d4edda;
    color: #155724;
  }
  
  .alert-danger {
    background-color: #f8d7da;
    color: #721c24;
  }
  </style>
  