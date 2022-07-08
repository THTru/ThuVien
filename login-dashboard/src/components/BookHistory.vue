<template>
<div class="wrapper" v-if="bookDetail.id!=0">
    <h1>
        ID sách: {{ bookDetail.id }} - {{ bookDetail.tensach }}
    </h1>
    <div class="list-cell label sortable" @click="sortphieumuon()">Phiếu mượn</div>
    <div class="list-cell label sortable" @click="sortidnguoimuon()">ID người đọc</div>
    <div class="list-cell lsize label sortable" @click="sortnguoimuon()">Tên</div>
    <div class="list-cell label sortable" @click="sortngaymuon()">Ngày mượn</div>
    <div class="list-cell label sortable" @click="sortngayhen()">Ngày hẹn trả</div>
    <div class="list-cell label sortable" @click="sortngaytra()">Ngày trả</div>
    <div class="list-cell lsize label">Trạng thái trả</div>
    
    <div v-for="item in bookHistory" v-bind:class="{expired: checkdate(item.phieumuon.ngayhentra, item.ngaytra)}">
        <div class="list-cell clickable" @click="toform(item.phieumuon.id)">{{ item.phieumuon.id }}</div>
        <div class="list-cell clickable" @click="toreaderhistory(item.phieumuon.bandoc.id)">{{ item.phieumuon.bandoc.id }}</div>
        <div class="list-cell lsize clickable" @click="toreaderhistory(item.phieumuon.bandoc.id)">{{ item.phieumuon.bandoc.tenbandoc }}</div>
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
    name: 'BookHistory',
    data(){
        return{
            bookDetail: { 'id': 0, 'tensach':'không' },
            bookHistory : [],
            sphieumuon: true, sidnguoimuon:true, snguoimuon:true,
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
        axios.post('http://localhost:8000/api/bookhistory', params)
        .then(response => {
            console.log(response)
            if(response.data.length>0){
                this.bookDetail = response.data[0]
                this.bookHistory = response.data[0].chitietmuon

                function compDate(a, b){
                    let date1 = new Date(a.phieumuon.ngaymuon)
                    let date2 = new Date(b.phieumuon.ngaymuon)
                    if (date1 > date2) return -1
                    if (date1 < date2) return 1
                    return 0
                }
                this.bookHistory.sort(compDate)
            }
        })
    },

    methods: {
        toform(id){
            this.$router.push({ path: '/dashboard/borrowform/'+id })
        },

        toreaderhistory(id){
            this.$router.push({ path: '/dashboard/readerhistory/'+id })
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
            this.bookHistory.sort(compForm);
            if(this.sphieumuon)
                this.bookHistory.reverse()
            this.sphieumuon = !this.sphieumuon
        },

        sortidnguoimuon(){
            function comp(a, b){
                let x = a.phieumuon.bandoc.id; let y = b.phieumuon.bandoc.id
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.bookHistory.sort(comp);
            if(this.sidnguoimuon)
                this.bookHistory.reverse()
            this.sidnguoimuon = !this.sidnguoimuon
        },

        sortnguoimuon(){
            function comp(a, b){
                let x = a.phieumuon.bandoc.tenbandoc; let y = b.phieumuon.bandoc.tenbandoc
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.bookHistory.sort(comp);
            if(this.snguoimuon)
                this.bookHistory.reverse()
            this.snguoimuon = !this.snguoimuon
        },

        sortngaymuon(){
            function comp(a, b){
                let x = new Date(a.phieumuon.ngaymuon); let y = new Date(b.phieumuon.ngaymuon)
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.bookHistory.sort(comp);
            if(this.sngaymuon)
                this.bookHistory.reverse()
            this.sngaymuon = !this.sngaymuon
        },

        sortngayhen(){
            function comp(a, b){
                let x = new Date(a.phieumuon.ngayhentra); let y = new Date(b.phieumuon.ngayhentra)
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.bookHistory.sort(comp);
            if(this.sngayhen)
                this.bookHistory.reverse()
            this.sngayhen = !this.sngayhen
        },

        sortngaytra(){
            function comp(a, b){
                let x = new Date(a.ngaytra); let y = new Date(b.ngaytra)
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.bookHistory.sort(comp);
            if(this.sngaytra)
                this.bookHistory.reverse()
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
    cursor:pointer;
    background-color: lightskyblue;
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