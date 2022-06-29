<template>
<div class="wrapper">
    <NavBar/>
    <div>Danh sách phiếu mượn sách</div>
    <div class="list-cell label msize sortable" @click="sortphieumuon()">Phiếu mượn</div>
    <div class="list-cell label msize sortable" @click="sortidnguoimuon()">ID người mượn</div>
    <div class="list-cell label xlsize sortable" @click="sortnguoimuon()">Người mượn</div>
    <div class="list-cell label msize sortable" @click="sortngaymuon()">Ngày mượn</div>
    <div class="list-cell label msize sortable" @click="sortngayhen()">Ngày hẹn trả</div>
    
    <div class="borrowform" v-for="item in listBorrowForm" @click="toform(item.id)" v-bind:class="{ expired: checkdate(item.ngayhentra, item.chitietmuon) }">
        <div class="list-cell msize">{{ item.id }}</div>
        <div class="list-cell msize">{{ item.bandoc.id }}</div>
        <div class="list-cell xlsize">{{ item.bandoc.tenbandoc }}</div>
        <div class="list-cell msize">{{ item.ngaymuon }}</div>
        <div class="list-cell msize">{{ item.ngayhentra }}</div>
        <span class="alert" v-if="checkdate(item.ngayhentra, item.chitietmuon)">Có sách trễ hẹn!</span>
    </div>
</div>
</template>

<script>
import axios from 'axios'
import NavBar from './NavBar.vue'
export default{
    name: 'BorrowDetail',
    components: { NavBar },
    data(){
        return{
            listBorrowForm: [],
            sphieumuon: false, sidnguoimuon:true, snguoimuon:true,
            sngaymuon:true, sngayhen:true,
        }
    },

    mounted(){
        axios.get('http://localhost:8000/api/borrowform').then(response=>
            {  
                console.log(response.data)
                this.listBorrowForm = response.data
            })
    },

    methods: {
        toform(id){
            this.$router.push({ path: '/dashboard/borrowform/'+id})
        },

        checkdate(ngayhen ,listdetail){
            let count=0
            listdetail.forEach(chitietmuon => {
                if(chitietmuon.ngaytra == '1900-01-01'){
                    const now = new Date()
                    const today = new Date(now.getFullYear()+'-'+(now.getMonth()+1)+'-'+now.getDate())
                    const hen = new Date(ngayhen)
                    if(today>hen) count++
                }
            })
            if(count!=0) return true
            else return false
        },

        sortphieumuon(){
            function compForm(a, b){
                let x = a.id; let y = b.id
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.listBorrowForm.sort(compForm);
            if(this.sphieumuon)
                this.listBorrowForm.reverse()
            this.sphieumuon = !this.sphieumuon
        },

        sortidnguoimuon(){
            function comp(a, b){
                let x = a.bandoc.id; let y = b.bandoc.id
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.listBorrowForm.sort(comp);
            if(this.sidnguoimuon)
                this.listBorrowForm.reverse()
            this.sidnguoimuon = !this.sidnguoimuon
        },

        sortnguoimuon(){
            function comp(a, b){
                let x = a.bandoc.tenbandoc; let y = b.bandoc.tenbandoc
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.listBorrowForm.sort(comp);
            if(this.snguoimuon)
                this.listBorrowForm.reverse()
            this.snguoimuon = !this.snguoimuon
        },

        sortngaymuon(){
            function comp(a, b){
                let x = new Date(a.ngaymuon); let y = new Date(b.ngaymuon)
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.listBorrowForm.sort(comp);
            if(this.sngaymuon)
                this.listBorrowForm.reverse()
            this.sngaymuon = !this.sngaymuon
        },

        sortngayhen(){
            function comp(a, b){
                let x = new Date(a.ngayhentra); let y = new Date(b.ngayhentra)
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.listBorrowForm.sort(comp);
            if(this.sngayhen)
                this.listBorrowForm.reverse()
            this.sngayhen = !this.sngayhen
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

.borrowform:hover{
    -webkit-filter: drop-shadow(0 0 15px yellow);
    color: orange;
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
    padding-right: 130px;
}
</style>