<template>
  <div>
   
    <div id="map" style="height: 500px;"></div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

const props = defineProps({
  bakeries: Array
})

// Corrigir ícones padrão do Leaflet
L.Icon.Default.mergeOptions({
  iconRetinaUrl: 'marker-icon-2x.png', // Ícone retina (alta definição)
  iconUrl: 'marker-icon.png',          // Ícone normal
  shadowUrl: 'marker-shadow.png',      // Sombra
})


onMounted(() => {
  // Inicializa o mapa com ponto inicial
  const map = L.map('map').setView([-7.13580600, -34.89041900], 12)
  
  // Camada de fundo OpenStreetMap
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors',
  }).addTo(map)

  // Adiciona marcadores para cada confeitaria
  props.bakeries.forEach(bakery => {
    const imageUrl = bakery.image ? `/storage/${bakery.image}` : '/storage/bakeries/default.jpg'
    
    const marker = L.marker([bakery.latitude, bakery.longitude]).addTo(map)
    
    marker.bindPopup(`
      <div style="text-align: center;">
        <strong>${bakery.name}</strong><br>
        <img src="${imageUrl}" style="width: 100px; height: auto; margin-top: 5px;"><br>
        <a href="/bakeries/${bakery.id}/show" style="color: #007BFF;">Ver detalhes</a><br>
        <small>Latitude: ${bakery.latitude} | Longitude: ${bakery.longitude}</small>
      </div>
    `)
  })
})
</script>

<style scoped>
#map {
  width: 100%;
  height: 500px;
}

/* Deixa o pop-up com imagem melhor centralizado */
.leaflet-popup-content {
  text-align: center;
}
</style>
