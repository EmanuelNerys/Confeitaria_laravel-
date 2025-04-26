<template>
  <div v-if="show" class="fixed inset-0 flex items-center justify-center bg-gray-600 bg-opacity-50 z-50">
    <div
      ref="modalRef"
      class="bg-white p-6 rounded-lg shadow-lg w-full sm:w-full md:w-10/12 lg:w-8/12 xl:w-6/12 transition-all transform scale-95 opacity-0 sm:scale-100 sm:opacity-100"
      :class="{'opacity-100 scale-100': show}"
    >
      <button
        @click="closeModal"
        class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 transition duration-300 p-2 rounded-full"
      >
        ✖️
      </button>
      <slot></slot>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits, ref, watch } from 'vue'

// Define as props
const props = defineProps({
  show: {
    type: Boolean,
    required: true,
  }
})

// Emitir evento para fechar o modal
const emit = defineEmits(['update:show'])

// Fechar o modal
const closeModal = () => {
  emit('update:show', false)
}

// Para garantir que o modal apareça com a transição correta
const modalRef = ref(null)

watch(() => props.show, (newValue) => {
  if (newValue) {
    modalRef.value?.classList.remove('scale-95', 'opacity-0')
    modalRef.value?.classList.add('scale-100', 'opacity-100')
  } else {
    modalRef.value?.classList.add('scale-95', 'opacity-0')
    modalRef.value?.classList.remove('scale-100', 'opacity-100')
  }
})
</script>

<style scoped>
/* Estilos para o modal */
.modal-overlay {
  background-color: rgba(0, 0, 0, 0.5); /* Semitransparente para o fundo */
  z-index: 50;
}

/* Efeito de transição do modal */
.transition-all {
  transition: transform 0.3s ease, opacity 0.3s ease;
}

/* Animação do modal */
.modal-enter-active, .modal-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}
.modal-enter, .modal-leave-to {
  opacity: 0;
  transform: scale(0.95);
}

/* Ajustar largura para telas grandes e pequenas */
@media (max-width: 640px) {
  .bg-white {
    max-width: 95% !important; /* Modal ocupa 95% da largura da tela em dispositivos móveis */
    margin-left: 2.5%; /* Espaço nas bordas */
    margin-right: 2.5%; /* Espaço nas bordas */
  }
}

@media (min-width: 641px) {
  .bg-white {
    max-width: 600px !important; /* Largura do modal em telas maiores */
    margin: 0 auto; /* Centraliza o modal */
  }
}

@media (min-width: 1024px) {
  .bg-white {
    max-width: 500px !important; /* Largura do modal em telas grandes */
  }
}
</style>
