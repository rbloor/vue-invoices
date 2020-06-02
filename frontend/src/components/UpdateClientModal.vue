<template>
  <v-dialog v-model="dialog" max-width="600px" persistent>
    <template v-slot:activator="{ on }">
      <v-icon v-on="on" medium color="primary">mdi-pencil-outline</v-icon>
    </template>
    <v-card>
      <v-form>
        <v-card-title class="pt-4 headline">Update client</v-card-title>
        <v-card-text>
          <v-text-field v-model="item.name" label="Company *" :error-messages="errors.name"></v-text-field>
          <v-text-field v-model="item.contact_name" label="Name *" :error-messages="errors.contact_name"></v-text-field>
          <v-text-field v-model="item.contact_email" label="Email *" :error-messages="errors.contact_email"></v-text-field>
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
import Client from "../apis/Client"
export default {
  name: "UpdateClientModal",
  props: ["item"],
  data() {
    return {
      form: {
        name: "",
        contact_name: "",
        contact_email: ""
      },
      dialog: false,
      errors: []
    }
  },
  methods: {
    submit() {
      Client.update(this.item.id, this.item)
        .then((data) => {
          this.$emit("update:item", data.data)
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
    }
  }
}
</script>
