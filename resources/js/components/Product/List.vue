<template>
    <div>

        <multiselect name="categories" v-model="selectedCategories" :options="categories.map(category => category.id)"
            :custom-label="opt => categories.find(x => x.id == opt).name" :multiple="true" :close-on-select="false"
            :clear-on-select="false" :preserve-search="true" placeholder="Filter By Categories" :preselect-first="true"
            :allow-empty="true">
            <template slot="selection" slot-scope="{ values, search, isOpen }">
                <span class="border px-2 mx-1" v-for="category in selectedCategories">{{ categories.find(x => x.id ==
                    category).name }} </span>
            </template>
        </multiselect>

        <b-table striped hover :items="filteredProducts" :fields="fields" responsive sort-icon-left :filter="filter"
            :filter-included-fields="['categories']">
            <hr />
            <template #cell(image)="data">
                <img class="product-image" :src="data.item.image" :alt=data.item.name />
            </template>
            <template #cell(categories)="data">
                {{ data.item.categories.map(category => category.name).join(', ') }}
            </template>
        </b-table>
    </div>
</template>
<script>
export default {
    name: "products",
    data() {
        return {
            products: [],
            categories: [],
            selectedCategories: [],
            filter: '',
            fields: [{
                key: 'id',
                sortable: false
            }, {
                key: 'image',
                sortable: false
            }, {
                key: 'name',
                sortable: false,
            }, {
                key: 'description',
                sortable: false
            }, {
                key: 'price',
                sortable: true
            }, {
                key: 'categories',
                sortable: false
            }]
        }
    },
    mounted() {
        this.getProducts();
        this.getCategories();
    },
    methods: {
        async getProducts() {
            await axios.get('/api/products').then(response => {
                this.products = response.data.data
            }).catch(error => {
                console.log(error)
                this.products = []
            })
        },
        async getCategories() {
            axios.get(`/api/categories`)
                .then(res => {
                    this.categories = res.data.data
                })
                .catch(error => {
                    console.log(error)
                    this.categories = []
                });

        },
    },
    computed: {
        filteredProducts() {
            if (this.selectedCategories.length > 0) {
                return this.products.filter(product => product.categories.some(category => this.selectedCategories.includes(category.id)));
            } else {
                return this.products;
            }
        }
    },
    watch: {
        selectedCategories() {
            this.filter = '';
        }
    },

}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>