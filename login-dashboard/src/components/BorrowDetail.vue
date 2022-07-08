<template>
<div class="wrapper">
    <div>Danh sách chi tiết mượn sách</div>
    <div class="sfont">
        <div class="list-cell label ssize sortable" @click="sortidchitiet()">ID</div>
        <div class="list-cell label msize sortable" @click="sortphieumuon()">Phiếu mượn</div>
        <div class="list-cell label xlsize sortable" @click="sortidnguoimuon()">Người mượn</div>
        <div class="list-cell label xlsize sortable" @click="sortidsach()">Sách</div>
        <div class="list-cell label msize sortable" @click="sortngaymuon()">Ngày mượn</div>
        <div class="list-cell label msize sortable" @click="sortngayhen()">Ngày hẹn trả</div>
        <div class="list-cell label msize sortable" @click="sortngaytra()">Ngày trả</div>
        <div class="list-cell label lsize">Trạng thái trả</div>
        <div class="list-cell label ssize">Edit</div>
        
        <div v-for="item in listDetail" v-bind:class="{expired: checkdate(item.phieumuon.ngayhentra, item.ngaytra)}">
            <div class="list-cell ssize">{{ item.id }}</div>
            <div class="list-cell msize clickable" @click="toform(item.phieumuon.id)">{{ item.phieumuon.id }}</div>
            <div class="list-cell xlsize clickable" @click="toreaderhistory(item.phieumuon.bandoc.id)">ID:{{ item.phieumuon.bandoc.id }} - {{item.phieumuon.bandoc.tenbandoc}}</div>
            <div class="list-cell xlsize clickable" @click="tobookhistory(item.sach.id)">ID:{{ item.sach.id }} - {{item.sach.tensach}}</div>
            <div class="list-cell msize">{{ dmy(item.phieumuon.ngaymuon) }}</div>
            <div class="list-cell msize">{{ dmy(item.phieumuon.ngayhentra) }}</div>
            <div class="list-cell msize clickable" v-if="item.ngaytra=='1900-01-01'" @click="bookback=item.id, today(), status='Bình thường'"><span></span></div>
            <div class="list-cell msize" v-else>{{dmy(item.ngaytra)}}</div>
            <div class="list-cell lsize">{{ item.trangthaitra }}</div>
            <div class="list-cell ssize clickable" @click="toeditdetail(item.id)">✍️</div>
            <span class="alert" v-if="checkdate(item.phieumuon.ngayhentra, item.ngaytra)">Trễ hẹn!</span>
            <br><div class="list-cell xxlsize" v-if="bookback==item.id">
                <b>Xác nhận trả sách</b>
                <br>Ngày trả:
                <div class="dropdown">
                    <div class="dropdown-chosen chooseid">{{ ngay.d }}-{{ ngay.m }}-{{ ngay.y }}</div>
                    <div class="dropdown-calendar"><Calendar v-bind:ngay="ngay"/></div>
                </div>
                <br>Trạng thái trả:
                <input v-model="status">
                <br><div class="button btn-green" @click="returnbook(item.id)">Xác nhận</div>
                <div class="button btn-red" @click="bookback=0">Hủy</div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios'
