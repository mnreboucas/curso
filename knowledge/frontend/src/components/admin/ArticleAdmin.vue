<template>
    <div class="article-admin">
        <b-form>
            <input id="article-id" type="hidden" v-model="article.id" />
            <b-form-group label="Nome:" label-for="article-name">
                <b-form-input id="article-name" type="text"
                    v-model="article.name" required
                    :readonly="mode === 'remove'"
                    placelholder="Informe o nome do artigo..." />
            </b-form-group>
            <b-form-group label="Descrição:" label-for="article-description">
                <b-form-input id="article-description" type="text"
                    v-model="article.description" required
                    :readonly="mode === 'remove'"
                    placelholder="Descreva seu artigo..." />
            </b-form-group>
            <b-form-group v-if="mode === 'save'"
                label="Imagem (URL):" label-for="article-imageUrl">
                <b-form-input id="article-imageUrl" type="text"
                    v-model="article.imageUrl" required
                    :readonly="mode === 'remove'"
                    placeholder="Informe a URL da Imagem..." />
            </b-form-group>
            <b-form-group v-if="mode === 'save'" 
                label="Categoria:" label-for="article-categoryId">
                <b-form-select id="article-categoryId"
                    :options="categories" v-model="article.categoryId" />
            </b-form-group>
            <b-form-group v-if="mode === 'save'" 
                label="Autor:" label-for="article-userId">
                <b-form-select id="article-userId"
                    :options="users" v-model="article.userId" />
            </b-form-group>
            <b-button variant="primary" v-if="mode === 'save'"
                @click="save">Salvar</b-button>
            <b-button variant="danger" v-if="mode === 'remove'"
                @click="remove">Excluir</b-button>
            <b-button class="ml-2" @click="reset">Cancelar</b-button>
        </b-form>
        <hr>
        <b-table hover striped
            :items="articles"
            :fields="fields">
            <template #cell(actions)="data">
                <b-button variant="warming" @click="loadArticle(data.item)">
                    <i class="fas fa-pencil-alt fa-2x"></i>
                </b-button>
                <b-button class="ml-2" variant="danger" @click="loadArticle(data.item, 'remove')">
                    <i class="fa fa-trash"></i>
                </b-button>
            </template>
        </b-table>
        <!-- Pagination -->
        <b-pagination
            size="md"
            v-model="page"
            :total-rows="count"
            :per-page="limit"
        ></b-pagination>
    </div>
</template>

<script>
    import { http, showError } from '@/global'
    import axios from 'axios'

    export default {
        name: 'ArticleAdmin',
        data: function() {
            return {
                mode: 'save',
                article: {},
                articles: [],
                categories: [],
                users: [],
                page: 1,
                limit: 0,
                count: 0,
                fields: [
                    { key: 'id', label: 'Código', sortable: true },
                    { key: 'name', label: 'Nome', sortable: true },
                    { key: 'description', label: 'Descrição', sortable: true },
                    { key: 'actions', label: 'Ações'}
                ]
            }
        },
        // computed: {
        //     rows() {
        //         return this.articles.length
        //     },
        // },
        methods: {
            // Carregar as informações do backend
            loadArticles() {
                http.get('/articles').then(r => {
                    this.articles = r.data['hydra:member']
                    this.count = r.data['hydra:member'].count
                    this.limit = r.data['hydra:member'].limit
                })
            },
            reset() {
                this.mode = 'save'
                this.article = {}
                this.loadArticles()
            },
            save() {
                const method = this.article.id ? 'put' : 'post'
                const id = this.article.id ? `/${this.article.id}` : ''
                axios[method](`${http}/articles${id}`, this.article)
                    .then(() => {
                        this.$toasted.global.defaultSuccess()
                        this.reset()
                    })

                // http[method](`${http}/articles${id}`, this.article)
                //     .then(() => {
                //         this.$toasted.global.defaultSuccess()
                //         this.reset()
                //     })
                    .catch(showError)
                
            },
            remove() {
                const id = this.article.id
                axios.delete(`${http}/articles/${id}`)
                    .then(() => {
                        this.$toasted.global.defaultSuccess()
                        this.reset()
                    })
                    .catch(showError)
            },
            loadArticle(article, mode = 'save') {
                this.mode = mode
                this.article = { ...article } //{ ...article } faz um clone do objeto utilizando um spread
            },
            loadCategories() {
                http.get('/categories').then(r => {
                    this.categories = r.data['hydra:member'].map(category => {
                        return { ...category, value: category.id, text: category.name }
                    })
                })
            },
            loadUsers() {
                http.get('/users').then(r => {
                    this.users = r.data['hydra:member'].map(user => {
                        return { ...user, value: user.id, text: user.name }
                    })
                })
            },

        },
        watch: {
            page() {
                this.loadArticles()
            }
        },
        mounted() {
            this.loadArticles()
            this.loadCategories()
            this.loadUsers()
        }
    }
</script>

<style>

</style>
