<template>
  <div>
    <h1>Cadastrar Confeitaria</h1>

    <!-- Mensagens de sucesso ou erro -->
    <div v-if="flash.success" class="alert alert-success">
      {{ flash.success }}
    </div>
    <div v-if="flash.error" class="alert alert-danger">
      {{ flash.error }}
    </div>

    <!-- Formulário de cadastro -->
    <form @submit.prevent="submit">
      <input 
        v-model="form.nome" 
        placeholder="Nome" 
        :class="{'is-invalid': form.errors.nome}" 
      />

      <input 
        v-model="form.cep" 
        placeholder="CEP" 
        @blur="buscarCep" 
        :class="{'is-invalid': form.errors.cep}" 
      />

      <input 
        v-model="form.rua" 
        placeholder="Rua" 
        :class="{'is-invalid': form.errors.rua}" 
      />
      <input 
        v-model="form.numero" 
        placeholder="Número" 
        :class="{'is-invalid': form.errors.numero}" 
      />
      <input 
        v-model="form.bairro" 
        placeholder="Bairro" 
        :class="{'is-invalid': form.errors.bairro}" 
      />
      <input 
        v-model="form.cidade" 
        placeholder="Cidade" 
        :class="{'is-invalid': form.errors.cidade}" 
      />
      <input 
        v-model="form.estado" 
        placeholder="Estado" 
        :class="{'is-invalid': form.errors.estado}" 
      />
      <input 
        v-model="form.telefone" 
        placeholder="Telefone" 
        :class="{'is-invalid': form.errors.telefone}" 
      />
      <input 
        v-model="form.latitude" 
        placeholder="Latitude" 
        :class="{'is-invalid': form.errors.latitude}" 
      />
      <input 
        v-model="form.longitude" 
        placeholder="Longitude" 
        :class="{'is-invalid': form.errors.longitude}" 
      />

      <button type="submit" :disabled="form.processing">Salvar</button>
    </form>

    <!-- Indicador de envio -->
    <div v-if="form.processing">Enviando...</div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import { usePage } from '@inertiajs/inertia-vue3'

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
})

function submit() {
  form.post('/bakeries', {
    onSuccess: () => {
      form.reset()
    },
    onError: () => {
      flash.error = "Erro ao cadastrar confeitaria. Tente novamente."
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
.is-invalid {
  border-color: red;
}

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
