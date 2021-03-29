

window.mensaje_rapido = function($texto,$tipo) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: $tipo,
        title: $texto
    })
}

window.mensaje_grande = function($texto,$titulo,$tipo) {
    const Toast = Swal.mixin({
        position: 'center',
        showConfirmButton: true,
        title: $titulo,
        confirmButtonText: 'Volver',
    })

    Toast.fire({
        icon: $tipo,
        title: $texto
    })
}

window.mensaje_bloqueador = function($texto,$tipo) {
    const Toast = Swal.mixin({
        toast: false,
        position: 'center',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        showConfirmButton: false,
    })

    Toast.fire({
        icon: $tipo,
        title: $texto
    })
}

window.validateEmail = function(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@']+(\.[^<>()\[\]\\.,;:\s@']+)*)|('.+'))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

window.customUpdateFields = function(){
    $(document).ready(function() {
        window.Materialize.updateTextFields();
    });
}
