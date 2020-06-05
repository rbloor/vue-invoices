<template>
  <v-container>
    <v-row>
      <v-col>
        <v-toolbar dark flat src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg">
          <v-toolbar-title>Invoice Show</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn icon large :to="{ name: 'InvoiceList' }"><v-icon>mdi-arrow-left</v-icon></v-btn>
        </v-toolbar>
        <v-card class="pa-6">
          <v-row>
            <v-col>
              <v-img max-width="350" src="https://ryanbloor.co.uk/img/logo.png"></v-img>
            </v-col>
            <v-spacer></v-spacer>
            <v-col>
              <h1 class="primary--text text-right display-3">INVOICE</h1>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <h3 class="subtitle-1 primary--text pb-1">FROM</h3>
              <p>Name<br />Address<br />Town<br />City<br />County<br />Post Code</p>
              <h3 class="subtitle-1 primary--text pb-1">TO</h3>
              <p>{{ invoice.client.contact_name }}<br />{{ invoice.client.name }}</p>
            </v-col>
            <v-spacer></v-spacer>
            <v-col>
              <h3 class="subtitle-1 text-right"><span class="primary--text">INVOICE #</span> {{ invoice.reference }}</h3>
              <h3 class="subtitle-1 text-right"><span class="primary--text">DATE</span> 01/07/2020</h3>
            </v-col>
          </v-row>
          <v-simple-table class="mt-4 mb-4">
            <template v-slot:default>
              <thead>
                <tr>
                  <th class="text-left subtitle-1 primary--text">Quantity</th>
                  <th class="text-left subtitle-1 primary--text">Description</th>
                  <th class="text-left subtitle-1 primary--text">Price</th>
                  <th class="text-right subtitle-1 primary--text">Total</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in invoice.transactions" :key="item.id">
                  <td>{{ item.quantity }} {{ item.unit }}</td>
                  <td>{{ item.description }}</td>
                  <td>{{ item.unit_cost }}</td>
                  <td class="text-right">&pound;{{ (item.quantity * item.unit_cost).toFixed(2) }}</td>
                </tr>
                <tr>
                  <td colspan="1"></td>
                  <td colspan="2" class="font-weight-bold subtitle-1">Total</td>
                  <td class="subtitle-1 text-right font-weight-bold">&pound;{{ invoice.total }}</td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>

          <v-row>
            <v-col>
              <h3 class="subtitle-1 primary--text pb-1">PAYMENT DETAILS</h3>
              <p>Bank: <br />Name: <br />Account Number: <br />Sort Code:</p>
              <h4 class="mt-6">Payment is due within 30 days.</h4>
              <h4 class="mt-4">
                If you have any questions concerning this invoice, contact me on XXXXXXXXXXX | <a href="mailto:test@example.com">test@example.com</a>
              </h4>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import Invoice from "@/apis/Invoice"

export default {
  props: {
    id: {
      type: [Number, String],
      required: true
    }
  },
  data() {
    return {
      invoice: {
        reference: "",
        status: "",
        client: {},
        transactions: []
      }
    }
  },
  created() {
    Invoice.find(this.id).then((response) => {
      this.invoice = response.data.data
    })
  },
  methods: {}
}
</script>
