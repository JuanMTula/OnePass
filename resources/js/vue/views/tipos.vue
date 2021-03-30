<template>
    <div class=" col s12 m5 ">
        <label :for="ident">
            Tipo <br>
            <select class="mt-3" :id="ident" :name="ident">
                <option value="00">Nada</option>
                <option value="01">Rojo</option>
                <option value="02">Azul</option>
                <option value="03">Verde</option>
                <option value="04">Amarillo</option>
                <option value="05">American Expres</option>
                <option value="06">Visa</option>
                <option value="07">Mastercard</option>
                <option value="08">Paypal</option>
                <option value="09">Banco</option>
                <option value="10">Portafolio</option>
                <option value="11">Autos</option>
                <option value="12">Casino</option>
                <option value="13">Tarjetas</option>
                <option value="14">Herramientas</option>
                <option value="15">Compras</option>
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
            function formatState (state) {
                if (!state.id) {
                    return state.text;
                }
                var baseUrl = "/includes/icons";
                var $state = $(
                    '<span><img src="' + baseUrl + '/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
                );
                return $state;
            };

            $("#"+that.ident).select2({
                templateResult: formatState,
                minimumResultsForSearch: Infinity,
                width: '150px'
            });

        });
    },
}

</script>

<style scoped>

</style>
