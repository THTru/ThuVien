<template>
  <div>
    <div class="style">
      <div class="logo-glow">
        <img class="flip" src="..\assets\logo.png">
      </div><br>
      This is the HomePage
    </div>

    <!-- <div>
      <ul class="gallery">
        <li class="gallery" v-for="item in type">
          <img class="gallery" :src="require('E:/hibiki/pokemon_type/' + item + '.png')">
        </li>
      </ul>
    </div> -->
  </div>
</template>

<script>
export default {
  name: 'Home',
  data(){
        return{
            // type: ['Ma', 'Thep', 'Bang', 'Bongtoi', 'Tien', 'Nuoc', 'Lua', 'Dien', 'Giacdau', 'Contrung', 'Co', 'Rong']
        }
    },
}
</script>


<style scoped>
.gallery {
  display: flex;
  justify-content: space-around;
}

ul.gallery {
  list-style-type: none;
  padding: 0;
  display: grid;
  grid-auto-flow: row;
  grid-template-columns: repeat(4, 1fr);
}
li.gallery {
  display: inline-block;
  background-color: rgb(200, 200, 255, 0.6);
  margin: auto;
  margin-top: 20px;
  margin-bottom: 20px;
  padding: 20px 20px 20px 20px;
  border-radius: 20% 20%;
}

img.gallery {
  width: 120px;
  animation: rotation 4s infinite linear;
  border-radius: 50%;
  box-shadow: 0 0 20px blue;
}

img.gallery:hover {
  animation: none;
  box-shadow: 0 0 40px yellow;
}

@keyframes rotation {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(359deg);
  }
}
</style>

