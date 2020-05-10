<template>
    <nav class="navbar navbar-dark bg-pink py-2">
        <div class="d-flex align-items-start">
            <router-link :to="{name: 'Info'}" class="mr-4"><i class="hover fas fa-info fa-1x"></i></router-link>
            <router-link :to="{name: 'Notes'}"><i class="hover fas cl-green fa-money-check-alt fa-2x mr-4"></i></router-link>
            <router-link :to="{name: 'Statistic'}"><i class="hover fas fa-poll fa-2x"></i></router-link>
        </div>
        
        <router-link to="profil"><i class="hover fas fa-user-circle fa-2x cl-green mr-1"></i><i @click="logOut" class="fas fa-times-circle"></i></router-link>
    </nav>
</template>

<script>
export default {
    methods: {
        logOut(){
            localStorage.removeItem('user-token');
            this.$store.state.token = false;
            this.$store.state.errors = 'Vous êtes maintenant déconnecté.';
        }
    }
}
</script>

<style scoped>
a {
    height: 1.8rem;
}

.navbar {
    padding: 0.2rem 1rem;
}

.px-5 {
    padding-left: 4.5rem!important;
}

.fa-1x {
    color: white;
    font-size: 1.8rem;
}

.fa-2x {
    color: white;
    font-size: 1.9rem;
}

.fa-times-circle {
    transition: all ease 400ms;
    color: rgb(0, 0, 0);
}
.fa-times-circle:hover {
    color: rgb(255, 255, 255);
}

.fa-poll {
    color: rgb(4, 216, 253);
}
</style>