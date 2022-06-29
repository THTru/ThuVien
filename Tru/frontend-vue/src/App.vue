<template>
  <div id="app">
    <ul class="navi">
      <li class="navi"><router-link to="/">Home</router-link></li>
      <li class="navi" v-if="auth_status"><router-link to="/dashboard">Dashboard</router-link></li>
      <li class="navi" style="float:right" v-if="!auth_status"><router-link to="/register">Register</router-link></li>
      <li class="navi" style="float:right" v-if="!auth_status"><router-link to="/login">Login</router-link></li>
      <li class="navi" style="float:right" v-if="auth_status"><a @click="logout">Sign Out</a></li>
    </ul>
    <!-- <img src="./assets/logo.png"> -->
    <router-view/>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'App',
  data() {
    return{
      auth_status: false
    }
  },

  updated(){
    let headers = { "Authorization": "Bearer " + localStorage.getItem("access_token") }
    axios.get('http://localhost:8000/api/testapi', { headers }).then(response=>{  
      if(response.data != 0) this.auth_status = true
      else this.auth_status = false
    })
    // alert(this.auth_status)
  },

  methods:{
        async logout(){
            const headers = {
                "Authorization": "Bearer " + localStorage.getItem("access_token")
            }
            localStorage.setItem("access_token", 0)
            axios.get('http://localhost:8000/api/logout', { headers }).then(()=>{
                this.$router.push({ name: "Login" })
            })
        }
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  font-size: medium;
  /* margin-top: 60px; */
}

ul.navi {
  list-style-type: none;
  padding: 0;
  overflow: hidden;
  background-image: url('./assets/image.jpg');
}

li.navi {
  float: left;
  border-right:1px solid #bbb;
}

li.navi a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li.navi a:hover {
  /* background-color: rgb(194, 138, 240); */
  background-image: url('./assets/background.jpg');
  background-repeat: no-repeat;
  background-size: 100% 120%;
  text-shadow: 0 0 15px blue;
}

img.flip {
  animation: flipping 5s infinite linear;
}

@keyframes flipping {
  from {
    transform: rotateY(0deg);
  }
  to {
    transform: rotateY(180deg);
  }
}

.logo-glow {
    animation: glowing 10s infinite linear;
}

@keyframes glowing {
  from{
    -webkit-filter: drop-shadow(0 0 15px yellow);
  }
  33%{
    -webkit-filter: drop-shadow(0 0 15px blue);
  }
  66%{
    -webkit-filter: drop-shadow(0 0 15px red);
  }
  to{
    -webkit-filter: drop-shadow(0 0 15px yellow);
  }
}

html {
  background-image: url('./assets/image2.jpg');
  background-repeat: no-repeat;
  background-size: 100% 120%;
  background-attachment: fixed;
  height: 100%;
}

.form{ 
    background-color: rgb(200, 200, 255, 0.6);
    border-radius: 5%;
    margin: auto;
    margin-top: 5%;
    width: 480px;
    padding-top: 20px;
    padding-bottom: 50px;
    color: white;
    text-shadow: 0 0 20px blue;
}

.btn-custom {
    background-image: url('./assets/image.jpg');
    background-size: 100% 100%;
    height: 40px;
    width: 120px;
    color:antiquewhite;
    font-size: medium;
    text-shadow: 0 0 20px blue;
    margin: 5px;
    border: 0;
    font-weight: bold;
}

.btn-custom:hover {
    background-image: url('./assets/image2.jpg');
    box-shadow: 0px 0px 10px rgb(0, 0, 255, 0.6);
}

.title-input{
  display: inline-block;
  width: 80px
}

input:hover {
  box-shadow: 0 0 10px yellow;
}

.form-group {
  margin-bottom: 5px;
}

.style{
  background-color: rgb(200, 200, 255, 0.7);
  border-radius: 5% 5% 50% 50%;
  margin: auto;
  margin-top: 2%;
  width: 480px;
  padding: 20px 0 30px 0;
  font-size: large;
  color: white;
  text-shadow: 0 0 20px blue;
}

.wrapper{
  white-space: nowrap;
  margin: auto;
  background-color: white;
  padding: 5px 10px 20px 10px;
  width:fit-content;
}
</style>
