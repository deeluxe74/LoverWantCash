<template>
  <div>
    <display-message class="ml-3 index-2" :errors="errors" :success="success"></display-message>
    <login v-if="!user" class="height-100"></login>
    <div v-else class="bg-grey">
      <nav-bar class="index-1"></nav-bar>
      <is-ios-message v-if="isIos"></is-ios-message>
      <transition name="fade" mode="out-in" appear>
        <router-view class="height index-0"></router-view>     
      </transition>
    </div>
  </div>
</template>

<script>
import Login from './components/Login';
import NavBar from './shares/components/NavBar';
import DisplayMessage from './shares/components/DisplayMessage';
import isIosMessage from './shares/components/isIosMessage';

export default {
  components: {
    Login,
    NavBar,
    DisplayMessage,
    isIosMessage
  },
  data(){
    return {
      load: true,
      isIos: false,
    }
  },
  computed: {
        success: function(){
          return this.$store.state.success;
        },
        errors: function(){
          return this.$store.state.errors;
        },
        user: function(){
          return this.$store.state.token;
        }
  },
  created(){
    this.isIos = false;
    const isIos = window.localStorage.getItem('isIos');
    if(isIos == 'true'){
      this.isIos = true;
    }
  }
}
</script>

<style>
body {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-size: 22px;
  font-family: 'Montserrat', sans-serif;
}
html {
  font-size: 22px;
  overflow: scroll;
  overflow-x: hidden;
  font-family: 'Montserrat', sans-serif;
}

::-webkit-scrollbar {
width: 0px; 
}

h1 {
  margin: 0;
  font-weight: 800;
  font-size: 2rem;
  font-family: 'Mali', cursive;
  color: white;
}

h2 {
  margin: 0;
  font-size: 1.4rem;
  color: white;
  font-weight: 100;
  font-family: 'Montserrat', sans-serif;
}


h3 {
  line-height: 1.6;
  margin: 0;
  color: white;
  font-weight: 500;
  font-size: 1rem;
  font-family: 'Mali', cursive;
}

h4 {
  line-height: 1.6;
  font-size: 0.8rem;
  color: white;
  font-weight: 500;
  font-family: 'Mali', cursive;
}

p {
  font-size: 0.7rem;
  font-weight: 200;
  color: white;
  text-align: justify;
  font-family: 'Mali', cursive;
}

input {
  border-radius: 5px;
  font-size: 0.8rem;
}

.height {
  min-height: 93vh;
}

.height-100 {
  min-height: 100vh;
}

.align-center {
  text-align: center;
}

.hover:hover {
  cursor: pointer;
  opacity: 0.8;
}

.hover-reverse:hover {
  cursor: pointer;
  opacity: 1;
}

.bg-black {
  background-color: #070707;
}
.bg-pink {
  background-color: #D20259;
}
.bg-grey {
  background-color: #323232;
}
.bg-white {
  background-color: #ffffff;
}
.bg-gold {
  background-color: #ffd700 !important;
}
.bg-green {
  background-color: #85BB65 !important;
}
.bg-blue {
  background-color: #52ABBF !important;
}
.bg-red {
  background-color: #f00101 !important;
}
.bg-elect {
  background-color: #ff5e00 !important;
}
.bg-cours {
  background-color: #1edb05 !important;
}

.cl-black{
  color: #000000 !important;
}
.cl-white{
  color: white !important;
}
.cl-green {
  color: #85BB65 !important;
}
.cl-blue {
  color: #52ABBF !important;
}
.cl-pink {
  color: #D20259 !important;
}
.cl-orange {
  color: #ff5e00 !important;
}

.spinner-border {
  margin-top: 80px;
  color: white!important;
}

.vdp-datepicker .input-group input {
  max-width: 90vw;
}

/* ANIMATE  */

.index-0 {
  z-index: 0;
}
.index-1 {
  z-index: 1;
}
.index-2 {
  z-index: 2;
}

.fade-enter-active, .fade-leave-active {
  transition: all 400ms ease-out;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  filter: blur(20px);
  opacity: 0;
}

@media screen and (min-width: 1200px) {
  body {
    font-size: 25px;
  }

  html {
    font-size: 25px;
  }
}

@media screen and (max-width: 400px) {
  body {
    font-size: 20px;
  }

  html {
    font-size: 20px;
  }
}
</style>