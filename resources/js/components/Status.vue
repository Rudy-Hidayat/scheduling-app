<template>
  <div class="container">
    <h2 class="mt-4">Status Pengajuan</h2>
    <ul class="list-group mt-3">
      <li v-for="schedule in schedules" :key="schedule.id" class="list-group-item">
        {{ schedule.name }} - {{ schedule.status }}
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      schedules: []
    };
  },
  created() {
    axios.get('/api/schedules/status')
      .then(response => {
        this.schedules = response.data;
      });
  }
};
</script>

<style scoped>
/* Add your styles here */
</style>
