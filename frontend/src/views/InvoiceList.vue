<template>
  <v-container class="fill-height" fluid>
    <v-row align="center" justify="center">
      <v-col cols="12" sm="8" md="8">
        <v-card>
          <v-toolbar dark flat src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg">
            <v-toolbar-title>Invoice list</v-toolbar-title>
            <v-spacer></v-spacer>
            <add-invoice-modal v-on:add:item="added($event)"></add-invoice-modal>
          </v-toolbar>
          <v-card-title>
            <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details clearable></v-text-field>
          </v-card-title>
          <v-data-table :headers="headers" :items="items" :search="search">
            <template v-slot:item.actions="{ item }">
              <update-invoice-modal v-bind:item="item" v-on:update:item="updated($event, item)"></update-invoice-modal>
              <v-icon class="ml-2" medium color="red" @click="deleted(item)">mdi-trash-can-outline</v-icon>
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
      items: [],
      search: "",
      loading: true,
      headers: [
        { text: "Reference", align: "start", value: "reference" },
        { text: "Client", value: "client.name" },
        { text: "Sent", value: "is_sent" },
        { text: "Paid", value: "is_paid" },
        { text: "Actions", sortable: false, filerable: false, value: "actions" }
      ]
    }
  },
  mounted() {
    Invoice.all().then((response) => {
      this.items = response.data.data
      this.loading = false
    })
  },
  methods: {
    added(item) {
      this.items.push(item)
    },
    updated(item, oldItem) {
      let index = this.items.indexOf(oldItem)
      Object.assign(this.items[index], item)
    },
    deleted(item) {
      Invoice.delete(item.id)
        .then(() => {
          const index = this.items.indexOf(item)
          confirm("Are you sure you want to delete this item?") && this.items.splice(index, 1)
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
