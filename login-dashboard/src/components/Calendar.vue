<template>
<div class="calendar">
    <span @click="ngay.y--, setdrange()">◀</span> Năm {{ ngay.y }} <span @click="ngay.y++, setdrange()">▶</span><br>
    <span @click="prevmonth()">◀</span> Tháng {{ ngay.m }} <span @click="nextmonth()">▶</span><br>
    <div class="days">
        <div class="dayofweek cell">CN</div>
        <div class="dayofweek cell">T2</div>
        <div class="dayofweek cell">T3</div>
        <div class="dayofweek cell">T4</div>
        <div class="dayofweek cell">T5</div>
        <div class="dayofweek cell">T6</div>
        <div class="dayofweek cell">T7</div>
        <div class="cell" v-if="first!=0" v-for="pad in first">_</div>
        <div class="choosable cell" v-bind:class="{chosen: item==ngay.d}" v-for="item in drange" @click="ngay.d=item">{{ item }}</div>
        <div class="cell" v-if="last!=6" v-for="pad in 6-last">_</div>
    </div>
</div>
</template>

<script>
export default{
    name: 'Calendar',
    props: ['ngay'],
    data(){
        return{
            drange: 31,
            first: 0,
            last: 0
        }
    },

    mounted(){
        this.first = new Date(this.ngay.y+'-'+this.ngay.m+'-'+'1').getDay()
        this.last = new Date(this.ngay.y+'-'+this.ngay.m+'-'+this.drange).getDay()
    },

    methods: {
        setdrange(){
            this.ngay.d=1
            const year=this.ngay.y
            const month=this.ngay.m
            const month31=[1, 3, 5, 7, 8, 10, 12]
            const month30=[4, 6, 9, 11]
            if(month31.includes(month)) this.drange=31
            else if(month30.includes(month)) this.drange=30
            else if(year%4==0 && year%100!=0) this.drange=29
            else this.drange=28
            this.first = new Date(this.ngay.y+'-'+this.ngay.m+'-'+'1').getDay()
            this.last = new Date(this.ngay.y+'-'+this.ngay.m+'-'+this.drange).getDay()
        },
        
        prevmonth(){
            this.ngay.m--
            if(this.ngay.m<1) { this.ngay.m=12; this.ngay.y-- }
            this.setdrange()
        },

        nextmonth(){
            this.ngay.m++
            if(this.ngay.m>12) { this.ngay.m=1; this.ngay.y++ }
            this.setdrange()
        },
    }
}
</script>

<style scoped>
.calendar{
    text-align: center;
    max-width: 270px;
    white-space: initial;
    cursor: context-menu;
}

.calendar span{
    font-size: larger;
}

.calendar span:hover{
    color:white;
    text-shadow: 0 0 15px red;
}

.days{
    font-size: 0;
}

.cell{
    font-size: medium;
    width: 35px;
    height: 20px;
    margin: 1px;
    display: inline-block;
}

.dayofweek{
    font-weight: bolder;
    background-color: yellow;
}

.choosable:hover{
    background-color:aquamarine;
}

.chosen{
    background-color: teal;
    color: white;
}
</style>