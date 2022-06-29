<template>
    <div class="form">
        <div class="logo-glow">
            <img class="flip" src="..\assets\logo.png">
        </div>
        <!-- <div class="alert alert-danger" v-if="error && !success">
            <p>There was an error, unable to complete registration.</p>
        </div>
        <div class="alert alert-success" v-if="success">
            <p>Registration completed. You can now <router-link :to="{name:'login'}">sign in.</router-link></p>
        </div> -->
        <form autocomplete="off" @submit.prevent="register" method="post">
            <div class="form-group">
                <label for="name" class ="title-input">Name</label>
                <input type="text" id="name" class="form-control" v-model="name" required>
                <!-- <span class="help-block" v-if="errors.name">{{ errors.name[0] }}</span> -->
            </div>
            <div class="form-group">
                <label for="email" class ="title-input">E-mail</label>
                <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required>
                <!-- <span class="help-block" v-if="errors.email">{{ errors.email[0] }}</span> -->
            </div>
            <div class="form-group">
                <label for="password" class ="title-input">Password</label>
                <input type="password" id="password" class="form-control" v-model="password" required>
                <!-- <span class="help-block" v-if="errors.password">{{ errors.password[0] }}</span> -->
            </div>
            <button type="submit" class="btn-custom">Submit</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    name: 'Register',
    data: function(){
        return{
            email: "",
            password: "",
            name: "",
        }
    },

    methods: {
        async register(){
            let params = {
                'email' : this.email,
                'password' : this.password,
                'name' : this.name
            }
            const res = await axios.post("http://localhost:8000/api/register", params)
            
            switch (res.data) {
                case 1:
                    alert("Tạo tài khoản thành công");
                    break;
                default:
                    alert("Email đã được sử dụng! vui lòng sử dụng email khác!");
            }
        }
    }
}
</script>

<style scoped>
</style>
