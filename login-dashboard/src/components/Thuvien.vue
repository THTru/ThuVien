<template>
    <div class="wrapper">
        <h1>Quản lý danh mục sách</h1>
        <button><router-link to="/dashboard/themsach">Thêm sách</router-link></button>
        <button><router-link to="/dashboard/tracuu">Tra cứu</router-link></button>
        <table class="table">
            <thead>
                <tr>
                    <th>Tên sách</th>
                    <th>Ngành</th>
                    <th>Lĩnh vực</th>
                    <th>Thể loại</th>
                    <th>Tác giả</th>
                    <th>NXB</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
            <tr v-for="item in sach" :key="item.id">
            <td>{{ item.tensach }}</td>
            <td>{{ item.tennganh }}</td>
            <td>{{ item.tenlinhvuc }}</td>
            <td>{{ item.tentheloai }}</td>
            <td>{{ item.tentacgia }}</td>
            <td>{{ item.tennxb }}</td>
            <td>{{ item.tentrangthai }}</td>
            <td><button @click="xoasach(item.id)">Xóa</button></td>
            <td><button><router-link :to="{name: 'SuaSach', query: { id: item.id }}" class="btn btn-primary">Sửa</router-link></button></td>
            </tr>
            </tbody>
            
        </table>
    </div>
</template>

<style scoped>
h1 {
    font-weight: bold;
    text-align: center;
    display: block;
    margin:auto;
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
         name: 'Thuvien',
        data() {
            return {
                sach: [

                ],
            }
        },
         mounted() {
            axios.get("http://localhost:8000/api/thuvienindex").then(response => {
                // console.log(response)
                this.sach = response.data
            })
                .catch(error => {
                console.log(error)
            });
        },
        methods:{
            async xoasach(index){
                // alert(index);
                if(confirm('Bạn có chắc muốn xóa danh mục này?')){
                    axios.post("http://localhost:8000/api/xoasach", {id: index}).then(response => {
                        // this.sach = response.data;
                        this.$router.go();
                    })
                }
            }
        }                
    }
</script>