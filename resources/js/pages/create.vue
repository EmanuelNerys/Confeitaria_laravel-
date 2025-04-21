<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="max-w-3xl w-full p-8 bg-white rounded-lg shadow-md">
      <h1 class="text-3xl font-semibold text-gray-800 mb-6">Cadastrar Confeitaria</h1>

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
              :value="form[field.id]"
              @input="event => form[field.id] = event.target.value"
              :type="field.type"
              :placeholder="field.placeholder"
              :class="{'border-red-500': form.errors[field.id]}"
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-400"
              @blur="field.id === 'cep' ? buscarCep() : null"
            />
            <p v-if="form.errors[field.id]" class="text-sm text-red-500 mt-1">{{ form.errors[field.id] }}</p>
          </div>

          <!-- Campo de imagem -->
          <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Imagem</label>
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
              Salvar
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

const { flash } = usePage().props

const form = useForm({
  nome: '',
  cep: '',
  rua: '',
  numero: '',
  bairro: '',
  cidade: '',
  estado: '',
  telefone: '',
  latitude: '',
  longitude: '',
  image: null,
})

const fields = [
  { id: 'nome', label: 'Nome', placeholder: 'Nome da Confeitaria', type: 'text' },
  { id: 'cep', label: 'CEP', placeholder: 'CEP', type: 'text' },
  { id: 'rua', label: 'Rua', placeholder: 'Rua', type: 'text' },
  { id: 'numero', label: 'Número', placeholder: 'Número', type: 'text' },
  { id: 'bairro', label: 'Bairro', placeholder: 'Bairro', type: 'text' },
  { id: 'cidade', label: 'Cidade', placeholder: 'Cidade', type: 'text' },
  { id: 'estado', label: 'Estado', placeholder: 'Estado', type: 'text' },
  { id: 'telefone', label: 'Telefone', placeholder: 'Telefone', type: 'text' },
  { id: 'latitude', label: 'Latitude', placeholder: 'Latitude', type: 'text' },
  { id: 'longitude', label: 'Longitude', placeholder: 'Longitude', type: 'text' },
]

function handleImage(event) {
  form.image = event.target.files[0]
}

function submit() {
  const data = new FormData()
  Object.entries(form.data()).forEach(([key, value]) => {
    if (value !== null && value !== '') {
      data.append(key, value)
    }
  })

  form.post('/bakeries', {
    data,
    forceFormData: true,
    onSuccess: () => form.reset(),
    onError: () => {
      flash.error = flash.error || 'Erro ao cadastrar confeitaria. Tente novamente.'
    }
  })
}

async function buscarCep() {
  const cep = form.cep.replace(/\D/g, '')

  if (cep.length !== 8) {
    flash.error = 'CEP inválido.'
    return
  }

  try {
    const response = await fetch(`/buscar-cep/${cep}`)
    if (!response.ok) throw new Error('CEP não encontrado')
    const data = await response.json()

    form.rua = data.logradouro || ''
    form.bairro = data.bairro || ''
    form.cidade = data.localidade || ''
    form.estado = data.uf || ''
  } catch (error) {
    console.error('Erro ao buscar CEP:', error)
    flash.error = 'CEP inválido ou não encontrado.'
  }
}
</script>
