<template>
    <div class="container">
        <a class="header center-align mt-5 pointer right" id="salir" onclick="$('.modal_salir').modal('open')" >Salir</a>
        <h2 class="header center-align" id="MainTitulo">OnePass</h2>
        <h5 class="header center-align" id="SubTitulo">Categorias
            <sl-button type="default" size="small" circle @click="modalCrearCategoria()"><sl-icon name="plus" ></sl-icon></sl-button>
        </h5>
        <div id="modal_salir" class="modal modal_salir">
            <div class="modal-content center">
                <h4>¿Quiere salir?</h4>
            </div>
            <div class="modal-footer center">
                <a onclick="$('.modal_salir').modal('close')" class="pointer modal-close waves-effect waves-green green darken-1 white-text btn-flat left">Volver</a>
                <a @click="logout()" class="pointer modal-close waves-effect waves-green red darken-1 white-text btn-flat right">Cerrar sesion</a>
            </div>
        </div>

        <div id="categorias" class="categorias mt-5" >

            <sl-details v-for="(categoria, indexCat) in categorias"
                        v-bind:key="categoria.categoria_id"
                        class="mb-2">
                <div slot="summary" class="chip chip-fix" >
                        <img :src="'/includes/icons/'+categoria.categoria_icono+'.png'">
                        {{categoria.categoria_titulo}}
                </div>

                <sl-button class="mr-2 mt-2" type="default" size="small" circle @click="modalModificarCategoria(categoria.categoria_titulo,categoria.categoria_id,categoria.categoria_icono)"><sl-icon name="gear"></sl-icon></sl-button>

                <sl-button class="mr-2 mt-2" type="default" size="small" circle @click="modalCrearClave(categoria.categoria_titulo,categoria.categoria_id)"><sl-icon name="plus"></sl-icon></sl-button>

                <sl-button class="mr-2 mt-2" :type="clave.claves_color"
                           @click="modalModificarClave(indexCat,indexClave)"
                           v-for="(clave, indexClave) in categoria.claves"
                           v-bind:key="clave.claves_id">

                           <div slot="prefix" class="chip chip-fix mt-1" >
                               <img :src="'/includes/icons/'+clave.claves_tipo+'.png'">
                               {{clave.claves_titulo}}
                           </div>

                </sl-button>

            </sl-details>

        </div>

        <sl-dialog  class="dialog-box dialog-focus"  label="Detalle" >

            <a>Titulo </a>
            <div class="row">
                <sl-input class="col s10"  id="elem_titulo" type="text" :value="dialog.claves_titulo"></sl-input>
                <sl-button class="col s2"  type="success" size="medium" @click="copiar('elem_titulo')">Copiar</sl-button>
            </div>

            <a>Detalle </a>
            <div class="row">
                <sl-input class="col s10"  id="elem_det" type="text" :value="dialog.claves_texto"></sl-input>
                <sl-button class="col s2"  type="success" size="medium" @click="copiar('elem_det')">Copiar</sl-button>
            </div>

            <a>Telefono</a>
            <div class="row">
                <sl-input class="col s10"  id="elem_tel" type="text" :value="dialog.claves_tel"></sl-input>
                <sl-button class="col s2"  type="success" size="medium" @click="copiar('elem_tel')">Copiar</sl-button>
            </div>

            <a>Cuenta</a>
            <div class="row">
                <sl-input class="col s10"  id="elem_cuenta" type="text" :value="dialog.claves_cuenta"></sl-input>
                <sl-button class="col s2"  type="success" size="medium" @click="copiar('elem_cuenta')">Copiar</sl-button>
            </div>

            <a>Clave</a>
            <div class="row">
                <sl-input class="col s10"  id="elem_clave" type="password" :value="dialog.claves_clave" toggle-password></sl-input>
                <sl-button class="col s2"  type="success" size="medium" @click="copiar('elem_clave')">Copiar</sl-button>
            </div>

            <a>Url</a>
            <div class="row">
                <sl-input class="col s10"  id="elem_url" type="text" :value="dialog.claves_url"></sl-input>
                <sl-button class="col s2"  type="success" size="medium" @click="copiar('elem_url')">Copiar</sl-button>
            </div>

            <div class="row">
                <tipos ident="elem_tipo"></tipos>
                <color ident="elem_color"></color>
            </div>

            <div class="modal-footer mt-5">
                <sl-button class="left" slot="footer" type="danger" @click="borrarClave()">Borrar</sl-button>
                <sl-button class="right" slot="footer" type="primary" @click="modificarClave()">Modificar</sl-button>
            </div>

        </sl-dialog>

        <div id="modal_modificar_categoria" class="modal modal_modificar_categoria">
            <div class="modal-content">
                <h4>Modificar categoria</h4>
                <button class="modal-close btn-flat" style="position:absolute;top:0;right:0;">X</button>
                <div class="row">
                    <tipos ident="modificar_categoria_tipo"></tipos>
                    <div class="input-field col s12 m7 label-fix">
                        <input id="modificar_categoria_titulo" type="text" :value="nombre">
                        <label for="modificar_categoria_titulo">Titulo &nbsp; &nbsp; &nbsp; <i>* campo requerido</i> </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <sl-button class="left" slot="footer" type="danger" @click="borrarCategoria()" >Borrar</sl-button>
                <sl-button slot="footer" type="primary" @click="modificarCategoria()">Modificar</sl-button>
            </div>
        </div>

        <div id="modal_crear_categoria" class="modal modal_crear_categoria">
            <div class="modal-content">
                <h4>Crear categoria</h4>
                <button class="modal-close btn-flat" style="position:absolute;top:0;right:0;">X</button>
                <div class="row">
                    <tipos ident="crear_categoria_tipo"></tipos>
                    <div class="input-field col s12 m7 label-fix">
                        <input id="crear_categoria_titulo" type="text">
                        <label for="crear_categoria_titulo">Titulo &nbsp; &nbsp; &nbsp; <i>* campo requerido</i> </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <sl-button slot="footer" type="primary" @click="crearCategoria()">Crear</sl-button>
            </div>
        </div>

        <div id="modal_crear_clave" class="modal modal_crear_clave">
            <div class="modal-content">
                <h4>Crear clave</h4>
                <button class="modal-close btn-flat" style="position:absolute;top:0;right:0;">X</button>
                <div>
                    <div class="input-field col s12 label-fix">
                        <input id="crear_clave_titulo" type="text">
                        <label for="crear_clave_titulo">Titulo &nbsp; &nbsp; &nbsp; <i>* campo requerido</i> </label>
                    </div>
                </div>
                <div>
                    <div class="input-field col s12 label-fix">
                        <input id="crear_clave_detalle" type="text">
                        <label for="crear_clave_detalle">Detalle</label>
                    </div>
                </div>
                <div>
                    <div class="input-field col s12 label-fix">
                        <input id="crear_clave_telefono" type="text">
                        <label for="crear_clave_telefono">Telefono</label>
                    </div>
                </div>
                <div>
                    <div class="input-field col s12 label-fix">
                        <input id="crear_clave_cuenta" type="text">
                        <label for="crear_clave_cuenta">Cuenta</label>
                    </div>
                </div>
                <div>
                    <div class="input-field col s12 label-fix">
                        <input id="crear_clave_clave" type="text">
                        <label for="crear_clave_clave">Clave</label>
                    </div>
                </div>
                <div>
                    <div class="input-field col s12 label-fix">
                        <input id="crear_clave_url" type="text">
                        <label for="crear_clave_url">Url</label>
                    </div>
                </div>
                <div class="row">
                    <tipos ident="crear_clave_tipo"></tipos>
                    <color ident="crear_clave_color"></color>
                </div>
            </div>
            <div class="modal-footer">
                <sl-button slot="footer" type="primary" @click="crearClave()">Crear</sl-button>
            </div>
        </div>

    </div>
