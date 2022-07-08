<template>
<div class="wrapper">
    <div>Danh sách bạn đọc</div>
    <div class="list-cell label ssize sortable" @click="sortidnguoimuon()">ID</div>
    <div class="list-cell label xlsize sortable" @click="sortnguoimuon()">Bạn đọc</div>
    <div class="list-cell label xlsize sortable" @click="sortemail()">E-mail</div>
    <div class="list-cell label ssize">Edit</div>
    <div v-for="item in listReader">
        <div class="list-cell ssize">{{ item.id }}</div>
        <div class="list-cell xlsize clickable" @click="toreaderhistory(item.id)">{{ item.tenbandoc }}</div>
        <div class="list-cell xlsize">{{ item.email }}</div>
        <div class="list-cell ssize clickable" @click="toeditreader(item.id)">✍️</div>
    </div>
</div>
</template>

<script>
import axios from 'axios'
export default {
    name: 'ListReader',
    data(){
        return{
            listReader: [],
            sidnguoimuon:true, snguoimuon:true, semail:true
        }
    },

    mounted(){
        axios.get('http://localhost:8000/api/getreader').then(response=>{
            this.listReader = response.data
        })
    },

    methods: {
        sortidnguoimuon(){
            function comp(a, b){
                let x = a.id; let y = b.id
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.listReader.sort(comp);
            if(this.sidnguoimuon)
                this.listReader.reverse()
            this.sidnguoimuon = !this.sidnguoimuon
        },

        sortnguoimuon(){
            function comp(a, b){
                let x = a.tenbandoc; let y = b.tenbandoc
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.listReader.sort(comp);
            if(this.snguoimuon)
                this.listReader.reverse()
            this.snguoimuon = !this.snguoimuon
        },

        sortemail(){
            function comp(a, b){
                let x = a.email; let y = b.email
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.listReader.sort(comp);
            if(this.semail)
                this.listReader.reverse()
            this.semail = !this.semail
        },

        toreaderhistory(id){
            this.$router.push({ path: '/dashboard/readerhistory/'+id })
        },

        toeditreader(id){
            alert(id)
        }
    }
}
</script>

<style scoped>
div.list-cell{
    padding: 10px;
    display: inline-block;
    margin-bottom: 5px;
    background-color: white;
    border: solid 1px grey;
    white-space: initial;
}

div.label{
    color:white;
    background-color:cadetblue;
    margin-bottom: 15px;
}

div.sortable:hover{
    background-color: lightskyblue;
    cursor:pointer;
}

.ssize{
    width: 65px;
}

.msize{
    width: 140px;
}

.lsize{
    width: 200px;
}

.xlsize{
    width: 350px;
}

.wrapper{
    white-space:nowrap;
}

.clickable:hover {
    color: orange;
    box-shadow: 0 0 15px yellow;
    border: 1px solid orange;
}
</style>