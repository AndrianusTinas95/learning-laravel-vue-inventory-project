<template>
    <div>
        <form id="search">
            <input type="text" class="form-control" placeholder="search..." name="query" v-model="searchQuery" aria-describedby="basic-addon1">
        </form>
        <div v-if="collection">
            <demo-grid
                :data="collection"
                :columns="collectionColumns"
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
                collectionColumns:['name'],
                collection:[]
            }
        },
        created(){
            this.fetchCollection();
        },
        methods:{
            fetchCollection(){
                axios.get('api/descriptions').then(resp => this.collection = resp.data.descriptions)
            }
        }
    }
</script>