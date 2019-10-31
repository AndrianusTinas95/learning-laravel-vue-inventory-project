<template>
    <div>
        <div class="container mb-2">
            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="row">
                        <div class="col-auto  mr-auto">
                            <button class="btn btn-primary"> Create Brand </button>
                        </div>
                        <div class="col-auto">
                            <form id="search">
                                <input type="text" class="form-control" placeholder="search...." name="query" v-model="searchQuery" aria-describedby="basic-addon1">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                brandsColumns:['name'],
                brands:[]
            }
        },
        created(){
            this.fetchbrands();
        },
        methods:{
            fetchbrands(){
                axios.get('/api/brands').then(resp => this.brands = resp.data.brands);
            }
        }
    }
</script>