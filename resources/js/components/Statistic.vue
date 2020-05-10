<template>
  <div v-if="user.lover_id">
    <div class="bg-grey align-center py-3" v-if="!load">
      <h1 class="bg-pink note-categorie my-4">Notes pour ce mois</h1>
      <div class="d-flex align-items-left ml-1">
        <button v-if="month" @click="searchNote(false), month = !month" class="btn btn-info">Toute l'Année</button>
        <button v-if="!month" @click="searchNote(true), month = !month" class="btn btn-info">Ce Mois</button>
      </div>
      <div class="donut">
        <h3>Total {{ countUser + countLover }} €</h3>
        <apexchart type="donut" :options="options" :series="series"></apexchart>
        <div class="d-flex flex-row justify-content-center my-3">
          <div class="badge bg-pink mr-2">
            <h3>{{ user.name }}</h3>
            <span class="totalUser">{{ countUser }}€</span>
          </div>
          <div class="badge bg-green">
            <h3>{{ lover.name }}</h3>
            <span class="totalUser">{{ countLover }}€</span>
          </div>
        </div>

      </div>

      <h3>Pour un total de {{ totalNote }} notes.</h3>

      <h1 class="bg-pink note-categorie my-4">Notes par catégories</h1>
      <apexchart class="mb-3 donut" type="donut" :options="optionsCategories" :series="seriesCategories"></apexchart>
      <br>
      <div class="badge bg-elect">
        <h3>Electricité</h3>
        <span class="totalUser">{{ seriesCategories[0] }}€</span>
      </div>
      <div class="badge bg-blue">
        <h3>Eau</h3>
        <span class="totalUser">{{ seriesCategories[1] }}€</span>
      </div>
      <div class="badge bg-cours">
        <h3>Course</h3>
        <span class="totalUser">{{ seriesCategories[2] }}€</span>
      </div>
      <div class="badge bg-red">
        <h3>Voiture</h3>
        <span class="totalUser">{{ seriesCategories[3] }}€</span>
      </div>
      <div class="badge bg-black">
        <h3>Réparation</h3>
        <span class="totalUser">{{ seriesCategories[4] }}€</span>
      </div>
      <div class="badge bg-pink">
        <h3>Autres</h3>
        <span class="totalUser">{{ seriesCategories[5] }}€</span>
      </div>
    </div>

    <div class="bg-grey py-3 align-center" v-else>
      <div v-if="load" class="d-flex justify-content-center">
          <div class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
          </div>
      </div>
    </div>
  </div>

  <div class="bg-grey py-3 align-center" v-else>
      <h3 class="welcome my-4">Les <strong>Statistique</strong></h3>
      <h4 class="mb-3 infos">Tu peut consulter toutes les informations en allant sur l'icone info de l'application</h4>
      <h4 class="mx-3 infos message-info">Tu doit être liée pour consulter les statistiques !</h4>
  </div>
  
</template>

<script>
export default {
  data: function() {
    return {
      options: {
        fill: {
          colors: ['#D20259', '#85BB65']
        },
        labels: [],
        dataLabels: {
          style: {
            fontSize: '1.3rem',
            fontWeight: '900',
          },
        },
        legend: {
          position: 'bottom',
          fontSize: '25px',   
        },
        chart: {
      	  sparkline: { enabled: true }
        },
        tooltip: {
          enabled: true,
        },
      },
      optionsCategories: {
        fill: {
          colors: ['#ff5e00', '#52ABBF', '#1edb05','#f00101', '#070707', '#D20259']
        },
        labels: [],
        dataLabels: {
          style: {
            fontSize: '1.3rem',
            fontWeight: '900', 
          },
        },
        legend: {
          position: 'bottom',
          fontSize: '25px',   
        },
        chart: {
      	  sparkline: { enabled: true }
        },
        tooltip: {
          enabled: true,
        },
      },
      seriesCategories: [],
      series: [],
      load: true,
      user: [],
      lover: [],
      totalNote: 0,
      month: true,
    }
  },
  created(){
    this.load = true;
    this.searchNote(true);
  },
  methods: {
    searchNote(month){
      let curr = new Date();
      let date = curr.toLocaleDateString("fr-EU");
      if(month){
        //Note per Month
        date = date.substring(3, date.length);
      }else {
        date = date.substring(6, date.length);
      }
      axios.post(`api/Statistic`, {
        token: this.$store.state.token,
        date: date
      })
      .then((response) => {
        const noteUser = response.data.noteUser;
        const noteLover = response.data.noteLover;
        this.user = response.data.user;
        this.lover = response.data.lover;

        this.totalNote = noteUser.length + noteLover.length;

        this.countUser = 0;
        this.countLover = 0;
        // Note by catégorie
        let Electricité = 0,Eau = 0,Course = 0,Voiture = 0,Réparation = 0,Autres = 0;
        const allNotes =  noteUser.concat(noteLover);
        allNotes.forEach(note => {
          if(note.designation == 'Electricité') {
            Electricité += parseFloat(note.prix);
          }else if(note.designation == 'Eau') {
            Eau += parseFloat(note.prix);
          }else if(note.designation == 'Course') {
            Course += parseFloat(note.prix);
          }else if(note.designation == 'Voiture') {
            Voiture += parseFloat(note.prix);
          }else if(note.designation == 'Réparation') {
            Réparation += parseFloat(note.prix);
          }else {
            Autres += parseFloat(note.prix);
          }
        });
        this.optionsCategories.labels = ['Electricité','Eau','Course','Voiture','Réparation','Autres'];
        this.seriesCategories = [Electricité,Eau,Course,Voiture,Réparation,Autres];
        // All note for user && lover
        noteUser.forEach(note => {
          this.countUser += parseFloat(note.prix);
        });
        noteLover.forEach(note => {
          this.countLover += parseFloat(note.prix);
        });
        this.series = [this.countUser, this.countLover];
        this.options.labels = [this.user.name, this.lover.name];
      })
      .then(() => {
        this.load = false;
      })
    }
  },
}
</script>

<style scoped>
.donut {
  width: 100vw;
  display: inline-block
}

.totalUser {
  color: rgb(234, 255, 43);
}

.note-categorie {
  font-size: 1.4rem;
  padding: 0.5rem 0;
}

.badge {
  width: 150px;
}


strong {
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

.btn-info {
  font-size: 0.8rem;
  padding: 0.3rem 0.5rem;
  margin-bottom: 10px;
}

@media screen and (min-width: 600px){
  .donut{
    width: 40vw;
  }
}
</style>