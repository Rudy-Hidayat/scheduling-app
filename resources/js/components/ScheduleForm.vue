<template>
  <div class="container">
    <h2 class="mt-4">Pengajuan Jadwal</h2>
    <form @submit.prevent="submitForm" class="mt-3">
      <div class="form-group">
        <label>Nama:</label>
        <input type="text" v-model="formData.name" class="form-control" required />
      </div>
      <div class="form-group">
        <label>NPM:</label>
        <input type="text" v-model="formData.npm" class="form-control" required />
      </div>
      <div class="form-group">
        <label>Asal Instansi:</label>
        <input type="text" v-model="formData.asal_instansi" class="form-control" required />
      </div>
      <div class="form-group">
        <label>Nomor Whatsapp:</label>
        <input type="text" v-model="formData.nomor_whatsapp" class="form-control" required />
      </div>
      <div class="form-group">
        <label>Purpose:</label>
        <input type="text" v-model="formData.purpose" class="form-control" required />
      </div>
      <div class="form-group">
        <label>Date:</label>
        <input type="date" v-model="formData.date" class="form-control" required />
      </div>
      <div class="form-group">
        <label>Time:</label>
        <input type="time" v-model="formData.time" class="form-control" required />
      </div>
      <div class="form-group">
        <label>End Time:</label>
        <input type="time" v-model="formData.end_time" class="form-control" required />
      </div>
      <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
    <div v-if="errorMessage" class="alert alert-danger mt-3">{{ errorMessage }}</div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      formData: {
        name: '',
        npm: '',
        asal_instansi: '',
        nomor_whatsapp: '',
        purpose: '',
        date: '',
        time: '',
        end_time: ''
      },
      errorMessage: ''
    };
  },
  methods: {
    submitForm() {
      axios.post('/api/schedules', this.formData)
        .then(response => {
          alert('Schedule submitted successfully');
          this.resetForm();
        })
        .catch(error => {
          if (error.response && error.response.data.errors) {
            this.errorMessage = error.response.data.errors.time[0];
          }
        });
    },
    resetForm() {
      this.formData = {
        name: '',
        npm: '',
        asal_instansi: '',
        nomor_whatsapp: '',
        purpose: '',
        date: '',
        time: '',
        end_time: ''
      };
      this.errorMessage = '';
    }
  }
};
</script>

<style scoped>
/* Add your styles here */
</style>
