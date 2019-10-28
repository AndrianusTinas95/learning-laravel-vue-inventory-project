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
                collectionColumns:['serial','quantity','category','description','location','manufacture','model'],
                collection:[]
            }
        },
        created(){
            this.fetchCollection();
        },
        methods:{
            fetchCollection(){
                axios.get('api/products').then(resp => this.collection = _.map(resp.data.products,function(num){
                  var pick = _.pick(num,'quantity','serial','manufacture.name','description.name','location.name','category.name','brand.name','status');
                  var objectProduct = {
                      quantity : pick.quantity, serial : pick.serial, manufacture : pick.manufacture.name, description : pick.description.name, location : pick.location.name, category : pick.category.name,brand : pick.brand.name,model : pick.status
                  };
                  return objectProduct;  
                }));
            }
        }
    }
</script>