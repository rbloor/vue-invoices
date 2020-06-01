<template>
  <v-container class="fill-height" fluid>
    <v-row align="center" justify="center">
      <v-col cols="12" sm="8" md="8">
        <v-card>
          <v-toolbar dark flat src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg">
            <v-toolbar-title>Client list</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon>
              <v-icon medium>mdi-plus-circle</v-icon>
            </v-btn>
          </v-toolbar>
          <v-card-title>
            <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
          </v-card-title>
          <v-data-table :headers="headers" :items="items" :search="search" hide-default-footer>
            <template v-slot:item.actions="{ item }">
              <v-btn class="" tile outlined color="primary" small @click="editItem(item)"> <v-icon left>mdi-pencil-outline</v-icon> Edit </v-btn>
              <v-btn class="ml-2" tile outlined color="red" small @click="deleteItem(item)">
                <v-icon left>mdi-trash-can-outline</v-icon> Delete
              </v-btn>
            </template>
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import Client from "@/apis/Client"

export default {
  data() {
    return {
      loading: true,
      search: "",
      items: [],
      headers: [
        {
          text: "Name",
          align: "start",
          value: "name"
        },
        { text: "Contact name", value: "contact_name" },
        { text: "Contact email", value: "contact_email" },
        { text: "Actions", sortable: false, filerable: false, value: "actions" }
      ]
    }
  },
  created() {
    Client.all().then((response) => {
      this.items = response.data.data
      this.loading = false
    })
  }
}
</script>
