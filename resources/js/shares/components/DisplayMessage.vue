<template>
    <div class="global">
        <transition-group name="fade">
            <div v-if="errors" key="1" class="message message-danger"><h3>{{ errors }}</h3></div>
            <div v-if="success" key="2" class="message bg-success"><h3>{{ success }}</h3></div>   
        </transition-group>
    </div>
</template>

<script>
export default {
    props: ['errors', 'success'],
    updated(){
        setTimeout(()=> {
            this.$store.state.errors = false;
            this.$store.state.success = false;
        },6000)
    }
}
</script>

<style scoped>
p {
    font-size:  1rem;
    font-weight: 800;
}

h3 {
    font-size: 0.8rem;
    font-family: 'Montserrat', sans-serif;
}

.global {
    left: 20vw;
    text-align: center;
    position: absolute;
}

.message {
    border-radius: 10px;
    transform: translateY(4vw);
    padding: 0.2rem 0.5rem;
    transition: all 1s ease-out;
}

.message-danger{
    background-color: rgb(206, 0, 27);
}

.bg-success{
    background-color: rgb(2, 204, 13);
}

.fade-enter-active, .fade-leave-active {
  transition: all 300ms;
  transform: translateY(-200px);
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}


</style>