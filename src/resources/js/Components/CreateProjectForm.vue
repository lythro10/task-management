<script setup>
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const emit = defineEmits(['projectCreated', 'formCanceled']);

const form = useForm({
    name: '',
    description: '',
});

const submit = () => {
    form.post(route('projects.store'), {
        onSuccess: () => {
            // Reset form and notify parent (Dashboard)
            form.reset();
            emit('projectCreated');
        },
        onStart: () => form.clearErrors(),
    });
};
</script>

<template>
    <form @submit.prevent="submit" class="p-6 border rounded-lg bg-white shadow-lg space-y-4">
        <h3 class="text-xl font-bold text-indigo-700">Create New Project</h3>
        
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Project Name*</label>
            <input id="name" type="text" v-model="form.name" required autofocus
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <p v-if="form.errors.name" class="text-sm text-red-600 mt-1">{{ form.errors.name }}</p>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" v-model="form.description" rows="3"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
            <p v-if="form.errors.description" class="text-sm text-red-600 mt-1">{{ form.errors.description }}</p>
        </div>

        <div class="flex justify-end space-x-3 pt-2">
            <button type="button" @click="emit('formCanceled')" class="text-gray-600 hover:text-gray-800 text-sm">
                Cancel
            </button>
            <PrimaryButton :disabled="form.processing">
                {{ form.processing ? 'Saving...' : 'Create Project' }}
            </PrimaryButton>
        </div>
    </form>
</template>