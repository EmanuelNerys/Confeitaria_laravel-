<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="max-w-3xl w-full p-8 bg-white rounded-lg shadow-md">
      <h1 class="text-3xl font-semibold text-gray-800 mb-6">Editar Confeitaria</h1>

      <!-- Mensagens de sucesso ou erro -->
      <div v-if="flash?.success" class="alert alert-success mb-4 p-4 bg-green-50 text-green-800 border-l-4 border-green-500 rounded-md">
        {{ flash.success }}
      </div>
      <div v-if="flash?.error" class="alert alert-danger mb-4 p-4 bg-red-50 text-red-800 border-l-4 border-red-500 rounded-md">
        {{ flash.error }}
      </div>

      <!-- Formulário de edição -->
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
              @blur="field.id === 'postal_code' ? buscarCep() : null"
            />
            <p v-if="form.errors[field.id]" class="text-sm text-red-500 mt-1">{{ form.errors[field.id] }}</p>
          </div>

          <!-- Campo de imagem -->
          <div>
            <label class="block text-sm font-medium text-gray-700">Imagem</label>
            <input
              type="file"
              @change="e => form.image = e.target.files[0]"
              class="mt-1 block w-full"
            />
          </div>

          <!-- Botão de envio -->
          <div>
            <button
              type="submit"
              :disabled="form.processing"
              class="w-full bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 disabled:bg-gray-300"
            >
              Atualizar
            </button>
          </div>
        </div>
      </form>

      <!-- Indicador de envio -->
      <div v-if="form.processing" class="mt-4 text-center text-gray-500">Atualizando...</div>
    </div>
  </div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/inertia-vue3'

const { flash, bakery } = usePage().props

const form = useForm({
  name: bakery?.name || '',
  postal_code: bakery?.postal_code || '',
  street: bakery?.street || '',
  number: bakery?.number || '',
  neighborhood: bakery?.neighborhood || '',
  city: bakery?.city || '',
  state: bakery?.state || '',
  phone: bakery?.phone || '',
  latitude: bakery?.latitude || '',
  longitude: bakery?.longitude || '',
  image: null,
})

const fields = [
  { id: 'name', label: 'Nome', placeholder: 'Nome da Confeitaria', type: 'text' },
  { id: 'postal_code', label: 'CEP', placeholder: 'CEP', type: 'text' },
  { id: 'street', label: 'Rua', placeholder: 'Rua', type: 'text' },
  { id: 'number', label: 'Número', placeholder: 'Número', type: 'text' },
  { id: 'neighborhood', label: 'Bairro', placeholder: 'Bairro', type: 'text' },
  { id: 'city', label: 'Cidade', placeholder: 'Cidade', type: 'text' },
  { id: 'state', label: 'Estado', placeholder: 'Estado', type: 'text' },
  { id: 'phone', label: 'Telefone', placeholder: 'Telefone', type: 'text' },
  { id: 'latitude', label: 'Latitude', placeholder: 'Latitude', type: 'text' },
  { id: 'longitude', label: 'Longitude', placeholder: 'Longitude', type: 'text' },
]

function submit() {
  const data = new FormData()
  Object.entries(form.data()).forEach(([key, value]) => {
    if (value !== null && value !== '') {
      data.append(key, value)
    }
  })

  // Enviar os dados com axios
  axios.post(`/bakeries/${bakery.id}?_method=PUT`, data, {
    headers: {
      'Content-Type': 'multipart/form-data'
    }
  })
  .then(() => {
    flash.success = 'Confeitaria atualizada com sucesso!'
    form.reset()
  })
  .catch(() => {
    flash.error = 'Erro ao atualizar confeitaria. Verifique os dados.'
  })
}

async function buscarCep() {
  const cep = form.postal_code.replace(/\D/g, '')

  if (cep.length !== 8) {
    flash.error = 'CEP inválido.'
    return
  }

  try {
    const response = await fetch(`/buscar-cep/${cep}`)
    if (!response.ok) throw new Error('CEP não encontrado')
    const data = await response.json()

    form.street = data.logradouro || ''
    form.neighborhood = data.bairro || ''
    form.city = data.localidade || ''
    form.state = data.uf || ''
  } catch (error) {
    console.error('Erro ao buscar CEP:', error)
    flash.error = 'CEP inválido ou não encontrado.'
  }
}
</script>

<style scoped>
.alert {
  padding: 1em;
  margin-bottom: 1em;
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
