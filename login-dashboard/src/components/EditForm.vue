<template>
<div class="wrapper" v-if="id_phieumuon!=0">
    <NavBar/>
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
            <div class="dropdown-item" v-for="item3 in listReader" @click="id_bandoc=item3.id, bandoc=item3.tenbandoc">
                {{ item3.tenbandoc }}
            </div>
        </div>
    </div>
    <br><br>

    Ngày mượn: 
    <div class="dropdown">
        <div class="dropdown-chosen chooseid">{{ ngaymuon.y }}</div>
        <div class="dropdown-content chooseid">
            <div class="dropdown-item" v-for="y1 in yrange" @click="ngaymuon.y=y1, setdrange1()">
                {{ y1 }}
            </div>
        </div>
    </div>
    <div class="dropdown">
        <div class="dropdown-chosen chooseid">{{ ngaymuon.m }}</div>
        <div class="dropdown-content chooseid">
            <div class="dropdown-item" v-for="m1 in 12" @click="ngaymuon.m=m1, setdrange1()">
                {{ m1 }}
            </div>
        </div>
    </div>
    <div class="dropdown">
        <div class="dropdown-chosen chooseid">{{ ngaymuon.d }}</div>
        <div class="dropdown-content chooseid">
            <div class="dropdown-item" v-for="d1 in drange1" @click="ngaymuon.d=d1">
                {{ d1 }}
            </div>
        </div>
    </div><br>

    Ngày hẹn trả:
    <div class="dropdown">
        <div class="dropdown-chosen chooseid">{{ ngayhen.y }}</div>
        <div class="dropdown-content chooseid">
            <div class="dropdown-item" v-for="y2 in yrange" @click="ngayhen.y=y2, setdrange2()">
                {{ y2 }}
            </div>
        </div>
    </div>
    <div class="dropdown">
        <div class="dropdown-chosen chooseid">{{ ngayhen.m }}</div>
        <div class="dropdown-content chooseid">
            <div class="dropdown-item" v-for="m2 in 12" @click="ngayhen.m=m2, setdrange2()">
                {{ m2 }}
            </div>
        </div>
    </div>
    <div class="dropdown">
        <div class="dropdown-chosen chooseid">{{ ngayhen.d }}</div>
        <div class="dropdown-content chooseid">
            <div class="dropdown-item" v-for="d2 in drange2" @click="ngayhen.d=d2">
                {{ d2 }}
            </div>
        </div>
    </div>

    <br><br>
    <button @click="check">Thay đổi</button>
    <button @click="del">Xóa</button>
    <button @click="cancel">Hủy</button>
</div>
</template>

<script>
    import axios from 'axios'
    import NavBar from './NavBar.vue'
    export default {
        name: 'EditForm',
        components: { NavBar },
        data(){
            return{
                id_phieumuon: 0,
                listReader: [],
                listReaderid: [],
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
                    this.setdrange1()
                    this.setdrange2()
                    this.ngaymuon.d = ngaymuon.getDate()
                    this.ngayhen.d = ngayhen.getDate()
                    
                    const thisYear = new Date().getFullYear()
                    for(let i=thisYear+1; i>=2000; i--)
                        this.yrange.push(i)
                }
            })

            axios.get('http://localhost:8000/api/getreader').then(response=>{
                this.listReader = response.data
            })

            axios.get('http://localhost:8000/api/getreaderid').then(response=>{
                this.listReaderid = response.data
            })
        },

        methods: {
            setdrange1(){
                this.ngaymuon.d=1
                const year=this.ngaymuon.y
                const month=this.ngaymuon.m
                const month31=[1, 3, 5, 7, 8, 10, 12]
                const month30=[4, 6, 9, 11]
                if(month31.includes(month)) this.drange1=31
                else if(month30.includes(month)) this.drange1=30
                else if(year%4==0 && year%100!=0) this.drange1=29
                else this.drange1=28
            },

            setdrange2(){
                this.ngayhen.d=1
                const year=this.ngayhen.y
                const month=this.ngayhen.m
                const month31=[1, 3, 5, 7, 8, 10, 12]
                const month30=[4, 6, 9, 11]
                if(month31.includes(month)) this.drange2=31
                else if(month30.includes(month)) this.drange2=30
                else if(year%4==0 && year%100!=0) this.drange2=29
                else this.drange2=28
            },

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
    padding-bottom: 60px;
}

button{
    width: 100px;
}
</style>