<template>
    <div>
         <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            Header
                        </div>

                        <div class="card-body">
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th v-for="key in columns" 
                                            @click="sortBy(key)"
                                            :class="{active : sortKey == key}"
                                        >
                                        {{key | capitalize}}
                                        <span class="arrow" :class="sortOrders[key] > 0 ? 'asc' : 'desc'">
                                        </span>
                                        </th>
                                    </tr>
                                </thead>
                                <thead>
                                    <tr>
                                        <th v-for="key in columns" >
                                            <input class="input form-control" v-model="searchOrder[key]" :placeholder="key">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="entry in paginatedData">
                                        <td v-for="key in columns">
                                            {{entry[key]}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <nav aria-label="Page Navigation">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a aria-label="Provious" class="page-link">
                                            Previous
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item" :class="{'active':currentPage===0}">
                                        <a @click="setPage(0)" class="page-link">1</a>
                                    </li>
                                    <li class="page-item" v-for="pageNumber in totalPages" v-if="Math.abs(pageNumber-currentPage) < 3 || pageNumber == totalPages - 1 || pageNumber == 0" :class="{'active':currentPage === pageNumber}">
                                        <a class="page-link" @click="setPage(pageNumber)" :class="{'active':currentPage === pageNumber, last:(pageNumber == totalPages - 1 && Math.abs(pageNumber - currentPage) > 3 ),first:(pageNumber == 0 && Math.abs(pageNumber - currentPage) > 3)}">
                                            <span>{{pageNumber+1}} 
                                                <span v-if="currentPage == pageNumber" class="sr-only"> (current) </span> 
                                            </span> 
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" aria-label="Next" class="page-link">
                                            <span aria-hidden="true">&raquo;</span>
                                            Next
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default{
        props:{
            data:Array,
            columns:Array,
            filterKey:String,
        },
        data:function(){
            var sortOrders={};
            this.columns.forEach(function(key){
                sortOrders[key] = 1;
            });
            
            var searchKeys = {};
            this.columns.forEach(function(key){
                searchKeys[key] = '';
            });

            return{
                sortKey:'',
                sortOrders:sortOrders,
                searchOrder:searchKeys,
                currentPage:0,
                itemsPerPage:10,
                resultCount:0,
            }
        },
        computed:{
            totalPages:function(){
                return Math.ceil(this.filteredData.length/this.itemsPerPage)
            },
            paginatedData:function(){
                if(this.currentPage >= this.totalPages){
                    this.currentPage = this.totalPages;
                }
                var index = this.currentPage * this.itemsPerPage;
                return this.filteredData.slice(index,index + this.itemsPerPage);
            },
            filteredData: function(){
                var sortKey     = this.sortKey;
                var filterKey   = this.filterKey && this.filterKey.toLowerCase();
                var searchKey   = this.searchOrder;
                var order       = this.sortOrders[sortKey] || 1;
                var data        = this.data;

                if(filterKey || searchKey){
                    data = data.filter(function(row) {
                        return Object.keys(row).some(function(key){
                            var filter;
                            if(_.size(searchKey) == 1){
                                filter = (String(row[key]).toLowerCase().indexOf(filterKey)) || (String(row['name']).toLowerCase().indexOf(searchKey['name'].toLowerCase()));
                            }else if(_.size(searchKey) == 7){
                                filter =(String(row[key]).toLowerCase().indexOf(filterKey))||
                                        (String(row['serial']).toLowerCase().indexOf(searchKey['serial'].toLowerCase())) ||
                                        (String(row['quantity']).toLowerCase().indexOf(searchKey['quantity'].toLowerCase())) ||
                                        (String(row['description']).toLowerCase().indexOf(searchKey['description'].toLowerCase())) ||
                                        (String(row['location']).toLowerCase().indexOf(searchKey['location'].toLowerCase())) ||
                                        (String(row['manufacture']).toLowerCase().indexOf(searchKey['manufacture'].toLowerCase())) ||
                                        (String(row['model']).toLowerCase().indexOf(searchKey['model'].toLowerCase())) ||
                                        (String(row['category']).toLowerCase().indexOf(searchKey['category'].toLowerCase()));
                            }
                            return (filter) > -1;
                        }) 
                    })
                }
                if(sortKey){
                    data = data.slice().sort(function(a,b){
                        a = a[sortKey]
                        b = b[sortKey]
                        return (a===b ? 0 : a > b ? 1 : -1) * order
                    })
                }
                return data;

            }

        },
        filters:{
            capitalize:function(str){
                return str.charAt(0).toUpperCase() + str.slice(1)
            }
        },
        methods:{
            sortBy:function(key){
                this.sortKey = key;
                this.sortOrders[key]=this.sortOrders[key] * -1;
            },
            setPage:function(pageNumber){
                this.currentPage = pageNumber
            }
        }
    }

</script>