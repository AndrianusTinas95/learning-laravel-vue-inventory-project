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
                                            <th >Action</th>
                                            <th >Status</th>
                                            <th >Quantity</th>
                                            <th v-if="showAddSerial">Model</th>
                                            <th v-if="showAddSerial">Categories</th>
                                            <th v-if="showAddSerial">Description</th>
                                            <th v-if="showAddSerial">Manufacture</th>
                                            <th v-if="showAddSerial">Transfer Location</th>
                                            <th style="text-align:center;">
                                                <a v-hotkey="addTd" v-on:click.prevent="addRow" class="addRow">
                                                    <button class="btn btn-primary">+</button>
                                                    <i class="glyphicon glyphicon-plus"></i>
                                                </a>
                                            </th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(addTd, index) in addRows" v-bind:key="index">
                                                <td :class="{'has-error':addTd.hasError}">
                                                    <div v-if="showAddSerial" class="input-group">
                                                        <input class="form-control input-sm" 
                                                                name="createProduct[]"
                                                                type="text"
                                                                v-model="addTd.createProduct">
                                                        <span class="input-group-append">
                                                                <button class="btn btn-sm btn-danger"
                                                                        @click.prevent="showAddSerial=false">
                                                                x
                                                                </button>
                                                        </span>
                                                    </div>
                                                     <div v-else class="input-group">
                                                         <span class="input-group-append">
                                                                <button class="btn btn-sm btn-primary"
                                                                        @click.prevent="showAddSerial = !showAddSerial"> 
                                                                        +
                                                                </button>
                                                        </span>
                                                        <select2 :options="products" 
                                                                name="product[]"                      
                                                                v-model.number="addTd.product"
                                                                @selectValue = "validateDuplicate($event,index)"
                                                                @selectQuantityValue = "addTd.maxQuantity = $event"
                                                                @selectStatusValue = "addTd.status = $event; addTd.status == 0 ? addTd.action = 2 : addTd.action = 1"
                                                                @selectManufactureValue = "addTd.manufacture = $event"
                                                                @selectDescriptionValue = "addTd.description = $event"
                                                                @selectLocationValue = "addTd.location = $event"
                                                                @selectCategoryValue = "addTd.category = $event"
                                                                @selectModelValue= "addTd.model= $event"
                                                        >
                                                            <option disabled value="0">Select One</option>
                                                        </select2>
                                                        
                                                    </div>
                                                    <span id="helpBlock2" :class="{'d-none': !addTd.hasError}" class="form-text">
                                                        Duplicated Entry
                                                    </span>
                                                </td>
                                                <td>
                                                    <select class="form-control"
                                                            v-model="addTd.action"
                                                            name="action[]"
                                                    >
                                                        <option value="1">
                                                            Working
                                                        </option>
                                                        <option value="0">
                                                            Defective
                                                        </option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control"
                                                            v-model="addTd.status"
                                                            name="status[]"
                                                    >
                                                        <option value="0">
                                                            TRANSFER
                                                        </option>
                                                        <option value="1">
                                                            DEPLOY
                                                        </option>
                                                        <option value="1">
                                                            REPLACED
                                                        </option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <!-- v-model.number ="addTd.quantity ? 1 : addTd.quantity" -->
                                                    <input name="quantity[]"
                                                            class="form-control input-sm"
                                                            min="1"
                                                            v-model.number ="addTd.quantity"
                                                            v-bind:max="addTd.maxQuantity ? addTd.maxQuantity : (addTd.maxQuantity == 0 ? 1 :0)"
                                                            type="number"
                                                            required>
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
                                                        <select2 :options="brands" name="model[]" v-model.number="addTd.model">
                                                            <option disabled value="0">Select One</option>
                                                        </select2>
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
                                                        <select2 :options="categories" name="category[]" v-model.number="addTd.category">
                                                            <option disabled value="0">Select One</option>
                                                        </select2>
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
                                                        <select2 :options="descriptions" name="description[]" v-model.number="addTd.description">
                                                            <option disabled value="0">Select One</option>
                                                        </select2>
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
                                                        <select2  :options="manufactures" name="manufacture[]" v-model.number="addTd.manufacture">
                                                            <option disabled value="0">Select One</option>
                                                        </select2>
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
                                                        <select2  :options="locations" name="location[]" v-model.number="addTd.location">
                                                            <option disabled value="0">Select One</option>
                                                        </select2>
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
    import Select2 from "./Select2.vue";
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
            validateDuplicate(event,index){
                var vm = this
                var product         = _.map(vm.addRows,'product')
                var pluckProduct    = _.map(vm.products,'id')
                var intersect       = _.intersection(product,vm.selected)
                if(_.includes(vm.selected, vm.addRows[index].product)){
                    console.error('Duplicated Entry')
                    this.addRows[index].hasError=true;
                }else{
                    this.selected = intersect
                    this.selected.push(this.addRows[index].product)
                    this.addRows[index].hasError=false;
                }
                console.log(pluckProduct)
                console.log(index)
            },
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

                    hasError:false,
                    maxQuantity:0
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
                var that = this ;
                $.get("../api/brands",function(data,status){
                    that.brands = _.map(data.brands,function(data){
                        var pick    = _.pick(data,'name','id');
                        var object  = {id:pick.id,text:pick.name}
                        return object; 
                    });
                });
                // axios.get('../api/brands').then(resp => this.brands = _.map(resp.data.brands,function(data){
                //     return _.pick(data,'name','id');
                // }))
            },
            fetchCategory:function(){
                 var that = this ;
                $.get("../api/categories",function(data,status){
                    that.categories = _.map(data.categories,function(data){
                        var pick    = _.pick(data,'name','id');
                        var object  = {id:pick.id,text:pick.name};
                        return object; 
                    });
                });
                // axios.get('../api/categories').then(resp => this.categories = _.map(resp.data.categories,function(data){
                //     return _.pick(data,'name','id');
                // }))
            },
            fetchProducts:function(){
                 var that = this ;
                $.get("../api/products",function(data,status){
                    that.products = _.map(data.products,function(data){
                        var pick    = _.pick(data,'serial','id','quantity','status','manufacture.id','description.id','location.id','category.id','brand.id');
                        var object  = {
                            id:pick.id,text:pick.serial,quantity : pick.quantity, status : pick.status , manufacture : pick.manufacture.id, description : pick.description.id, location : pick.location.id, category : pick.category.id,brand : pick.brand.id
                        };
                        return object; 
                    });
                });
                // axios.get('../api/products').then(resp => this.products = resp.data.products);
            },
            fetchDescriptions:function(){
                 var that = this ;
                $.get("../api/descriptions",function(data,status){
                    that.descriptions = _.map(data.descriptions,function(data){
                        var pick    = _.pick(data,'name','id');
                        var object  = {id:pick.id,text:pick.name};
                        return object; 
                    });
                });

                // axios.get('../api/descriptions').then(resp => this.descriptions = _.map(resp.data.descriptions,function(data){
                //     return _.pick(data,'name','id');
                // }))
            },
            fetchManufacture:function(){
                 var that = this ;
                $.get("../api/manufactures",function(data,status){
                    that.manufactures = _.map(data.manufactures,function(data){
                        var pick    = _.pick(data,'name','id');
                        var object  = {id:pick.id,text:pick.name};
                        return object; 
                    });
                });
                // axios.get('../api/manufactures').then(resp => this.manufactures = _.map(resp.data.manufactures,function(data){
                //     return _.pick(data,'name','id');
                // }))
            },
            fetchLocation:function(){
                 var that = this ;
                $.get("../api/locations",function(data,status){
                    that.locations = _.map(data.locations,function(data){
                        var pick    = _.pick(data,'name','id');
                        var object  = {id:pick.id,text:pick.name};
                        return object; 
                    });
                });
                // axios.get('../api/locations').then(resp => this.locations = _.map(resp.data.locations,function(data){
                //     return _.pick(data,'name','id');
                // }))
            },
        },
        components:{
                'select2':Select2
        },
    }
</script>
