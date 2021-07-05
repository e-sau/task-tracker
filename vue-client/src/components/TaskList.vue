<template>
    <div>
        <BaseInput
            v-model="taskId"
            placeholder="Task ID"
        />
        <button class="btn" @click="getTaskById">Get Task By ID</button>
        <button class="btn" @click="getTasks">Get All Tasks</button>
        <table v-if="tasks.length">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <TaskListItem
                    v-for="task in tasks"
                    :key="task.id"
                    :task="task"
                />
            </tbody>
        </table>
        <p v-else>
            Nothing left in the list.
        </p>
    </div>
</template>

<script>
  import BaseInput from './BaseInput.vue';
  import TaskListItem from './TaskListItem.vue';
  import axios from 'axios';

  export default {
    components: {
      BaseInput, TaskListItem,
    },
    data () {
      return {
        apiUrl: 'http://task-tracker/api/tasks',
        taskId: '',
        tasks: []
      }
    },
    methods: {
      getTasks () {
        axios
          .get(this.apiUrl)
          .then(response => this.tasks = response.data)
          .catch(error => {
            console.log(error);
            this.tasks = [];
          });
      },
      getTaskById () {
        axios
          .get(`${this.apiUrl}/${+this.taskId}`)
          .then(response => this.tasks = [response.data])
          .catch(error => {
            console.log(error);
            this.tasks = [];
          });
      }
    }
  }
</script>

<style scoped>
    table {
        margin-top: 10px;
        width: 100%;
        border-collapse: collapse;
    }
    th {
        padding: 5px 7px;
        border: 1px solid #ccc;
    }
    .btn {
        margin-left: 5px;
        padding: 9px 10px;
        color: #fff;
        border: none;
        background: #0a73bb;
        cursor: pointer;
    }
</style>