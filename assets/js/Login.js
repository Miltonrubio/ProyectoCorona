$(document).on("submit", "#form_inicio_sesion", function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type: "POST",
        method: "POST",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        url : '../../app/Controlador/NotasControlador.php?operador=inicio_sesion',
        success : function (response) {
            response = response.trim();
            switch (response) {
                case 'not-found':
                    $('#phone').addClass('is-invalid');
                    $('#password').addClass('is-invalid');
                    $('#mensaje-verificacion').show();
                    break;

                case 'error':
                    toastr.error('Error en la peticion');
                    break;

                case 'required':
                    toastr.warning('Campos faltantes');
                    break;

                default:
                    location.href = "../../";
                    break;
            }
        }
    });
});

$('#mostrarPassword').on('change', function(){
    $('#password').prop('type', this.checked ? 'text' : 'password');
});