<template>
    <div>
        <b-input v-model="filter" placeholder="Filter By Category"></b-input>
        <b-table striped hover :items="products" :fields="fields" responsive :sort-by.sync="sortBy"
            :sort-desc.sync="sortDesc" sort-icon-left :filter="filter" :filter-included-fields="['categories']">
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
        this.getProducts()
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
    }
}
</script>