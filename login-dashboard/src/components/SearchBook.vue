<template>
    <div class="wrapper">
        <router-link to="/dashboard/searchbook">Tìm theo tên</router-link>|
        <router-link to="/dashboard/searchstatus">Tìm theo trạng thái</router-link>
        <div class="search-box align-items-center">
            <h1>Tìm kiếm sách</h1>
            <input type="text" class="search-bar" placeholder="Search..." v-model="search"
                @keyup.enter="searchBook()" />
            <!-- {{ text }} -->
            <div class="input-group-prepend">
                <button class="btn btn-primary" type="button" @click="searchBook()">Search</button>
            </div>

            <!-- <ul class="list-unstyled" v-for="(book, index) in books":key="book.id"></ul> -->
        </div>
        <div class="col-md-8">
            <div v-if="showsearch==true" class="font-smaller">
                <div class="list-cell label xlsize">Tên sách</div>
                <div class="list-cell label msize">Trạng thái</div>
                <div class="list-cell label lsize">Lĩnh vực</div>
                <div class="list-cell label lsize">Ngành</div>
                <div class="list-cell label xlsize">Nhà xuất bản</div>
                <div class="list-cell label lsize">Tác giả</div>
                <div class="list-cell label msize">Thể loại</div>

                <div class="borrowform" v-for="book in books" v-bind:key="book.id">
                    <div class="row">
                        <div class="list-cell xlsize">{{ book.tensach }}</div>
                        <div class="list-cell msize" >{{ book.tentrangthai }}</div>
                        <div class="list-cell lsize">{{ book.tenlinhvuc }}</div>
                        <div class="list-cell lsize">{{ book.tennganh }}</div>
                        <div class="list-cell xlsize">{{ book.tennxb }}</div>
                        <div class="list-cell lsize">{{ book.tentacgia }}</div>
                        <div class="list-cell msize">{{ book.tentheloai }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
// import func from 'vue-editor-bridge'
import axios from 'axios'
// import { response } from 'express'
export default {
    name: 'Search-book',
    data: function() {
        return {
            search: '',
            showsearch: false,
            books: []
        }
    },

    methods: {
        searchBook : function (){
            // console.log("searching ...")
            // if (this.text.trim().length === 0){
            //     return
            // }

            let params ={
                'q': this.search
            }
            console.log(params)
            axios.post('http://localhost:8000/api/search', params)
                // .then(res => res.json())
                .then(res => {
                    this.books = res.data
                    this.search = ''
                    this.showsearch = true
                    // console.log(response.data.data)
                })
                .catch(err => {
                    console.log(err)
                })
            // console.log(par/ams)
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

.font-smaller{
    font-size: smaller;
}

.ssize{
    width: 65px;
}

.msize{
    width: 140px;
}

.lsize{
    width: 150px;
}

.xlsize{
    width: 250px;
}

/* .input-group-prepend {
    display: flex;
    align-items: center;
    padding: $input-padding-y $input-padding-x;
    margin-bottom: 0; 
    font-size: $font-size-base; // Match inputs
    font-weight: $font-weight-normal;
    line-height: $input-line-height;
    color: $input-group-addon-color;
    text-align: center;
    white-space: nowrap;
    background-color: $input-group-addon-bg;
    border: $input-border-width solid $input-group-addon-border-color;
    @include border-radius($input-border-radius);
    
} */
</style>