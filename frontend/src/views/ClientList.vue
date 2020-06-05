<template>
  <v-container>
    <v-row>
      <v-col>
        <v-card>
          <v-toolbar dark flat src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg">
            <v-toolbar-title>Client list</v-toolbar-title>
            <v-spacer></v-spacer>
            <add-client-modal v-on:add:item="added"></add-client-modal>
          </v-toolbar>
          <v-card-title>
            <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details clearable></v-text-field>
          </v-card-title>
          <v-data-table :headers="headers" :items="items" :search="search">
            <template v-slot:item.actions="{ item }">
              <update-client-modal v-bind:item="item" v-on:update:item="updated"></update-client-modal>
            </template>
            <template v-slot:item.actions="{ item }">
              <update-client-modal v-bind:item="item" v-on:update:item="updated"></update-client-modal>
              <v-btn class="ml-2" small dark color="red" @click="deleted(item)">Delete</v-btn>
            </template>
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import Client from "@/apis/Client"
import AddClientModal from "@/components/AddClientModal"
import UpdateClientModal from "@/components/UpdateClientModal"

export default {
  components: {
    AddClientModal,
    UpdateClientModal
  },
  data() {
    return {
      dialog: false,
      items: [],
      search: "",
      headers: [
        { text: "Name", align: "start", value: "name" },
        { text: "Contact name", value: "contact_name" },
        { text: "Contact email", value: "contact_email" },
        { text: "Actions", sortable: false, filerable: false, value: "actions" }
      ]
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    init() {
      Client.all().then((response) => {
        this.items = response.data.data
      })
    },
    added() {
      this.init()
    },
    updated() {
      this.init()
    },
    deleted(item) {
      confirm("Are you sure you want to delete this item?") &&
        Client.delete(item.id)
          .then(() => {
            this.init()
          })
          .catch((error) => {
            if (error.response.status === 422) {
              this.errors = error.response.data.errors
            }
          })
    }
  }
}
</script>
