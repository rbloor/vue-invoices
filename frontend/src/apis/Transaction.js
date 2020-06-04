import Api from "./Api"
import Csrf from "./Csrf"

export default {
  all() {
    return Api.get("/transaction")
  },

  find(id) {
    return Api.get(`/transaction/${id}`)
  },

  async create(form) {
    await Csrf.getCookie()
    return Api.post("/transaction", form)
  },

  async update(id, form) {
    await Csrf.getCookie()
    return Api.patch(`/transaction/${id}`, form)
  },

  async delete(id) {
    await Csrf.getCookie()
    return Api.delete(`/transaction/${id}`)
  }
}
