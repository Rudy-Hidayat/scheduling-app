<template>
  <div class="container">
    <h2 class="mt-4">Jadwal Dekan</h2>
    <table class="table mt-3">
      <thead class="thead-dark">
        <tr>
          <th>Nama</th>
          <th>NPM</th>
          <th>Instansi</th>
          <th>WhatsApp</th>
          <th>Purpose</th>
          <th>Date</th>
          <th>Time</th>
          <th>End Time</th>
          <th>Status</th>
          <th>Notes</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="schedule in schedules" :key="schedule.id">
          <td>{{ schedule.name }}</td>
          <td>{{ schedule.npm }}</td>
          <td>{{ schedule.asal_instansi }}</td>
          <td>{{ schedule.nomor_whatsapp }}</td>
          <td>{{ schedule.purpose }}</td>
          <td>{{ schedule.date }}</td>
          <td>{{ schedule.time }}</td>
          <td>{{ schedule.end_time }}</td>
          <td>{{ schedule.status }}</td>
          <td>{{ schedule.notes }}</td>
        </tr>
      </tbody>
    </table>
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
    axios.get('/api/schedules')
      .then(response => {
        this.schedules = response.data;
      });
  }
};
</script>

<style scoped>
/* Add your styles here */
</style>
