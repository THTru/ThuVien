<template>
    <div class="wrapper">
        <div><button class="back" @click="back">Back</button></div>
        <div class="nganh" v-if="themnganh">
             <div>
                <label for="tensach">Tên ngành</label>
                <a class="a1"><input type="text" id="tennganh" class="form-control" v-model="tennganh" required></a>
                <button @click="themmoinganh">Thêm ngành</button><br>
            </div>
        </div>
        <div class="linhvuc" v-if="themlinhvuc">
             <div>
                <label for="linhvuc">Tên lĩnh vực</label>
                <a class="a1"><input type="text" id="tenlinhvuc" class="form-control" v-model="tenlinhvuc" required></a>
                <button @click="themmoilinhvuc">Thêm lĩnh vực</button><br>
            </div>
        </div>
        <div class="theloai" v-if="themtheloai">
             <div>
                <label for="theloai">Tên thể loại</label>
                <a class="a1"><input type="text" id="tentheloai" class="form-control" v-model="tentheloai" required></a>
                <button @click="themmoitheloai">Thêm thể loại</button><br>
            </div>
        </div>
        <div class="tacgia" v-if="themtacgia">
             <div>
                <label for="tacgia">Tên tác giả</label>
                <a class="a1"><input type="text" id="tentacgia" class="form-control" v-model="tentacgia" required></a>
                <button @click="themmoitacgia">Thêm tác giả</button><br>
            </div>
        </div>
        <div class="nxb" v-if="themnxb">
             <div>
                <label for="nxb">Tên nhà xuất bản</label>
                <a class="a1"><input type="text" id="tennxb" class="form-control" v-model="tennxb" required></a>
                <button @click="themmoinxb">Thêm nxb</button><br>
            </div>
        </div>

<!-- cái này cho sửa -->
        <div class="nganh" v-if="suanganh">
             <div>
                <label for="tensach">Tên ngành</label>
                <a class="a1"><input type="text" id="tennganh" class="form-control" v-model="tennganh" required></a>
                <button @click="suanganhnay">Sửa ngành</button><br>
            </div>
        </div>
        <div class="linhvuc" v-if="sualinhvuc">
             <div>
                <label for="linhvuc">Tên lĩnh vực</label>
                <a class="a1"><input type="text" id="tenlinhvuc" class="form-control" v-model="tenlinhvuc" required></a>
                <button @click="sualinhvucnay">Sửa lĩnh vực</button><br>
            </div>
        </div>
        <div class="theloai" v-if="suatheloai">
             <div>
                <label for="theloai">Tên thể loại</label>
                <a class="a1"><input type="text" id="tentheloai" class="form-control" v-model="tentheloai" required></a>
                <button  @click="suatheloainay">Sửa thể loại</button><br>
            </div>
        </div>
        <div class="tacgia" v-if="suatacgia">
             <div>
                <label for="tacgia">Tên tác giả</label>
                <a class="a1"><input type="text" id="tentacgia" class="form-control" v-model="tentacgia" required></a>
                <button @click="suatacgianay">Sửa tác giả</button><br>
            </div>
        </div>
        <div class="nxb" v-if="suanxb">
             <div>
                <label for="nxb">Tên nhà xuất bản</label>
                <a class="a1"><input type="text" id="tennxb" class="form-control" v-model="tennxb" required></a>
                <button @click="suanxbnay">Sửa nxb</button><br>
            </div>
        </div>


