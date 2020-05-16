<template>
    <div class="bg-grey py-3 align-center" v-if="allNotes.length >= 1">
        <div class="mb-5">
            <div class="mb-3 bg-white p-2">
                <h2 class="cl-black">{{ nameCount }} doit {{ count }}</h2>
            </div>
            <div class="d-flex justify-content-end" v-if="currUser.lover_id">
                <button v-if="countMonth" @click="totalCount(notes, '€ ce mois')" class="btn btn-info btn-all">Dette pour ce mois</button>
                <button v-if="!countMonth" @click="totalCount(allNotes, '€ en total')" class="btn btn-info btn-all">Dette depuis le début</button>
            </div>
            
            
            <div v-if="!changMonth" class="d-flex flex-row justify-content-center my-2"><h3>{{ month }}</h3><h4 class="ml-2">{{ selectYear }}</h4><i @click="changMonth = !changMonth" class="hover fas fa-edit cl-white mt-2 ml-2"></i></div>
            <div v-if="changMonth" class="d-flex flex-row justify-content-center">
                <select v-model="month" class="form-control mr-2">
                    <option>Janvier</option>
                    <option>Février</option>
                    <option>Mars</option>
                    <option>Avril</option>
                    <option>Mai</option>
                    <option>Juin</option>
                    <option>Juillet</option>
                    <option>Août</option>
                    <option>Septembre</option>
                    <option>Octobre</option>
                    <option>Novembre</option>
                    <option>Décembre</option>
                </select>
                <select v-model="selectYear" class="form-control mr-2">
                    <option v-for="year in years + 1" v-if="year > 2018" :key="'years' + year">{{ year }}</option>
                </select>
                <i @click="changeDate" class="hover fas fa-check-circle cl-green fa-2x"></i>
            </div>
            <div v-if="!load" class="d-flex flex-column align-items-center">
                <div v-for="(note, index) in notes" class="note mb-2" :key="'notes' + index">
                    <h4 class="date mb-1 cl-black">{{ note.date }}</h4>
                    <div :class="currUser.id == note.id_user ? 'bg-pink' : 'bg-white'" class="note-badge badge d-flex flex-row justify-content-between align-items-center">
                    
                        <i v-if="note.designation == 'Electricité'" class="icone fas fa-bolt fa-2x"></i>
                        <i v-if="note.designation == 'Eau'" class="icone fas fa-tint cl-blue fa-2x"></i>
                        <i v-if="note.designation == 'Course'" class="icone fas fa-shopping-cart cl-gold fa-2x"></i>
                        <i v-if="note.designation == 'Réparation'" class="icone fas fa-tools cl-orange fa-2x"></i>
                        <i v-if="note.designation == 'Voiture'" class="icone fas fa-car-crash cl-green fa-2x"></i>
                        <i v-if="note.designation != 'Electricité' && note.designation != 'Eau' && note.designation != 'Course' && note.designation != 'Réparation' && note.designation != 'Voiture'" class="icone fas fa-question cl-blue fa-2x"></i>

                        <h3 class="cl-black designation">{{ note.designation }}</h3>
                        <h3 class="price">{{ note.prix }}€</h3>
                        <i @click="deleteNote(note)" :class="currUser.id == note.id_user ? 'cl-white' : ''" class="fas fa-times-circle fa-1x hover"></i>
                    </div>
                </div>
                <div v-if="notes.length == 0">
                    <h4 class="mx-3 mt-2 infos message-info">Aucune note n'ai disponible pour ce mois. Tu peut en ajouté ou choisir un autre mois.</h4>
                </div>
            </div>
            <div v-if="load" class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <new-note></new-note>
    </div>

    <div class="bg-grey py-3 align-center" v-else>
        <h3 class="welcome my-4">Bienvenue dans <span>LoverWantCash</span></h3>
        <h4 class="mb-3 infos">Tu peut consulter toutes les informations en allant sur l'icone info de l'application</h4>
        <h4 class="mx-3 infos message-info">Pour le moment aucune note est enregistré !</h4>
        <new-note></new-note>
    </div>
</template>

<script>
import NewNote from './NewNote';
import { EventBus } from '../event-bus.js';

