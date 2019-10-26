<template>
    <div>
        <form id="search">
            <input type="text" class="form-control" placeholder="search..." name="query" v-model="searchQuery" aria-describedby="basic-addon1">
        </form>
        <div v-if="brands">
            <demo-grid
                :data="brands"
                :columns="brandsColumns"
                :filter-key="searchQuery"
            >
            </demo-grid>
        </div>
        <div v-else>
            Loading...
        </div>
    </div>
</template>
<script>
    import DemoGrid from './../Filtering/filter.vue';
    export default{
        components:{
            DemoGrid
        },
        data(){
            return {
                searchQuery:'',
                brandsColumns:['name',],
                brands:[]
            }
        },
        created(){
            this.fetcbrands();
        },
        methods:{
            fetcbrands(){
                axios.get('api/brands').then(resp => this.brands = resp.data.brands)
            }
        }
    }
</script>