<template>
<div class="wrapper">
<form autocomplete="off">
    Tên: <input v-model="readerDetail.tenbandoc" required><br>
    E-mail: <input type="email" v-model="readerDetail.email" placeholder="email@gmail.com" required><br>
    SĐT: <input v-model="readerDetail.sdt" required><br>
    <button @click="add()">Thêm</button>
    <button @click="back()">Hủy</button>
</form>
</div>
</template>

<script>
import axios from 'axios'
export default{
    name: 'NewReader',
    data(){
        return{
            readerDetail: {
                tenbandoc: "",
                email: "",
                sdt: "",
            }
        }
    },
    methods: {
        add(){
            let params = {
                "tenbandoc" : this.readerDetail.tenbandoc,
                "email" : this.readerDetail.email,
                "sdt" : this.readerDetail.sdt
            }
            axios.post('http://localhost:8000/api/newreader', params).then(response=>{
                if(response.data == true){
                    alert('Thêm mới thành công!')
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