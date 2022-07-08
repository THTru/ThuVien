<template>
<div class="wrapper" v-if="readerDetail.id!=0">
    <h1>
        ID bạn đọc: {{ readerDetail.id }} - {{ readerDetail.tenbandoc }}
    </h1>
    <div class="list-cell label  sortable" @click="sortphieumuon()">Phiếu mượn</div>
    <div class="list-cell label sortable" @click="sortidsach()">ID sách</div>
    <div class="list-cell lsize label sortable" @click="sortsach()">Tên sách</div>
    <div class="list-cell label sortable" @click="sortngaymuon()">Ngày mượn</div>
    <div class="list-cell label sortable"  @click="sortngayhen()">Ngày hẹn trả</div>
    <div class="list-cell label sortable" @click="sortngaytra()">Ngày trả</div>
    <div class="list-cell lsize label">Trạng thái trả</div>
    
    <div v-for="item in readerHistory" v-bind:class="{expired: checkdate(item.phieumuon.ngayhentra, item.ngaytra)}">
        <div class="list-cell clickable" @click="toform(item.phieumuon.id)">{{ item.phieumuon.id }}</div>
        <div class="list-cell clickable" @click="tobookhistory(item.sach.id)">{{ item.sach.id }}</div>
        <div class="list-cell lsize clickable" @click="tobookhistory(item.sach.id)">{{ item.sach.tensach }}</div>
        <div class="list-cell">{{ dmy(item.phieumuon.ngaymuon) }}</div>
        <div class="list-cell">{{ dmy(item.phieumuon.ngayhentra) }}</div>
        <div class="list-cell" v-if="item.ngaytra=='1900-01-01'">_</div>
        <div class="list-cell" v-else>{{ dmy(item.ngaytra) }}</div>
        <div class="list-cell lsize">{{ item.trangthaitra }}</div>
        <span class="alert" v-if="checkdate(item.phieumuon.ngayhentra, item.ngaytra)">Trễ hẹn!</span>
    </div>
</div>
</template>

<script>
import axios from 'axios'
export default {
    name: 'ReaderHistory',
    data(){
        return{
            readerDetail: { 'id':0, 'tenbandoc':'Không' },
            readerHistory : [],
            sphieumuon: true, sidsach:true, ssach:true,
            sngaymuon:true, sngayhen:true, sngaytra:true,
        }
    },

    created(){
        console.log(this.$route)
    },

    mounted(){
        let params = {
            'id' : this.$route.params.id
        }
        axios.post('http://localhost:8000/api/readerhistory', params)
        .then(response => {
            console.log(response)
            if(response.data.length>0){
                this.readerHistory = response.data
                this.readerDetail.id = this.readerHistory[0].phieumuon.bandoc.id
                this.readerDetail.tenbandoc = this.readerHistory[0].phieumuon.bandoc.tenbandoc

                function compDate(a, b){
                    let date1 = new Date(a.phieumuon.ngaymuon)
                    let date2 = new Date(b.phieumuon.ngaymuon)
                    if (date1 > date2) return -1
                    if (date1 < date2) return 1
                    return 0
                }
                this.readerHistory.sort(compDate)
            }
        })
    },

    methods: {
        toform(id){
            this.$router.push({ path: '/dashboard/borrowform/'+id })
        },

        tobookhistory(id){
            this.$router.push({ path: '/dashboard/bookhistory/'+id })
        },

        checkdate(ngayhen, ngaytra){
            if(ngaytra != '1900-01-01') return false
            else{
                const hen = new Date(ngayhen)
                const now = new Date()
                const today = new Date(now.getFullYear()+'-'+(now.getMonth()+1)+'-'+now.getDate())
                if(today>hen) return true
                else return false
            }
        },

        sortphieumuon(){
            function compForm(a, b){
                let x = a.phieumuon.id; let y = b.phieumuon.id
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.readerHistory.sort(compForm);
            if(this.sphieumuon)
                this.readerHistory.reverse()
            this.sphieumuon = !this.sphieumuon
        },

        sortidsach(){
            function comp(a, b){
                let x = a.sach.id; let y = b.sach.id
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.readerHistory.sort(comp);
            if(this.sidsach)
                this.readerHistory.reverse()
            this.sidsach = !this.sidsach
        },

        sortsach(){
            function comp(a, b){
                let x = a.sach.tensach; let y = b.sach.tensach
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.readerHistory.sort(comp);
            if(this.ssach)
                this.readerHistory.reverse()
            this.ssach = !this.ssach
        },

        sortngaymuon(){
            function comp(a, b){
                let x = new Date(a.phieumuon.ngaymuon); let y = new Date(b.phieumuon.ngaymuon)
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.readerHistory.sort(comp);
            if(this.sngaymuon)
                this.readerHistory.reverse()
            this.sngaymuon = !this.sngaymuon
        },

        sortngayhen(){
            function comp(a, b){
                let x = new Date(a.phieumuon.ngayhentra); let y = new Date(b.phieumuon.ngayhentra)
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.readerHistory.sort(comp);
            if(this.sngayhen)
                this.readerHistory.reverse()
            this.sngayhen = !this.sngayhen
        },

        sortngaytra(){
            function comp(a, b){
                let x = new Date(a.ngaytra); let y = new Date(b.ngaytra)
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.readerHistory.sort(comp);
            if(this.sngaytra)
                this.readerHistory.reverse()
            this.sngaytra = !this.sngaytra
        },

        dmy(ngay){
            ngay = new Date(ngay)
            let y = ngay.getFullYear()
            let m = ngay.getMonth()+1; if(m<10) m = '0'+m
            let d = ngay.getDate(); if(d<10) d = '0'+d
            return d+'-'+m+'-'+y
        }
    }
}
</script>


<style scoped>
div.list-cell{
    width: 110px;
    padding: 10px;
    display: inline-block;
    margin-bottom: 5px;
    border: 1px solid grey
}

div.label{
    color:white;
    background-color:cadetblue;
    margin-bottom:15px;
}

div.sortable:hover{
    background-color: lightskyblue;
    cursor:pointer;
}

div.lsize{
    width: 320px;
}

.wrapper{
     white-space:nowrap;
}

.clickable:hover {
    color: orange;
    box-shadow: 0 0 15px yellow;
    border: 1px solid orange;
}

div.expired span.alert{
    margin-top:10px;
    margin-left: 5px;
    padding: 2px;
    display:inline-block;
    position:absolute;
    color:white;
    background-color: red;
}

div.expired div{
    box-shadow: 0 0 5px red;
}

.wrapper{
    padding-right: 70px;
}
</style>