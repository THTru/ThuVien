<template>
<div class="wrapper">
    Từ:
    <div class="dropdown">
        <div class="dropdown-chosen chooseid">{{ ngay1.d }}-{{ ngay1.m }}-{{ ngay1.y }}</div>
        <div class="dropdown-calendar"><Calendar v-bind:ngay="ngay1"/></div>
    </div><br>
    Đến:
    <div class="dropdown">
        <div class="dropdown-chosen chooseid">{{ ngay2.d }}-{{ ngay2.m }}-{{ ngay2.y }}</div>
        <div class="dropdown-calendar"><Calendar v-bind:ngay="ngay2"/></div>
    </div><br>
    <br><button @click="check">Xuất báo cáo</button>

    <div v-if="rep" class="report">
        <br><br>
        <h1>Báo cáo mượn và trả sách từ ngày {{ dmy(ngay1str) }} đến {{ dmy(ngay2str) }}</h1>
        <table>
            <tr>
                <th>Phiếu mượn</th>
                <th>ID người mượn</th>
                <th class="wide">Tên người mượn</th>
                <th>ID sách</th>
                <th class="wide">Tên sách</th>
                <th class="date">Ngày mượn</th>
                <th class="date">Ngày hẹn trả</th>
                <th class="date">Ngày trả</th>
                <th class="wide">Trạng thái trả</th>
            </tr>
            <tr v-for="item in listDetail">
                <td>{{ item.phieumuon.id }}</td>
                <td>{{ item.phieumuon.bandoc.id }}</td>
                <td>{{ item.phieumuon.bandoc.tenbandoc }}</td>
                <td>{{ item.sach.id }}</td>
                <td>{{ item.sach.tensach }}</td>
                <td>{{ dmy(item.phieumuon.ngaymuon) }}</td>
                <td>{{ dmy(item.phieumuon.ngayhentra) }}</td>
                <td v-if="item.ngaytra!='1900-01-01'">{{ dmy(item.ngaytra) }}</td>
                <td v-else>_</td>
                <td>{{ item.trangthaitra }}</td>
            </tr>
        </table>
        <div class="stat">Số lượt mượn: {{ nborrow }}</div>
        <div class="stat">Số lượt trả: {{ nreturn }}</div>
        <div class="stat">Số lượt trả bình thường: {{ nnormal }}</div>
        <div class="stat">Số sách mất: {{ nlost }}</div>
        <br><button @click="exportreport">Xuất file docx</button>
    </div>
</div>
</template>

<script>
    import axios from 'axios'
    import Calendar from './Calendar.vue'
    export default {
        name: 'BorrowBook',
        components: { Calendar },
        data(){
            return{
                rep: false,
                listDetail: null,
                ngay1: {'y':2000, 'm':1, 'd':1},
                ngay2: {'y':2000, 'm':1, 'd':1},
                ngay1str: '', ngay2str: '',
                nborrow: 0, nreturn: 0, nlost: 0, nnormal: 0
            }
        },

        mounted(){
            const today = new Date()
            this.ngay1.y = today.getFullYear()
            this.ngay2.y = today.getFullYear()
            this.ngay1.m = today.getMonth()+1
            this.ngay2.m = today.getMonth()+1
            this.ngay1.d = today.getDate()
            this.ngay2.d = today.getDate()
        },

        methods: {
            check(){
                let params = {
                    'y1': this.ngay1.y,
                    'm1': this.ngay1.m,
                    'd1': this.ngay1.d,
                    'y2': this.ngay2.y,
                    'm2': this.ngay2.m,
                    'd2': this.ngay2.d,
                }
                this.rep=true
                this.ngay1str = this.ngay1.y+'-'+this.ngay1.m+'-'+this.ngay1.d
                this.ngay2str = this.ngay2.y+'-'+this.ngay2.m+'-'+this.ngay2.d
                axios.post('http://localhost:8000/api/detailbydate', params).then(response=>{
                    console.log(response.data)
                    this.listDetail = response.data
                    function compDate(a, b){
                        let date1 = new Date(a.phieumuon.ngaymuon)
                        let date2 = new Date(b.phieumuon.ngaymuon)
                        if (date1 < date2) return -1
                        if (date1 > date2) return 1
                        return 0
                    }
                    this.listDetail.sort(compDate)

                    this.nborrow = 0; this.nreturn =0; this.nlost = 0; this.nnormal=0
                    let ngay1 = new Date(this.ngay1str)
                    this.listDetail.forEach(element => {
                        const ngaymuon = new Date(element.phieumuon.ngaymuon)
                        if(ngaymuon >= ngay1) this.nborrow++
                        if(element.ngaytra != '1900-01-01') this.nreturn++
                        if(element.trangthaitra=='Mất sách') this.nlost++
                        if(element.trangthaitra=='Bình thường') this.nnormal++
                    });
                    // this.nborrow = element.phieumuon.ngaymuon
                })
            },

            exportreport(){
                let params = {
                    'y1': this.ngay1.y,
                    'm1': this.ngay1.m,
                    'd1': this.ngay1.d,
                    'y2': this.ngay2.y,
                    'm2': this.ngay2.m,
                    'd2': this.ngay2.d,
                }
                if(confirm('Xác nhận báo cáo?')){
                    axios.post('http://localhost:8000/api/exportreport', params, {responseType: 'blob'}).then(response=>{
                        const headers = response.headers
                        let blob = new Blob([response.data], { type: headers['content-type']})
                        let link = document.createElement('a')
                        link.href = window.URL.createObjectURL(blob)
                        if(params.m1<10) params.m1 = '0'+params.m1
                        if(params.m2<10) params.m2 = '0'+params.m2
                        if(params.d1<10) params.d1 = '0'+params.d1
                        if(params.d2<10) params.d2 = '0'+params.d2
                        link.download = params.y1+params.m1+params.d1+'_'+params.y2+params.m2+params.d2+'.docx'
                        link.click()
                        link.remove()
                    })
                }
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

.dropdown-item:hover{
    background-color:cornflowerblue;
    color: white;
}

.dropdown:hover .dropdown-calendar {
  display: block;
}

.chooseid{
    width: 100px;
    text-align: center;
}

.wrapper{
    min-width: 500px;
    padding-bottom: 175px;
}

.report{
    font-family: 'Times New Roman', Times, serif;
    font-size: large;
    color: black;
}

table{
    table-layout: auto;
    width: 100%;
}

th{
    background: silver;
    border: 1px solid black;
}

th.date{
    width: 8%;
}

th.wide{
    width: 20%;
}

td{
    border: 1px solid gray;
}

tr:nth-child(odd) {
    background-color: #f1f1f1;
}

tr:nth-child(even) {
    background-color: white;
}

div.stat {
    display: inline-block;
    padding: 15px;
}
</style>