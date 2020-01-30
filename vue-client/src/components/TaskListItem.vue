<template>
    <tr>
        <td>{{ task.id }}</td>
        <td>{{ task.title }}</td>
        <td>{{ task.description }}</td>
    </tr>
</template>

<script>
  export default {
    props: {
      task: {
        type: Object,
        required: true
      }
    }
  }
</script>

<style scoped>
    td {
        padding: 5px 7px;
        text-align: center;
        border: 1px solid #ccc;
    }
    td:nth-child(3) {
        text-align: left;
    }
</style>