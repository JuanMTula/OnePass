<!DOCTYPE html>

  <html>
    <head>

      @include('includes.html_head')

    </head>

    <body>

      <div class="container" id="MainContainer">

        <h2 class="header center-align" id="MainTitulo">OnePass</h2>

        <div id="MailPw" style="display: none;" autocomplete="off">
             <div class="container_cd">

                    <input autocomplete="false" name="hidden" type="text" style="display:none;">

                    <div class='row'>
                      <div class='input-field col s12'>
                        <input  type="email" id='login-mail'/>
                        <label for='email'>Mail</label>
                      </div>
                    </div>

                    <div class='row'>
                      <div class='input-field col s12'>
                        <input type='password' id='login-password' />
                        <label for='password'>Password</label>
                      </div>
                      <label style='float: right;'>
                      <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                      <input type="hidden" name="action" value="validate_captcha">
                      <a id='enterkeylogin' onclick="iniciarsesion()" class="waves-effect waves-light btn"><i class="material-icons">subdirectory_arrow_right</i></a>
                      </label>
                    </div>

                    <br/>
                 <sl-button disabled>Click me</sl-button>

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
        </div>

        <div id="Contenido" style="display: none;">
            <div class="row">

              <div class="col s12 m2 l2"> </div>

              <div class="col s12 m8 l8">

                <div style="height: 30px;"></div>

                <div>
                  <a onclick="$('.modal_newcat').modal('open')" class="waves-effect waves-light btn blue lighten-3 white-text left btn-closex"><i class="material-icons left">add</i>Nueva categoria</a>
                  <a onclick="cerrarsesion()" class="waves-effect waves-light btn red accent-1 white-text right btn-closex">Cerrar sesion</a>
                </div>

                <div style="height: 60px;"></div>

                <table class="highlight centered " >

                <tbody id="ContenidoTabla">

                </tbody>

                </table>

              </div>

              <div class="col s12 m2 l2"> </div>


            </div>

        </div>

      </div>

      <!-- Modals  -->
      @include('includes.html_modals')

      <!-- JS libs -->
      @include('includes.js_lib')

      <!-- JS custom -->
      <script> @include('includes.custom_js') </script>


      <!-- JS recaptcha -->
      @if(env('GOOGLE_CAPTCHA_PRIV') && env('GOOGLE_CAPTCHA_PUBL')  )
        <script src="https://www.google.com/recaptcha/api.js?render={{env('GOOGLE_CAPTCHA_PUBL')}}" ></script>
        <script async defer >
            grecaptcha.ready(function() {
                grecaptcha.execute('{{env('GOOGLE_CAPTCHA_PUBL')}}', {action:'validate_captcha'})
                          .then(function(token) {
                    document.getElementById('g-recaptcha-response').value = token;
                });
            });
        </script>
      @endif

    </body>

  </html>