import Calendar from './Calendar.vue'
export default{
    name: 'BorrowDetail',
    components: { Calendar },
    data(){
        return{
            listDetail: [],
            bookback: 0,
            ngay: {y: 1900, m: 1, d: 1,},
            status: 'Bình thường',
            sidchitiet: false, sphieumuon: true, sidnguoimuon:true, sidsach:true,
            sngaymuon:true, sngayhen:true, sngaytra:true,
            componentKey:0
        }
    },

    mounted(){
        let params = {
            'id_form': 0
        }
        axios.post('http://localhost:8000/api/getdetail', params).then(response=>
            {  
                console.log(response.data)
                this.listDetail = response.data
            })
    },

    methods: {
        toform(id){
            this.$router.push({ path: '/dashboard/borrowform/'+id})
        },

        tobookhistory(id){
            this.$router.push({ path: '/dashboard/bookhistory/'+id})
        },

        toreaderhistory(id){
            this.$router.push({ path: '/dashboard/readerhistory/'+id})
        },

        toeditdetail(id){
            this.$router.push({ path: '/dashboard/editdetail/'+id})
        },

        today(){
            let today = new Date()
            this.ngay.m = today.getMonth()+1
            this.ngay.y = today.getFullYear()
            this.ngay.d = today.getDate()
        },

        returnbook(id){
            let params={
                'id' : id,
                'y' : this.ngay.y, 'm' : this.ngay.m, 'd' : this.ngay.d,
                'status' : this.status
            }

            axios.post('http://localhost:8000/api/returnbook', params).then(response=>{
                console.log(response)
                alert(response.data)
                if(response.data == "Trả sách thành công"){
                    this.$router.go();
                }
            })
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

        sortidchitiet(){
            function compForm(a, b){
                let x = a.id; let y = b.id
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.listDetail.sort(compForm);
            if(this.sidchitiet)
                this.listDetail.reverse()
            this.sidchitiet = !this.sidchitiet
        },

        sortphieumuon(){
            function compForm(a, b){
                let x = a.phieumuon.id; let y = b.phieumuon.id
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.listDetail.sort(compForm);
            if(this.sphieumuon)
                this.listDetail.reverse()
            this.sphieumuon = !this.sphieumuon
        },

        sortidnguoimuon(){
            function comp(a, b){
                let x = a.phieumuon.bandoc.id; let y = b.phieumuon.bandoc.id
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.listDetail.sort(comp);
            if(this.sidnguoimuon)
                this.listDetail.reverse()
            this.sidnguoimuon = !this.sidnguoimuon
        },

        sortidsach(){
            function comp(a, b){
                let x = a.sach.id; let y = b.sach.id
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.listDetail.sort(comp);
            if(this.sidsach)
                this.listDetail.reverse()
            this.sidsach = !this.sidsach
        },

        sortngaymuon(){
            function comp(a, b){
                let x = new Date(a.phieumuon.ngaymuon); let y = new Date(b.phieumuon.ngaymuon)
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.listDetail.sort(comp);
            if(this.sngaymuon)
                this.listDetail.reverse()
            this.sngaymuon = !this.sngaymuon
        },

        sortngayhen(){
            function comp(a, b){
                let x = new Date(a.phieumuon.ngayhentra); let y = new Date(b.phieumuon.ngayhentra)
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.listDetail.sort(comp);
            if(this.sngayhen)
                this.listDetail.reverse()
            this.sngayhen = !this.sngayhen
        },

        sortngaytra(){
            function comp(a, b){
                let x = new Date(a.ngaytra); let y = new Date(b.ngaytra)
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.listDetail.sort(comp);
            if(this.sngaytra)
                this.listDetail.reverse()
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
    font-weight: bold;
}

div.sortable:hover{
    background-color: lightskyblue;
    cursor:pointer;
}

.ssize{
    width: 25px;
}

.msize{
    width: 84px;
}

.lsize{
    width: 190px;
}

.xlsize{
    width: 290px;
}

.xxlsize{
    width: 900px;
}

.xxlsize .btn-red, .xxlsize .btn-green, .xxlsize .dropdown{
    box-shadow: none;
}

.clickable:hover span:after{
    content: 'Trả';
    color:orange;
    font-weight: bold;
}

.clickable span:after{
    content: '_';
    text-align:center;
}

.wrapper{
    white-space:nowrap;
}

.sfont{
    font-size: smaller;
}

.clickable:hover {
    color: orange;
    box-shadow: 0 0 15px yellow;
    border: 1px solid orange;
}

input{
    width: 245px;
    height: 50px;
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid;
}

.button{
    display:inline-block;
    margin: 10px;
    width: 120px;
    padding: 5px;
}

.btn-green{
    border: 1px solid green;
    color:green;
    background-color: lightgreen;
}

.btn-green:hover{
    background-color: green;
    color: white;
    font-weight: bold;
    box-shadow: 0 0 15px cyan;
}

.btn-red{
    border: 1px solid red;
    color:red;
    background-color: lightpink;
}

.btn-red:hover{
    background-color: red;
    color: white;
    font-weight: bold;
    box-shadow: 0 0 15px orange;
}

.dropdown {
  position: relative;
  display: inline-block;
  text-align: left;
  margin-bottom: 10px;
}

.dropdown-chosen {
    text-align: center;
    border: 1px solid;
    padding: 4px;
    width: 100px;
    color:black;
}

.dropdown-calendar {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  height: fit-content;
  width: 270px;
  box-shadow: 0px 8px 10px black;
  padding: 5px 5px;
  z-index: 1;
} 

.dropdown:hover .dropdown-calendar{
  display: block;
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
    padding-right: 60px;
    padding-bottom: 50px;
}
</style>