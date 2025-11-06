<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3'; 
import {ref} from 'vue';

const props = defineProps({
    project: Object,
    users: Array,
    statuses: Object,
});

</script>
<template>
 <Head title="Project - {{ props.project.name }}" />
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


    </AuthenticatedLayout>

</template>