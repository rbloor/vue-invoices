import Vue from "vue"
import VueRouter from "vue-router"

import Home from "../views/Home.vue"
import Login from "../views/Login.vue"
import Register from "../views/Register.vue"
import Dashboard from "../views/Dashboard.vue"

import ClientList from "../views/ClientList.vue"
import InvoiceList from "../views/InvoiceList.vue"
import InvoiceShow from "../views/InvoiceShow.vue"

Vue.use(VueRouter)

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home
  },
  {
    path: "/login",
    name: "Login",
    component: Login,
    meta: { guestOnly: true }
  },
  {
    path: "/register",
    name: "Register",
    component: Register,
    meta: { guestOnly: true }
  },
  {
    path: "/dashboard",
    name: "Dashboard",
    component: Dashboard,
    meta: { authOnly: true }
  },
  {
    path: "/clients",
    name: "ClientList",
    component: ClientList,
    meta: { authOnly: true }
  },
  {
    path: "/invoices",
    name: "InvoiceList",
    component: InvoiceList,
    meta: { authOnly: true }
  },
  {
    path: "/invoices/:id",
    name: "InvoiceShow",
    component: InvoiceShow,
    meta: { authOnly: true },
    props: true
  }
]

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes
})

function isLoggedIn() {
  return localStorage.getItem("auth")
}

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.authOnly)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (!isLoggedIn()) {
      next({
        path: "/login",
        query: { redirect: to.fullPath }
      })
    } else {
      next()
    }
  } else if (to.matched.some((record) => record.meta.guestOnly)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (isLoggedIn()) {
      next({
        path: "/dashboard",
        query: { redirect: to.fullPath }
      })
    } else {
      next()
    }
  } else {
    next() // make sure to always call next()!
  }
})

export default router
