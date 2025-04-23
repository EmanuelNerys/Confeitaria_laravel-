<template>
  <div class="max-w-7xl mx-auto px-6 py-10">
    <!-- Título principal -->
    <h1 class="text-4xl font-extrabold text-center text-gray-800 mb-12 tracking-tight">
      Bem-vindo a <span class="text-blue-600">{{ bakery.nome }}</span>!
    </h1>

    <!-- Confeitarias em Destaque -->
    <section v-if="bakeries.length" class="mb-16">
      <h2 class="text-2xl font-bold text-gray-700 mb-6">🏪 Confeitarias em Destaque</h2>
      <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <div
          v-for="bakery in bakeries"
          :key="bakery.id"
          class="bg-white rounded-2xl shadow-md hover:shadow-lg transition duration-300 overflow-hidden"
        >
          <img
            :src="bakery.image ? `/storage/${bakery.image}` : 'https://via.placeholder.com/400x200'"
            alt="Imagem da confeitaria"
            class="h-40 w-full object-cover"
          />
          <div class="p-5">
            <h3 class="text-lg font-semibold text-gray-800">{{ bakery.nome }}</h3>
            <p class="text-sm text-gray-500">{{ bakery.cidade }}, {{ bakery.estado }}</p>
            <p class="text-sm text-gray-500">{{ bakery.rua }}, {{ bakery.numero }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Botão de Edição -->
    <a
      v-if="bakeries.length"
      :href="`/bakeries/${bakeries[0].id}/edit`"
      class="inline-block bg-yellow-500 text-white text-lg font-medium py-3 px-6 rounded-full shadow-lg hover:bg-yellow-600 transition-all duration-300"
    >
      ✏️ Editar Confeitaria
    </a>
  </div>
</template>
