<template>
<div class="wrapper" v-if="id_phieumuon!=0">
    Phiếu mượn: {{ id_phieumuon }}
    <br><br>
    Người đọc:
    <div class="dropdown">
        <input class="chooseid" v-model="id_bandoc" readonly="readonly">
        <div class="dropdown-content chooseid">
            <div class="dropdown-item" v-for="item4 in listReaderid" @click="id_bandoc=item4.id, bandoc=item4.tenbandoc">
                {{ item4.id }}
            </div>
        </div>
    </div>
    <div class="dropdown">
        <input class="choosereader" v-model="bandoc" readonly="readonly">
        <div class="dropdown-content choosereader">
            <input v-model="readerKey" @keyup="filterReader(readerKey)">🔍
            <div class="dropdown-item" v-for="item3 in listReaderfilter" @click="id_bandoc=item3.id, bandoc=item3.tenbandoc">
                {{ item3.tenbandoc }}
            </div>
        </div>
    </div>
    <br><br>

    Ngày mượn: 
    <div class="dropdown">
        <div class="dropdown-chosen chooseid">{{ ngaymuon.d }}-{{ ngaymuon.m }}-{{ ngaymuon.y }}</div>
        <div class="dropdown-calendar"><Calendar v-bind:ngay="ngaymuon"/></div>
    </div><br>

    Ngày hẹn trả:
    <div class="dropdown">
        <div class="dropdown-chosen chooseid">{{ ngayhen.d }}-{{ ngayhen.m }}-{{ ngayhen.y }}</div>
        <div class="dropdown-calendar"><Calendar v-bind:ngay="ngayhen"/></div>
    </div>

    <br><br>
    <button @click="check">Thay đổi</button>
    <button @click="del">Xóa</button>
    <button @click="cancel">Hủy</button>
</div>
</template>

<script>
    import axios from 'axios'
    import Calendar from './Calendar.vue'
    export default {
        name: 'EditForm',
        components: { Calendar },
        data(){
            return{
                id_phieumuon: 0,
                listReader: [],
                listReaderid: [],
                listReaderfilter: [], readerKey: '',
                bandoc: 'Chưa chọn',
                id_bandoc: 0,
                ngaymuon: {'y':2000, 'm':1, 'd':1},
                ngayhen: {'y':2000, 'm':1, 'd':1},
                yrange:[], drange1: 31, drange2: 31,
            }
        },

        mounted(){
            let params = {'id': this.$route.params.id}
            axios.post('http://localhost:8000/api/formbyid', params).then(response=>{
                console.log(response.data)
                if(response.data.length>0){
                    this.id_phieumuon = response.data[0].id
                    this.id_bandoc = response.data[0].bandoc.id
                    this.bandoc = response.data[0].bandoc.tenbandoc
                    
                    const ngaymuon = new Date(response.data[0].ngaymuon)
                    const ngayhen = new Date(response.data[0].ngayhentra)
                    this.ngaymuon.y = ngaymuon.getFullYear()
                    this.ngayhen.y = ngayhen.getFullYear()
                    this.ngaymuon.m = ngaymuon.getMonth()+1
                    this.ngayhen.m = ngayhen.getMonth()+1
                    this.ngaymuon.d = ngaymuon.getDate()
                    this.ngayhen.d = ngayhen.getDate()
                    
                    const thisYear = new Date().getFullYear()
                    for(let i=thisYear+1; i>=2000; i--)
                        this.yrange.push(i)
                }
            })

            axios.get('http://localhost:8000/api/getreader').then(response=>{
                this.listReader = response.data
                this.listReaderfilter = this.listReader
            })

            axios.get('http://localhost:8000/api/getreaderid').then(response=>{
                this.listReaderid = response.data
            })
        },

        methods: {
            check(){
                let params = {
                    'id_phieumuon': this.id_phieumuon,
                    'id_bandoc' : this.id_bandoc,
                    'y1': this.ngaymuon.y,
                    'm1': this.ngaymuon.m,
                    'd1': this.ngaymuon.d,
                    'y2': this.ngayhen.y,
                    'm2': this.ngayhen.m,
                    'd2': this.ngayhen.d,
                }
                if(confirm("Thay đổi sẽ ảnh hưởng đến CSDL. Vẫn muốn tiếp tục?")){
                    axios.post('http://localhost:8000/api/editform', params).then(response=>{
                        console.log(response)
                        if(response.data===1){
                            alert('Phiếu mượn có ID: '+ this.id_phieumuon + ' đã thay đổi')
                            this.$router.push({ path: '/dashboard/borrowform/'+this.id_phieumuon })
                        }
                    })
                }
                
            },

            filterReader(bandoc){
                this.listReaderfilter = this.listReader.filter(function(el){
                    return el.tenbandoc.toLowerCase().includes(bandoc.toLowerCase())
                })
            },

            cancel(){
                this.$router.push({ path: '/dashboard/borrowform/'+this.id_phieumuon })
            },

            del(){
                if(confirm('Xóa phiếu mượn sẽ xóa tất cả chi tiết mượn sách trong phiếu. Có muốn tiếp tục?')){
                    let params = { 'id' : this.id_phieumuon }
                    axios.post('http://localhost:8000/api/deleteform', params).then(response=>{
                        if(response.data === 1){
                            alert('Phiếu mượn có ID: '+ this.id_phieumuon + ' đã bị xóa')
                            this.$router.push({ path: '/dashboard/listborrowform'})
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

.dropdown:hover .dropdown-content, .dropdown:hover .dropdown-calendar {
  display: block;
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
    padding-bottom: 150px;
}

button{
    width: 100px;
}
</style>