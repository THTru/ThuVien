<template>
    <div class="form">
        <div class="logo-glow">
            <img class="flip" src="..\assets\logo.png">
        </div>
        <!-- <div class="alert alert-danger" v-if="error">
            <p>There was an error, unable to sign in with those credentials.</p>
        </div> -->
        <form autocomplete="off" @submit.prevent="login" method="post">
            <div class="form-group">
                <label for="email" class ="title-input">E-mail</label>
                <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required>
            </div>
            <div class="form-group">
                <label for="password" class ="title-input">Password</label>
                <input type="password" id="password" class="form-control" v-model="password" required>
            </div>
            <!-- <button type="submit" class="btn btn-default">Sign in</button> -->
            <button type="submit" class="btn-custom">Sign in</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    name:'Login',
    data: function(){
        return{
            email: "",
            password: "",
        }
    },

    methods: {
        async login(){
            let params = {
                'email' : this.email,
                'password' : this.password
            }
            const res = await axios.post("http://localhost:8000/api/login", params)

            if(res.data == 0){
                alert("Sai email hoặc password!")
            } else{
                localStorage.setItem('access_token', res.data.access_token)
                this.$router.push({ name: 'Dashboard'}).catch(()=>{})
            }

            // axios.post("http://localhost:8000/api/login", params).then(response =>{
            //     console.log(response)
            // });
        }
    }
}
</script>

<style scoped>
</style>