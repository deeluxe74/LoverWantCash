import Notes from './components/Notes';
import Profil from './components/Profil';
import Info from './components/Info';
import Statistic from './components/Statistic';


export const routes = [
    {
        path:'/',
        name: 'Notes',
        component: Notes
    },
    {
        path:'/Profil',
        name: 'Profil',
        component: Profil
    },
    {
        path:'/Info',
        name: 'Info',
        component: Info
    },
    {
        path:'/Statistic',
        name: 'Statistic',
        component: Statistic
    }
]

