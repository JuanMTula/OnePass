<template>
    <div class="container">
        <h2 class="header center-align" id="MainTitulo">OnePass</h2>

        <div class='row mb-0'>
            <div class='input-field col s12 m6 offset-m3 mb-2 mt-0' >
                <sl-input label="Email" type="email" id="mail" name="mail" autocomplete="off" required></sl-input>
            </div>
        </div>

        <div class='row mb-0'>
            <div class='input-field col s12 m6 offset-m3 mb-0 mt-0'>
                <sl-input label="Clave" type="password" id="clave" name="clave" autocomplete="off" toggle-password required> </sl-input>
            </div>
        </div>

        <div class='row mb-0'>
            <div class='input-field col s12 m6 offset-m3 mb-0'>
                <sl-button type="primary" size="medium" id="btn-entrar"
                           style="width: 100%; margin-bottom: 1rem;"
                           @click="login()" >Entrar</sl-button>
            </div>
        </div>

        <div class='row'>
            <div class='input-field col s12 m6 offset-m3'>
                <sl-button type="secondary" size="small" id="btn-invitado"
                           style="width: 100%; margin-bottom: 1rem;"
                           @click="loginAsGuest()" >Entrar como invitado</sl-button>
            </div>
        </div>


        <div class='row'>
        <center>
            <div class='row'>
                <a href="javascript:void(0)" onclick="$('.modal_reg').modal('open')">Registrase</a>
                <a>&nbsp;&nbsp; | &nbsp;&nbsp;</a>
                <a href="javascript:void(0)" onclick="$('.modal_olv').modal('open')">Olvide mi clave</a>
                <a>&nbsp;&nbsp; | &nbsp;&nbsp;</a>
                <a href="javascript:void(0)" onclick="$('.modal_info').modal('open')">?</a>
            </div>
        </center>
        </div>

        <div id="modal_reg" class="modal modal_reg">
            <div class="modal-content">

                <h4 class="center-align" >Bienvenido</h4>

                <p class="center-align" >Complete todos los campos y no se olvide de su clave, esta no puede ser recuperada ni cambiada a futuro.</p>

                <div class="row">
                    <div class="col s12">

                        <div class="row">
                            <div class="input-field col s12">
                                <input id="reg_nombre" type="text">
                                <label for="reg_nombre">Nombre</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <input id="reg_mail" type="email" class="validate">
                                <label for="reg_mail">Mail</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12 m6">
                                <input id="reg_pass" type="password" >
                                <label for="reg_pass">Clave</label>
                            </div>

                            <div class="input-field col s12 m6">
                                <input id="reg_pass2" type="password">
                                <label for="reg_pass2">Repetir clave</label>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" onclick="$('.modal_reg').modal('close')" class="modal-close waves-effect waves-green red darken-1 white-text btn-flat left">Cerrar</a>
                <a href="javascript:void(0)" onclick="registrar();" class="waves-effect waves-green light-blue darken-2 white-text btn-flat">Registrase</a>
            </div>
        </div>

        <div id="modal_olv" class="modal modal_olv">
            <div class="modal-content">
                <h4>¿Olvido su clave?</h4>
                <p>Desafortunadamente, por cuestiones de seguridad esta función no esta disponible, ya que la información guardada es de suma importancia y cualquier persona con acceso a su mail podría solicitar una recuperación de clave y acceder a sus claves.</p>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" onclick="$('.modal_olv').modal('close')" class="modal-close waves-effect waves-green red darken-1 white-text btn-flat left">Cerrar</a>
            </div>
        </div>

        <div id="modal_info" class="modal modal_info">

            <div class="modal-content">

                <h4>OnePass</h4>

                <div class="row">

                    <p>Gestion de claves en la nube, simple y seguro. Compatible con todo tipo de dispositivos, permite generar categoria y usar etiquetas graficas.</p>

                    <p class="card-panel yellow lighten-1 center">Aplicacion sin fines de lucro, no apto para uso profesional, y de libre distribucion.</p>

                    <p> Creado por Juan Manuel Tula</p>

                    <a href="http://www.madmoss.com/" target="_blank" >Visitar el sitio del creador</a>

                </div>

            </div>

            <div class="modal-footer">

                <a href="javascript:void(0)" onclick="$('.modal_info').modal('close')" class="modal-close waves-effect waves-green red darken-1 white-text btn-flat left btn-closex">Cerrar</a>

            </div>

        </div>

    </div>
</template>

<script>
    export default {
        components: {

        },
        data() {
            return {

            }
        },
        created() {
            this.init();
            $(document).ready(function(){

                $('.modal_reg').modal();
                $('.modal_olv').modal();
                $('.modal_info').modal();

            });
        },
        methods: {
            init() {

            },

            loginAsGuest() {
                $('#mail').val(siteInvitado['usuario']);
                $('#clave').val(siteInvitado['clave']);
                $('#btn-entrar').click();
            },

            login() {

                if($('#mail').val() == ""){
                    window.mensaje_rapido("El email es requerido",'error')
                    return false;
                }

                if($('#clave').val() == ""){
                    window.mensaje_rapido("La clave es requerida",'error')
                    return false;
                }

                if(! window.validateEmail($('#mail').val()) && $('#mail').val() != "demo" ){
                    window.mensaje_rapido("El email no es valido",'error')
                    return false;
                }

                const router = this.$router;
                let that = this
                axios({
                    method : 'get',
                    url    : siteRoutes['login'],
                    params : {
                        mail  : $('#mail').val(),
                        clave : $('#clave').val(),
                    },
                    responseType: 'json'
                })
                    .then(function (res) {
                        if(res.data.valido == true)
                            router.push({name: "categorias"});
                        else
                            window.mensaje_rapido(res.data.mensaje,'error');
                    })

            },
            loadTemplate() {



            }
        }

    }
</script>

<style scoped>

</style>
