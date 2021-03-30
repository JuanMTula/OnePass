<template>
    <div class=" col s12 m7 ">
        <label :for="ident">
            Color <br>
            <select class="mt-3" :id="ident" :name="ident">
                <option value="primary">Azul</option>
                <option value="success">Verde</option>
                <option value="info">Gris</option>
                <option value="warning">Naranja</option>
                <option value="danger">Rojo</option>
            </select>
        </label>
    </div>
</template>

<script>
export default {

    props: {
        ident:String
    },
    data() {
        return { }
    },
    created() {
        let that = this;
        $(document).ready(function(){

            $("#"+that.ident).select2({
                minimumResultsForSearch: Infinity,
                width: '150px'
            });

        });
    },
}

</script>

<style scoped>

</style>
