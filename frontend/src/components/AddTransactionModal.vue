<template>
  <v-dialog v-model="dialog" max-width="600px" persistent @input="open">
    <template v-slot:activator="{ on }">
      <v-btn fab small v-on="on" color="primary"><v-icon>mdi-plus</v-icon></v-btn>
    </template>
    <v-card>
      <v-form>
        <v-card-title class="pt-4 headline">Add transaction</v-card-title>
        <v-card-text>
          <v-text-field v-model="form.quantity" type="number" label="Quantity"></v-text-field>
          <v-combobox v-model="form.unit" :items="['hour', 'day', 'service', 'project']" label="Unit" clearable></v-combobox>
          <v-text-field v-model="form.description" label="Description"></v-text-field>
          <v-text-field v-model="form.unit_cost" prefix="£" type="number" label="Rate"></v-text-field>
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
export default {
  name: "AddTransactionModal",
  data() {
    return {
      dialog: false,
      errors: [],
      form: {
        quantity: "",
        unit: "",
        description: "",
        unit_cost: ""
      },
      default: {
        quantity: "",
        unit: "",
        description: "",
        unit_cost: ""
      }
    }
  },
  methods: {
    open() {},
    close() {
      this.dialog = false
      this.errors = []
      this.form = Object.assign({}, this.default)
    },
    submit() {
      this.$emit("add:item", this.form)
      this.close()
    }
  }
}
</script>
