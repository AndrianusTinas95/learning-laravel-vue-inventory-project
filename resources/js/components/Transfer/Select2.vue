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
            .select2({
                theme:"bootstrap4",
                data:this.$attrs.options,
                placeholder:'Select One',
                allowClear:true,
                tags:true,
                createTag:function(params){
                    var term = $.trim(params.term) + (
                        vm.$attrs.options.some(function(r){
                            return r.text == params.term
                        }) ? "" :(" (new)")
                    );

                    if(/ \(new\)$/.test(term) ===''){
                        return null;
                    }

                    return {
                        id:term,
                        text:term,
                        isNewFlag:true
                    }
                }
            })
            .val(this.value)
            .trigger('change')
            .on('select2:select',function(e){
                console.log(e.params.data.id)

                if(e.params.data.isNewFlag){
                    if(/ \(new\)$/.test(e.params.data.text)){
                        console.log(/ \(new\)$/.exec(e.params.data.text));
                        console.log($.trim(e.params.data.text.replace(/ \(new\)$/,'')));
                        var post = $.trim(e.params.data.text.replace(/ \(new\)$/,''));
                        axios.post('../api/brands',{name:post})
                        .then(
                            resp => {
                                $(this).find('[value="'+e.params.data.id+'"]')
                                        .replaceWith(
                                            '<option selected value="'+resp.data.id+'">'+resp.data.name+'</option>'
                                        )
                            }
                        )
                    }
                }else{
                    vm.$emit('selectValue',e.params.data.id)
                }
            })
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
