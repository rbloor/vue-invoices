<template>
  <v-dialog v-model="dialog" max-width="800px" persistent @input="open()">
    <template v-slot:activator="{ on }">
      <v-btn small dark v-on="on" color="primary">Edit</v-btn>
    </template>
    <v-card>
      <v-form>
        <v-card-title class="pt-4 headline">Update invoice</v-card-title>
        <v-card-text>
          <v-text-field v-model="form.reference" label="Reference (Generated)" disabled></v-text-field>
          <v-select
            v-model="form.client_id"
            :items="clients"
            item-text="name"
            item-value="id"
            label="Client"
            :error-messages="errors.client_id"
            disabled
          ></v-select>
          <v-combobox v-model="form.status" :items="['draft', 'sent', 'paid', 'overdue']" label="Status"></v-combobox>
          <v-data-table :headers="headers" :items="form.transactions" hide-default-footer calculate-widths disable-sort>
            <template v-slot:top>
              <v-toolbar flat>
                <v-toolbar-title>Transactions</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <add-transaction-modal v-on:add:item="transactionAdded($event)"></add-transaction-modal>
              </v-toolbar>
            </template>
            <template v-slot:item.total="{ item }">
              {{ Number(item.unit_cost * item.quantity).toFixed(2) }}
            </template>
            <template v-slot:item.actions="{ item }">
              <update-transaction-modal :item="item" v-on:update:item="transactionUpdated($event, item)"></update-transaction-modal>
              <v-btn class="ml-2 red" fab x-small dark><v-icon @click="transactionDeleted(item)">mdi-trash-can-outline</v-icon></v-btn>
            </template>
          </v-data-table>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn text color="primary" @click="close">Close</v-btn>
          <v-btn text color="primary" @click="submit">Save</v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </v-dialog>
</template>

<script>
import Invoice from "../apis/Invoice"
import Client from "../apis/Client"
import AddTransactionModal from "@/components/AddTransactionModal"
import UpdateTransactionModal from "@/components/UpdateTransactionModal"
export default {
  name: "UpdateInvoiceModal",
  props: ["item"],
  components: {
    AddTransactionModal,
    UpdateTransactionModal
  },
  data() {
    return {
      dialog: false,
      errors: [],
      form: {
        reference: "",
        status: "draft",
        client_id: "",
        transactions: []
      },
      default: {
        reference: "",
        status: "draft",
        client_id: "",
        transactions: []
      },
      headers: [
        { text: "Quantity", align: "start", value: "quantity" },
        { text: "Unit", value: "unit" },
        { text: "Description", value: "description" },
        { text: "Cost", value: "unit_cost" },
        { text: "Total", value: "total" },
        { text: "Actions", value: "actions" }
      ],
      clients: []
    }
  },
  methods: {
    open() {
      Client.all().then((response) => {
        this.clients = response.data.data
      })
      this.form = Object.assign({}, this.item)
      this.form.client_id = this.item.client.id
    },
    close() {
      this.dialog = false
      this.errors = []
      this.form = Object.assign({}, this.default)
    },
    submit() {
      Invoice.update(this.form.id, this.form)
        .then((response) => {
          this.$emit("update:item", response.data.data)
          this.close()
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors
          }
        })
    },
    transactionAdded(transaction) {
      this.form.transactions.push(transaction)
      this.$emit("update:item")
    },
    transactionUpdated(transaction, oldTransaction) {
      let index = this.form.transactions.indexOf(oldTransaction)
      Object.assign(this.form.transactions[index], transaction)
      this.$emit("update:item")
    },
    transactionDeleted(transaction) {
      const index = this.form.transactions.indexOf(transaction)
      this.form.transactions.splice(index, 1)
    }
  }
}
</script>
