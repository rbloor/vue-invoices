<template>
  <v-dialog v-model="dialog" max-width="600px" persistent @input="open">
    <template v-slot:activator="{ on }">
      <v-btn small dark v-on="on" color="primary">Edit</v-btn>
    </template>
    <v-card>
      <v-form>
        <v-card-title class="pt-4 headline">Update client</v-card-title>
        <v-card-text>
          <v-text-field v-model="form.name" label="Company" :error-messages="errors.name"></v-text-field>
          <v-text-field v-model="form.contact_name" label="Name" :error-messages="errors.contact_name"></v-text-field>
          <v-text-field v-model="form.contact_email" label="Email" :error-messages="errors.contact_email"></v-text-field>
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
import Client from "../apis/Client"
export default {
  name: "UpdateClientModal",
  props: ["item"],
  data() {
    return {
      dialog: false,
      errors: [],
      form: {
        name: "",
        contact_name: "",
        contact_email: ""
      },
      default: {
        name: "",
        contact_name: "",
        contact_email: ""
      }
    }
  },
  methods: {
    open() {
      this.form = Object.assign({}, this.item)
    },
    close() {
      this.dialog = false
      this.errors = []
      this.form = Object.assign({}, this.default)
    },
    submit() {
      Client.update(this.form.id, this.form)
        .then(() => {
          this.$emit("update:item")
          this.close()
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
