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
                <a class="pointer" onclick="$('.modal_reg').modal('open')">Registrase</a>
                <a>&nbsp;&nbsp; | &nbsp;&nbsp;</a>
                <a class="pointer" onclick="$('.modal_olv').modal('open')">Olvide mi clave</a>
            </div>
            <div class='row'>

                <div class="card-panel amber lighten-3 center">
                    <p> Gestion de claves en la nube, simple y seguro. Compatible con todo tipo de dispositivos, permite generar categoria y usar etiquetas graficas.</p>

                    <p> Aplicacion sin fines de lucro, no apto para uso profesional, y de libre distribucion.</p>

                    <p> Creado por Juan Manuel Tula</p>
                    <hr>
                    <h5>Herramientas usadas</h5>
                    <a target="_blank" href="https://laravel.com/">Laravel</a> -
                    <a target="_blank" href="https://www.php.net/">Php</a> -
                    <a target="_blank" href="https://www.mysql.com/">MySql</a> <br>

                    <a target="_blank" href="https://es.vuejs.org/">Vue</a> -
                    <a target="_blank" href="https://router.vuejs.org/">Vue Route</a> -
                    <a target="_blank" href="https://jquery.com/">Jquery</a> -
                    <a target="_blank" href="https://materializecss.com/">Materialize</a> <br>

                    <a target="_blank" href="https://select2.org/">Select2</a> -
                    <a target="_blank" href="https://sweetalert2.github.io/">SweetAlert2</a> -
                    <a target="_blank" href="https://github.com/axios/axios">Axios</a> -
                    <a target="_blank" href="https://shoelace.style/">Shoelace</a> <br>

                    <a target="_blank" href="https://github.com/JuanMTula/OnePass">GitHub del proyecto</a>

                </div>

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
                                <input id="reg_pass_confirmation" type="password">
                                <label for="reg_pass_confirmation">Repetir clave</label>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <a onclick="$('.modal_reg').modal('close')" class="modal-close waves-effect waves-green red darken-1 white-text btn-flat left pointer">Cerrar</a>
                <a @click="nuevoUsuario()" class="waves-effect waves-green light-blue darken-2 white-text btn-flat pointer">Registrase</a>
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
            $(document).ready(function(){
                $('.modal_reg').modal();
                $('.modal_olv').modal();
            });
        },
        methods: {

            loginAsGuest() {
                $('#mail').val(window.siteInvitado['usuario']);
                $('#clave').val(window.siteInvitado['clave']);
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
                    url    : window.siteRoutes['login'],
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

            nuevoUsuario() {
                Swal.fire({
                    title: 'Todos los datos estan correctos?',
                    text: "Por favor verifiquelos antes de continuar",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, enviar',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {
                        Swal.showLoading();
                        axios.post(window.siteRoutes['nuevoUsuario'], {
                            nombre: $('#reg_nombre').val(),
                            mail: $('#reg_mail').val(),
                            password: $('#reg_pass').val(),
                            password_confirmation: $('#reg_pass_confirmation').val()
                        })
                            .then(function (res) {
                                Swal.close();

                                if(res.data.status == "success"){
                                    window.mensaje_grande("Usuario creado exitosamente","Usuario creado",'success');
                                    $('.modal_reg').modal('close');
                                    $('#reg_nombre').val("");
                                    $('#reg_mail').val("");
                                    $('#reg_pass').val("");
                                    $('#reg_pass_confirmation').val("");
                                }
                                else if(res.data.status == "error"){
                                    window.mensaje_grande(res.data.message,"Error al crear usuario",'error');
                                }else{
                                    window.mensaje_bloqueador("Error al crear usuario",'error');
                                }
                            })
                            .catch(function (response) {
                                Swal.close();
                            });
                    }
                })


            }
        }

    }
</script>

<style scoped>

</style>
