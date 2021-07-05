<template>
    <div id="app">
        <TaskList/>
    </div>
</template>

<script>
  import TaskList from './components/TaskList.vue'

  export default {
    components: {
      TaskList
    }
  }
</script>

<style>
    #app {
        max-width: 400px;
        margin: 0 auto;
        line-height: 1.4;
        font-family: Cambria, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

</style>