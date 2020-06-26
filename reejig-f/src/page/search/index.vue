<template>
  <div>
    <p v-if="error" class="error">
      {{ error }}
    </p>
    <div>
      <form action="">
        <input type="text" v-model="query">
        <button @click.prevent="onSearch" type="submit">
          Search
        </button>
        <button @click.prevent="onReset">Reset</button>
      </form>
    </div>
    <table>
      <thead>
        <tr>
          <th @click="doOrder('firstname')">
            <sort 
              title="First Name"
              v-bind:orderBy="order.firstname" />
          </th>
          <th @click="doOrder('lastname')">
            <sort 
              title="Last Name"
              v-bind:orderBy="order.lastname" />
          </th>
          <th @click="doOrder('current_job_title')">
            <sort 
              title = "Current Job Title"
              v-bind:orderBy="order.current_job_title" />
          </th>
          <th @click="doOrder('current_company')">
            <sort 
              title = "Current Company"
              v-bind:orderBy="order.current_company" />
          </th>
          <th @click="doOrder('gender')">
            <sort 
              title="Gender"
              v-bind:orderBy="order.gender" />
          </th>
          <th @click="doOrder('city')">
            <sort 
              title="City"
              v-bind:orderBy="order.city" />
          </th>
        </tr>
        <tr v-for="(contact, i) in contacts" v-bind:key="i">
          <td>{{ contact.firstname }}</td>
          <td>{{ contact.lastname }}</td>
          <td>{{ contact.current_job_title }}</td>
          <td>{{ contact.current_company }}</td>
          <td>{{ contact.gender }}</td>
          <td>{{ contact.city }}</td>
        </tr>
      </thead>
    </table>
  </div>
</template>

<script>
  import axios from 'axios';
  import Sort from '../../components/Sort';
  export default {
    data: function(){
      return {
        query: '',
        contacts: [],
        error: '',
        order: {
          firstname: 1,
          lastname: 1,
          current_job_title: 1,
          current_company: 1,
          gender: 1,
          city: 1,
        }
      }
    },
    components: {
      Sort,
    },
    created(){
      this.onSearch();
    },
    methods: {
      onSearch(){
        axios.get(`http://127.0.0.1:8000/api/contacts/search/${this.query}`)
          .then(response => {
            this.contacts = response.data;
            this.error = '';
          })
          .catch(e => {
            this.error = e;
            this.contacts = [];
          })
      },
      onReset(){
        this.query = '';
        this.onSearch();
      },
      doOrder(order){
        this.order[order] *= -1;
        let contacts = JSON.parse(JSON.stringify(this.contacts));
        contacts = Object.values(contacts);
        contacts.sort((a,b) => (
          this.order[order] * a[order].localeCompare(b[order])
        ));
        this.contacts = contacts;
      }
    }
  }
</script>

<style scoped>
  .error {
    font-weight: bold;
    color: red;
  }
</style>