import Api from "./Api"
import Csrf from "./Csrf"

export default {
  all() {
    return Api.get("/client")
  },

  find(id) {
    return Api.get(`/client/${id}`)
  },

  async create(form) {
    await Csrf.getCookie()
    return Api.post("/client/store", form)
  },

  async update(id, form) {
    await Csrf.getCookie()
    return Api.patch(`/client/${id}`, form)
  },

  async delete(id) {
    await Csrf.getCookie()
    return Api.delete(`/client/${id}`)
  }
}
