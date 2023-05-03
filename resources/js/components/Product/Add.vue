<template>
    <div class="w-100">
        <h1>
            ADD PRODUCT
        </h1>
        <b-form @submit.prevent="submitNewProduct" @reset="onReset">
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

            <b-form-group id="input-group-4" label="Product category:" label-for="categories">
                <b-form-select v-model="form.categories_ids" :options="categories" value-field="id" text-field="name"
                    disabled-field="notEnabled" multiple required>
                </b-form-select>
            </b-form-group>

            <b-form-group id="image" label="Product image:" label-for="image">
                <b-form-file v-model="form.image" placeholder="Choose a file or drop it here..."
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
                photo: [],
                categories_ids: []
            },
            alert: {
                message: '',
                status: false
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
            let formData = new FormData();

            formData.append("name", this.form.name);
            formData.append("description", this.form.description);
            formData.append("price", this.form.price);
            formData.append("image", this.form.image);
            // formData.append("categories_ids", this.form.categories_ids);

            this.saveProduct(formData)
        },
        reset() {
            this.form = {
                name: '',
                description: '',
                price: '',
                photo: '',
                categories_ids: []
            }
        },
        saveProduct(formData) {
            axios.post(`/api/products`, formData)
                .then(res => {
                    if (res.status == 201) {
                        this.alert.status = true
                        this.alert.message = "Product added with success"
                        this.onReset()
                    }
                })
                .catch(err => {
                    console.log('error', err)
                });
        }
    }
}
</script>