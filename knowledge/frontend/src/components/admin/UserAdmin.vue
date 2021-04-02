<template>
    <div class="user-admin">
        <b-table hover striped :items="users" :fields="fields"></b-table>
    </div>
</template>

<script>
    import { http } from '@/global'

    export default {
        name: 'UserAdmin',
        data() {
            return {
                mode: 'save',
                user: {},
                users: [],
                fields: [
                    { key: 'id', label: 'Código', sortable: true },
                    { key: 'name', label: 'Nome', sortable: true },
                    { key: 'email', label: 'E-mail', sortable: true },
                    { key: 'admin', label: 'Administrador', sortable: true,
                        formatter: value => value ? 'Sim' : 'Não' },
                    { key: 'action', label: 'Ações'}
                ]
            }
        },
        methods: {
            // Carregar os usuários do backend
            loadUsers() {
                http.get('/users').then(r => {
                    this.users = r.data['hydra:member']
                    console.log(this.users)
                })
            }
        },
        mounted() {
            this.loadUsers()
        }
    }
</script>

<style>

</style>