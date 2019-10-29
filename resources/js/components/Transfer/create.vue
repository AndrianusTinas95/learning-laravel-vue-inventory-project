<template>
    <div class="container">
        <div class="row justify-content-center">
            <div :class="{'col-md-10' :!showAddSerial,'col-md-12' : showAddSerial}">
                 <section class="card">
                    <div class="card card-header">
                            <h3>{{showAddSerial ? 'Create Brand New Items CFAT' :  'Create CFAT'}}</h3>
                    </div>
                    <div class="card card-body">
                        <form action="../api/transfers" method="POST">
                            <input type="hidden" name="_token" :value="laravelToken">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <th>Serial</th>
                                            <th >Status</th>
                                            <th v-if="showAddSerial">Model</th>
                                            <th v-if="showAddSerial">Categories</th>
                                            <th v-if="showAddSerial">Description</th>
                                            <th v-if="showAddSerial">Manufacture</th>
                                            <th v-if="showAddSerial">Transfer Location</th>
                                            <th style="text-align:center;">
                                                <a v-hotkey="addTd" v-on:click="addRow" class="addRow">
                                                    <button class="btn btn-primary">+</button>
                                                    <i class="glyphicon glyphicon-plus"></i>
                                                </a>
                                            </th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(addTd, index) in addRows" v-bind:key="index">
                                                <td>
                                                     <div class="input-group">
                                                         <select class="form-control"
                                                            name="product[]" 
                                                            v-model="addTd.product"
                                                            required>
                                                            <option v-for="option in products" v-bind:value="option.id" v-bind:key="option.id">
                                                                {{option.serial ? option.serial : option.description.name }}
                                                            </option>
                                                         </select>
                                                        <span class="input-group-append">
                                                                <button class="btn btn-sm btn-primary"
                                                                        @click.prevent="showAddSerial = !showAddSerial"> 
                                                                        +
                                                                </button>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select class="form-control"
                                                            v-model="addTd.status"
                                                    >
                                                        <option value="1">
                                                            Working
                                                        </option>
                                                        <option value="0">
                                                            Defective
                                                        </option>
                                                    </select>
                                                </td>
                                                <td v-if="showAddSerial">
                                                    <div v-if="addTd.showModel" class="input-group">
                                                        <input class="form-control input-sm" 
                                                                name="createModel[]"
                                                                type="text"
                                                                v-model="addTd.createModel">
                                                        <span class="input-group-append">
                                                                <button class="btn btn-sm btn-primary"
                                                                        @click.prevent="createModelMethod(index)">
                                                                +
                                                                </button>
                                                                <button class="btn btn-sm btn-danger"
                                                                        @click.prevent="addTd.showModel=false">
                                                                x
                                                                </button>
                                                        </span>
                                                    </div>
                                                    <div v-else class="input-group">
                                                        <select class="form-control"
                                                                v-model="addTd.model">
                                                            <option v-for="option in brands" v-bind:value="option.id" v-bind:key="option.id">
                                                                {{option.name}}
                                                            </option>
                                                        </select>
                                                        <span class="input-group-append">
                                                                <button class="btn btn-sm btn-primary"
                                                                        @click.prevent="addTd.showModel = !addTd.showModel"> 
                                                                        +
                                                                </button>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td v-if="showAddSerial">
                                                    <div v-if="addTd.showCategory" class="input-group">
                                                        <input class="form-control input-sm" 
                                                                name="createCategory[]"
                                                                type="text"
                                                                v-model="addTd.createCategory">
                                                        <span class="input-group-append">
                                                                <button class="btn btn-sm btn-primary"
                                                                        @click.prevent="createCategoryMethod(index)">
                                                                +
                                                                </button>
                                                                <button class="btn btn-sm btn-danger"
                                                                        @click.prevent="addTd.showCategory=false">
                                                                x
                                                                </button>
                                                        </span>
                                                    </div>
                                                    <div v-else class="input-group">
                                                        <select class="form-control"
                                                                v-model="addTd.category"
                                                        >
                                                            <option v-for="option in categories" v-bind:value="option.id" v-bind:key="option.id">
                                                                {{option.name}}
                                                            </option>
                                                        </select>
                                                        <span class="input-group-append">
                                                                <button class="btn btn-sm btn-primary"
                                                                        @click.prevent="addTd.showCategory = !addTd.showCategory"> 
                                                                        +
                                                                </button>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td v-if="showAddSerial">
                                                    <div v-if="addTd.showDescription" class="input-group">
                                                        <input class="form-control input-sm" 
                                                                name="createDescription[]"
                                                                type="text"
                                                                v-model="addTd.createDescription">
                                                        <span class="input-group-append">
                                                                <button class="btn btn-sm btn-primary"
                                                                        @click.prevent="createDescriptionMethod(index)">
                                                                +
                                                                </button>
                                                                <button class="btn btn-sm btn-danger"
                                                                        @click.prevent="addTd.showDescription=false">
                                                                x
                                                                </button>
                                                        </span>
                                                    </div>
                                                    <div v-else class="input-group">
                                                        <select class="form-control"
                                                            v-model="addTd.description"
                                                        >
                                                            <option v-for="option in descriptions" v-bind:value="option.id" v-bind:key="option.id">
                                                                {{option.name}}
                                                            </option>
                                                        </select>
                                                        <span class="input-group-append">
                                                                <button class="btn btn-sm btn-primary"
                                                                        @click.prevent="addTd.showDescription = !addTd.showDescription"> 
                                                                        +
                                                                </button>
                                                        </span>
                                                    </div>
                                                </td>

                                                <td v-if="showAddSerial">
                                                    <div v-if="addTd.showManufacture" class="input-group">
                                                        <input class="form-control input-sm" 
                                                                name="createManufacture[]"
                                                                type="text"
                                                                v-model="addTd.createManufacture">
                                                        <span class="input-group-append">
                                                                <button class="btn btn-sm btn-primary"
                                                                        @click.prevent="createManufactureMethod(index)">
                                                                +
                                                                </button>
                                                                <button class="btn btn-sm btn-danger"
                                                                        @click.prevent="addTd.showManufacture=false">
                                                                x
                                                                </button>
                                                        </span>
                                                    </div>
                                                    <div v-else class="input-group">
                                                        <select class="form-control"
                                                            v-model="addTd.manufacture"
                                                        >
                                                            <option v-for="option in manufactures" v-bind:value="option.id" v-bind:key="option.id">
                                                                {{option.name}}
                                                            </option>
                                                        </select>
                                                        <span class="input-group-append">
                                                                <button class="btn btn-sm btn-primary"
                                                                        @click.prevent="addTd.showManufacture = !addTd.showManufacture"> 
                                                                        +
                                                                </button>
                                                        </span>
                                                    </div>
                                                </td>

                                                <td v-if="showAddSerial">
                                                    <div v-if="addTd.showLocation" class="input-group">
                                                        <input class="form-control input-sm" 
                                                                name="createLocation[]"
                                                                type="text"
                                                                v-model="addTd.createLocation">
                                                        <span class="input-group-append">
                                                                <button class="btn btn-sm btn-primary"
                                                                        @click.prevent="createLocationMethod(index)">
                                                                +
                                                                </button>
                                                                <button class="btn btn-sm btn-danger"
                                                                        @click.prevent="addTd.showLocation=false">
                                                                x
                                                                </button>
                                                        </span>
                                                    </div>
                                                    <div v-else class="input-group">
                                                        <select class="form-control"
                                                            v-model="addTd.location"
                                                        >
                                                            <option v-for="option in locations" v-bind:value="option.id" v-bind:key="option.id">
                                                                {{option.name}}
                                                            </option>
                                                        </select>
                                                        <span class="input-group-append">
                                                                <button class="btn btn-sm btn-primary"
                                                                        @click.prevent="addTd.showLocation = !addTd.showLocation"> 
                                                                        +
                                                                </button>
                                                        </span>
                                                    </div>
                                                </td>
                                              
                                                <td>
                                                    <button @click.prevent="addRows.splice(index,1)" class="btn btn-sm btn-danger">
                                                        <i class="glyphicon glyphicon-remove"></i>
                                                        x
                                                        </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- <button class="btn btn-primary" @click="addSerial"> Add Serial </button> -->
                                    <button class="btn btn-primary" > Add Serial </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                laravelToken:window.Laravel.csrfToken,
                addRows:[],
                brands:[],
                categories:[],
                products:[],
                descriptions:[],
                manufactures:[],
                locations:[],

                showAddSerial:false
            }
        },
        mounted() {
            this.fetchProducts();
            this.fetchModel();
            this.fetchCategory();
            this.fetchDescriptions();
            this.fetchManufacture();
            this.fetchLocation();
        },
        computed:{
            addTd(){
                return {
                    enter : this.addRow,
                    esc : this.deleteRow
                }
            }
        },
        methods:{
            deleteRow(){
                this.addRows.pop()
            },
            addSerial:function() {
                var addRows = _.map(this.addRows,function(num){
                    return _.pick(num,'quantity','serial','manufacture','description','location','category','model','status');
                });  
                axios.post('../api/products',{products:addRows}).then(resp =>{
                    console.log(resp.data);
                });
            },
            addRow(){
                this.addRows.push({
                    quantity:1,
                    serial:null,
                    status:null,
                    model:null,
                    category:null,
                    description:null,
                    manufacture:null,
                    location:null,

                    createModel:'',
                    createCategory:'',
                    createDescription:'',
                    createManufacture:'',
                    createLocation:'',

                    showAddSerial:false,
                    showModel:false,
                    showCategory:false,
                    showDescription:false,
                    showManufacture:false,
                    showLocation:false,

                });
            },
            createModelMethod(index){

            },
            createCategoryMethod(index){

            },
            createDescriptionMethod(index){

            },
            createManufactureMethod(index){

            },
            createLocationMethod(index){

            },
            fetchModel:function(){
                // var that = this ;
                // $.get("../api/brands",function(data,status){
                //     that.brands = _.map(data.brands,function(data){

                //     });
                // });
                axios.get('../api/brands').then(resp => this.brands = _.map(resp.data.brands,function(data){
                    return _.pick(data,'name','id');
                }))
            },
            fetchCategory:function(){
                axios.get('../api/categories').then(resp => this.categories = _.map(resp.data.categories,function(data){
                    return _.pick(data,'name','id');
                }))
            },
            fetchProducts:function(){
                axios.get('../api/products').then(resp => this.products = resp.data.products);
            },
            fetchDescriptions:function(){
                axios.get('../api/descriptions').then(resp => this.descriptions = _.map(resp.data.descriptions,function(data){
                    return _.pick(data,'name','id');
                }))
            },
            fetchManufacture:function(){
                axios.get('../api/manufactures').then(resp => this.manufactures = _.map(resp.data.manufactures,function(data){
                    return _.pick(data,'name','id');
                }))
            },
            fetchLocation:function(){
                axios.get('../api/locations').then(resp => this.locations = _.map(resp.data.locations,function(data){
                    return _.pick(data,'name','id');
                }))
            },
        }
    }
</script>
