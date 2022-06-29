<template>
<div>
    <div class="style">
        Name: {{name}} <br>
        Email: {{email}}<br><br>
    </div>
    <br>
    <div class="container">
        <router-view/>
    </div>
</div>    
</template>
<script>
import axios from 'axios'
export default {
    data(){
        return{
            email: '',
            name: '',
        }
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
    },

    created(){
        const headers = {
            "Authorization": "Bearer " + localStorage.getItem("access_token")
        }

        axios.get('http://localhost:8000/api/testapi', { headers }).then(response =>{
            this.name = response.data.name
            this.email = response.data.email
        })
    },
}
</script>

<style>
.container{
    position: relative;
    width: fit-content;
    max-width: 100%;
    overflow-x: scroll;
    margin:auto;
}
</style>