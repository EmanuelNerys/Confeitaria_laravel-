<template>
  <div>
    <h1>Lista de Confeitarias</h1>

    <!-- Exibe mensagem de sucesso -->
    <div v-if="flash.success" class="alert alert-success">
      {{ flash.success }}
    </div>

    <!-- Lista de Confeitarias -->
    <ul v-if="bakeries.length > 0">
      <li v-for="bakery in bakeries" :key="bakery.id">
        <h3>{{ bakery.name }}</h3>
        <p>{{ bakery.city }}, {{ bakery.state }}</p>
        <p>{{ bakery.phone }}</p>
      </li>
    </ul>

    <!-- Caso não haja confeitarias cadastradas -->
    <p v-else>Nenhuma confeitaria cadastrada ainda.</p>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/inertia-vue3'

// Pegando os dados da página que o Inertia passou
const { bakeries, flash } = usePage().props
</script>

<style scoped>
/* Estilos para a lista de confeitarias */
.bakery-card {
  border: 1px solid #ddd;
  padding: 1em;
  margin-bottom: 1em;
  border-radius: 8px;
  background-color: #f9f9f9;
}

.bakery-card h3 {
  margin-top: 0;
}

/* Estilo para alertas */
.alert {
  padding: 1em;
  margin-bottom: 1em;
}

.alert-success {
  background-color: #d4edda;
  color: #155724;
}
</style>
