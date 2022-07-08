<template>
    <div class="wrapper">
        <h1>Sách mượn nhiều</h1>
        <br>Top:
        <button @click="n=3">3</button><button  @click="n=5">5</button><button  @click="n=10">10</button>
        <table class="table">
            <thead>
                <tr>
                    <th>TOP</th>
                    <th>Tên sách</th>
                    <th>tến tác giả</th>
                    <th>Nhà xuất bản</th>
                    <th>Số lượt mượn</th>
                </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in list.slice(0,n)" :key="item.id">
            <td>{{ index+1 }}</td>
            <td>{{ item.sach.tensach }}</td>
            <td>{{ item.sach.tacgia.tentacgia }}</td>
            <td>{{ item.sach.nxb.tennxb }}</td>
            <td>{{ item.n }}</td>
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

button {
    width: 60px;
}
</style>

<script>
    import axios from 'axios'
    export default {
         name: 'TKBandoc',
        data() {
            return {
                list: [],
                n: 3,
            }
        },
         mounted() {
            axios.get("http://localhost:8000/api/topmuon").then(response1 => {
                console.log(response1);
                this.list = response1.data;
                function compare( a, b ) {
                    if ( a.n < b.n ){
                        return 1;
                    }
                    if ( a.n > b.n ){
                        return -1;
                    }
                    return 0;
                    }

                this.list.sort( compare );
            })
                .catch(error => {
                console.log(error)
            });
        },           
    }
</script>