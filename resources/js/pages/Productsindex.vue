<template>
  <div class="max-w-5xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">📦 Produtos da Confeitaria</h1>

    <!-- Flash messages -->
    <div v-if="flashSuccess" class="alert alert-success">{{ flashSuccess }}</div>
    <div v-if="flashError" class="alert alert-danger">{{ flashError }}</div>

    <!-- Formulário de criação/edição -->
    <div class="bg-white p-4 rounded shadow mb-8">
      <h2 class="text-xl font-semibold mb-4">{{ editingProduct ? 'Editar Produto' : 'Novo Produto' }}</h2>
      <form @submit.prevent="submitProduct" enctype="multipart/form-data" class="space-y-4">
        <input v-model="form.name" type="text" placeholder="Nome" class="input" />
        <input v-model="form.price" type="number" placeholder="Preço" class="input" />
        <textarea v-model="form.description" placeholder="Descrição" class="input"></textarea>
        <input type="file" @change="e => form.image = e.target.files[0]" />

        <button type="submit" class="btn bg-blue-600 text-white">
          {{ editingProduct ? 'Atualizar' : 'Criar' }}
        </button>
        <button v-if="editingProduct" type="button" @click="cancelEdit" class="btn bg-gray-500 text-white">
          Cancelar
        </button>
      </form>
    </div>

    <!-- Lista de Produtos -->
    <div class="products-container">
      <div v-if="products.length">
        <div v-for="product in products" :key="product.id" class="product-card">
          <h3>{{ product.name }}</h3>
          <p>{{ product.description }}</p>
          <p>Preço: R$ {{ product.price }}</p>
          <img v-if="product.image" :src="getProductImageUrl(product.image)" alt="Imagem do produto" />

          <div class="actions">
            <button @click="editProduct(product)">Editar</button>
            <button @click="deleteProduct(product.id)">Excluir</button>
          </div>
        </div>
      </div>
      <p v-else>Nenhum produto cadastrado ainda.</p>
    </div>
  </div>
</template>

<script setup>
import { usePage, useForm } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import { ref, watch } from 'vue'

const { bakery, flash } = usePage().props

const products = ref(bakery.products)
const flashSuccess = ref(flash.success || '')
const flashError = ref(flash.error || '')
const editingProduct = ref(null)

const form = useForm({
  name: '',
  price: '',
  description: '',
  image: null
})

function submitProduct() {
  const route = editingProduct.value
    ? `/bakeries/${bakery.id}/products/${editingProduct.value.id}?_method=PUT`
    : `/bakeries/${bakery.id}/products`

  form.post(route, {
    forceFormData: true,
    onSuccess: () => {
      flashSuccess.value = editingProduct.value
        ? 'Produto atualizado com sucesso!'
        : 'Produto criado com sucesso!'
      resetForm()
      reloadPage()
    },
    onError: () => {
      flashError.value = 'Erro ao salvar o produto.'
    }
  })
}

function editProduct(product) {
  editingProduct.value = product
  form.name = product.name
  form.price = product.price
  form.description = product.description
  form.image = null
}

function cancelEdit() {
  resetForm()
}

function resetForm() {
  form.reset()
  form.clearErrors()
  editingProduct.value = null
}

function deleteProduct(id) {
  if (confirm('Tem certeza que deseja excluir este produto?')) {
    Inertia.delete(`/bakeries/${bakery.id}/products/${id}`, {
      onSuccess: () => {
        flashSuccess.value = 'Produto excluído com sucesso!'
        reloadPage()
      },
      onError: () => {
        flashError.value = 'Erro ao excluir o produto.'
      }
    })
  }
}

function getProductImageUrl(image) {
  return `/storage/${image}`
}

function reloadPage() {
  Inertia.reload({ only: ['bakery'] })
}

// Watch para atualizações de flash messages
watch(flash, () => {
  flashSuccess.value = flash.success || ''
  flashError.value = flash.error || ''
})
</script>

<style scoped>
.input {
  @apply block w-full border border-gray-300 rounded px-3 py-2;
}
.btn {
  @apply px-4 py-2 rounded hover:opacity-90;
}
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
</style>
