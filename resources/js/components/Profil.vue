<template>
    <div class="bg-grey align-center pt-3" v-if="load">
        <h1 class="mb-3">{{ user.name.toUpperCase() }}</h1>
        <h3 class="bg-pink py-2">Email</h3>
        <h4>{{ user.email }}</h4>

        <h3 class="bg-pink py-2">Nombre de Notes</h3>
        <h4>{{ note }}</h4>

        <h3 class="bg-pink py-2">Secret pass</h3>
        <h4>{{ user.secret_pass }}</h4>

        <div v-if="nameLover" class="mt-4 pb-4">
            <i class="fas fa-heart fa-5x"></i>
            <h3 class="my-2">{{ nameLover }}</h3>
        
            <button @click="loverDelete" class="mt-1 btn btn-danger">Me délier</button>
        </div>
        <div v-else class="mt-4 pb-4">
            <i @click="showAdd = !showAdd" class="fas fa-heart-broken hover fa-4x"></i>
            <form @submit.prevent="sendLove" enctype="multipart/form-data" action="api/login">
                <h4 v-if="showAdd">Entrer le secret pass de la personne avec qui vous souhaitez vous liez</h4>
                <input v-if="showAdd" v-model="secret" type="text" class="form-control" required> 
                <button v-if="showAdd" type="submit" class="btn btn-success mt-2">Me lier</button>
            </form>
        </div>
  </div>
    <div v-else>
        <div class="spinner-border text-danger" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            user: null,
            note: null,
            load: false,
            secret: null,
            showAdd: false,
            nameLover: null,
        }
    },
    methods: {
        sendLove(){
            if(this.user.lover_id == null) {
                axios.post(`api/profil/sendLove`, {
                token: this.$store.state.token,
                secret: this.secret
                })
                .then((response)=> {
                    if(response.data.asErrors){
                        this.$store.state.errors = response.data.message;
                    }else {
                        this.$store.state.success = response.data.message;
                        this.nameLover = response.data.nameLover;
                    }
                })
            }else {
                this.$store.state.errors = 'Il semble que tu soit déja liée a une personne';
            }
            
        },
        loverDelete(){
            axios.post(`api/profil/loverDelete`, {
                token : this.$store.state.token,
            })
            .then((response)=> {
                this.$store.state.success = response.data.message;
                this.nameLover = false;
            })
        }
    },
    created(){
        axios.post(`api/get`,  {
            token: this.$store.state.token,
        })
        .then((response) => {
            this.user = response.data.user;
            this.note = response.data.note.length;
            if(response.data.nameLover){
                this.nameLover = response.data.nameLover;
            }
            this.load = true;
        })
    }
}
</script>

<style scoped>
h2 {
    font-weight: 700;
}

h3 {
    font-size: 1.2rem;
}

h4 {
    font-family: 'Montserrat', sans-serif;
    font-size: 0.9rem;
    margin: 0.9rem 0;
    font-weight: 300;
}

span {
    color: white;
    font-size: 1rem;
    font-weight: 200;
}

.btn-danger {
    font-size: 0.8rem;
    background-color: #e91b14;
}

.form-control {
    margin: 10px 0;
}

.hover:hover {
    color: gold;
}

.fa-heart {
    color: rgb(219, 0, 11);
}
.fa-heart-broken {
    transition: all 500ms ease-out;
    animation: wing infinite 1.2s ease-out;
    color: rgb(219, 0, 11);
}

@keyframes wing {
    0% {opacity: 1;}
    30%{opacity: 0.4;}
    100% {opacity: 1;}
}
</style>