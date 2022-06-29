<template>
<div class="wrapper" v-if="id_chitiet!=0">
    <NavBar/>
    ID: {{ id_chitiet }} - Người mượn: {{ id_bandoc }} - {{ tenbandoc }}<br>
    Phiếu mượn: {{ id_phieumuon }}<br>
    Ngày mượn: {{ ngaymuon }} - Ngày hẹn trả: {{ ngayhen }}<br><br>
    Sách mượn:
    <div class="dropdown"><div class="dropdown-chosen chooseid">{{ book.id }}</div></div>
    <div class="dropdown"><div class="dropdown-chosen choosebook">{{ book.ten }}</div></div>
    <br>

    Ngày trả:
    <div class="dropdown" v-if="!returnbook"><div class="dropdown-chosen chooseid">-</div></div>
    <div class="dropdown" v-else>
        <div class="dropdown-chosen chooseid">{{ ngaytra.y }}</div>
        <div class="dropdown-content chooseid">
            <div class="dropdown-item" v-for="y2 in yrange" @click="ngaytra.y=y2, setdrange()">
                {{ y2 }}
            </div>
        </div>
    </div>
    <div class="dropdown" v-if="!returnbook"><div class="dropdown-chosen chooseid">-</div></div>
    <div class="dropdown" v-else>
        <div class="dropdown-chosen chooseid">{{ ngaytra.m }}</div>
        <div class="dropdown-content chooseid">
            <div class="dropdown-item" v-for="m2 in 12" @click="ngaytra.m=m2, setdrange()">
                {{ m2 }}
            </div>
        </div>
    </div>
    <div class="dropdown" v-if="!returnbook"><div class="dropdown-chosen chooseid">-</div></div>
    <div class="dropdown" v-else>
        <div class="dropdown-chosen chooseid">{{ ngaytra.d }}</div>
        <div class="dropdown-content chooseid">
            <div class="dropdown-item" v-for="d2 in drange" @click="ngaytra.d=d2">
                {{ d2 }}
            </div>
        </div>
    </div>
    <br>Trạng thái trả
    <input :disabled="!returnbook" v-model="trangthaitra">

    <br><br>
    <button @click="check">Thay đổi</button>
    <button v-if="!returnbook" @click="lost">Báo mất</button>
    <button @click="del">Xóa</button>
    <button @click="cancel">Hủy</button>
</div>
</template>

<script>
    import axios from 'axios'
    import NavBar from './NavBar.vue'
    export default {
        name: 'EditDetail',
        components: { NavBar },
        data(){
            return{
                id_chitiet: 0,
                id_phieumuon: 0, ngaymuon: '1900-01-01', ngayhen: '1900-01-01',
                id_bandoc: 0, tenbandoc: 'không',
                detail: null,
                book: {'ten' : 'Chưa chọn', 'id': 0, 'trangthai' : '_'},
                ngaytra: {'y':2000, 'm':1, 'd':1},
                yrange:[], drange: 31,
                trangthaitra: 'bình thường',
                returnbook: false,
            }
        },

        mounted(){
            const thisYear = new Date().getFullYear()
            for(let i=thisYear+1; i>=2000; i--)
                this.yrange.push(i)

            let params = { 'id': this.$route.params.id }
            axios.post('http://localhost:8000/api/detailbyid', params).then(response=>{      
                console.log(response.data)
                if(response.data.length>0){
                    this.detail = response.data[0]
                    this.id_chitiet = this.$route.params.id
                    this.book.ten = this.detail.sach.tensach
                    this.book.id = this.detail.sach.id
                    this.book.trangthai = this.detail.sach.trangthai.tentrangthai
                    this.trangthaitra = this.detail.trangthaitra
                    this.id_phieumuon = this.detail.phieumuon.id
                    this.ngaymuon = this.detail.phieumuon.ngaymuon
                    this.ngayhen = this.detail.phieumuon.ngayhentra
                    this.id_bandoc = this.detail.phieumuon.bandoc.id
                    this.tenbandoc = this.detail.phieumuon.bandoc.tenbandoc
                    
                    const ngaytra = new Date(this.detail.ngaytra)
                    this.ngaytra.y = ngaytra.getFullYear()
                    this.ngaytra.m = ngaytra.getMonth()+1
                    this.setdrange()
                    this.ngaytra.d = ngaytra.getDate()
                    if(this.detail.ngaytra != '1900-01-01')
                        this.returnbook = true
                }
            })
        },

        methods: {
            setdrange(){
                this.ngaytra.d=1
                const year=this.ngaytra.y
                const month=this.ngaytra.m
                const month31=[1, 3, 5, 7, 8, 10, 12]
                const month30=[4, 6, 9, 11]
                if(month31.includes(month)) this.drange=31
                else if(month30.includes(month)) this.drange=30
                else if(year%4==0 && year%100!=0) this.drange=29
                else this.drange=28
            },

            check(){
                let params = {
                    'id': this.id_chitiet,
                    'trangthaitra': this.trangthaitra,
                    'y': this.ngaytra.y,
                    'm': this.ngaytra.m,
                    'd': this.ngaytra.d,
                }
                if(confirm("Thay đổi có ảnh hưởng đến CSDL. Có muốn tiếp tục?")){
                    axios.post("http://localhost:8000/api/editdetail", params).then(response=>{
                        console.log(response)
                        if(response.data===1){
                            alert('Chi tiết mượn có ID: '+ this.id_chitiet + ' đã thay đổi')
                            this.$router.push({ path: '/dashboard/borrowdetail' })
                        }
                        else alert(response.data)
                    })
                }
            },

            cancel(){
                this.$router.push({ path: '/dashboard/borrowdetail' })
            },

            del(){
                const params = { 'id': this.id_chitiet }
                if(confirm('Xóa chi tiết sẽ ảnh hưởng CSDL. Có muốn tiếp tục xóa?'))
                    axios.post('http://localhost:8000/api/deletedetail', params).then(response=>{
                        console.log(response.data)
                        if(response.data){
                            alert('Chi tiết mượn có ID: '+ this.id_chitiet + ' đã bị xóa')
                            this.$router.push('/dashboard/borrowdetail')
                        }
                    })
            },

            lost(){
                const params = { 'id': this.id_chitiet }
                if(confirm('Xác nhận báo mất sách')){
                    axios.post('http://localhost:8000/api/confirmlost', params).then(response=>{
                        if(response.data){
                            alert('Ghi nhận sách đã mất')
                            this.$router.push('/dashboard/borrowdetail')
                        }
                    })
                }
            }
        }
    }
</script>

<style scoped>
.dropdown {
  position: relative;
  display: inline-block;
  text-align: left;
  margin-bottom: 10px;
}
.dropdown-chosen {
    border: 1px solid black;
    padding: 2px;
    color:black;
}
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  height:90px;
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
.choosebook{
    width:400px;
}
.choosereader{
    width:250px;
}
.chooseid{
    width: 140px;
    text-align: center;
}
.wrapper{
    padding-bottom: 40px;
}
input{
    width: 400px;
}

button{
    width: 100px;
}
</style>