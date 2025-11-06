<script setup>
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue'; 

const props = defineProps({
    projectId: Number,
    users: Array,
    statuses: Object, 
});

const emit = defineEmits(['taskCreated']);


const form = useForm({
    title: '',
    description: '',
    due_date: '',
    assigned_to: props.users[0]?.id || '',
    status: props.statuses.pending, 
});


const submit = () => {
 
    form.post(route('tasks.store', props.projectId), {
        preserveScroll: true,
  
        onSuccess: () => {
         
            form.reset();
            emit('taskCreated');
        },
        onStart: () => form.clearErrors(),
    });
};
</script>

<template>
    <form @submit.prevent="submit">
        <h4 class="text-md font-semibold mb-4 text-gray-700">Create New Task</h4>
        
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title*</label>
                <input id="title" type="text" v-model="form.title" required 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <p v-if="form.errors.title" class="text-sm text-red-600 mt-1">{{ form.errors.title }}</p>
            </div>

            <div>
                <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                <input id="due_date" type="date" v-model="form.due_date" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <p v-if="form.errors.due_date" class="text-sm text-red-600 mt-1">{{ form.errors.due_date }}</p>
            </div>

            <div>
                <label for="assigned_to" class="block text-sm font-medium text-gray-700">Assign To*</label>
                <select id="assigned_to" v-model="form.assigned_to" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option v-for="user in users" :key="user.id" :value="user.id">
                        {{ user.name }}
                    </option>
                </select>
                <p v-if="form.errors.assigned_to" class="text-sm text-red-600 mt-1">{{ form.errors.assigned_to }}</p>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status*</label>
                <select id="status" v-model="form.status" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option v-for="(value, key) in statuses" :key="key" :value="value">
                        {{ key.charAt(0).toUpperCase() + key.slice(1).replace('_', ' ') }}
                    </option>
                </select>
                <p v-if="form.errors.status" class="text-sm text-red-600 mt-1">{{ form.errors.status }}</p>
            </div>
        </div>

        <div class="mt-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" v-model="form.description" rows="3"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
            <p v-if="form.errors.description" class="text-sm text-red-600 mt-1">{{ form.errors.description }}</p>
        </div>

        <div class="flex justify-end mt-4">
            <PrimaryButton :disabled="form.processing">
                {{ form.processing ? 'Saving...' : 'Create Task' }}
            </PrimaryButton>
        </div>
    </form>
</template>