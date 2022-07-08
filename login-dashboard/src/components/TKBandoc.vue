<template>
    <div class="wrapper">
        <h1>Thống kê bạn đọc</h1>
        <br><button><router-link :to="{name: 'NewReader'}">Thêm mới</router-link></button>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên bạn đọc</th>
                    <th>E-mail</th>
                    <th>Số điện thoại</th>
                    <th>Số lần mượn</th>
                </tr>
            </thead>
            <tbody>
            <tr v-for="item in bandoc" :key="item.id">
            <td>{{ item.id }}</td>
            <td>{{ item.tenbandoc }}</td>
            <td>{{ item.email }}</td>
            <td>{{ item.sdt }}</td>
            <td>{{ demphieu(item.id) }}</td>
            <td v-if="demphieu(item.id)==0"></td>
            <td v-else><button><router-link :to="{path: '/dashboard/readerhistory/'+item.id}" class="btn btn-primary">Chi tiết</router-link></button></td>
            <td><button><router-link :to="{path: '/dashboard/editreader/'+item.id}" class="btn btn-primary">Sửa</router-link></button></td>
            <td><button class="btn btn-primary" @click="delreader(item.id)">Xóa</button></td>
            </tr>
            </tbody>
            
        </table>
    </div>
</template>

<style scoped>
h1 {
    font-weight: bold;
    text-align: center;
    display: inline-block;
    margin: auto;
    margin-top: 10px;
    margin-bottom: 50px;
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
         name: 'TKBandoc',
        data() {
            return {
                bandoc: [],
                phieumuon: [],
            }
        },
         mounted() {
            axios.get("http://localhost:8000/api/indexbandoc").then(response => {
                console.log(response);
                this.bandoc = response.data;
            })
                .catch(error => {
                console.log(error)
            });

            axios.get("http://localhost:8000/api/guiphieu").then(response1 => {
                console.log(response1);
                this.phieumuon = response1.data;
            })
                .catch(error => {
                console.log(error)
            });
        },
        methods:{
            demphieu(id){
                let n=0;
                this.phieumuon.forEach(countp);
                function countp(item){
                    if(item.id_bandoc==id) n++
                }
                return n
            },

            delreader(id){
                let params = { "id": id }
                if(confirm("Xóa bạn đọc sẽ xóa tất cả thông tin mượn sách của bạn đọc này. Có muốn tiếp tục?"))
                    axios.post('http://localhost:8000/api/deletereader', params).then(response=>{
                        if(response.data == true) {
                            alert("Xóa thành công")
                            axios.get("http://localhost:8000/api/indexbandoc").then(response => {
                                console.log(response);
                                this.bandoc = response.data;
                            })
                        }
                    })
            }
        }            
    }
</script>