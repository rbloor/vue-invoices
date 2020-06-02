<template>
  <v-dialog v-model="dialog" max-width="600px" persistent>
    <template v-slot:activator="{ on }">
      <v-btn icon v-on="on"><v-icon large>mdi-plus-circle</v-icon></v-btn>
    </template>
    <v-card>
      <v-form>
        <v-card-title class="pt-4 headline">Add invoice</v-card-title>
        <v-card-text>
          <small>* indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn @click="close" color="blue darken-1" text>Close</v-btn>
          <v-btn @click="submit" color="blue darken-1" text>Submit</v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </v-dialog>
</template>

<script>
import Invoice from "../apis/Invoice"
export default {
  name: "AddInvoiceModal",
  data() {
    return {
      form: {},
      dialog: false,
      errors: []
    }
  },
  methods: {
    submit() {
      Invoice.create(this.form)
        .then((data) => {
          this.$emit("add:item", data.data)
          this.close()
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors
          }
        })
    },
    close() {
      this.dialog = false
      this.errors = []
      this.form = {}
    }
  }
}
</script>
