const Home = () => import('../components/Home.vue')
const ProductList = () => import('../components/product/List.vue')
const ProductAdd = () => import('../components/product/Add.vue')

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'productList',
        path: '/products',
        component: ProductList
    }, {
        name: 'productAdd',
        path: '/products/add',
        component: ProductAdd
    }
]

// const router = createRouter({
//     history: createWebHistory(),
//     routes: routes,
// });

export default routes;