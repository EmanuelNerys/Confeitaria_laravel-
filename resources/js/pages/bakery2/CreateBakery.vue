<template>
    <div class="max-w-4xl mx-auto p-8 bg-white rounded-lg shadow-lg">
      <h1 class="text-3xl font-bold text-gray-800 mb-6">Criar Confeitaria</h1>
  
      <form @submit.prevent="submitForm">
        <!-- Nome da Confeitaria -->
        <div class="mb-4">
          <label for="nome" class="block text-sm font-medium text-gray-700">Nome da Confeitaria</label>
          <input
            id="nome"
            v-model="form.nome"
            type="text"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
            placeholder="Nome da confeitaria"
            required
          />
        </div>
  
        <!-- CEP -->
        <div class="mb-4">
          <label for="cep" class="block text-sm font-medium text-gray-700">CEP</label>
          <input
            id="cep"
            v-model="form.cep"
            type="text"
            @blur="fetchAddressFromCep"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
            placeholder="CEP"
            required
          />
        </div>
  
        <!-- Endereço -->
        <div class="mb-4">
          <label for="rua" class="block text-sm font-medium text-gray-700">Endereço</label>
          <input
            id="rua"
            v-model="form.rua"
            type="text"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
            placeholder="Endereço"
            required
          />
        </div>
  
        <!-- Número -->
        <div class="mb-4">
          <label for="numero" class="block text-sm font-medium text-gray-700">Número</label>
          <input
            id="numero"
            v-model="form.numero"
            type="text"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
            placeholder="Número"
            required
          />
        </div>
  
        <!-- Bairro -->
        <div class="mb-4">
          <label for="bairro" class="block text-sm font-medium text-gray-700">Bairro</label>
          <input
            id="bairro"
            v-model="form.bairro"
            type="text"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
            placeholder="Bairro"
            required
          />
        </div>
  
        <!-- Cidade -->
        <div class="mb-4">
          <label for="cidade" class="block text-sm font-medium text-gray-700">Cidade</label>
          <input
            id="cidade"
            v-model="form.cidade"
            type="text"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
            placeholder="Cidade"
            required
          />
        </div>
  
        <!-- Estado -->
        <div class="mb-4">
          <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
          <input
            id="estado"
            v-model="form.estado"
            type="text"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
            placeholder="Estado"
            required
          />
        </div>
  
        <!-- Telefone -->
        <div class="mb-4">
          <label for="telefone" class="block text-sm font-medium text-gray-700">Telefone</label>
          <input
            id="telefone"
            v-model="form.telefone"
            type="text"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
            placeholder="Telefone"
            required
          />
        </div>
  
        <!-- Botão de Enviar -->
        <div>
          <button type="submit" class="bg-blue-500 text-white p-2 rounded-md w-full">Criar Confeitaria</button>
        </div>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { useForm } from '@inertiajs/inertia-vue3';
  
  // Modelo de dados do formulário
  const form = ref({
    nome: '',
    cep: '',
    rua: '',
    numero: '',
    bairro: '',
    cidade: '',
    estado: '',
    telefone: ''
  });
  
  // Função para buscar o endereço pelo CEP usando a API ViaCEP
  const fetchAddressFromCep = async () => {
    if (form.value.cep.length === 8) {
      try {
        const response = await fetch(`https://viacep.com.br/ws/${form.value.cep}/json/`);
        const data = await response.json();
  
        if (!data.erro) {
          form.value.rua = data.logradouro;
          form.value.bairro = data.bairro;
          form.value.cidade = data.localidade;
          form.value.estado = data.uf;
        } else {
          alert('CEP não encontrado!');
        }
      } catch (error) {
        console.error('Erro ao buscar o CEP:', error);
        alert('Erro ao buscar o CEP. Tente novamente.');
      }
    }
  };
  
  // Função para enviar os dados do formulário
  const submitForm = () => {
    // Envia os dados para o backend utilizando Inertia
    form.value.post(route('bakeries.store'));
  };
  </script>
  
  <style scoped>
  /* Estilos adicionais */
  input:focus {
    outline: 2px solid #4B5563;
  }
  </style>
  