const ProductList = () => import('../components/product/List.vue')
const ProductAdd = () => import('../components/product/Add.vue')

export const routes = [
    {
        name: 'productList',
        path: '/',
        component: ProductList
    }, {
        name: 'productAdd',
        path: '/products/add',
        component: ProductAdd
    }
]

export default routes;