<script setup>
import {Head, Link} from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    producto: Object,
});
</script>

<template>
    <Head title="Detalles de Producto"/>

    <AppLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Detalles del Producto
                </h2>
                <Link :href="route('productos.index')"
                      class="px-4 py-2 bg-gray-800 dark:bg-gray-700 text-white rounded-md hover:bg-gray-700 dark:hover:bg-gray-600">
                    Volver a Productos
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Información de producto</h3>

                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">ID</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ producto.id_producto }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ producto.nombre }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Marca</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ producto.marca }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Referencia</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ producto.referencia }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Capacidad</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ producto.capacidad }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Características</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ producto.caracteristicas }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Imagen</p>
                                    <img :src="producto.imagen" alt="Imagen del producto" class="w-32 h-32 object-cover rounded-md"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>