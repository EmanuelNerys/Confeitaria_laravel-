<template>
  <div>
    <h1>Cadastrar Confeitaria</h1>

    <!-- Exibe mensagem de sucesso ou erro -->
    <div v-if="flash.success" class="alert alert-success">
      {{ flash.success }}
    </div>
    <div v-if="flash.error" class="alert alert-danger">
      {{ flash.error }}
    </div>

    <!-- Formulário de cadastro -->
    <form @submit.prevent="submit">
      <input v-model="form.name" placeholder="Nome" :class="{'is-invalid': form.errors.name}" />
      <input v-model="form.cep" placeholder="CEP" :class="{'is-invalid': form.errors.cep}" />
      <input v-model="form.street" placeholder="Rua" :class="{'is-invalid': form.errors.street}" />
      <input v-model="form.number" placeholder="Número" :class="{'is-invalid': form.errors.number}" />
      <input v-model="form.neighborhood" placeholder="Bairro" :class="{'is-invalid': form.errors.neighborhood}" />
      <input v-model="form.city" placeholder="Cidade" :class="{'is-invalid': form.errors.city}" />
      <input v-model="form.state" placeholder="Estado" :class="{'is-invalid': form.errors.state}" />
      <input v-model="form.phone" placeholder="Telefone" :class="{'is-invalid': form.errors.phone}" />
      <input v-model="form.latitude" placeholder="Latitude" :class="{'is-invalid': form.errors.latitude}" />
      <input v-model="form.longitude" placeholder="Longitude" :class="{'is-invalid': form.errors.longitude}" />

      <button type="submit" :disabled="form.processing">Salvar</button>
    </form>

    <!-- Exibe indicador de carregamento -->
    <div v-if="form.processing">Enviando...</div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import { usePage } from '@inertiajs/inertia-vue3'

const { flash } = usePage().props;  // Pegando flash diretamente do Inertia

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
      // Não precisa mais setar flash.success aqui, pois ele é enviado com a resposta Inertia
    },
    onError: () => {
      flash.error = "Erro ao cadastrar confeitaria. Tente novamente.";
    }
  });
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
