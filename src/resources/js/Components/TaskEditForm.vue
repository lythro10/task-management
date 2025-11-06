<script setup>

const props = defineProps({
    task: Object,
    users: Array,
    statuses: Object,
});

const emit = defineEmits(['editCanceled', 'taskUpdated']);


</script>

<template>
    <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
        <p class="text-sm text-yellow-800">Task Edit Form for {{ props.task.title }}</p>
        <button @click="emit('editCanceled')" class="mt-2 text-indigo-600 text-sm">Cancel Edit</button>
    </div>
</template>