export default {
    components: {
        NewNote
    },
    data(){
        return {
            currMonth: null,
            notes: [],
            allNotes: [],
            month: null,
            years: null,
            selectYear: null,
            changMonth: false,
            load: true,
            currUser: null,
            
            nameCount: null,
            countMonth: true,
            count: null,
            countUser: null,
            countLover: null
        }
    },
    methods: { 
        getMonth(){
            let curr = new Date;
            this.years = curr.getFullYear();
            this.selectYear = this.years;
            let date = curr.toLocaleDateString("fr-EU");
            this.currMonth = date[3] + date[4];
            this.getMonthLetter(this.currMonth);
        },
        getMonthLetter(index){
            if(index == '01'){this.month = 'Janvier';}
            else if(index == '02'){this.month = 'Février';}
            else if(index == '03'){this.month = 'Mars';}
            else if(index == '04'){this.month = 'Avril';}
            else if(index == '05'){this.month = 'Mai';}
            else if(index == '06'){this.month = 'Juin';}
            else if(index == '07'){this.month = 'Juillet';}
            else if(index == '08'){this.month = 'Août';}
            else if(index == '09'){this.month = 'Septembre';}
            else if(index == '10'){this.month = 'Octobre';}
            else if(index == '11'){this.month = 'Novembre';}
            else if(index == '12'){this.month = 'Déxembre';}
        },
        getMonthNumber(index){
            if(index == 'Janvier'){this.currMonth = '01';}
            else if(index == 'Février'){this.currMonth = '02';}
            else if(index == 'Mars'){this.currMonth = '03';}
            else if(index == 'Avril'){this.currMonth = '04';}
            else if(index == 'Mai'){this.currMonth = '05';}
            else if(index == 'Juin'){this.currMonth = '06';}
            else if(index == 'Juillet'){this.currMonth = '07';}
            else if(index == 'Août'){this.currMonth = '08';}
            else if(index == 'Septembre'){this.currMonth = '09';}
            else if(index == 'Octobre'){this.currMonth = '10';}
            else if(index == 'Novembre'){this.currMonth = '11';}
            else if(index == 'Déxembre'){this.currMonth = '12';}
        },
        changeDate(){
            this.getMonthNumber(this.month);
            this.getNotes();
            this.changMonth = false; 
        },
        getNotes(){
            this.notes = [];
            const date = this.currMonth + '/' + this.years;
            axios.post(`api/getNote`, {
                date: date,
                token: this.$store.state.token
            })
            .then((response) => {
                let notes = response.data.notes;
                this.allNotes = response.data.allNotes;
                notes.forEach(note => {
                    if(note.date[3] + note.date[4] == this.currMonth){
                        this.notes.push(note);
                    }
                });
                //Get notes in good order
                this.notes.sort(function(a,b) {return (a.date > b.date) ? 1 : ((b.date > a.date) ? -1 : 0);} )
                //Delete the same date
                let oldDate ;
                this.notes.forEach(note => {
                    if(oldDate){
                        if(oldDate == note.date){
                            oldDate = note.date;
                            note.date = null;
                        }else {
                            oldDate = note.date;
                        }
                    }else {
                        oldDate = note.date;
                    }
                    
                });
                this.currUser = response.data.user;
                this.userLover = response.data.userLover;
                this.totalCount(this.notes, '€ ce mois');
            })
            .then(()=> { this.load = false; })
        },
        totalCount(notes, string){
            //Check if user is lied / Is not say it
            if(this.currUser.lover_id){
                this.countMonth = !this.countMonth;
                this.count = null;
                this.countUser = null;
                this.countLover = null;
                notes.forEach(note => {
                    if(note.id_user == this.currUser.id){
                        this.countUser += parseFloat(note.prix);
                    }else {
                        this.countLover += parseFloat(note.prix);
                    }
                    if(this.countUser > this.countLover){
                        this.count = ((this.countUser - this.countLover)/2) + string;
                        this.nameCount = this.userLover.name.toUpperCase();
                    }else {
                        this.count = ((this.countLover - this.countUser)/2) + string;
                        this.nameCount = this.currUser.name.toUpperCase();
                    }   
                });
            }else {
                this.nameCount = this.currUser.name.toUpperCase();
                this.count = 'se liée pour profiter des fonctionnalités.';
            }
        },
        deleteNote(note){ 
            if(this.currUser.id == note.id_user){
                axios.post(`api/deleteNote`, {
                    id : note.id
                })
                .then((response) => {
                    this.$store.state.success = response.data.message;
                    this.getNotes();
                })
            }else {
                this.$store.state.errors = 'Vous pouvez seulement supprimé vos notes !'
            }
        }
    },
    created(){
        this.getMonth();
        this.getNotes(); 
        EventBus.$on('sendNote', event => {
            setTimeout(() => {
                this.getNotes();  
            }, 300);
            
        });
    }

}
</script>

<style scoped>
h2 {
    font-size: 1.2rem;
}

h3 {
    font-size: 1.4rem;
}

span {
    border-radius: 5px;
    padding: 0.3rem 0.5rem;
    background-color: #D20259;
    color: white;
}

.message-info {
    font-weight: 500 !important;
    border-radius: 5px;
    padding: 0.3rem 0.5rem;
    background-color: #D20259;
    color: white;
}

.infos {
    font-family: 'Montserrat', sans-serif;
    font-weight: 300;
}

.btn-all {
    font-size: 0.8rem;
}

.fa-times-circle {
    color: rgb(206, 2, 2);
}

.fa-bolt {
    color: #008CDA;
}

.note {
    width: 90vw;
}

.note-badge {
    height: 8vh;
}



.date {
    text-align: left;
}

.icone {
    position: absolute;
    left: 10vw;
}

.designation {
    left: 25vw;
    position: absolute;
    font-weight: 300;
    font-size: 1.1rem;
}

.price {
    position: absolute;
    right: 19vw;
    color: #85BB65;
    font-size: 1rem;
    font-weight: 600;
    font-family: 'Montserrat', sans-serif;
}

.fa-times-circle {
    position: absolute;
    right: 8vw;
}

.fa-edit  {
    font-size: 0.7rem;
}

.fa-1x {
    font-size: 1rem;
}

.fa-2x {
    font-size: 1.5rem;
}

.form-control {
    width: 30vw;
}

.spinner-border {
    margin-top: 5rem;
    color: rgb(255, 255, 255);
}


</style>