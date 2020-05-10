<template>
    <div :class="close ? 'up' : 'bottom'" class="message-ios">
        <div v-if="!close" class="bg-blue raduis-top">
            <div class="d-flex flex-row justify-content-center">
                <i class="fas fa-plus-square fa-2x cl-white"></i>
                <h2 class="ml-1">Installer l'application !</h2>
                <i @click="close = !close" class="fas fa-window-close fa-2x hover"></i>
            </div>
            <p class="mt-2 align-center">Il te suffit de cliquer sur le bouton partage <i class="fas fa-external-link-alt"></i> puis sélectionner "Ajouter a l'écran d'accueil". Alors pas compliqué ? </p>
        </div>

        <div v-else>
            <div @click="close = !close" class="raduis bg-blue align-center py-1 px-2">
                <h2 class="install-app">Installer Application</h2>
                <i class="fas fa-download hover cl-white"></i>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            close: false,
        }
    },
}
</script>

<style scoped>
.message-ios {
    position: fixed;
    z-index: 100;
}

.bottom {
    bottom: 0vh;
}

.up {
    bottom: 20vh;
}

h2 {
    font-size: 0.8rem;
    font-weight: 500;
}

p  {
    margin: 0 0 5px 0;
    font-size: 0.6rem;
    font-weight: 200;
}

.raduis-top {
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}

.raduis {
    border-radius: 5px;
}

.bg-blue {
    padding: 0.3rem 0.5rem;
}

.fa-2x {
    font-size: 1.1rem;
}

.install-app {
    font-size: 0.6rem;
}

.fa-download {
    font-size: 0.5rem;
}

.fa-window-close {
    position: absolute;
    right: 5px;
    color: red;
    opacity: 1;
}
</style>