<!---->       


        <div class="row">    
            <div class="column">
            <button v-if="!themnganh" @click="openthemnganh">Thêm ngành</button><br>
                <table>
                    <thead>
                        <tr>
                            <th>Tên ngành</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item1 in nganh" :key="item1.id">
                            <td>{{ item1.tennganh}}</td>
                            <td><button @click="opensuanganh(item1)">Sửa</button></td>
                            <td><button @click="xoanganh(item1.id)">Xóa</button></td>
                        </tr>    
                    </tbody>
                </table>
            </div>

            <div class="column">
            <button v-if="!themlinhvuc"  @click="openlinhvuc">Thêm lĩnh vực</button><br>
                <table>
                    <thead>
                        <tr>
                            <th>Tên lĩnh vực</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item2 in linhvuc" :key="item2.id">
                            <td>{{ item2.tenlinhvuc}}</td>
                            <td><button @click="opensualinhvuc(item2)">Sửa</button></td>
                            <td><button @click="xoalinhvuc(item2.id)">Xóa</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="column">
                <button v-if="!themtheloai" @click="opentheloai">Thêm thể loại</button><br>
                <table>
                    <thead>
                        <tr>
                            <th>Tên thể loại</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item3 in theloai" :key="item3.id">
                            <td>{{ item3.tentheloai}}</td>
                            <td><button @click="opensuatheloai(item3)">Sửa</button></td>
                            <td><button @click="xoatheloai(item3.id)">Xóa</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="column">
                <button v-if="!themtacgia" @click="opentacgia">Thêm tác giả</button><br>
                <table>
                    <thead>
                        <tr>
                            <th>Tên tác giả</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item4 in tacgia" :key="item4.id">
                            <td>{{ item4.tentacgia}}</td>
                            <td><button @click="opensuatacgia(item4)">Sửa</button></td>
                            <td><button @click="xoatacgia(item4.id)">Xóa</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="column">
                <button v-if="!themnxb" @click="opennxb">Thêm nxb</button><br>
                <table>
                    <thead>
                        <tr>
                            <th>Tên nxb</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item5 in nxb" :key="item5.id">
                            <td>{{ item5.tennxb}}</td>
                            <td><button @click="opensuanxb(item5)">Sửa</button></td>
                            <td><button @click="xoanxb(item5.id)">Xóa</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</template>

<style scoped>
.row {
  display: flex;
  margin-left:-5px;
  margin-right:-5px;
}

.column {
  flex: 50%;
  padding: 5px;
}

th{
    color: red;
}

td{
    color: red;
}

table, td, th {  
  border: 1px solid #00ff00;
  text-align: left;
}

table {
    border-collapse: collapse;
    width: 100%;
}

.nganh{
    margin:auto;
    margin-top: 10px;
    margin-bottom: 50px;
}

.linhvuc{
    margin:auto;
    margin-top: 10px;
    margin-bottom: 50px;
}

.theloai{
    margin:auto;
    margin-top: 10px;
    margin-bottom: 50px;
}

.tacgia{
    margin:auto;
    margin-top: 10px;
    margin-bottom: 50px;
}
.nxb{
    margin:auto;
    margin-top: 10px;
    margin-bottom: 50px;
}

label{
    color: red;
}
</style>

