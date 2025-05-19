<script setup>
import { defineProps, ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

// Recibimos el arreglo de productos con sus categorías y marcas
const { productos } = defineProps({
  productos: {
    type: Array,
    default: () => [],
  },
});

// Estado de filtros
const selectedCategory = ref('');
const selectedBrand = ref('');

// Función para limpiar filtros
const clearFilters = () => {
  selectedCategory.value = '';
  selectedBrand.value = '';
};

// Lista de categorías dinámica según la marca seleccionada
const categories = computed(() => {
  let prods = productos;
  if (selectedBrand.value) {
    prods = prods.filter(p => p.marca === selectedBrand.value);
  }
  return Array.from(new Set(prods.map(p => p.nombre_categoria))).filter(Boolean);
});

// Lista de marcas dinámica según la categoría seleccionada
const brands = computed(() => {
  let prods = productos;
  if (selectedCategory.value) {
    prods = prods.filter(p => p.nombre_categoria === selectedCategory.value);
  }
  return Array.from(new Set(prods.map(p => p.marca))).filter(Boolean);
});

// Productos filtrados según ambos filtros
const filteredProducts = computed(() =>
  productos.filter(p => {
    if (selectedCategory.value && p.nombre_categoria !== selectedCategory.value) return false;
    if (selectedBrand.value && p.marca !== selectedBrand.value) return false;
    return true;
  })
);
</script>

<template>
  <AppLayout title="Principal">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Principal</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
          <h3 class="text-lg font-medium mb-4 dark:text-gray-200">Productos Disponibles</h3>

          <!-- Filtros dependientes con botón de limpiar -->
          <div class="flex flex-wrap gap-4 mb-6 items-end">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoría</label>
              <select
                v-model="selectedCategory"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"
              >
                <option value="">Todas</option>
                <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Marca</label>
              <select
                v-model="selectedBrand"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"
              >
                <option value="">Todas</option>
                <option v-for="brand in brands" :key="brand" :value="brand">{{ brand }}</option>
              </select>
            </div>

            <div>
              <button
                @click="clearFilters"
                class="mt-1 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600"
              >
                Limpiar filtros
              </button>
            </div>
          </div>

          <!-- Grid de productos filtrados -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
              v-for="producto in filteredProducts"
              :key="producto.id_producto"
              class="border border-gray-200 dark:border-gray-700 p-4 rounded-lg hover:shadow-md transition"
            >
              <img
                v-if="producto.imagen"
                :src="producto.imagen"
                alt="Imagen de {{ producto.nombre }}"
                class="w-full h-32 object-cover rounded mb-2"
              />
              <h4 class="text-center font-medium mb-2">{{ producto.nombre }}</h4>
              <p class="text-center text-sm text-gray-500 mb-2">
                {{ producto.nombre_categoria }} / {{ producto.marca }}
              </p>
              <a
                :href="route('productos.show', producto.slug)"
                target="_blank"
                class="block text-center text-blue-600 hover:underline dark:text-indigo-400 font-medium"
              >
                Ver detalle
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
