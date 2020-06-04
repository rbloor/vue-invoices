<template>
  <v-container class="fill-height" fluid>
    <v-row align="center" justify="center">
      <v-col cols="12" sm="8" md="8">
        <v-card>
          <v-toolbar dark flat src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg">
            <v-toolbar-title>Invoice list</v-toolbar-title>
            <v-spacer></v-spacer>
            <add-invoice-modal v-on:add:item="added"></add-invoice-modal>
          </v-toolbar>
          <v-card-title>
            <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details clearable></v-text-field>
          </v-card-title>
          <v-data-table :headers="headers" :items="items" :search="search">
            <template v-slot:item.actions="{ item }">
              <update-invoice-modal v-bind:item="item" v-on:update:item="updated"></update-invoice-modal>
              <v-btn class="ml-2" icon><v-icon medium color="red" @click="deleted(item)">mdi-trash-can-outline</v-icon></v-btn>
            </template>
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import Invoice from "@/apis/Invoice"
import AddInvoiceModal from "@/components/AddInvoiceModal"
import UpdateInvoiceModal from "@/components/UpdateInvoiceModal"

export default {
  components: {
    AddInvoiceModal,
    UpdateInvoiceModal
  },
  data() {
    return {
      dialog: false,
      items: [],
      search: "",
      headers: [
        { text: "Reference", align: "start", value: "reference" },
        { text: "Client", value: "client.name" },
        { text: "Status", value: "status" },
        { text: "Total", value: "total" },
        { text: "Actions", sortable: false, filerable: false, value: "actions" }
      ]
    }
  },
  created() {
    this.init()
  },
  methods: {
    init() {
      Invoice.all().then((response) => {
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
        Invoice.delete(item.id)
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
