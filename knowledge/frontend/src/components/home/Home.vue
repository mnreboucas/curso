<template>
    <div class="home">
        <PageTitle icon="fa fa-home" main="Dashboard"
            sub="Base de Conhecimento" />
        <div class="stats">
            <Stat title="Categorias" :value="totalUsers"
                icon="fa fa-folder" color="#d54d50" />
            <Stat title="Artigos" :value="totalUsers"
                icon="fa fa-file" color="#3bc480" />
            <Stat title="Usuários" :value="totalUsers"
                icon="fa fa-user" color="#3282cd"  />
        </div>
    </div>
</template>

<script>
    import PageTitle from '../template/PageTitle'
    import Stat from './Stat'
    import { http } from '@/global'

    export default {
        name: 'Home',
        components: { PageTitle, Stat },
        data: function() {
            return {
                totalUsers: 0
            }
        },
        methods: {
            getStats() {
                http.get('/users/stats').then(r => this.totalUsers = r.data['hydra:member'][0])
            }
        },
        mounted() {
            this.getStats()
        }
    }
</script>

<style>
    .stats {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }
</style>