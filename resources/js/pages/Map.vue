<template>
    <div>
      <h1 class="text-2xl font-bold mb-4">Mapa de Confeitarias</h1>
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
  delete L.Icon.Default.prototype._getIconUrl
  L.Icon.Default.mergeOptions({
    iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
    iconUrl: require('leaflet/dist/images/marker-icon.png'),
    shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
  })
  
  onMounted(() => {
    const map = L.map('map').setView([-23.5505, -46.6333], 12)
  
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors',
    }).addTo(map)
  
    props.bakeries.forEach(bakery => {
      const imageUrl = `/storage/${bakery.image}`
      const marker = L.marker([bakery.latitude, bakery.longitude]).addTo(map)
      marker.bindPopup(`
        <strong>${bakery.nome}</strong><br>
        <img src="${imageUrl}" style="width: 100px; margin-top: 5px;"><br>
        <a href="/bakeries/${bakery.id}/edit">Ver detalhes</a>
      `)
    })
  })
  </script>
  