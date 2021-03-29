<!DOCTYPE html>

  <html>
    <head>
        <title>OnePass</title>
        <link rel="icon"  type="image/png"  href="./includes/favicon.png" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="title" content="OnePass">
        <meta name="description" content="Password keeper">
        <meta name="author" content="Juan Manuel Tula">
        <link rel="stylesheet" href="./css/app.css">

    </head>
    <body class="sl-theme-dark">
        <div id="app">

            <router-view></router-view>
        </div>

{{--      <div class="container" id="MainContainer">--}}

{{--        <h2 class="header center-align" id="MainTitulo">OnePass</h2>--}}

{{--        <div id="MailPw" style="display: none;" autocomplete="off">--}}
{{--             <div class="container_cd">--}}

{{--                    <input autocomplete="false" name="hidden" type="text" style="display:none;">--}}

{{--                    <div class='row'>--}}
{{--                      <div class='input-field col s12'>--}}
{{--                        <input  type="email" id='login-mail'/>--}}
{{--                        <label for='email'>Mail</label>--}}
{{--                      </div>--}}
{{--                    </div>--}}

{{--                    <div class='row'>--}}
{{--                      <div class='input-field col s12'>--}}
{{--                        <input type='password' id='login-password' />--}}
{{--                        <label for='password'>Password</label>--}}
{{--                      </div>--}}
{{--                      <label style='float: right;'>--}}
{{--                      <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">--}}
{{--                      <input type="hidden" name="action" value="validate_captcha">--}}
{{--                      <a id='enterkeylogin' onclick="iniciarsesion()" class="waves-effect waves-light btn"><i class="material-icons">subdirectory_arrow_right</i></a>--}}
{{--                      </label>--}}
{{--                    </div>--}}

{{--                    <br/>--}}
{{--                 <sl-button disabled>Click me</sl-button>--}}

{{--                    <center>--}}
{{--                      <div class='row'>--}}
{{--                        <a href="javascript:void(0)" onclick="$('.modal_reg').modal('open')">Registrase</a>--}}
{{--                        <a>&nbsp;&nbsp; | &nbsp;&nbsp;</a>--}}
{{--                        <a href="javascript:void(0)" onclick="$('.modal_olv').modal('open')">Olvide mi clave</a>--}}
{{--                        <a>&nbsp;&nbsp; | &nbsp;&nbsp;</a>--}}
{{--                        <a href="javascript:void(0)" onclick="$('.modal_info').modal('open')">?</a>--}}
{{--                      </div>--}}
{{--                    </center>--}}

{{--                </div>--}}
{{--        </div>--}}

{{--        <div id="Contenido" style="display: none;">--}}
{{--            <div class="row">--}}

{{--              <div class="col s12 m2 l2"> </div>--}}

{{--              <div class="col s12 m8 l8">--}}

{{--                <div style="height: 30px;"></div>--}}

{{--                <div>--}}
{{--                  <a onclick="$('.modal_newcat').modal('open')" class="waves-effect waves-light btn blue lighten-3 white-text left btn-closex"><i class="material-icons left">add</i>Nueva categoria</a>--}}
{{--                  <a onclick="cerrarsesion()" class="waves-effect waves-light btn red accent-1 white-text right btn-closex">Cerrar sesion</a>--}}
{{--                </div>--}}

{{--                <div style="height: 60px;"></div>--}}

{{--                <table class="highlight centered " >--}}

{{--                <tbody id="ContenidoTabla">--}}

{{--                </tbody>--}}

{{--                </table>--}}

{{--              </div>--}}

{{--              <div class="col s12 m2 l2"> </div>--}}


{{--            </div>--}}

{{--        </div>--}}

{{--      </div>--}}

      <script src="./js/app.js"></script>

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

      @include('includes.routes')


    </body>

  </html>
