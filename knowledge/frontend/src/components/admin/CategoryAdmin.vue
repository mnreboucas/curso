<template>
    <div class="category-admin">
        <b-form>
            <input id="category-id" type="hidden" v-model="category.id" />
            <b-row>
                <b-col xs="12">
                    <b-form-group label="Nome:" label-for="category-name">
                        <b-form-input id="category-name" type="text"
                            v-model="category.name" required
                            :readonly="mode === 'remove'"
                            placelholder="Informe o nome da categoria..." />
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col xs="12">
                    <b-form-group label="Categoria Pai:" label-for="category-parentId">
                        <b-form-select id="category-parentId"
                            :options="categories" v-model="category.parentId">
                        </b-form-select>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col xs="12">
                    <b-button variant="primary" v-if="mode === 'save'"
                        @click="save">Salvar</b-button>
                    <b-button variant="danger" v-if="mode === 'remove'"
                        @click="remove">Excluir</b-button>
                    <b-button class="ml-2" @click="reset">Cancelar</b-button>
                </b-col>
            </b-row>
        </b-form>
        <hr>
        <b-table hover striped id="list"
            :items="categories" 
            :fields="fields"
            :current-page="currentPage"
            :per-page="perPage">
            <template #cell(actions)="data">
                <b-button variant="warming" @click="loadcategory(data.item)">
                    <i class="fas fa-pencil-alt fa-2x"></i>
                </b-button>
                <b-button class="ml-2" variant="danger" @click="loadcategory(data.item, 'remove')">
                    <i class="fa fa-trash"></i>
                </b-button>
            </template>
        </b-table>
        <!-- Pagination -->
        <b-pagination
            v-model="currentPage"
            :total-rows="rows"
            :per-page="perPage"
            aria-controls="list"
        ></b-pagination>
    </div>
</template>

<script>
    import { http, showError } from '@/global'
    import axios from 'axios'

    export default {
        name: 'CategoryAdmin',
        data: function() {
            return {
                mode: 'save',
                category: {},
                categories: [],
                fields: [
                    { key: 'id', label: 'Código', sortable: true },
                    { key: 'name', label: 'Nome', sortable: true },
                    { key: 'parentId', label: 'Caminho', sortable: true },
                    { key: 'actions', label: 'Ações'}
                ],
                currentPage: 1,
                perPage: 3,
            }
        },
        computed: {
            rows() {
                return this.categories.length
            },
        },
        methods: {
            // Carregar as categorias do backend
            loadCategories() {
                http.get('/categories').then(r => {
                    // this.categories = r.data['hydra:member']
                    this.categories = r.data['hydra:member'].map(category => {
                        return { ...category, value: category.id, text: category.name }
                    })
                })
            },
            reset() {
                this.mode = 'save'
                this.category = {}
                this.loadCategories()
            },
            save() {
                const method = this.category.id ? 'put' : 'post'
                const id = this.category.id ? `/${this.category.id}` : ''
                axios[method](`${http}/categories${id}`, this.category)
                    .then(() => {
                        this.$toasted.global.defaultSuccess()
                        this.reset()
                    })

                // http[method](`${http}/categories${id}`, this.category)
                //     .then(() => {
                //         this.$toasted.global.defaultSuccess()
                //         this.reset()
                //     })
                    .catch(showError)
                
            },
            remove() {
                const id = this.category.id
                axios.delete(`${http}/categories/${id}`)
                    .then(() => {
                        this.$toasted.global.defaultSuccess()
                        this.reset()
                    })
                    .catch(showError)
            },
            loadCategory(category, mode = 'save') {
                this.mode = mode
                this.category = { 
                    id: category.id,
                    name: category.name,
                    parentId: category.parentId
                 }
            }

        },
        mounted() {
            this.loadCategories()
        }
    }
</script>

<style>

</style>
