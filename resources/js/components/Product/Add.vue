<template>
    <div class="w-100">
        <h1>
            ADD PRODUCT
        </h1>
        <b-form @submit.prevent="submit" @reset="reset">
            <b-form-group id="name" label="Name:" label-for="name">
                <b-form-input id="name" type="text" name="name" v-model="form.name" required
                    placeholder="Product name"></b-form-input>
            </b-form-group>

            <b-form-group id="description" label="Product description:" label-for="textarea">
                <b-form-textarea id="textarea" name="description" v-model="form.description"
                    placeholder="Enter description..." rows="3" max-rows="6" required></b-form-textarea>
            </b-form-group>

            <b-form-group id="price" label="Product price:" label-for="price">
                <b-form-input id="price" type="number" name="price" v-model="form.price" required step="0.10" min="0"
                    placeholder="Enter product price"></b-form-input>
            </b-form-group>

            <b-form-group id="catgories_ids" label="Categories" label-for="categories"
                :invalid-feedback="form.categories_ids.length === 0 ? 'Please select at least one category' : null">
                <multiselect name="categories" v-model="form.categories_ids"
                    :options="categories.map(category => category.id)"
                    :custom-label="opt => categories.find(x => x.id == opt).name" :multiple="true" :close-on-select="false"
                    :clear-on-select="false" :preserve-search="true" placeholder="Choose a category" :preselect-first="true"
                    :allow-empty="false">
                    <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single"
                            v-if="categories.length" v-show="!isOpen">{{ form.categories_ids.length }} options
                            selected</span></template>
                </multiselect>
            </b-form-group>

            <b-form-group id="image" label="Product image:" label-for="image">
                <b-form-file v-model="form.image" required placeholder="Choose a file or drop it here..."
                    drop-placeholder="Drop file here..." accept="image/jpeg, image/png, image/gif"></b-form-file>
            </b-form-group>

            <b-button type="submit" variant="primary">Submit</b-button>
            <b-button type="reset" variant="danger">Reset</b-button>
        </b-form>
    </div>
</template>

<script>
export default {
    name: "addProduct",
    data() {
        return {
            categories: [],
            form: {
                name: '',
                description: '',
                image: [],
                categories_ids: []
            }
        }
    },
    mounted() {
        this.getCategories()
    },
    methods: {
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
        submit() {
            if (this.form.categories_ids.length == 0) {
                this.makeToast('danger', "You must select at least one category")
                return;
            }
            let formData = new FormData();

            formData.append("name", this.form.name);
            formData.append("description", this.form.description);
            formData.append("price", this.form.price);
            formData.append("image", this.form.image);
            this.form.categories_ids.forEach(c => {
                formData.append("categories_ids[]", c);
            })

            this.saveProduct(formData)
        },
        reset() {
            this.form = {
                name: '',
                description: '',
                price: '',
                image: '',
                categories_ids: []
            }
        },
        saveProduct(formData) {
            axios.post(`/api/products`, formData)
                .then(res => {
                    this.makeToast('success', "Product Has been saved successfully")
                    this.reset()
                })
                .catch(err => {
                    this.makeToast('danger', "Something went wrong")
                    console.log('error', err)
                });
        },
        makeToast(variant = null, content) {
            this.$bvToast.toast(content, {
                title: `${variant || 'default'}`,
                variant: variant,
                solid: true
            })
        }
    }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>