import Api from "./Api"
import Csrf from "./Csrf"

export default {
  all() {
    return Api.get("/invoice")
  },

  find(id) {
    return Api.get(`/invoice/${id}`)
  },

  async create(form) {
    await Csrf.getCookie()
    return Api.post("/invoice", form)
  },

  async update(id, form) {
    await Csrf.getCookie()
    return Api.patch(`/invoice/${id}`, form)
  },

  async delete(id) {
    await Csrf.getCookie()
    return Api.delete(`/invoice/${id}`)
  }
}
