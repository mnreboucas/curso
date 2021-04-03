<template>
    <div class="user-admin">
        <b-form>
            <input id="user-id" type="hidden" v-model="user.id" />
            <b-row>
                <b-col md="6" sm="12">
                    <b-form-group label="Nome:" label-for="user-name">
                        <b-form-input id="user-name" type="text"
                            v-model="user.name" required
                            placelholder="Informe o nome do usuário..." />
                    </b-form-group>
                </b-col>
                <b-col md="6" sm="12">
                    <b-form-group label="E-mail:" label-for="user-email">
                        <b-form-input id="user-email" type="text"
                            v-model="user.email" required
                            placelholder="Informe o E-mail do usuário..." />
                    </b-form-group>
                </b-col>
            </b-row>
            <b-form-checkbox id="user-admin" v-model="user.admin" class="mt-3 mb-3">
                Administrador?
            </b-form-checkbox>
            <b-row>
                <b-col md="6" sm="12">
                    <b-form-group label="Senha:" label-for="user-password">
                        <b-form-input id="user-password" type="password"
                            v-model="user.password" required
                            placelholder="Informe a senha do usuário..." />
                    </b-form-group>
                </b-col>
                <b-col md="6" sm="12">
                    <b-form-group label="Confirmação de senha:" 
                        label-for="user-confirm-password">
                        <b-form-input id="user-confirm-password" type="password"
                            v-model="user.confirmPassword" required
                            placelholder="Confirme a senha do usuário..." />
                    </b-form-group>
                </b-col>
            </b-row>
            <b-button variant="primary" v-if="mode === 'save'"
                @click="save">Salvar</b-button>
            <b-button variant="danger" v-if="mode === 'remove'"
                @click="remove">Excluir</b-button>
            <b-button class="ml-2" @click="reset">Cancelar</b-button>
        </b-form>
        <hr>
        <b-table :items="users" :fields="fields" hover striped>
            <template #cell(actions)="data">
                <b-button variant="warming" @click="loadUser(data.item)">
                    <i class="fas fa-pencil-alt fa-2x"></i>
                </b-button>
                <b-button class="ml-2" variant="danger" @click="loadUser(data.item, 'remove')">
                    <i class="fa fa-trash"></i>
                </b-button>
            </template>
        </b-table>
    </div>
</template>

<script>
    import { http, showError, baseUrlApi } from '@/global'
    import axios from 'axios'

    export default {
        name: 'UserAdmin',
        data: function() {
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
                    { key: 'actions', label: 'Ações'}
                ]
            }
        },
        methods: {
            // Carregar os usuários do backend
            loadUsers() {
                http.get('/users').then(r => {
                    this.users = r.data['hydra:member']
                })
            },
            reset() {
                this.mode = 'save'
                this.user = {}
                this.loadUsers()
            },
            save() {
                const method = this.user.id ? 'put' : 'post'
                const id = this.user.id ? `/${this.user.id}` : ''
                axios[method](`${baseUrlApi}users${id}`, this.user)
                    .then(() => {
                        this.$toasted.global.defaultSuccess()
                        this.reset()
                    })

                // http[method](`${http}/users${id}`, this.user)
                //     .then(() => {
                //         this.$toasted.global.defaultSuccess()
                //         this.reset()
                //     })
                    .catch(showError)
                
            },
            remove() {
                const id = this.user.id
                axios.delete(`${baseUrlApi}users/${id}`)
                    .then(() => {
                        this.$toasted.global.defaultSuccess()
                        this.reset()
                    })
                    .catch(showError)
            },
            loadUser(user, mode = 'save') {
                this.mode = mode
                this.user = { ...user } //{ ...user } faz um clone do objeto utilizando um spread
            }

        },
        computed: {
            rows() {
                return this.items.length
            }
        },
        mounted() {
            this.loadUsers()
        }
    }
</script>

<style>

</style>