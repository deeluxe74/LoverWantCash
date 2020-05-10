<template>
    <div class="bg-grey">
        <div @click="show = !show" :class="show ? 'bg-pink-opacity hover-reverse animate' : 'bg-pink animate-note hover'" class="py-2 align-center ">
            <h1>Note <i class="fas fa-plus-square cl-green"></i></h1>     
        </div>
        <div v-if="show" class="px-3 py-3">
            <form @submit.prevent="sendNote" enctype="multipart/form-data" action="api/login">
                <div>
                    <h2>Date</h2>
                    <date-picker v-model="date" :language="fr" :bootstrap-styling="true" :value="date"></date-picker>
                </div>
                <h2 class="mt-2">Catégorie</h2>
                <select v-model="designation" class="form-control">
                    <option>Electricité</option>
                    <option>Eau</option>
                    <option>Course</option>
                    <option>Voiture</option>
                    <option>Réparation</option>
                    <option>Autres</option>
                </select>
                <input v-model="designationAutres" placeholder="Préciser ..." v-if="designation == 'Autres'" type="text" class="form-control mt-2" required>
                <div class="mr-3">
                    <h2 class="mt-2">Prix</h2>
                    <input v-model="prix" type="number" class="form-control" required>
                </div>
                <div class="align-center mt-3">
                    <button type="submit" class="btn bg-pink cl-white my-3">Envoyer</button>
                </div>
            </form>
            
        </div>
    </div>
</template>

<script>
import DatePicker from 'vuejs-datepicker';
import { fr } from 'vuejs-datepicker/dist/locale'
import { EventBus } from '../event-bus.js';

export default {
    components: {
        DatePicker
    },
    data(){
        return {
            fr: fr,
            show: false,
            designation: null,
            designationAutres: null,
            prix: null,
            date: null,
        }
    },
    methods: {
        sendNote(){
            EventBus.$emit('sendNote', 'notes envoyer.');
            if(this.designation == 'Autres'){
                this.designation = this.designationAutres;
            }
            axios.post(`api/newNote`,{
                designation: this.designation,
                prix: this.prix,
                date: this.date.toLocaleDateString("fr-EU"),
                token: this.$store.state.token,
            })
            .then((response)=> {
                this.show = false;
                this.$store.state.errors = false;
                this.$store.state.success = response.data.message;
                this.designation = null; this.prix = null; this.designationAutres = null; this.date = new Date();
            })
        }
    },
    created(){  
        this.date = new Date();
        this.currDate = this.date.toLocaleDateString("fr-EU");    
    }
}
</script>

<style scoped>

h1 {
    font-family: 'Montserrat', sans-serif;
    font-size: 1.3rem;
    font-weight: 300;
}

h2 {
    margin-bottom: 10px;
    font-weight: 200;
    font-size: 1.2rem;
}

.form-control {
    width: 90vw;
}

.bg-grey {
    position: fixed;
    bottom: 0;
    width: 100vw;
    background-color: rgba(37, 35, 35, 0.95);
}

.bg-pink-opacity {
    background-color: rgba(210, 2, 89, 0.8);
}

.hover-reverse:hover {
    background-color: rgba(210, 2, 89, 1);
}

.btn {
    opacity: 0.7;
}
.btn:hover {
    opacity: 1;
    color: white;
}

.height {
    height: 90vh;
}

.animate {
    transition: all 400ms ease-out;
}

.animate-note {
    transition: all 400ms ease-out;
}
.animate-note:hover {
    transform: scale(1.2);
    opacity: 0.8;
}


</style>