<script scoped>
    import axios from 'axios'
    export default {
         name: 'Tracuu',
        data() {
            return {
                nganh: [],
                linhvuc:[],
                theloai:[],
                tacgia: [],
                nxb: [],
                themnganh: false,
                themlinhvuc: false,
                themtheloai: false,
                themtacgia: false,
                themnxb: false,
                tennganh: "",
                tenlinhvuc: "",
                tentheloai: "",
                tentacgia: "",
                tennxb: "",
                suanganh: false,
                sualinhvuc: false,
                suatheloai: false,
                suatacgia: false,
                suanxb: false,
                idtam: ""
            }
        },
        mounted() {

            axios.get("http://localhost:8000/api/chondata").then(response1 => {
                // console.log(response)
                this.nganh = response1.data.nganh;
                this.linhvuc = response1.data.linhvuc;
                this.theloai = response1.data.theloai;
                this.tacgia = response1.data.tacgia;
                this.nxb = response1.data.nxb;
            })
                .catch(error => {
                console.log(error)
            });



        },
        methods:{
            false1cuc(){
                this.themnganh = false;
                this.themlinhvuc = false;
                this.themtheloai = false;
                this.themtacgia = false;
                this.themnxb = false;
                this.suanganh = false;
                this.sualinhvuc = false;
                this.suatheloai = false;
                this.suatacgia = false;
                this.suanxb = false;
            },
            
            async openthemnganh(){
                this.false1cuc();
                this.themnganh = true;

            },

            async openlinhvuc(){
                this.false1cuc();
                this.themlinhvuc = true;

            },

            async opentheloai(){
                this.false1cuc();
                this.themtheloai = true;
            },

            async opentacgia(){
                this.false1cuc();
                this.themtacgia = true;
            },

            async opennxb(){
                this.false1cuc();
                this.themnxb = true;
            },

            async opensuanganh(item){
                this.false1cuc();
                this.suanganh = true;
                this.tennganh = item.tennganh;
                this.idtam = item.id;
            },

            async opensualinhvuc(item){
                this.false1cuc();
                this.sualinhvuc = true;
                this.tenlinhvuc = item.tenlinhvuc;
                this.idtam = item.id;
            },

            async opensuatheloai(item){
                this.false1cuc();
                this.suatheloai = true;
                this.tentheloai = item.tentheloai;
                this.idtam = item.id;
            },

            async opensuatacgia(item){
                this.false1cuc();
                this.suatacgia = true;
                this.tentacgia = item.tentacgia;
                this.idtam = item.id;
            },

            async opensuanxb(item){
                this.false1cuc();
                this.suanxb = true;
                this.tennxb = item.tennxb;
                this.idtam = item.id;
            },



            async themmoinganh(){
                let params = {
                    'tennganh' : this.tennganh,
                }

                axios.post("http://localhost:8000/api/themmoinganh", params).then(response => {
                    // console.log(response)
                    if(response.data === 1){
                        alert("Đã thêm ngành mới");
                        this.$router.go();
                    }
                    else alert("Ngành đã tồn tại");                    
                })
            },

            async themmoilinhvuc(){
                let params = {
                    'tenlinhvuc' : this.tenlinhvuc,
                }

                axios.post("http://localhost:8000/api/themmoilinhvuc", params).then(response => {
                    // console.log(response)
                    if(response.data === 1){
                        alert("Đã thêm lĩnh vực mới");
                        this.$router.go();
                    }
                    else alert("Lĩnh vực đã tồn tại");
                })
            },

            async themmoitheloai(){
                let params = {
                    'tentheloai' : this.tentheloai,
                }

                axios.post("http://localhost:8000/api/themmoitheloai", params).then(response => {
                    // console.log(response)
                    if(response.data === 1){
                        alert("Đã thêm thể loại mới");
                        this.$router.go();
                    }
                    else alert("Thể loại đã tồn tại");
                })
            },

            async themmoitacgia(){
                let params = {
                    'tentacgia' : this.tentacgia,
                }

                axios.post("http://localhost:8000/api/themmoitacgia", params).then(response => {
                    // console.log(response)
                    if(response.data === 1){
                        alert("Đã thêm tác giả mới");
                        this.$router.go();
                    }
                    else alert("Tác giả đã tồn tại");
                })
            },

            async themmoinxb(){
                let params = {
                    'tennxb' : this.tennxb,
                }

                axios.post("http://localhost:8000/api/themmoinxb", params).then(response => {
                    // console.log(response)
                    if(response.data === 1){
                        alert("Đã thêm nhà xuất bản mới");
                        this.$router.go();
                    }
                    else alert("Nhà xuất bản đã tồn tại");
                })
            },

            async xoanganh(index){
                // alert(index);
                if(confirm('Bạn có chắc muốn xóa ngành này?')){
                    axios.post("http://localhost:8000/api/xoanganh", {id: index}).then(response => {
                        // console.log(response);
                        if(response.data === 1){
                            alert("Xóa ngành thành công");
                            this.$router.go();
                        }
                        else {
                            alert("Không thể xóa do có đầu sách chứa thông tin ngành này.");
                        }
                    })
                }
            },

            async xoalinhvuc(index){
                // alert(index);
                if(confirm('Bạn có chắc muốn xóa lĩnh vực này?')){
                    axios.post("http://localhost:8000/api/xoalinhvuc", {id: index}).then(response => {
                        // console.log(response);
                        if(response.data === 1){
                            alert("Xóa lĩnh vực thành công");
                            this.$router.go();
                        }
                        else {
                            alert("Không thể xóa do có đầu sách chứa thông tin lĩnh vực này.");
                        }
                    })
                }
            },

            async xoatheloai(index){
                // alert(index);
                if(confirm('Bạn có chắc muốn xóa lĩnh vực này?')){
                    axios.post("http://localhost:8000/api/xoatheloai", {id: index}).then(response => {
                        // console.log(response);
                        if(response.data === 1){
                            alert("Xóa thể loại thành công");
                            this.$router.go();
                        }
                        else {
                            alert("Không thể xóa do có đầu sách chứa thông tin thể loại này.");
                        }
                    })
                }
            },

            async xoatacgia(index){
                // alert(index);
                if(confirm('Bạn có chắc muốn xóa tác giả này?')){
                    axios.post("http://localhost:8000/api/xoatacgia", {id: index}).then(response => {
                        console.log(response);
                        if(response.data === 1){
                            alert("Xóa tác giả thành công");
                            this.$router.go();
                        }
                        else {
                            alert("Không thể xóa do có đầu sách chứa thông tin tác giả này.");
                        }
                    })
                }
            },

            async xoanxb(index){
                // alert(index);
                if(confirm('Bạn có chắc muốn xóa nhà xuất bản này?')){
                    axios.post("http://localhost:8000/api/xoanxb", {id: index}).then(response => {
                        console.log(response);
                        if(response.data === 1){
                            alert("Xóa nhà xuất bản thành công");
                            this.$router.go();
                        }
                        else {
                            alert("Không thể xóa do có đầu sách chứa thông tin nhà xuất bản này.");
                        }
                    })
                }
            },

            async suanganhnay(){
                let params = {
                    'tennganh' : this.tennganh,
                    'id' : this.idtam,
                }

                axios.post("http://localhost:8000/api/suanganh", params).then(response => {
                    // console.log(response)
                    this.nganh = response.data
                    alert("Đã sửa ngành thành công");     
                    // this.$router.go();           
                })
            },

            async sualinhvucnay(){
                let params = {
                    'tenlinhvuc' : this.tenlinhvuc,
                    'id' : this.idtam,
                }

                axios.post("http://localhost:8000/api/sualinhvuc", params).then(response => {
                    // console.log(response)
                    alert("Đã sửa lĩnh vực thành công");     
                    this.$router.go();            
                })
            },

            async suatheloainay(){
                let params = {
                    'tentheloai' : this.tentheloai,
                    'id' : this.idtam,
                }

                axios.post("http://localhost:8000/api/suatheloai", params).then(response => {
                    // console.log(response)
                    alert("Đã sửa thể loại thành công");     
                    this.$router.go();            
                })
            },

            async suatacgianay(){
                let params = {
                    'tentacgia' : this.tentacgia,
                    'id' : this.idtam,
                }

                axios.post("http://localhost:8000/api/suatacgia", params).then(response => {
                    // console.log(response)
                    alert("Đã sửa tác giả thành công");     
                    this.$router.go();            
                })
            },

            async suanxbnay(){
                let params = {
                    'tennxb' : this.tennxb,
                    'id' : this.idtam,
                }

                axios.post("http://localhost:8000/api/suanxb", params).then(response => {
                    // console.log(response)
                    alert("Đã sửa nhà xuất bản thành công");     
                    this.$router.go();            
                })
            },




            async back(){
                this.$router.push({name: "Thuvien"});
                return;
            },
        }           
    }
</script>