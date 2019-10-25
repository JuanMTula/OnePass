
<div id="modal_olv" class="modal modal_olv">
    <div class="modal-content">
      <h4>¿Olvido su clave?</h4>
      <p>Desafortunadamente, por cuestiones de seguridad esta función no esta disponible, ya que la información guardada es de suma importancia y cualquier persona con acceso a su mail podría solicitar una recuperación de clave y acceder a sus claves.</p>
    </div>
    <div class="modal-footer">
      <a href="javascript:void(0)" onclick="$('.modal_olv').modal('close')" class="modal-close waves-effect waves-green red darken-1 white-text btn-flat left">Cerrar</a>
    </div>
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
  
<div id="modal_newcat" class="modal modal_newcat">
    <div class="modal-content">
        
        <h4 class="center-align" >Nueva categorias</h4>
        
        <div class="row">
            
              <div class="input-field col s12 m5" style="margin-top: 28px;">
          
              <select id='cat_icono' style='width: 200px;'>
               <option value='00' selected>Gris</option>
               <option value='01'>Rojo</option>
               <option value='02'>Azul</option>
               <option value='03'>Verde</option>
               <option value='04'>Amarillo</option>
               <option value='05'>American</option>
               <option value='06'>Visa</option>
               <option value='07'>Mastercard</option>
               <option value='08'>Paypal</option>
               <option value='09'>Banco</option>
               <option value='10'>Maletin</option>
               <option value='11'>Auto</option>
               <option value='12'>Casino</option>
               <option value='13'>Credito</option>
               <option value='14'>Trabajo</option>
               <option value='15'>Compras</option>
              </select>
              
          
              </div>
              
                <div class="input-field col s12 m7">
                  <input id="cat_nombre" type="text">
                  <label for="cat_nombre">Nombre</label>
                </div>
              
              
        </div>      
         
      
      
      
    </div>
    <div class="modal-footer">
      <a href="javascript:void(0)" onclick="$('.modal_newcat').modal('close')" class="modal-close waves-effect waves-green red darken-1 white-text btn-flat left btn-closex">Cerrar</a>
      <a href="javascript:void(0)" onclick="crearcategoria();" class="waves-effect waves-green light-blue darken-2 white-text btn-flat">Nueva</a>
    </div>
  </div>
  
<div id="modal_vercat" class="modal modal_vercat">
    <div class="modal-content">
        
        <div class="row">
            
              <div class="input-field col s12 m5" style="margin-top: 28px;">
          
              <select id='cat_icono2' style='width: 200px;'>
               <option value='00'selected>Gris</option>
               <option value='01'>Rojo</option>
               <option value='02'>Azul</option>
               <option value='03'>Verde</option>
               <option value='04'>Amarillo</option>
               <option value='05'>American</option>
               <option value='06'>Visa</option>
               <option value='07'>Mastercard</option>
               <option value='08'>Paypal</option>
               <option value='09'>Banco</option>
               <option value='10'>Maletin</option>
               <option value='11'>Auto</option>
               <option value='12'>Casino</option>
               <option value='13'>Credito</option>
               <option value='14'>Trabajo</option>
               <option value='15'>Compras</option>
              </select>
              
          
              </div>
              
                <div class="input-field col s10 m5">
                  <input id="vercat_nombre" type="text">
                  
                </div>
              
                <div class="input-field col s1 m1">
                   <a href="javascript:void(0)" onclick="modificarcategoria()" ><i class="material-icons">save</i></a>
                </div>
                <div class="input-field col s1 m1">
                   <a href="javascript:void(0)" onclick="borrarcategoria()" ><i class="material-icons red-text">delete</i></a>
                </div>
              
              
        </div>      

        <div id="contentclaves">
         
         
        </div> 
     
    </div>
    <div class="modal-footer">
      <a href="javascript:void(0)" onclick="$('.modal_vercat').modal('close')" class="modal-close waves-effect waves-green red darken-1 white-text btn-flat left btn-closex">Cerrar</a>
    </div>
  </div>
  
