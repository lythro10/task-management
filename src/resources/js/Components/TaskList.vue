<script setup>
import TaskEditForm from '@/Components/TaskEditForm.vue'; 

const props = defineProps({
    tasks: Array,
    users: Array,
    statuses: Object,
});


const deleteTask = (taskId) => {
    if (confirm('Are you sure you want to delete this task?')) {
     
        alert(`Task deletion for ID ${taskId} needs backend implementation.`);
    }
}
</script>

<template>
    <div class="space-y-4">
        <div v-for="task in tasks" :key="task.id" class="p-4 border rounded-lg bg-white shadow">
            
            <TaskEditForm
                v-if="editingTask && editingTask.id === task.id"
                :task="task"
                :users="users"
                :statuses="statuses"
                @editCanceled="editingTask = null"
                @taskUpdated="editingTask = null"
            />
            
            <div v-else class="flex justify-between items-start">
                <div class="flex-grow pr-4">
                    <p class="font-bold text-gray-800">{{ task.title }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ task.description }}</p>
                    <div class="text-xs text-gray-500 mt-2 space-y-1">
                        <p>Assigned to: <strong class="text-gray-700">{{ task.assignee.name }}</strong></p>
                        <p>Due: {{ task.due_date }}</p>
                    </div>
                </div>
                
                <div class="flex flex-col items-end space-y-2">
                    <div class="text-sm font-semibold p-1 rounded-full px-3 whitespace-nowrap"
                         :class="{
                            'bg-green-100 text-green-700': task.status === 'done',
                            'bg-yellow-100 text-yellow-700': task.status === 'in_progress',
                            'bg-red-100 text-red-700': task.status === 'pending',
                         }">
                        {{ task.status.toUpperCase().replace('_', ' ') }}
                    </div>
                    
                    <div class="flex space-x-2">
                        <button @click="editingTask = task" class="text-indigo-600 hover:text-indigo-800 text-sm">
                            Edit
                        </button>
                        <button @click="deleteTask(task.id)" class="text-red-600 hover:text-red-800 text-sm">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div v-if="tasks.length === 0" class="text-center p-8 text-gray-500 border-dashed border-2 rounded-lg mt-4">
        This project has no tasks yet.
    </div>
</template>