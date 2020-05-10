<template>
  <div>
      <div class="bg-grey h-50 pl-4 py-3">
        <h1>Connexion</h1>
        <form @submit.prevent="login" enctype="multipart/form-data" action="api/login">
          <h2>Email</h2>
          <input v-model="logEmail" type="email" class="form-control">
          <h2>Pass</h2>
          <input v-model="logPass" type="password" class="form-control">
          <div class="align">
            <button type="submit" class="btn btn-success my-3">Connecter</button>
          </div>
        </form>
        
      </div>

      <div class="bg-pink h-50 pl-4 py-3">
        <h1 class="cl-black">Inscription</h1>
        <form @submit.prevent="signUp" enctype="multipart/form-data" action="api/signUp">
          <h2>Email</h2>
          <input v-model="email" required type="email" class="form-control">
          <h2>Prénom</h2>
          <input maxlength="12" v-model="name" required type="text" class="form-control">
          <div class="d-flex flex-row">
            <div>
              <h2>Pass</h2>
              <input v-model="pass" required minlength="5" type="password" class="form-control">
            </div>
            <div>
              <h2>Confirm</h2>
              <input v-model="pass2" required minlength="5" type="password" class="form-control">
            </div>
          </div>
          <div class="align">
            <button type="submit" class="btn btn-success my-3">S'inscrire</button>
          </div>
        </form>
        
      </div>
  </div>
</template>

<script>
export default {
  data(){
    return {
      name: null,
      email: null,
      pass: null,
      pass2: null,
      logPass: null,
      logEmail: null
    }
  },
  methods: {
    signUp(){
      if(this.pass === this.pass2){
        axios.post(`api/signUp`, {
          name: this.name,
          email: this.email,
          pass: this.pass
        })
        .then((response) => {
          this.$store.state.errors = false;
          this.$store.state.success = 'Félicitation vous êtes maintenant inscrit !';
          window.scroll(0,0);
          this.name = null; this.email = null; this.pass = null; this.pass2 = null;
        })
      }else {
        this.$store.state.success = false;
        this.$store.state.errors = 'Les mots de passes ne sont pas identique.';
      }
    },
    login(){
      axios.post(`api/login`, {
        email: this.logEmail,
        password: this.logPass
      })
      .then((response) => {
        if(response.data.asErrors){
          this.$store.state.success = false;
          this.$store.state.errors= response.data.message;
        }else {
          this.$store.state.errors = false;
          this.$store.state.success = response.data.message;
          // Création du token de recupération compte
          this.$store.state.token = response.data.token;
          localStorage.setItem('user-token', response.data.token);
          //Send the Load Screen
          this.$router.push({ name: 'Notes' });
        }
      })
    }
  }
}
</script>

<style scoped>
h1 {
  margin-bottom: 20px;
}

h2 {
  margin-top: 0.5rem;
  color: white;
}

.align {
  text-align: center;
  width: 85%;
}

.form-control {
  width: 85%;
}

.h-50 {
  min-height: 50vh;
}
</style>