<template>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-2">
            <a class="navbar-brand" href="#">Inventory</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name:'createTransfers'}">Create CFAT</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name:'products'}">Tech Items</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name:'descriptions'}">Descriptions</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name:'brands'}">Brands</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name:'manufactures'}">Manufactures</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name:'locations'}">Locations</router-link>
                    </li> 
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name:'categories'}">Categories</router-link>
                    </li>
                </ul>
                <span class="navbar-text">
                Navbar text with an inline element
                </span>
            </div>
        </nav>
     
        <router-view></router-view>
    </div>
</template>
<script>
  export default{
      
  }
</script>