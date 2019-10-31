<template>
    <select class="input-sm" :name="name" >
        <slot></slot>
    </select>
</template>
<style src="select2/dist/css/select2.min.css"></style>
<!--<style src="select2-bootstrap-theme/dist/select2-bootstrap.min.css"></style>-->

<style src="@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css"></style>

<script>
    import Select2 from "select2";

    export default{
        prop:[
            'options', 'value', 'name'
        ],
        data(){
            return {
                msg : 'halo',
                name: name,
            }
        },
        mounted(){
            var vm = this;
            $(this.$el)
            .select2({theme:"bootstrap4",data:this.$attrs.options})
            .val(this.value)
            .trigger('change')
            .on('change',function(){
                vm.$emit('input',this.value)
            })
        },
        watch:{
            value:function(value){
                //update value
                $(this.$el).val(value).trigger('change');
            },
            options:function(options){
                // update options
                $(this.$el).select2({data:options})
            }
        },
        destroyed:function(){
            $(this.$el).off().select2('destroy')
        },
    }
</script>
