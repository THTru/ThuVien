

<template>
    <div class="wrapper">
        <div><button class="back" @click="back">Back</button></div>
        <form autocomplete="off" @submit.prevent="capnhatsach" method="post">
            
            <div class="form-group" >
                <label for="tensach">Tên sách</label>
                <a class="a1"><input type="text" id="tensach" class="form-control" v-model="tensach" required></a>
            </div>
            <div class="form-group" >
                <label for="nganh">Ngành</label>
                <a class="a2"><select v-model="tennganh"><option v-for="item in nganh" :value="item.id">{{ item.tennganh }}</option></select></a>
            </div>
            <div class="form-group" >
                <label for="linhvuc">Lĩnh vực</label>
                <a class="a3"><select v-model="tenlinhvuc"><option v-for="item in linhvuc" :value="item.id">{{ item.tenlinhvuc }}</option></select></a>
            </div>
            <div class="form-group" >
                <label for="theloai">Thể loại</label>
                <a class="a4"><select v-model="tentheloai"><option v-for="item in theloai" :value="item.id">{{ item.tentheloai }}</option></select></a>
            </div>
            <div class="form-group" >
                <label for="tacgia">Tác giả</label>
                <a class="a5"><select v-model="tentacgia"><option v-for="item in tacgia" :value="item.id">{{ item.tentacgia }}</option></select></a>
            </div>
            <div class="form-group" >
                <label for="nxb">Nhà xuất bản</label>
                <a class="a6"><select v-model="tennxb"><option v-for="item in nxb" :value="item.id">{{ item.tennxb }}</option></select></a>
            </div>
            <div class="form-group" >
                <label for="nxb">Trạng thái</label>
                <a class="a7"><select v-model="tentrangthai"><option v-for="item in trangthai" :value="item.id">{{ item.tentrangthai }}</option></select></a>
            </div>                  
            <button type="submit" class="btn btn-default">Thay đổi</button>
        </form>
    </div>
</template>

<style scoped>
form{
    /* float: left; */
    margin:auto;
    margin-top: 50px;
    margin-bottom: 50px;
}

input{
    width: 242px;
}

select{
    width: 250px;
}

label{
    color: red;
}

a.a1{
    margin-left: 30px;
}

a.a2{
    margin-left: 48px;
}

a.a3{
    margin-left: 33px;
}

a.a4{
    margin-left: 39px;
}

a.a5{
    margin-left: 43px;
}

a.a6{
    margin-left: 0px;
}

a.a7{
    margin-left: 24px;
}

button.btn{
    margin:auto;
}

/*button.tracuu{
    margin-left: 0px;
    margin-right:300px;
    margin-top: 150px;
    margin-bottom: 0px;
}*/


</style>

<script>
    import axios from 'axios'
    export default{
        name: 'SuaSach',
        data: function(){
            return{
                // sach: [],
                tensach:"",
                tennganh: "",
                tenlinhvuc: "",
                tentheloai: "",
                tentacgia:"",
                tennxb: "",
                tentrangthai: "",
                nganh: [],
                linhvuc: [],
                theloai: [],
                tacgia: [],
                nxb: [],
                trangthai: [],
                
            }
        },

        mounted(){

            axios.get("http://localhost:8000/api/chondata").then(response1 => {
                this.nganh = response1.data.nganh;
                this.linhvuc = response1.data.linhvuc;
                this.theloai = response1.data.theloai;
                this.tacgia = response1.data.tacgia;
                this.nxb = response1.data.nxb;
                this.trangthai = response1.data.trangthai;
            })
                .catch(error => {
                console.log(error)
            });
            
            
            
            // alert(this.$route.params.id);
            
            axios.post("http://localhost:8000/api/suasach", {id: this.$route.query.id}).then(response => {
                console.log(response);         
                this.tensach=response.data.tensach;
                this.tennganh=response.data.id_nganh;
                this.tenlinhvuc=response.data.id_linhvuc;
                this.tentheloai=response.data.id_theloai;
                this.tentacgia=response.data.id_tacgia;
                this.tennxb=response.data.id_nxb;
                this.tentrangthai=response.data.id_trangthai;
                // alert(this.sach.id_nganh);
            })
                .catch(error => {
                console.log(error)
            });
            // alert(response.data.data.tensach);

        },

        methods: {

            async capnhatsach(){
                let paramss= {
                    'id': this.$route.query.id,
                    'tensach' : this.tensach,
                    'id_nganh' : this.tennganh,
                    'id_linhvuc' : this.tenlinhvuc,
                    'id_theloai' : this.tentheloai,
                    'id_tacgia' : this.tentacgia,
                    'id_nxb' : this.tennxb,
                    'id_trangthai' :this.tentrangthai,
                }
                // alert(paramss.id);
                if(confirm('Bạn có chắc muốn sửa sách này?')){
                    axios.post("http://localhost:8000/api/capnhatsach", paramss).then(response => {
                        
                        this.$router.push({ name: "Thuvien" }).catch(()=>{});
                        alert("Đã sửa thông tin danh mục sách");
                    })
                }
            },
            async back(){
                this.$router.push({name: "Thuvien"});
                return;
            },
        }
    }
</script>