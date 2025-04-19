<template>
  <div>
    <h1>Lista de Confeitarias</h1>

    <!-- Exibe mensagem de sucesso -->
    <div v-if="flash.success" class="alert alert-success">
      {{ flash.success }}
    </div>

    <!-- Exibe mensagem de erro -->
    <div v-if="flash.error" class="alert alert-danger">
      {{ flash.error }}
    </div>

    <!-- Lista de Confeitarias -->
    <div class="bakeries-container">
      <div v-if="bakeries.length > 0">
        <div v-for="bakery in bakeries" :key="bakery.id" class="bakery-card">
          <h3>{{ bakery.name }}</h3>
          <p>{{ bakery.city }}, {{ bakery.state }}</p>
          <p>{{ bakery.phone }}</p>
          
          <!-- Botões de Ação -->
          <div class="actions">
            <button @click="editBakery(bakery.id)">Editar</button>
            <button @click="deleteBakery(bakery.id)">Excluir</button>
          </div>
        </div>
      </div>

      <!-- Caso não haja confeitarias cadastradas -->
      <p v-else>Nenhuma confeitaria cadastrada ainda.</p>
    </div>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'

// Pegando os dados da página que o Inertia passou
const { bakeries, flash } = usePage().props

// Função para editar uma confeitaria
function editBakery(id) {
  Inertia.visit(`/bakeries/${id}/edit`) // Redireciona para a página de edição
}

// Função para excluir uma confeitaria
function deleteBakery(id) {
  if (confirm('Tem certeza que deseja excluir esta confeitaria?')) {
    Inertia.delete(`/bakeries/${id}`, {
      onSuccess: () => {
        flash.success = 'Confeitaria excluída com sucesso!' // Atualiza a mensagem de sucesso
      },
      onError: () => {
        flash.error = 'Erro ao excluir a confeitaria.' // Atualiza a mensagem de erro
      }
    })
  }
}
</script>

<style scoped>
.bakeries-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: space-around;
}

.bakery-card {
  border: 1px solid #ddd;
  padding: 1em;
  margin-bottom: 1em;
  border-radius: 8px;
  background-color: #f9f9f9;
  width: 300px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.bakery-card h3 {
  margin-top: 0;
  font-size: 1.25em;
}

.bakery-card p {
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

/* Estilo para alertas */
.alert {
  padding: 1em;
  margin-bottom: 1em;
  border-radius: 5px;
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
