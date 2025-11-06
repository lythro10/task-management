<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3'; 
// Project creation form component
import CreateProjectForm from '@/Components/CreateProjectForm.vue';
import { ref } from 'vue'; // Imported for reactive state ('ref') and general use


// Define the 'projects' prop to receive data from the ProjectController
const props = defineProps({
    projects: Array,
});

const showCreateForm = ref(false); // Controls the visibility of the creation form


const handleFormClose = () => {
    // This is called when the form is submitted successfully OR canceled.
    showCreateForm.value = false;
    // On successful submission, the backend redirects back to the dashboard, 
    // which automatically refreshes the 'projects' prop.
};

</script>

<template>
    <Head title="Project Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Delfi Task Management - Project Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                
                <div class="flex justify-end">
                    <button 
                        @click="showCreateForm = !showCreateForm"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition">
                        {{ showCreateForm ? 'Hide Form' : '+ New Project' }}
                    </button>
                </div>

                <CreateProjectForm
                    v-if="showCreateForm"
                    @projectCreated="handleFormClose"
                    @formCanceled="handleFormClose"
                />
                
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    
                    <div v-for="project in props.projects" :key="project.id" 
                         class="overflow-hidden bg-white shadow-xl sm:rounded-lg p-6 border-l-4 border-indigo-500">
                        
                        <Link :href="route('projects.show', project.id)" 
                              class="text-xl font-bold text-indigo-600 hover:text-indigo-800 transition duration-150 ease-in-out">
                            {{ project.name }}
                        </Link>
                        
                        <p class="mt-2 text-sm text-gray-600 line-clamp-2">
                            {{ project.description }}
                        </p>

                        <div class="mt-4 border-t pt-4">
                            <p class="font-medium text-lg">
                                Total Tasks: <strong class="ml-1">{{ project.total_tasks }}</strong>
                            </p>
                            
                            <div class="text-sm mt-2 space-y-1">
                                <p class="flex items-center">
                                    Done: <strong class="ml-1">{{ project.summary.done }}</strong>
                                </p>
                                <p class="flex items-center">
                                    In Progress: <strong class="ml-1">{{ project.summary.in_progress }}</strong>
                                </p>
                                <p class="flex items-center">
                                    Pending: <strong class="ml-1">{{ project.summary.pending }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div v-if="props.projects.length === 0" class="md:col-span-3 text-center p-10 text-gray-500 border-2 border-dashed rounded-lg">
                        You currently do not own any projects.
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>