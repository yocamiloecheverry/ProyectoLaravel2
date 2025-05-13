<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    producto: Object,
    categorias: Array,
});

import { reactive } from 'vue';

const form = reactive({
    nombre: props.producto.nombre,
    marca: props.producto.marca,
    referencia: props.producto.referencia,
    capacidad: props.producto.capacidad,
    caracteristicas: props.producto.caracteristicas,
    id_categoria: props.producto.id_categoria,
    imagen: null, // importante iniciar en null
    errors: {},
    processing: false,
});

const submit = () => {
    const formData = new FormData();

    formData.append('nombre', form.nombre);
    formData.append('marca', form.marca);
    formData.append('referencia', form.referencia);
    formData.append('capacidad', form.capacidad);
    formData.append('caracteristicas', form.caracteristicas);
    formData.append('id_categoria', form.id_categoria);

    if (form.imagen instanceof File) {
        formData.append('imagen', form.imagen);
    }

    formData.append('_method', 'PUT');

    Inertia.post(route('productos.update', props.producto.id_producto), formData, {
        forceFormData: true,
        onStart: () => form.processing = true,
        onFinish: () => form.processing = false,
        onSuccess: () => console.log('Producto actualizado exitosamente.'),
        onError: (errors) => {
            form.errors = errors;
            console.error(errors);
        }
    });
};

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    form.imagen = file;

    if (file) {
        form.preview = URL.createObjectURL(file);
    }
};
</script>

<template>

    <Head title="Editar Producto" />

    <AppLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Editar Producto</h2>
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
                        <form @submit.prevent="submit">

                            <div class="mb-4">
                                <InputLabel for="nombre" value="Nombre Producto" class="dark:text-gray-300" />
                                <TextInput id="nombre" type="text" class="mt-1 block w-full" v-model="form.nombre" required autofocus />
                                <InputError class="mt-2" :message="form.errors.nombre" />
                            </div>

                            <div class="mb-4">
                                <InputLabel for="categoria" value="Categoría del Producto" class="dark:text-gray-300" />
                                <select id="id_categoria" class="mt-1 block w-full" v-model="form.id_categoria" required>
                                    <option value="" disabled>Seleccione una categoría</option>
                                    <option v-for="categoria in categorias" :key="categoria.id_categoria" :value="categoria.id_categoria">
                                        {{ categoria.nombre_categoria }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.id_categoria" />
                            </div>

                            <div class="mb-4">
                                <InputLabel for="marca" value="Marca Producto" class="dark:text-gray-300" />
                                <TextInput id="marca" type="text" class="mt-1 block w-full" v-model="form.marca" required />
                                <InputError class="mt-2" :message="form.errors.marca" />
                            </div>

                            <div class="mb-4">
                                <InputLabel for="referencia" value="Referencia Producto" class="dark:text-gray-300" />
                                <TextInput id="referencia" type="text" class="mt-1 block w-full" v-model="form.referencia" required />
                                <InputError class="mt-2" :message="form.errors.referencia" />
                            </div>

                            <div class="mb-4">
                                <InputLabel for="capacidad" value="Capacidad Producto" class="dark:text-gray-300" />
                                <TextInput id="capacidad" type="text" class="mt-1 block w-full" v-model="form.capacidad" required />
                                <InputError class="mt-2" :message="form.errors.capacidad" />
                            </div>

                            <div class="mb-4">
                                <InputLabel for="caracteristicas" value="Características Producto" class="dark:text-gray-300" />
                                <TextInput id="caracteristicas" type="text" class="mt-1 block w-full" v-model="form.caracteristicas" required />
                                <InputError class="mt-2" :message="form.errors.caracteristicas" />
                            </div>

                            <div class="mb-4">
                                <InputLabel for="imagen" value="Imagen del Producto" class="dark:text-gray-300" />
                                <input id="imagen" type="file"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300"
                                    @change="handleFileUpload" />
                                <InputError class="mt-2" :message="form.errors.imagen" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Editar Producto
                                </PrimaryButton>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </AppLayout>
</template>
