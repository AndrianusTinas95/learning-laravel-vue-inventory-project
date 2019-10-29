<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                 <section class="card">
                    <div class="card card-header">
                            <h3>Create Teach Item</h3>
                    </div>
                    <div class="card card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th>Serial</th>
                                <th>Status</th>
                                <th>Model</th>
                                <th>Categories</th>
                                <th>Description</th>
                                <th>Manufacture</th>
                                <th>Location</th>
                                <th style="text-align:center;">
                                    <a v-hotkey="addTd" v-on:click="addRow" class="addRow">+
                                        <i class="glyphicon glyphicon-plus"></i>
                                    </a>
                                </th>
                            </thead>
                            <tbody>
                                <tr v-for="(addTd, index) in addRows" v-bind:key="index">
                                    <td>
                                        <select class="form-control"
                                                name="product[]" 
                                                v-model="addTd.product"
                                                required>
                                                <option v-for="option in products" v-bind:value="option.id" v-bind:key="option.id">
                                                    {{option.serial ? option.serial : option.description.name }}
                                                </option>
                                        </select>
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
                                    <td>
                                        <select class="form-control"
                                                v-model="addTd.model"
                                        >
                                            <option v-for="option in brands" v-bind:value="option.id">
                                                {{option.name}}
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control"
                                                v-model="addTd.category"
                                        >
                                            <option v-for="option in categories" v-bind:value="option.id">
                                                {{option.name}}
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control"
                                                v-model="addTd.description"
                                        >
                                            <option v-for="option in descriptions" v-bind:value="option.id">
                                                {{option.name}}
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control"
                                                v-model="addTd.manufacture"
                                        >
                                            <option v-for="option in manufactures" v-bind:value="option.id">
                                                {{option.name}}
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control"
                                                v-model="addTd.location"
                                        >
                                            <option v-for="option in locations" v-bind:value="option.id">
                                                {{option.name}}
                                            </option>
                                        </select>
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
                        <button class="btn btn-primary" @click="addSerial"> Add Serial </button>
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
                addRows:[],
                brands:[],
                categories:[],
                products:[],
                descriptions:[],
                manufactures:[],
                locations:[],
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
                });
            },
            fetchModel:function(){
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
