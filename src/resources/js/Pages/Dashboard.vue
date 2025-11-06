<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3'; 

// Define the 'projects' prop to receive data from the ProjectController
const props = defineProps({
    projects: Array,
});

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
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                
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
                                    <span class="text-green-600 mr-2">✅</span> 
                                    Done: <strong class="ml-1">{{ project.summary.done }}</strong>
                                </p>
                                <p class="flex items-center">
                                    <span class="text-yellow-500 mr-2">🚧</span> 
                                    In Progress: <strong class="ml-1">{{ project.summary.in_progress }}</strong>
                                </p>
                                <p class="flex items-center">
                                    <span class="text-red-500 mr-2">⏳</span> 
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