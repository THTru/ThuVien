<template>
    <div>
        <div class="search-box align-items-center">
            <h1>Tìm kiếm trạng thái</h1>
            <input type="text" class="search-bar" placeholder="Search..." v-model="search"
                @keyup.enter="searchStatusBook()" />
            <!-- {{ text }} -->
            <div class="input-group-prepend">
                <button class="btn btn-primary" type="button" @click="searchStatusBook()">Search</button>
            </div>

            <!-- <ul class="list-unstyled" v-for="(book, index) in books":key="book.id"></ul> -->
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
            books: []
        }
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