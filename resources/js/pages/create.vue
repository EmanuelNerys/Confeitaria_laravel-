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
      <form @submit.prevent="submit">
        <div class="space-y-6">
          <div>
            <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
            <input 
              id="nome" 
              v-model="form.nome" 
              type="text" 
              placeholder="Nome da Confeitaria"
              :class="{'border-red-500': form.errors.nome}" 
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-400"
            />
            <p v-if="form.errors.nome" class="text-sm text-red-500 mt-1">{{ form.errors.nome }}</p>
          </div>

          <div>
            <label for="cep" class="block text-sm font-medium text-gray-700">CEP</label>
            <input 
              id="cep" 
              v-model="form.cep" 
              type="text" 
              placeholder="CEP"
              @blur="buscarCep" 
              :class="{'border-red-500': form.errors.cep}" 
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-400"
            />
            <p v-if="form.errors.cep" class="text-sm text-red-500 mt-1">{{ form.errors.cep }}</p>
          </div>

          <div>
            <label for="rua" class="block text-sm font-medium text-gray-700">Rua</label>
            <input 
              id="rua" 
              v-model="form.rua" 
              type="text" 
              placeholder="Rua"
              :class="{'border-red-500': form.errors.rua}" 
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-400"
            />
            <p v-if="form.errors.rua" class="text-sm text-red-500 mt-1">{{ form.errors.rua }}</p>
          </div>

          <div>
            <label for="numero" class="block text-sm font-medium text-gray-700">Número</label>
            <input 
              id="numero" 
              v-model="form.numero" 
              type="text" 
              placeholder="Número"
              :class="{'border-red-500': form.errors.numero}" 
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-400"
            />
            <p v-if="form.errors.numero" class="text-sm text-red-500 mt-1">{{ form.errors.numero }}</p>
          </div>

          <div>
            <label for="bairro" class="block text-sm font-medium text-gray-700">Bairro</label>
            <input 
              id="bairro" 
              v-model="form.bairro" 
              type="text" 
              placeholder="Bairro"
              :class="{'border-red-500': form.errors.bairro}" 
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-400"
            />
            <p v-if="form.errors.bairro" class="text-sm text-red-500 mt-1">{{ form.errors.bairro }}</p>
          </div>

          <div>
            <label for="cidade" class="block text-sm font-medium text-gray-700">Cidade</label>
            <input 
              id="cidade" 
              v-model="form.cidade" 
              type="text" 
              placeholder="Cidade"
              :class="{'border-red-500': form.errors.cidade}" 
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-400"
            />
            <p v-if="form.errors.cidade" class="text-sm text-red-500 mt-1">{{ form.errors.cidade }}</p>
          </div>

          <div>
            <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
            <input 
              id="estado" 
              v-model="form.estado" 
              type="text" 
              placeholder="Estado"
              :class="{'border-red-500': form.errors.estado}" 
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-400"
            />
            <p v-if="form.errors.estado" class="text-sm text-red-500 mt-1">{{ form.errors.estado }}</p>
          </div>

          <div>
            <label for="telefone" class="block text-sm font-medium text-gray-700">Telefone</label>
            <input 
              id="telefone" 
              v-model="form.telefone" 
              type="text" 
              placeholder="Telefone"
              :class="{'border-red-500': form.errors.telefone}" 
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-400"
            />
            <p v-if="form.errors.telefone" class="text-sm text-red-500 mt-1">{{ form.errors.telefone }}</p>
          </div>

          <div>
            <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
            <input 
              id="latitude" 
              v-model="form.latitude" 
              type="text" 
              placeholder="Latitude"
              :class="{'border-red-500': form.errors.latitude}" 
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-400"
            />
            <p v-if="form.errors.latitude" class="text-sm text-red-500 mt-1">{{ form.errors.latitude }}</p>
          </div>

          <div>
            <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
            <input 
              id="longitude" 
              v-model="form.longitude" 
              type="text" 
              placeholder="Longitude"
              :class="{'border-red-500': form.errors.longitude}" 
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-400"
            />
            <p v-if="form.errors.longitude" class="text-sm text-red-500 mt-1">{{ form.errors.longitude }}</p>
          </div>

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
import { useForm } from '@inertiajs/inertia-vue3'
import { usePage } from '@inertiajs/inertia-vue3'

const { flash } = usePage().props // Acessando flash, que pode ser vazio

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
})

function submit() {
  form.post('/bakeries', {
    onSuccess: () => {
      form.reset()
    },
    onError: () => {
      flash.error = flash.error || 'Erro ao cadastrar confeitaria. Tente novamente.'
    }
  })
}

async function buscarCep() {
  const cep = form.cep.replace(/\D/g, '')

  if (cep.length !== 8) return

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

<style scoped>
/* Estilos globais não são necessários com Tailwind */
</style>
