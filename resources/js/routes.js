import Brands from "./components/Brands/index.vue";
import Categories from "./components/Categories/index.vue";
import Descriptions from "./components/Descriptions/index.vue";
import Locations from "./components/Locations/index.vue";
import Manufactures from "./components/Manufactures/index.vue";

export default [
    {
        path:'/brands',
        components:Brands,
        name:'brands'
    },
    {
        path:'/categories',
        components:Categories,
        name:'categories'
    },
    {
        path:'/descriptions',
        components:Descriptions,
        name:'descriptions'
    },
    {
        path:'/locations',
        components:Locations,
        name:'locations'
    },
    {
        path:'/manufactures',
        components:Manufactures,
        name:'manufactures'
    }
];