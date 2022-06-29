<template>
<div class="wrapper" v-if="formDetail.id!=0">
    <NavBar/>
    ID phiếu mượn: {{ formDetail.id }} <span class="linkto" @click="toeditform(formDetail.id)">⟪Edit⟫</span><br>
    Bạn đọc: <span class="linkto" @click="toreaderhistory(formDetail.id_bandoc)">
        {{ formDetail.id_bandoc }} - {{ formDetail.tenbandoc }}
    </span><br>
    Ngày mượn: {{ formDetail.ngaymuon }}<br>
    Ngày hẹn trả {{ formDetail.ngayhentra }}
    <br>
    <span v-if="countexpired" class="linkto alert" @click="sendalert()">‼ Thông báo trả sách ‼</span><br v-else>
    <div>Danh sách chi tiết mượn sách</div>
    <div class="list-cell label ssize sortable" @click="sortidchitiet()">ID</div>
    <div class="list-cell label msize sortable"  @click="sortidsach()">ID Sách</div>
    <div class="list-cell label xlsize sortable" @click="sortsach()">Sách</div>
    <div class="list-cell label msize sortable" @click="sortngaytra()">Ngày trả</div>
    <div class="list-cell label lsize">Trạng thái trả</div>
    <div class="list-cell label ssize">Edit</div>
    
    <div v-for="item in listDetail" v-bind:class="{ expired: checkdate(item.phieumuon.ngayhentra, item.ngaytra)}">
        <div class="list-cell ssize">{{ item.id }}</div>
        <div class="list-cell msize clickable" @click="tobookhistory(item.sach.id)">{{ item.sach.id }}</div>
        <div class="list-cell xlsize clickable" @click="tobookhistory(item.sach.id)">{{ item.sach.tensach }}</div>
        <div class="list-cell msize clickable" v-if="item.ngaytra=='1900-01-01'"  @click="bookback=item.id, today(), status='Bình thường'"><span></span></div>
        <div class="list-cell msize" v-else>{{item.ngaytra}}</div>
        <div class="list-cell lsize">{{ item.trangthaitra }}</div>
        <div class="list-cell ssize clickable" @click="toeditdetail(item.id)">✍️</div>
        <span class="alert" v-if="checkdate(item.phieumuon.ngayhentra, item.ngaytra)">Trễ hẹn!</span>
        <br><div class="list-cell xxlsize" v-if="bookback==item.id">
            <b>Xác nhận trả sách</b>
            <br>Ngày trả (yyyy-mm-dd):
            <div class="dropdown">
                <div class="dropdown-chosen chooseid">{{ y }}</div>
                <div class="dropdown-content chooseid">
                    <div class="dropdown-item" v-for="y1 in yrange" @click="y=y1, setdrange()">
                        {{ y1 }}
                    </div>
                </div>
            </div>
            <div class="dropdown">
                <div class="dropdown-chosen chooseid">{{ m }}</div>
                <div class="dropdown-content chooseid">                        <div class="dropdown-item" v-for="m1 in 12" @click="m=m1, setdrange()">
                        {{ m1 }}
                    </div>
                </div>
            </div>
            <div class="dropdown">
                <div class="dropdown-chosen chooseid">{{ d }}</div>
                <div class="dropdown-content chooseid">                        <div class="dropdown-item" v-for="d1 in drange" @click="d=d1">
                        {{ d1 }}
                    </div>
                </div>
            </div>
            <br>Trạng thái trả:
            <input v-model="status">
            <br><div class="button btn-green" @click="returnbook(item.id, y, m, d, status)">Xác nhận</div>
            <div class="button btn-red" @click="bookback=0">Hủy</div>
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios'
import NavBar from './NavBar.vue'
export default{
    name: 'BorrowForm',
    components: { NavBar },
    data(){
        return{
            listDetail: [], countexpired: false,
            formDetail: {
                'id' : 0,
                'id_bandoc' : 0,
                'tenbandoc' : 'Không',
                'ngaymuon' : '2000-1-1',
                'ngayhentra' : '2000-1-1',
            },
            bookback: 0,
            yrange: [], drange: 31,
            y: 1900, m: 1, d: 1,
            status: 'Bình thường',
            sidchitiet: false, sidsach:true, ssach: true, sngaytra:true,
        }
    },

    mounted(){
        const thisYear = new Date().getFullYear()
            for(let i=thisYear+1; i>=2000; i--)
                this.yrange.push(i)
        
        let params = {
            'id_form': this.$route.params.id
        }
        axios.post('http://localhost:8000/api/getdetail', params).then(response=>
            {  
                console.log(response.data)
                if(response.data.length>0){
                    this.listDetail = response.data
                    this.formDetail.id = this.listDetail[0].phieumuon.id
                    this.formDetail.id_bandoc = this.listDetail[0].phieumuon.bandoc.id
                    this.formDetail.tenbandoc = this.listDetail[0].phieumuon.bandoc.tenbandoc
                    this.formDetail.ngaymuon = this.listDetail[0].phieumuon.ngaymuon
                    this.formDetail.ngayhentra = this.listDetail[0].phieumuon.ngayhentra
                }
            })
    },

    methods: {
        tobookhistory(id){
            this.$router.push({ path: '/dashboard/bookhistory/'+id})
        },

        toreaderhistory(id){
            this.$router.push({ path: '/dashboard/readerhistory/'+id})
        },

        toeditdetail(id){
            this.$router.push({ path: '/dashboard/editdetail/'+id })
        },

        toeditform(id){
            this.$router.push({ path: '/dashboard/editform/'+id })
        },

        today(){
            let today = new Date()
            this.m = today.getMonth()+1
            this.y = today.getFullYear()
            this.setdrange()
            this.d = today.getDate()
        },

        setdrange(){
            this.d=1
            const year=this.y
            const month=this.m
            const month31=[1, 3, 5, 7, 8, 10, 12]
            const month30=[4, 6, 9, 11]
            if(month31.includes(month)) this.drange=31
            else if(month30.includes(month)) this.drange=30
            else if(year%4==0 && year%100!=0) this.drange=29
            else this.drange=28
        },

        returnbook(id, y, m, d, status){
            let params={
                'id' : id,
                'y' : y, 'm' : m, 'd' : d,
                'status' : status
            }

            axios.post('http://localhost:8000/api/returnbook', params).then(response=>{
                console.log(response)
                alert(response.data)
                if(response.data == "Trả sách thành công"){
                    this.$router.go()
                }
            })
        },

        checkdate(ngayhen, ngaytra){
            if(ngaytra != '1900-01-01') return false
            else{
                const hen = new Date(ngayhen)
                const now = new Date()
                const today = new Date(now.getFullYear()+'-'+(now.getMonth()+1)+'-'+now.getDate())
                if(today>hen){
                    this.countexpired = true
                    return true
                }
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

        sortsach(){
            function comp(a, b){
                let x = a.sach.tensach; let y = b.sach.tensach
                if (x > y) return -1; if (x < y) return 1; return 0
            }
            this.listDetail.sort(comp);
            if(this.ssach)
                this.listDetail.reverse()
            this.ssach = !this.ssach
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

        sendalert(){
            const params = { 'id': this.formDetail.id }
            if(confirm('Gửi mail thông báo trễ hẹn?'))
                axios.post('http://localhost:8000/api/sendmail', params).then(response=>{
                    if(response.data) alert('Đã gửi mail thông báo cho người mượn')
                }).catch()
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
    width: 50px;
}

.msize{
    width: 110px;
}

.lsize{
    width: 240px;
}

.xlsize{
    width: 400px;
}

.xxlsize{
    width: 800px;
}

.xxlsize .btn-red, .xxlsize .btn-green, .xxlsize .dropdown, .xxlsize .dropdown .dropdown-content .dropdown-item{
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

.clickable:hover {
    color: orange;
    box-shadow: 0 0 15px yellow;
    border: 1px solid orange;
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
    width: 60px;
    color:black;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  height:125px;
  box-shadow: 0px 8px 10px black;
  padding: 5px 5px;
  z-index: 1;
  overflow: auto;
}

.dropdown-item:hover{
    background-color:cornflowerblue;
    color: white;
}

.dropdown:hover .dropdown-content {
  display: block;
}

.linkto{
    color: blue;
}

.linkto:hover{
    color: orange;
    text-shadow: 0 0 10px yellow;
    cursor: pointer;
}

span.alert{
    color:red;
    display: inline-block;
    border: 1px solid red;
    padding: 0 5px 0 5px;
    margin:0%;
}

span.alert:hover{
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