<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3'; 
import TaskList from '@/Components/TaskList.vue'; 
import TaskCreateForm from '@/Components/TaskCreateForm.vue'; 
import { ref } from 'vue';

const props = defineProps({
    project: Object, 
    users: Array,    
    statuses: Object, 
});


const showCreateForm = ref(false);

</script>

<template>
    <Head :title="'Project: ' + props.project.name" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Project: {{ props.project.name }}
                </h2>
                <Link :href="route('dashboard')" class="text-sm text-indigo-600 hover:text-indigo-800">
                    ← Back to Dashboard
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-2">Owner: {{ props.project.owner.name}}</h3>
                    <p class="text-gray-600">{{ props.project.description }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4 border-b pb-4">
                        <h3 class="text-lg font-bold text-gray-700">
                            Tasks ({{ props.project.tasks.length }})
                        </h3>
                        <button 
                            @click="showCreateForm = !showCreateForm"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition">
                            {{ showCreateForm ? 'Cancel' : '+ Add New Task' }}
                        </button>
                    </div>

                    <TaskCreateForm
                        v-if="showCreateForm"
                        :project-id="props.project.id"
                        :users="props.users"
                        :statuses="props.statuses"
                        class="mb-6 p-4 border rounded-lg bg-indigo-50"
                        @taskCreated="showCreateForm = false" 
                    />
                    
                    <TaskList 
                        :tasks="props.project.tasks" 
                        :users="props.users"
                        :statuses="props.statuses"
                    />

                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>