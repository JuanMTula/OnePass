
// inicacion de campos

    $(document).ready(function(){
    
        $('.modal_reg').modal();
        $('.modal_olv').modal();
        $('.modal_newcat').modal();
        $('.modal_vercat').modal();
        $('.modal_nuevaclave').modal({

      endingTop: '2%',
      
      });
        $('.modal_modifclave').modal({

      endingTop: '2%',
      
      });
        $('.modal_info').modal();
        
        $("#cat_icono").select2({
          templateResult: formatOptions,
          minimumResultsForSearch: -1
        });
        
        $("#cat_icono2").select2({
          templateResult: formatOptions,
          minimumResultsForSearch: -1
        });
        
        reload_session();
        enterlogin();
        

    });

// variables
        
    var cont_selected = 0;
    var clave_selected = 0;
        

// funciones

    function checkRecaptcha() {
      var response = grecaptcha.getResponse();
      if(response.length == 0) { 
        //reCaptcha not verified
        alert("no pass"); 
      }
      else { 
        //reCaptch verified
        alert("pass"); 
      }
    }
    
    function cerrarsesion(){
  
        
        
        axios.get("{{route('logout')}}", {

        })
        .then(function (response) {
            
            mensaje_rapido(response.data.mensaje,'success');
            
            if(response.data.valido == 1){
          
           /* $('#MailPw').show();  
            $('#login-mail').val("");
            $('#login-password').val("");
            
            $('#Contenido').hide();  
            $('#Contenido').empty(); */

            location.reload();
            
          }else{
              
              
          }
          
        });  
        
    }
    
    function borrarcategoria(){
  
        Swal.fire({
          title: 'Borrar categoria?',
          text: "Se perderan todos los datos!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'No',
          confirmButtonText: 'Si, borrar!'
        }).then((result) => {
            
        if (result.value) {
           axios.get("{{route('borrarcategoriacontent')}}", {
           params: {
               id: cont_selected
           }
           }).then(function (response) {
           
            if(response.data.valido == 0){
                
                  mensaje_rapido(response.data.mensaje,'error');
                
            }
            
            if(response.data.valido == 1){
                
                  mensaje_rapido(response.data.mensaje,'success');
                    
                    getfullcontent();
                    $('.modal_vercat').modal('close');
                
            }
           
            
        });
        
        }
        
        })

        
        
    }
    
    function borrarclave(){
  
        Swal.fire({
          title: 'Borrar clave?',
          text: "Se perderan todos los datos!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'No',
          confirmButtonText: 'Si, borrar!'
        }).then((result) => {
            
        if (result.value) {
           axios.get("{{route('borrarclave')}}", {
           params: {
               id: clave_selected
           }
           }).then(function (response) {
               
                if(response.data.valido == 0){
                
                    mensaje_rapido(response.data.mensaje,'error');
                
                }
                
                if(response.data.valido == 1){
                
                    mensaje_rapido(response.data.mensaje,'success');
                    
                    vercontenido(cont_selected);
                    
                    $('.modal_modifclave').modal('close');
                
                }
              
            
        });
        
        }
        
        })

        
        
    }
    
    function modificarcategoria(){
  
        if( $('#vercat_nombre').val() == ""){
            
            mensaje_rapido('El campo nombre no puede estar vacio','error');
            
            return 0;
        }
        
        axios.get("{{route('modificarcategoriacontent')}}", {
            params: {
              nombre: $('#vercat_nombre').val(),
              icono: $('#cat_icono2').val(),
              id: cont_selected
            }
          })
          .then(function (response) {
              
            if(response.data.valido == 0){
               
                mensaje_rapido(response.data.mensaje,'error');
                
            }else{
                if(response.data.valido == 1){
                    
                    mensaje_rapido(response.data.mensaje,'success');
                    
                    $('#cat_nombre').val("");
                    $('#cat_icono').val(00);
                    
                    $('.modal_newcat').modal('close');
                    
                    getfullcontent();
                    
                    
                }else{
                    
                    mensaje_rapido('Error de respuesta, fuera de posibilidad','error');
                    
                }
            }
            
          });  
        
    }
    
    function crearcategoria(){
  
        if( $('#cat_nombre').val() == ""){
            
            mensaje_rapido('El campo nombre no puede estar vacio','error');
            
            return 0;
        }
        
        axios.get("{{route('crearcategoriacontent')}}", {
            params: {
              nombre: $('#cat_nombre').val(),
              icono: $('#cat_icono').val()
            }
          })
          .then(function (response) {
              
            if(response.data.valido == 0){
               
                mensaje_rapido(response.data.mensaje,'error');
                
            }else{
                if(response.data.valido == 1){
                    
                    mensaje_rapido(response.data.mensaje,'success');
                    
                    $('#cat_nombre').val("");
                    $('#cat_icono').val(00);
                    
                    $('.modal_newcat').modal('close');
                    
                    getfullcontent();
                    
                    
                }else{
                    
                    mensaje_rapido('Error de respuesta, fuera de posibilidad','error');
                    
                }
            }
            
          });  
        
    }
    
    function vercontenido(id){
        
        cont_selected=id;
        
        axios.get("{{route('getcontent')}}", {
            params: {
              content_id: id
            }
          })
        .then(function (response) {
        
            if (response.data.valido == 0){
              
                mensaje_rapido(response.data.mensaje,'error');
                
            }else{
                    
                $('.modal_vercat').modal('open')
                
                $('#vercat_nombre').val(response.data.nombre)
                $('#cat_icono2').val(response.data.icono).trigger('change');
                

                var resp = "";
                
                $('#contentclaves').empty();
                
                $('#contentclaves').append("<a onclick='nuevaclave(cont_selected)' class='waves-effect waves-light btn blue darken-1 white-text btn-xsm btn-realtext'><i class='material-icons left'>add</i>Nueva clave</a>  <br> <br>");
                
                response.data.claves.forEach(data => {
                    resp =" <a onclick='vercontenidoclave("+data.id+")' class='waves-effect waves-teal btn btn-realtext btn-elements'><i class='material-icons left'>description</i>"+data.titulo+"</a>";
                    $('#contentclaves').append(resp);
                });
                
                $('#contentclaves').append("<br>");
                
            }
        
        });
        
        
          
    }
    
    function nuevaclave(){
   
                $('#crearclave_titulo').val('');
                $('#crearclave_text').val('');
                $('#crearclave_tipo').val('');
                $('#crearclave_url').val('');
                $('#crearclave_tel').val('');
                $('#crearclave_cuenta').val('');
                $('#crearclave_clave').val('');
                Materialize.updateTextFields();
                $('#crearclave_titulo').focus();
                
                $('.modal_nuevaclave').modal('open')

    }
    
    function crearclave(){
   
        axios.get("{{route('crearclave')}}", {
            params: {
              categoria: cont_selected,
              titulo: $('#crearclave_titulo').val(),
              texto: $('#crearclave_text').val(),
              tipo: $('#crearclave_tipo').val(),
              url: $('#crearclave_url').val(),
              tel: $('#crearclave_tel').val(),
              cuenta: $('#crearclave_cuenta').val(),
              clave: $('#crearclave_clave').val()
              
            }
          })
        .then(function (response) {
            
            if (response.data.valido == 0){
            
                mensaje_rapido(response.data.mensaje,'error');
            
            }else{
                
                vercontenido(cont_selected);
                
                mensaje_rapido(response.data.mensaje,'success');
                
                $('.modal_nuevaclave').modal('close')
            
            }

        });  
             
                
        
        
    }

    function vercontenidoclave(id){
        
        clave_selected = id;
        
        axios.get("{{route('getcontentclaves')}}", {
            params: {
              clave: id
            }
          })
        .then(function (response) {
            
          if (response.data.valido == 0){
              
                mensaje_rapido(response.data.mensaje,'error');
                
            }else{
                    
                $('#modifclave_titulo').val(response.data.claves.titulo);
                $('#modifclave_texto').val(response.data.claves.texto);
                $('#modifclave_tipo').val(response.data.claves.tipo);
                $('#modifclave_url').val(response.data.claves.url);
                $('#modifclave_tel').val(response.data.claves.tel);
                $('#modifclave_cuenta').val(response.data.claves.cuenta);
                $('#modifclave_clave').val(response.data.claves.clave);
                Materialize.updateTextFields();
                $('#modifclave_titulo').focus();
                
                $('.modal_modifclave').modal('open')
               
                
            }
        
        });  
            
    }
    
    function modifcontenidoclave(){
        
        axios.get("{{route('modifcontentclaves')}}", {
            params: {
              id:clave_selected,
              titulo: $('#modifclave_titulo').val(),
              texto: $('#modifclave_texto').val(),
              tipo: $('#modifclave_tipo').val(),
              url: $('#modifclave_url').val(),
              tel: $('#modifclave_tel').val(),
              cuenta: $('#modifclave_cuenta').val(),
              clave: $('#modifclave_clave').val(),
              
            }
          })
        .then(function (response) {
            
          if (response.data.valido == 0){
              
                mensaje_rapido(response.data.mensaje,'error');
                
            }else{
             
               mensaje_rapido(response.data.mensaje,'success');
             
            }
        
        });  
            
    }

    function getfullcontent(){
        
        
        $('#MailPw').hide();
        $('#Contenido').show();
        
        $('#ContenidoTabla').html("Cargando contenido de tabla...");
        
        axios.get("{{route('getfullcontent')}}", {

          })
          .then(function (response) {

            if(response.data.valido == 2 || response.data.valido == 0){
               
                $('#ContenidoTabla').html("<a>"+response.data.mensaje+"</a>");
                
            }
            
            if(response.data.valido == 1){
               
                $('#ContenidoTabla').html("");
                
                var resp = "";
                response.data.contenido.forEach(data => {
                    resp ="<tr onclick='vercontenido("+data.id_etiq+")' style='cursor: pointer;'>";
                    resp = resp + "<td style='width: 50px'> <img src='./includes/icons/"+data.icono_etiq+".png' width='32' height='32'></td>";
                    resp = resp + "<td>"+data.texto_etiq+"</td>";
                    resp = resp + "</tr>";
                    $('#ContenidoTabla').append(resp);
                });
                
                resp = "";
                
            }
            
          }); 
    }
    
    function reload_session(){
        
        axios.get("{{route('setsession')}}", {

          })
          .then(function (response) {
            
            if(response.data == 'ok'){
                
                $('.modal_reg').modal('close');
                $('#MailPw').hide();  
                
                $('.grecaptcha-badge').hide()
                
                getfullcontent();
                
            }else{
                
                $('.grecaptcha-badge').show()

                $('.modal_reg').modal('close');
                $('#MailPw').show();
                $('#login-mail').focus();

            }
            
          }); 
    }
    
    function registrar(){
    
        var cons_validarReg = validateReg();
        
        if(cons_validarReg['valido'] == 0){
            
            mensaje_rapido(cons_validarReg['mensaje'],'error');

        }else{
          
        axios.get("{{route('newregist')}}", {
            params: {
              nombre: $('#reg_nombre').val(),
              mail:$('#reg_mail').val(),
              pass:$('#reg_pass').val(),
              pass2:$('#reg_pass2').val(),
            }
          })
          .then(function (response) {
            if(response.data.valido == 0){
               
                mensaje_rapido(response.data.mensaje,'error');
                
            }else{
                if(response.data.valido == 1){
                    
                    mensaje_rapido(response.data.mensaje,'success');
                    
                    reload_session();
                    
                }else{
                    
                    mensaje_rapido('Error de respuesta, fuera de posibilidad','error');
                    
                }
            }
          });    
             
        }
    
    }

    function validateReg(){

        if( $('#reg_nombre').val() == ''){
            return  res0 = {mensaje: 'Campo nombre sin completar.', valido:0};
            }
            
        if( $('#reg_mail').val() == ''){ 
            return  res0 = {mensaje: 'Campo mail sin completar.', valido:0};
            }
            
        if( validateEmail($('#reg_mail').val()) == false){
            return  res0 = {mensaje: 'El campo mail no es valido.', valido:0};
            }   
            
        if( $('#reg_pass').val() == ''){
            return  res0 = {mensaje: 'Campo clave sin completar.', valido:0};
            }
            
        if( $('#reg_pass2').val() == ''){
            return  res0 = {mensaje: 'Campo repetir clave sin completar.', valido:0};
            }   
       
        if( $('#reg_pass').val() != $('#reg_pass2').val()){
            return  res0 = {mensaje: 'Las claves no coniciden.', valido:0};
            }   
        
        return res0 = {mensaje: 'exito', valido:1};
        
    }
    
    function iniciarsesion(){

        if( $('#login-mail').val() == ""){
            
            mensaje_rapido('El campo mail es requerido.','error');
            
            return 0;
            
        }

        if( $('#login-password').val() == ""){
            
            mensaje_rapido('El campo clave es requerido.','error');
            
            return 0;
            
        }
        
        axios.get("{{route('login')}}", {
            params: {
              mail:$('#login-mail').val(),
              pass:$('#login-password').val(),
              grc:$('#g-recaptcha-response').val(),
            }
          })
          .then(function (response) {
              
            if(response.data.valido == 0){
               
                mensaje_rapido(response.data.mensaje,'error');
                
            }else{
                
                if(response.data.valido == 1){
                    
                    mensaje_rapido(response.data.mensaje,'success');
                    
                    $('#MailPw').hide();  
                    $('#Contenido').show();
                    
                    $('.grecaptcha-badge').addClass( 'hide' );
                    
                    getfullcontent();
                
                    
                }else{
                    
                    mensaje_rapido('Error de acceso, fuera de posibilidad','error');
                    
                }
            }
          });    
             
       
        
    }

//funciones comunes

    function enterlogin(){
        
         $('#login-mail').keypress(function(e) {
        if(e.which == 13) {
            $('#enterkeylogin').click();
        }
        });
        
         $('#login-password').keypress(function(e) {
        if(e.which == 13) {
            $('#enterkeylogin').click();
        }
        });
   
    
    }
    
    function mensaje_rapido($texto,$condicion) {

            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000
            })
            
            Toast.fire({
              type: $condicion,
              title: $texto
            })

    }
    
    function validateEmail(email) {
         var re = /^(([^<>()\[\]\\.,;:\s@']+(\.[^<>()\[\]\\.,;:\s@']+)*)|('.+'))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
         return re.test(String(email).toLowerCase());  
            
    }

    function formatOptions (state) {
        if (!state.id) { return state.text; }
        var $state = $( '<span ><img sytle="display: inline-block;" src="/includes/icons/' + state.element.value.toLowerCase() + '.png" /> ' + state.text + '</span>');
        return $state;
    }