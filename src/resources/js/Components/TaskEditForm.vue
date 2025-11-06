<script setup>
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

import { router } from '@inertiajs/vue3';

const props = defineProps({
    task: Object,
    users: Array,
    statuses: Array,
});

const emit = defineEmits(['editCanceled', 'taskUpdated']);


// Initialize Inertia form state with the current task data
const form = useForm({
    title: props.task.title,
    description: props.task.description,
    due_date: props.task.due_date,
    assigned_to: props.task.assigned_to,
    status: props.task.status,
});

const submit = () => {
    form.patch(route('tasks.update', props.task.id), {
        onSuccess: () => {
            emit('taskUpdated');
        },
        onStart: () => form.clearErrors(),
    });
};
</script>

<template>
    <form @submit.prevent="submit" class="space-y-3 p-4 bg-gray-50 border rounded-lg">
        <h5 class="text-md font-semibold text-gray-800">Edit Task: {{ task.title }}</h5>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="edit_title" class="block text-sm font-medium text-gray-700">Title</label>
                <input id="edit_title" type="text" v-model="form.title" required 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <p v-if="form.errors.title" class="text-sm text-red-600 mt-1">{{ form.errors.title }}</p>
            </div>
            <div>
                <label for="edit_due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                <input id="edit_due_date" type="date" v-model="form.due_date" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <p v-if="form.errors.due_date" class="text-sm text-red-600 mt-1">{{ form.errors.due_date }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="edit_assigned_to" class="block text-sm font-medium text-gray-700">Assign To</label>
                <select id="edit_assigned_to" v-model="form.assigned_to" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option v-for="user in users" :key="user.id" :value="user.id">
                        {{ user.name }}
                    </option>
                </select>
                <p v-if="form.errors.assigned_to" class="text-sm text-red-600 mt-1">{{ form.errors.assigned_to }}</p>
            </div>
            <div>
                <label for="edit_status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="edit_status" v-model="form.status" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option v-for="status in statuses" :key="status" :value="status">
                        {{ status.charAt(0).toUpperCase() + status.slice(1).replace('_', ' ') }}
                    </option>
                </select>
                <p v-if="form.errors.status" class="text-sm text-red-600 mt-1">{{ form.errors.status }}</p>
            </div>
        </div>
        
        <div>
            <label for="edit_description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="edit_description" v-model="form.description" rows="2"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
            <p v-if="form.errors.description" class="text-sm text-red-600 mt-1">{{ form.errors.description }}</p>
        </div>

        <div class="flex justify-end space-x-2 pt-2">
            <button type="button" @click="emit('editCanceled')" class="text-gray-600 hover:text-gray-800 text-sm">
                Cancel
            </button>
            <PrimaryButton :disabled="form.processing">
                {{ form.processing ? 'Updating...' : 'Save Changes' }}
            </PrimaryButton>
        </div>
    </form>
</template>