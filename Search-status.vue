<template>
    <div>
        <div class="search-box align-items-center">
            <h1>Tìm kiếm trạng thái</h1>
            <!-- <input type="text" class="search-bar" placeholder="Search..." v-model="search"
                @keyup.enter="searchStatusBook()" /> -->
            <!-- {{ text }} -->
            <div class="input-group-prepend">
                <button class="btn btn-primary" type="button" @click="searchStatusBook()">Search</button>
            </div>

            <!-- <ul class="list-unstyled" v-for="(book, index) in books":key="book.id"></ul> -->
        </div>
        <div class="dropdown">
            Trạng thái:
            <!-- <div class="dropdown-chosen">{{sach.tentheloai}}</div> -->
            <input class="chosetext" v-model="search" readonly="readonly">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                trangthai
            </button>
            <div class="dropdown-content">
                <div class="dropdown-item" v-for="trangthai in listTrangThai" v-bind:key="trangthai.id"
                    @click="search=trangthai.tentrangthai">
                    {{ trangthai.tentrangthai }}
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div v-if="showsearch==true">
                <div class="row">
                    <div class="borrowform" v-for="book in books" v-bind:key="book.id">
                        <div class="row">
                            <div class="list-cell msize">{{ book.tensach }}</div>
                            <div class="list-cell msize">{{ book.tentrangthai }}</div>
                        </div>
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
    data: function () {
        return {
            search: '',
            showsearch: false,
            books: [],
            listTrangThai: []
            
        }
    },

    mounted (){
        axios.get('http://127.0.0.1:8000/api/gettrangthai')
            .then(response => {
                this.listTrangThai = response.data
            })
    },

    methods: {
        searchStatusBook: function () {
            // console.log("searching ...")
            if (this.search.trim().length === 0){
                return
            }

            let params = {
                'q': this.search
            }
            console.log(params)
            axios.post('http://127.0.0.1:8000/api/status', params)
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




.dropdown {
    position: relative;
    display: inline-block;
    text-align: left;
    margin-bottom: 10px;
}

.dropdown-chosen {
    border: 1px solid black;
    padding: 2px;
    color: black;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    height: 90px;
    box-shadow: 0px 8px 10px black;
    padding: 5px 5px;
    z-index: 1;
    overflow: auto;
}

.dropdown-item:hover {
    background-color: cornflowerblue;
    color: white;
}

.dropdown:hover .dropdown-content {
    display: block;
}
.choosetext{
    width: 400px;
}

.choosereader {
    width: 250px;
}

.chooseid {
    width: 140px;
    text-align: center;
}
.wrapper {
    padding-bottom: 75px;
}
</style>