<div id="modal_nuevaclave" class="modal modal_nuevaclave">
    
    <div class="modal-content">
        
        <h4>Crear clave</h4>
     
        <div class="row">
         
            <div class="input-field col s12 label-fix">
              <input id="crearclave_titulo" type="text">
              <label for="crearclave_titulo">Titulo &nbsp; &nbsp; &nbsp; <i>* campo requerido</i> </label>
            </div>
             
            <div class="input-field col s12 label-fix">
              <textarea id="crearclave_text" class="materialize-textarea"></textarea>
              <label for="crearclave_text">Texto</label>
            </div> 
            
            <div class="input-field col s12 label-fix">
              <input id="crearclave_tipo" type="text">
              <label for="crearclave_tipo">Tipo</label>
            </div>
            
            <div class="input-field col s12 label-fix">
              <input id="crearclave_url" type="text">
              <label for="crearclave_url">Web</label>
            </div>
            
            <div class="input-field col s12 label-fix">
              <input id="crearclave_tel" type="number">
              <label for="crearclave_tel">Telefono</label>
            </div>
            
            <div class="input-field col s12 label-fix">
              <input id="crearclave_cuenta" type="text">
              <label for="crearclave_cuenta">Usuario</label>
            </div>
            
            <div class="input-field col s12 label-fix">
              <input id="crearclave_clave" type="text">
              <label for="crearclave_clave">Clave</label>
            </div>
         
        </div>
        
    </div>
    
    <div class="modal-footer">
        
       <a href="javascript:void(0)" onclick="$('.modal_nuevaclave').modal('close')" class="modal-close waves-effect waves-green red darken-1 white-text btn-flat left btn-closex">Cerrar</a>
       <a href="javascript:void(0)" onclick="crearclave()" class="waves-effect waves-green blue darken-1 white-text btn-flat right" ><i class="material-icons">save</i></a>
       
    </div>
    
  </div>
  
<div id="modal_modifclave" class="modal modal_modifclave">
    
    <div class="modal-content">
        
        <h4>Modificar clave</h4>
     
        <div class="row">
         
            <div class="input-field col s12 label-fix">
              <input id="modifclave_titulo" type="text">
              <label for="modifclave_titulo">Titulo &nbsp; &nbsp; &nbsp; <i>* campo requerido</i> </label>
            </div>
             
            <div class="input-field col s12 label-fix">
              <textarea id="modifclave_texto" class="materialize-textarea"></textarea>
              <label for="modifclave_texto">Texto</label>
            </div> 
            
            <div class="input-field col s12 label-fix">
              <input id="modifclave_tipo" type="text">
              <label for="modifclave_tipo">Tipo</label>
            </div>
            
            <div class="input-field col s12 label-fix">
              <input id="modifclave_url" type="text">
              <label for="modifclave_url">Web</label>
            </div>
            
            <div class="input-field col s12 label-fix">
              <input id="modifclave_tel" type="number">
              <label for="modifclave_tel">Telefono</label>
            </div>
            
            <div class="input-field col s12 label-fix">
              <input id="modifclave_cuenta" type="text">
              <label for="modifclave_cuenta">Usuario</label>
            </div>
            
            <div class="input-field col s12 label-fix">
              <input id="modifclave_clave" type="text">
              <label for="modifclave_clave">Clave</label>
            </div>
         
        </div>
        
    </div>
    
    <div class="modal-footer">
        
       <a href="javascript:void(0)" onclick="$('.modal_modifclave').modal('close')" class="modal-close waves-effect waves-green red darken-1 white-text btn-flat left btn-closex">Cerrar</a>
       <a href="javascript:void(0)" onclick="modifcontenidoclave()" class="waves-effect waves-green blue darken-1 white-text btn-flat right" ><i class="material-icons">save</i></a>
       <a  style="margin-right: 5px; "href="javascript:void(0)" onclick="borrarclave()" class="waves-effect waves-green red darken-1 white-text btn-flat right" ><i class="material-icons">delete</i></a>
       
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
