<template>
<div class="wrapper">
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
        <input class="choosereader" v-model="bandoc" readonly>
        <div class="dropdown-content choosereader">
            <input v-model="readerKey" @keyup="filterReader(readerKey)">🔍
            <div class="dropdown-item" v-for="item3 in listReaderfilter" @click="id_bandoc=item3.id, bandoc=item3.tenbandoc">
                {{ item3.tenbandoc }}
            </div>
        </div>
    </div>
    <br><br>

    Sách mượn:
    <div v-for="(book, index) in sach">
        <div class="dropdown">
            <div class="dropdown-chosen chooseid">{{ book.id }}</div>
            <div class="dropdown-content chooseid">
                <div class="dropdown-item" @click="book.ten='Chưa chọn', book.id=0,  book.trangthai='_'">0</div>
                <div class="dropdown-item" v-for="item2 in listBookid" @click="book.ten=item2.tensach, book.id=item2.id,  book.trangthai=item2.trangthai.tentrangthai">
                    {{ item2.id }}
                </div>
            </div>
        </div>
        <div class="dropdown">
            <!-- <div class="dropdown-chosen choosebook">{{ book.ten }}</div> -->
            <input class="dropdown-chosen choosebook" v-model="book.ten" @keyup="filterBook(book.ten, index)">
            <div class="dropdown-content choosebook">
                <input v-model="book.bookkey" @keyup="filterBook(book.bookkey, index)">🔍
                <div class="dropdown-item" @click="book.ten='Chưa chọn', book.id=0,  book.trangthai='_', book.listBookfilter=listBook">Chưa chọn</div>
                <div class="dropdown-item" v-for="item in book.listBookfilter" @click="book.ten=item.tensach, 
                book.id=item.id, book.trangthai=item.trangthai.tentrangthai, book.listBookfilter=listBook">
                    {{ item.tensach }}
                </div>
            </div>
        </div>
        <div class="dropdown"><div class="dropdown-chosen chooseid">{{ book.trangthai }}</div></div>
    </div>
    <!-- Ngày mượn: 
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
    </div> -->
    <br>
    Ngày mượn:
    <div class="dropdown">
        <div class="dropdown-chosen chooseid">{{ ngaymuon.d+'-'+ngaymuon.m+'-'+ngaymuon.y }}</div>
        <div class="dropdown-calendar">
            <Calendar v-bind:ngay="ngaymuon"/>
        </div>
    </div><br>
    Ngày hẹn trả:
    <div class="dropdown">
        <div class="dropdown-chosen chooseid">{{ ngayhen.d+'-'+ngayhen.m+'-'+ngayhen.y }}</div>
        <div class="dropdown-calendar">
            <Calendar v-bind:ngay="ngayhen"/>
        </div>
    </div>
    <br><br><button @click="check">Mượn sách</button>
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
                listBook: [],
                listBookid: [],
                sach : [
                    {'ten' : 'Chưa chọn', 'id': 0, 'trangthai' : '_', 'listBookfilter': [], 'bookkey': ''},
                    {'ten' : 'Chưa chọn', 'id': 0, 'trangthai' : '_', 'listBookfilter': [], 'bookkey': ''},
                    {'ten' : 'Chưa chọn', 'id': 0, 'trangthai' : '_', 'listBookfilter': [], 'bookkey': ''},
                    {'ten' : 'Chưa chọn', 'id': 0, 'trangthai' : '_', 'listBookfilter': [], 'bookkey': ''},
                ],
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
            const today = new Date()
            this.ngaymuon.y = today.getFullYear()
            this.ngayhen.y = today.getFullYear()
            this.ngaymuon.m = today.getMonth()+1
            this.ngayhen.m = today.getMonth()+1
            // this.setdrange1()
            // this.setdrange2()
            this.ngaymuon.d = today.getDate()
            this.ngayhen.d = today.getDate()
            
            const thisYear = new Date().getFullYear()
            for(let i=thisYear+1; i>=2000; i--)
                this.yrange.push(i)

            axios.get('http://localhost:8000/api/getbook').then(response=>
            {   
                this.listBook = response.data
                const list = this.listBook
                this.sach.forEach(myFunction)

                function myFunction(item){
                    item.listBookfilter = list
                }
            })
            axios.get('http://localhost:8000/api/getbookid').then(response=>
            {
                this.listBookid = response.data
            })

            axios.get('http://localhost:8000/api/getreader').then(response=>
            {
                this.listReader = response.data
                this.listReaderfilter = this.listReader
            })

            axios.get('http://localhost:8000/api/getreaderid').then(response=>
            {
                this.listReaderid = response.data
            })
        },

        methods: {
        //     setdrange1(){
        //         this.ngaymuon.d=1
        //         const year=this.ngaymuon.y
        //         const month=this.ngaymuon.m
        //         const month31=[1, 3, 5, 7, 8, 10, 12]
        //         const month30=[4, 6, 9, 11]
        //         if(month31.includes(month)) this.drange1=31
        //         else if(month30.includes(month)) this.drange1=30
        //         else if(year%4==0 && year%100!=0) this.drange1=29
        //         else this.drange1=28
        //     },

        //     setdrange2(){
        //         this.ngayhen.d=1
        //         const year=this.ngayhen.y
        //         const month=this.ngayhen.m
        //         const month31=[1, 3, 5, 7, 8, 10, 12]
        //         const month30=[4, 6, 9, 11]
        //         if(month31.includes(month)) this.drange2=31
        //         else if(month30.includes(month)) this.drange2=30
        //         else if(year%4==0 && year%100!=0) this.drange2=29
        //         else this.drange2=28
        //     },

            check(){
                let temparr = []
                this.sach.forEach(myFunction)
                function myFunction(item){
                        temparr.push(item.id)
                }

                let params = {
                    'id_sach' : temparr,
                    'id_bandoc' : this.id_bandoc,
                    'y1': this.ngaymuon.y,
                    'm1': this.ngaymuon.m,
                    'd1': this.ngaymuon.d,
                    'y2': this.ngayhen.y,
                    'm2': this.ngayhen.m,
                    'd2': this.ngayhen.d,
                }
                axios.post('http://localhost:8000/api/borrow', params).then(
                    response=>{
                        alert(response.data)
                        if(response.data == 'Mượn thành công')
                            this.$router.push({ path: '/dashboard/borrowdetail' })
                    }
                )
            },

            filterReader(bandoc){
                this.listReaderfilter = this.listReader.filter((el) => {
                    return this.ignoreViet(el.tenbandoc).includes(this.ignoreViet(bandoc))
                })
            },

            filterBook(sach, index){
                this.sach[index].listBookfilter = this.listBook.filter((el) => {
                    return this.ignoreViet(el.tensach).includes(this.ignoreViet(sach))
                })
                console.log(this.sach)
            },

            ignoreViet(str){
                str = str.toLowerCase()
                str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a")
                str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e")
                str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i")
                str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o")
                str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u")
                str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y")
                str = str.replace(/đ/g, "d")
                return str
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
  height: 110px;
  box-shadow: 0px 8px 10px black;
  padding: 5px 5px;
  z-index: 1;
  overflow: auto;
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

.dropdown:hover .dropdown-content, .dropdown:hover .dropdown-calendar {
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
    padding-bottom: 170px;
    padding-right: 10px;
    padding-left: 10px;
}
</style>