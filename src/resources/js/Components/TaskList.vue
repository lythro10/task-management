<script setup>
import TaskEditForm from '@/Components/TaskEditForm.vue'; 
import { ref, computed } from 'vue'; // Imported for sorting logic
import { router } from '@inertiajs/vue3';


const props = defineProps({
    tasks: Array,
    users: Array,
    statuses: Object,
});

const editingTask = ref(null); 
const sortKey = ref('due_date'); 
const sortOrder = ref('asc');   

const sortedTasks = computed(() => {
    let sorted = [...props.tasks];

    sorted.sort((a, b) => {
        const aValue = a[sortKey.value] || ''; 
        const bValue = b[sortKey.value] || '';

        if (!aValue && !bValue) return 0;
        if (!aValue) return 1;
        if (!bValue) return -1;
        
        const aDate = new Date(aValue).getTime();
        const bDate = new Date(bValue).getTime();

        let comparison = aDate - bDate;

        return sortOrder.value === 'asc' ? comparison : comparison * -1;
    });

    return sorted;
});
// -------------------------------------


const deleteTask = (taskId) => {
    if (confirm('Are you sure you want to permanently delete this task?')) {
        router.delete(route('tasks.destroy', taskId), {
            preserveScroll: true, 
            onSuccess: () => {
            },
            onError: (errors) => {
                alert('Failed to delete task: ' + errors.error);
            }
        });
    }
}


const finishEdit = () => {
    editingTask.value = null; 

}
</script>

<template>
    <div class="space-y-4">
        
        <div class="flex items-center justify-end text-sm text-gray-500 mb-4">
             Sort by Due Date:
             <button @click="sortOrder = (sortOrder === 'asc' ? 'desc' : 'asc')" 
                     class="ml-2 px-2 py-1 bg-gray-100 rounded hover:bg-gray-200 transition">
                 {{ sortOrder === 'asc' ? 'Ascending (Oldest First) ↑' : 'Descending (Newest First) ↓' }}
             </button>
        </div>

        <div v-for="task in sortedTasks" :key="task.id" class="p-4 border rounded-lg bg-white shadow">
            
            <TaskEditForm
                v-if="editingTask && editingTask.id === task.id"
                :task="task"
                :users="props.users"
                :statuses="props.statuses"
                @editCanceled="editingTask = null"
                @taskUpdated="finishEdit"
            />
            
            <div v-else class="flex justify-between items-start">
                <div class="flex-grow pr-4">
                    <p class="font-bold text-gray-800">{{ task.title }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ task.description }}</p>
                    <div class="text-xs text-gray-500 mt-2 space-y-1">
                        <p>Assigned to: <strong class="text-gray-700">{{ task.assignee.name }}</strong></p>
                        
                        <p>Due: 
                            <strong class="text-gray-700">
                                {{ task.due_date 
                                    ? new Date(task.due_date).toLocaleDateString('en-GB', { 
                                        day: '2-digit', month: '2-digit', year: 'numeric' 
                                    })
                                    : 'N/A' 
                                }}
                            </strong>
                        </p>
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