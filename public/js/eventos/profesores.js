$(document).ready(function(){
    
    const swalWithBootstrapButtons = Swal.mixin()

    const modal = new bootstrap.Modal('#ModalInformacion')      
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

    document.getElementsByName('btnEliminar').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault()
    
            swalWithBootstrapButtons.fire({
                title: '¿Desea eliminar el registro?',
                text: "Esta accion no podra ser revertida",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                confirmButtonText: 'Si',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            })
            .then((result) => {
                if (result.isConfirmed) {
                    let formulario = this.parentNode
                    formulario.submit()
                }
            })
        })
    })

    document.getElementsByName('btnInfo').forEach(btn => {
        btn.addEventListener('click', () => {
            let id = parseInt(btn.attributes.item(1).nodeValue)

            if(id == '' || !Number.isInteger(id))
            {                
                Toast.fire({
                    icon: 'error',
                    title: 'El parametro debe ser numerico'
                })
            }
            else
            {
                let url = window.location.origin
                $.ajax({
                    url: `${url}/profesores/ver/${id}`,
                    method: 'GET',
                    success: function(response) {
                        if(response.tipo == 'ok')
                        {
                            modal.show()
                            
                            document.getElementById('nombre').innerText = response.profesor.nombre
                            document.getElementById('documento').innerText = response.profesor.documento
                            document.getElementById('email').innerText = response.profesor.email
                            document.getElementById('telefono').innerText = response.profesor.telefono
                            document.getElementById('ciudad').innerText = response.profesor.ciudad
                            document.getElementById('direccion').innerText = response.profesor.direccion
                        }
                        else
                        {
                            Toast.fire({
                                icon: 'error',
                                title: 'El parametro enviado no cumple los requisitos'
                            })
                        }
                    }
                })
            }
        })
    })
})