<template>
    <div class="wrapper">
        <div><button class="back" @click="back">Back</button></div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID phiếu</th>
                    <th>ID sách</th>
                    <th>Tên sách</th>
                    <th>Ngày mượn</th>
                    <th>Ngày hẹn trả</th>
                    <th>Ngày trả</th>
                    <th>Trạng thái trả</th>
                </tr>
            </thead>
            <tbody>
            <tr v-for="item in chitiet" :key="item.id">
            <td>{{ item.id_phieumuon }}</td>
            <td>{{ item.sach.id }}</td>
            <td>{{ item.sach.tensach }}</td>
            <td>{{ item.phieumuon.ngaymuon }}</td>
            <td>{{ item.phieumuon.ngayhentra }}</td>
            <td>{{ item.ngaytra }}</td>
            <td>{{ item.trangthaitra }}</td>
            </tr>
            </tbody>
            
        </table>
    </div>
</template>

<style scoped>
h1 {
    font-weight: bold;
    color: red;
    text-align: center;
    display: inline-block;
    margin-top: 10px;
    margin-bottom: 100px;
    margin-right: 550px;
    margin-left: 550px;
}

th{
    color: red;
}

td{
    color: red;
}

table, td, th {  
  border: 1px solid #00ff00;
  text-align: left;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
  padding: 15px;
}
</style>

<script>
    import axios from 'axios'
    export default {
         name: 'Chitietbandoc',
        data() {
            return {
                chitiet: [],
            }
        },
         mounted() {
            axios.post("http://localhost:8000/api/chitietbandoc", {id: this.$route.query.id}).then(response1 => {
                console.log(response1);
                this.chitiet = response1.data;
            })
                .catch(error => {
                console.log(error)
            });
        },
        methods:{
            async back(){
                this.$router.push({name: "TKBandoc"});
                return;
            },
        }               
    }
</script>