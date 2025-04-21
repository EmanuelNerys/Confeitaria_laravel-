<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Lista de Confeitarias</h1>

    <!-- Exibe mensagem de sucesso -->
    <div v-if="flash?.success" class="alert alert-success mb-4 p-4 bg-green-100 text-green-800 rounded">
      {{ flash.success }}
    </div>

    <!-- Exibe mensagem de erro -->
    <div v-if="flash?.error" class="alert alert-danger mb-4 p-4 bg-red-100 text-red-800 rounded">
      {{ flash.error }}
    </div>

    <!-- Lista de Confeitarias -->
    <div class="bakeries-container flex flex-wrap gap-5 justify-center">
      <div v-if="bakeries.length > 0">
        <div v-for="bakery in bakeries" :key="bakery.id" class="bakery-card p-4 border border-gray-300 rounded-lg shadow-md bg-white w-72">
          <h3 class="text-xl font-semibold mb-2">{{ bakery.name }}</h3>
          <p class="text-gray-600">{{ bakery.city }}, {{ bakery.state }}</p>
          <p class="text-gray-600">{{ bakery.phone }}</p>

          <!-- Botões de Ação -->
          <div class="actions mt-4 flex space-x-2">
            <button 
              @click="editBakery(bakery.id)" 
              class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
              Editar
            </button>
            <button 
              @click="deleteBakery(bakery.id)" 
              class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
              Excluir
            </button>
          </div>
        </div>
      </div>

      <!-- Caso não haja confeitarias cadastradas -->
      <p v-else class="text-lg text-gray-500">Nenhuma confeitaria cadastrada ainda.</p>
    </div>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import { computed } from 'vue'

// Pegando os dados da página que o Inertia passou
const page = usePage()
const bakeries = computed(() => page.props.bakeries ?? [])
const flash = computed(() => page.props.flash ?? {})

// Função para editar uma confeitaria
function editBakery(id) {
  Inertia.visit(`/bakeries/${id}/edit`) // Redireciona para a página de edição
}

// Função para excluir uma confeitaria
function deleteBakery(id) {
  if (confirm('Tem certeza que deseja excluir esta confeitaria?')) {
    Inertia.delete(`/bakeries/${id}`, {
      onSuccess: () => {
        flash.success = 'Confeitaria excluída com sucesso!'
        bakeries.value = bakeries.value.filter(bakery => bakery.id !== id)
      },
      onError: () => {
        flash.error = 'Erro ao excluir a confeitaria.'
      }
    })
  }
}
</script>

<style scoped>
/* Caso precise adicionar algo personalizado */
</style>
