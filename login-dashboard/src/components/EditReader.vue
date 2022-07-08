<template>
<div class="wrapper">
<form>
    ID: <input v-model="readerDetail.id" readonly="true"><br>
    Tên: <input v-model="readerDetail.tenbandoc" required><br>
    E-mail: <input type="email" v-model="readerDetail.email" required><br>
    SĐT: <input v-model="readerDetail.sdt" required><br>
    <button @click="edit()">Sửa</button>
    <button @click="back()">Hủy</button>
</form>
</div>
</template>

<script>
import axios from 'axios'
export default{
    name: 'EditReader',
    data(){
        return{
            readerDetail: {
                id: "",
                tenbandoc: "",
                email: "",
                sdt: "",
            }
        }
    },

    mounted(){
        let params = { "id" : this.$route.params.id }
        axios.post('http://localhost:8000/api/readerbyid', params).then(response=>{
            this.readerDetail=response.data
        })
    },

    methods: {
        edit(){
            let params = {
                "id" : this.$route.params.id,
                "tenbandoc" : this.readerDetail.tenbandoc,
                "email" : this.readerDetail.email,
                "sdt" : this.readerDetail.sdt
            }
            axios.post('http://localhost:8000/api/editreader', params).then(response=>{
                if(response.data == true){
                    alert('Sửa thông tin bạn đọc thành công!')
                    this.$router.push({ name: 'TKBandoc' })
                }
                else alert(response.data)
            })
        },

        back(){
            this.$router.push({ name: 'TKBandoc' })
        }
    }
}
</script>

<style scoped>
</style>