</template>

<script>
import tipos from "./tipos";
import color from "./color";

    export default {
        components: {
            tipos,
            color
        },
        data() {
            return {
                categorias: [],
                claves: [],
                dialog:[],
                flag:0,
                nombre:"",
            }
        },
        created() {
            let that = this;
            $(document).ready(function(){
                that.init();
                $('.modal_salir').modal();

                $('.modal_modificar_categoria').modal();
                $('.modal_crear_categoria').modal();
                $('.modal_crear_clave').modal();
            });
        },
        mounted() {

        },
        methods: {
            init() {
                let that = this;
                axios({
                    method : 'get',
                    url    : siteRoutes['lista'],
                    responseType: 'json'
                }).then(function (res) {
                    that.categorias = res.data;
                })
            },
            logout() {
                const router = this.$router;
                axios({
                    method : 'get',
                    url    : siteRoutes['logout'],
                    responseType: 'json'
                }).then(function (res) {
                    if(res.data.valido == true)
                        router.push({name: "home"});
                    else
                        window.mensaje_rapido(res.data.mensaje,'error');
                })



            },
            copiar(elemento) {
                $('#'+elemento)[0].select();
                document.execCommand("Copy");
                $('#categorias').focus();
            },

            modalCrearCategoria(categoria,id){
                $('.modal_crear_categoria').modal('open');
                window.customUpdateFields();
            },
            crearCategoria(){
                $('#modificar_categoria_tipo').val("00");
                $('#modificar_categoria_tipo').trigger('change');
                let that = this;
                Swal.showLoading();
                axios.post(siteRoutes['crearCategoria'], {
                    nombre: $('#crear_categoria_titulo').val(),
                    tipo: $('#crear_categoria_tipo').val()
                })
                    .then(function (res) {
                        Swal.close();
                        if(res.data.status == "success"){
                            window.mensaje_rapido('Categoria creada','success');
                            $('.modal_crear_categoria').modal('close');
                            that.init();
                            that.clearData();
                        }
                        else if(res.data.status == "error"){
                            window.mensaje_grande(res.data.message,"Error al crear categoria",'error')
                        }else{
                            window.mensaje_bloqueador("Error critico al crear categoria",'error');
                        }
                    })
                    .catch(function (response) {
                        Swal.close();
                        window.mensaje_bloqueador("Error critico al crear categoria",'error');
                    });


            },
            modalModificarCategoria(categoria,id,icono){
                this.nombre = categoria;
                this.flag = id;
                $('.modal_modificar_categoria').modal('open');
                $('#modificar_categoria_tipo').val(icono);
                $('#modificar_categoria_tipo').trigger('change');
                window.customUpdateFields();
            },
            modificarCategoria(){
                let that = this;
                Swal.fire({
                    title: 'Modificar categoria',
                    text: "Seguro quiere modificar esta categoria?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, modificar',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {
                        Swal.showLoading();
                        axios.post(siteRoutes['modificarCategoria'], {
                            id: that.flag,
                            nombre: $('#modificar_categoria_titulo').val(),
                            tipo: $('#modificar_categoria_tipo').val()
                        })
                            .then(function (res) {
                                Swal.close();
                                if(res.data.status == "success"){
                                    window.mensaje_rapido('Categoria modificada','success');
                                    $('.modal_modificar_categoria').modal('close');
                                    that.init();
                                    that.clearData();
                                }
                                else if(res.data.status == "error"){
                                    window.mensaje_grande(res.data.message,"Error al modificar categoria",'error');
                                }else{
                                    window.mensaje_bloqueador("Error critico al crear categoria",'error');
                                }
                            })
                            .catch(function (response) {
                                Swal.close();
                                window.mensaje_bloqueador("Error critico al crear categoria",'error');
                            });
                    }
                })


            },
            borrarCategoria(){
                let that = this;
                Swal.fire({
                    title: 'Borrar categoria',
                    text: "Seguro quiere borrar esta categoria?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borrar',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {
                        Swal.showLoading();
                        axios.post(siteRoutes['borrarCategoria'], {
                            id: that.flag,
                        })
                            .then(function (res) {
                                Swal.close();
                                if(res.data.status == "success"){
                                    that.init();
                                    that.clearData();
                                    window.mensaje_rapido('Categoria borrada','success');
                                    $('.modal_modificar_categoria').modal('close');
                                }
                                else if(res.data.status == "error"){
                                    window.mensaje_grande(res.data.message,"Error al borrar categoria",'error');
                                }else{
                                    window.mensaje_bloqueador("Error al crear categoria",'error');
                                }
                            })
                            .catch(function (response) {
                                Swal.close();
                                window.mensaje_bloqueador("Error al crear categoria",'error');
                            });
                    }
                })

            },

            modalCrearClave(categoriaTitulo,categoriaId){
                this.nombre = categoriaTitulo;
                this.flag = categoriaId;
                $('.modal_crear_clave').modal('open');
                window.customUpdateFields();
            },
            crearClave(){

                let that = this;
                Swal.showLoading();
                axios.post(siteRoutes['crearClave'], {
                    categoria_id: that.flag,
                    titulo: $('#crear_clave_titulo').val(),
                    color: $('#crear_clave_color').val(),
                    tipo: $('#crear_clave_tipo').val(),
                    detalle: $('#crear_clave_detalle').val(),
                    telefono: $('#crear_clave_telefono').val(),
                    cuenta: $('#crear_clave_cuenta').val(),
                    clave: $('#crear_clave_clave').val(),
                    url: $('#crear_clave_url').val(),
                })
                    .then(function (res) {
                        Swal.close();
                        if(res.data.status == "success"){
                            window.mensaje_rapido('Clave creada','success');
                            $('.modal_crear_clave').modal('close');
                            that.init();
                            that.clearData();
                        }
                        else if(res.data.status == "error"){
                            window.mensaje_grande(res.data.message,"Error al crear clave",'error')
                        }else{
                            window.mensaje_bloqueador("Error al crear clave",'error');
                        }
                    })
                    .catch(function (response) {
                        Swal.close();
                        window.mensaje_bloqueador("Error al crear clave",'error');
                    });

            },
            modalModificarClave(categoria,clave){
                this.flag = clave;
                this.dialog = this.categorias[categoria]['claves'][clave];
                this.flag = this.dialog['claves_id'];
                $('#elem_tipo').val(this.dialog.claves_tipo);
                $('#elem_tipo').trigger('change');
                $('#elem_color').val(this.dialog.claves_color);
                $('#elem_color').trigger('change');
                $('.dialog-box')[0].show();
            },
            modificarClave(){
                let that = this;
                Swal.fire({
                    title: 'Modificar clave',
                    text: "Seguro quiere modificar esta clave?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, modificar',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {
                        Swal.showLoading();
                        axios.post(siteRoutes['modificarClave'], {
                            id: that.flag,
                            titulo: $('#elem_titulo').val(),
                            detalle: $('#elem_det').val(),
                            telefono: $('#elem_tel').val(),
                            cuenta: $('#elem_cuenta').val(),
                            clave: $('#elem_clave').val(),
                            url: $('#elem_url').val(),
                            tipo: $('#elem_tipo').val(),
                            color: $('#elem_color').val(),
                        })
                            .then(function (res) {
                                Swal.close();
                                if(res.data.status == "success"){
                                    window.mensaje_rapido('Clave modificada','success');
                                    $('.dialog-box')[0].handleCloseClick();
                                    that.init();
                                }
                                else if(res.data.status == "error"){
                                    window.mensaje_grande(res.data.message,"Error al modificar clave",'error');
                                }
                                else{
                                    window.mensaje_bloqueador("Error al modificar clave",'error');
                                }
                            })
                            .catch(function (response) {
                                Swal.close();
                                window.mensaje_bloqueador("Error al modificar clave",'error');
                            });
                    }
                })


            },
            borrarClave(){
                let that = this;
                Swal.fire({
                    title: 'Borrar clave',
                    text: "Seguro quiere borrar esta clave?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borrar',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {
                        Swal.showLoading();
                        axios.post(siteRoutes['borrarClave'], {
                            id: that.flag,
                        })
                            .then(function (res) {
                                Swal.close();
                                if(res.data.status == "success"){
                                    window.mensaje_rapido('Clave borrada','success');
                                    $('.dialog-box')[0].handleCloseClick();
                                    that.init();
                                    that.clearData();
                                }
                                else if(res.data.status == "error"){
                                    window.mensaje_grande(res.data.message,"Error al borrar clave",'error');
                                }
                                else{
                                    window.mensaje_bloqueador("Error al borrar clave",'error');
                                }
                            })
                            .catch(function (response) {
                                Swal.close();
                                window.mensaje_bloqueador("Error al borrar clave",'error');
                            });
                    }
                });

            },

            clearData(){
                this.nombre = null;
                this.flag = null;

                $('.modal_modificar_categoria').modal('close');
                $('.modal_crear_categoria').modal('close');
                $('.modal_crear_clave').modal('close');
                $('.dialog-box')[0].handleCloseClick();

                $('#crear_categoria_titulo').val("");
                $('#modificar_categoria_titulo').val("");
                $('#elem_titulo').val("");
                $('#elem_det').val("");
                $('#elem_tel').val("");
                $('#elem_cuenta').val("");
                $('#elem_clave').val("");
                $('#elem_url').val("");
                $('#crear_clave_titulo').val("");
                $('#crear_clave_detalle').val("");
                $('#crear_clave_telefono').val("");
                $('#crear_clave_cuenta').val("");
                $('#crear_clave_clave').val("");
                $('#crear_clave_url').val("");

                window.customUpdateFields();
            }

        }
    }
</script>

<style scoped>
sl-icon::part(base) {
    color: #2b6eff;
}
.chip-fix{
    background-color: unset!important;
}
</style>
