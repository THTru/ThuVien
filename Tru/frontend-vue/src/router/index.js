import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import NotFound from '@/components/NotFound'
import Login from '@/components/Login'
import Register from '@/components/Register'
import Dashboard from '@/components/Dashboard'
import Gallery from '@/components/Gallery'
import BorrowBook from '@/components/BorrowBook'
import BookHistory from '@/components/BookHistory'
import ReaderHistory from '@/components/ReaderHistory'
import BorrowDetail from '@/components/BorrowDetail'
import ListBorrowForm from '@/components/ListBorrowForm'
import BorrowForm from '@/components/BorrowForm'
import EditDetail from '@/components/EditDetail'
import EditForm from '@/components/EditForm'
import BorrowReport from '@/components/BorrowReport'
import axios from 'axios'

Vue.use(Router)

export default new Router({
  // mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home,
    },

    {
      path: '/login',
      name: 'Login',
      component: Login,
      beforeEnter: (to, from, next) =>{
        let headers = { "Authorization": "Bearer " + localStorage.getItem("access_token") }
        axios.get('http://localhost:8000/api/testapi', { headers }).then(response=>{ 
          if(response.data != 0) next({ name: 'Dashboard' })
          else next()
        }).catch(()=>{})
      }
    },

    {
      path: '/register',
      name: 'Register',
      component: Register,
      beforeEnter: (to, from, next) =>{
        let headers = { "Authorization": "Bearer " + localStorage.getItem("access_token") }
        axios.get('http://localhost:8000/api/testapi', { headers }).then(response=>{ 
          if(response.data != 0) next({ name: 'Dashboard' })
          else next()
        }).catch(()=>{})
      }
    },

    {
      path: '/dashboard',
      name: 'Dashboard',
      component: Dashboard,
      beforeEnter: (to, from, next) =>{
        let headers = { "Authorization": "Bearer " + localStorage.getItem("access_token") }
        axios.get('http://localhost:8000/api/testapi', { headers }).then(response=>{
          // console.log(response)
          if(response.data != 0) next()
          else next({ name: 'Login' })
        }).catch(()=>{
            // return next({ name: 'Home'})
        })
      },
      children: [
        {
          path: 'gallery',
          name: 'Gallery',
          component: Gallery
        },

        {
          path: 'borrowbook',
          name: 'BorrowBook',
          component: BorrowBook
        },

        {
          path: 'bookhistory/:id',
          name: 'BookHistory',
          component: BookHistory
        },

        {
          path: 'readerhistory/:id',
          name: 'ReaderHistory',
          component: ReaderHistory
        },

        {
          path: 'borrowdetail',
          name: 'BorrowDetail',
          component: BorrowDetail
        },

        {
          path: 'listborrowform',
          name: 'ListBorrowForm',
          component: ListBorrowForm
        },

        {
          path: 'borrowform/:id',
          name: 'BorrowForm',
          component: BorrowForm
        },

        {
          path: 'editdetail/:id',
          name: 'EditDetail',
          component: EditDetail
        },

        {
          path: 'editform/:id',
          name: 'EditForm',
          component: EditForm
        },

        {
          path: 'borrowreport',
          name: 'BorrowReport',
          component: BorrowReport
        }
      ]
    },

    {
      path: '*',
      name: 'NotFound',
      component: NotFound
    }
  ]
})
