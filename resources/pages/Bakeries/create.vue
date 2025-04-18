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
        v-model="form.name" 
        placeholder="Nome" 
        :class="{'is-invalid': form.errors.name}" 
      />

      <!-- Campo de CEP com busca automática -->
      <input 
        v-model="form.cep" 
        placeholder="CEP" 
        @blur="buscarCep" 
        :class="{'is-invalid': form.errors.cep}" 
      />

      <input 
        v-model="form.street" 
        placeholder="Rua" 
        :class="{'is-invalid': form.errors.street}" 
      />
      <input 
        v-model="form.number" 
        placeholder="Número" 
        :class="{'is-invalid': form.errors.number}" 
      />
      <input 
        v-model="form.neighborhood" 
        placeholder="Bairro" 
        :class="{'is-invalid': form.errors.neighborhood}" 
      />
      <input 
        v-model="form.city" 
        placeholder="Cidade" 
        :class="{'is-invalid': form.errors.city}" 
      />
      <input 
        v-model="form.state" 
        placeholder="Estado" 
        :class="{'is-invalid': form.errors.state}" 
      />
      <input 
        v-model="form.phone" 
        placeholder="Telefone" 
        :class="{'is-invalid': form.errors.phone}" 
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
  name: '',
  cep: '',
  street: '',
  number: '',
  neighborhood: '',
  city: '',
  state: '',
  phone: '',
  latitude: '',
  longitude: '',
})

// Função de submit
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

// Função de busca do CEP usando a rota do Laravel
async function buscarCep() {
  const cep = form.cep.replace(/\D/g, '') // Remove qualquer caractere não numérico

  if (cep.length !== 8) return // Se o CEP não tiver 8 dígitos, não faz a busca

  try {
    // Faz a chamada à rota do Laravel que retorna os dados do CEP
    const response = await fetch(`/buscar-cep/${cep}`)
    if (!response.ok) throw new Error('CEP não encontrado')
    const data = await response.json()

    // Preenche os campos do formulário com os dados retornados pela API
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
