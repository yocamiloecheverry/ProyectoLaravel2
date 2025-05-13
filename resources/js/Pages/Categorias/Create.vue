<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    nombre_categoria: '',
    descripcion: '',
    imagen: null,
});

const submit = () => {
    form.post(route('categorias.store')); 
};

const handleFileUpload = (event) => {
    form.imagen = event.target.files[0]; // Guarda el archivo en el formulario
};
</script>

<template>
    <Head title="Crear Categoria"/>

    <AppLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Crear Categoria</h2>
                <Link :href="route('categorias.index')"
                      class="px-4 py-2 bg-gray-800 dark:bg-gray-700 text-white rounded-md hover:bg-gray-700 dark:hover:bg-gray-600">
                    Volver a Categorias
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <InputLabel for="nombre_categoria" value="Nombre Categoria" class="dark:text-gray-300"/>
                                <TextInput
                                    id="nombre_categoria"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.nombre_categoria"
                                    required
                                    autofocus
                                />
                                <InputError class="mt-2" :message="form.errors.nombre_categoria"/>
                            </div>

                            <div class="mb-4">
                                <InputLabel for="descripcion" value="Descripcion" class="dark:text-gray-300"/>
                                <TextInput
                                    id="descripcion"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.descripcion"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.descripcion"/>
                            </div>

                            <div class="mb-4">
                                <InputLabel for="imagen" value="Imagen de la Categoría" class="dark:text-gray-300" />
                                <input id="imagen" type="file"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300"
                                    @change="handleFileUpload" />
                                <InputError class="mt-2" :message="form.errors.imagen" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                               :disabled="form.processing">
                                    Crear Categoria
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>