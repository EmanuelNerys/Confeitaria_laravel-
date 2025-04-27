<template>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center">
      <div class="max-w-3xl w-full p-8 bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Cadastrar Produto</h1>
  
        <!-- Mensagens de sucesso ou erro -->
        <div v-if="flash?.success" class="alert alert-success mb-4 p-4 bg-green-50 text-green-800 border-l-4 border-green-500 rounded-md">
          {{ flash.success }}
        </div>
        <div v-if="flash?.error" class="alert alert-danger mb-4 p-4 bg-red-50 text-red-800 border-l-4 border-red-500 rounded-md">
          {{ flash.error }}
        </div>
  
        <!-- Formulário de cadastro -->
        <form @submit.prevent="submit" enctype="multipart/form-data">
          <div class="space-y-6">
            <!-- Campos de texto -->
            <div v-for="field in fields" :key="field.id">
              <label :for="field.id" class="block text-sm font-medium text-gray-700">{{ field.label }}</label>
              <input
                :id="field.id"
                v-model="form[field.id]"
                :type="field.type"
                :placeholder="field.placeholder"
                :class="{'border-red-500': form.errors[field.id]}"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-400"
              />
              <p v-if="form.errors[field.id]" class="text-sm text-red-500 mt-1">{{ form.errors[field.id] }}</p>
            </div>
  
            <!-- Campo de imagem -->
            <div>
              <label for="image" class="block text-sm font-medium text-gray-700">Imagem do Produto</label>
              <input
                id="image"
                type="file"
                @change="handleImage"
                accept="image/*"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md"
              />
              <p v-if="form.errors.image" class="text-sm text-red-500 mt-1">{{ form.errors.image }}</p>
            </div>
  
            <!-- Botão de envio -->
            <div>
              <button
                type="submit"
                :disabled="form.processing"
                class="w-full bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 disabled:bg-gray-300"
              >
                Salvar Produto
              </button>
            </div>
          </div>
        </form>
  
        <!-- Indicador de envio -->
        <div v-if="form.processing" class="mt-4 text-center text-gray-500">Enviando...</div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { useForm, usePage } from '@inertiajs/inertia-vue3'
  import { router } from '@inertiajs/inertia'
  
  const { flash } = usePage().props
  
  const form = useForm({
    name: '',
    description: '',
    price: '',
    bakery_id: '', // Para associar o produto a uma confeitaria
    image: null,
  })
  
  const fields = [
    { id: 'name', label: 'Nome do Produto', placeholder: 'Ex: Bolo de Chocolate', type: 'text' },
    { id: 'description', label: 'Descrição', placeholder: 'Descrição breve do produto', type: 'text' },
    { id: 'price', label: 'Preço', placeholder: 'Ex: 19.90', type: 'number' },
    { id: 'bakery_id', label: 'ID da Confeitaria', placeholder: 'ID da confeitaria', type: 'number' },
  ]
  
  function handleImage(event) {
    form.image = event.target.files[0]
  }
  
  function submit() {
    // Verifica se os campos obrigatórios estão preenchidos
    const requiredFields = ['name', 'description', 'price', 'bakery_id']
    const emptyFields = requiredFields.filter(field => !form[field])
  
    if (emptyFields.length > 0) {
      alert('⚠️ Preencha todos os campos obrigatórios antes de enviar.')
      return
    }
  
    console.log('🔄 Enviando dados do produto:', form.data())
  
    form.post('/products/store', {
      forceFormData: true,
      onSuccess: () => {
        console.log('✅ Produto cadastrado com sucesso!')
        alert('✅ Produto cadastrado com sucesso!')
        form.reset()
        router.visit('/home')
      },
      onError: () => {
        console.error('❌ Erro ao cadastrar produto:', form.errors)
        alert('❌ Ocorreu um erro ao cadastrar o produto.')
      }
    })
  }
  </script>
  