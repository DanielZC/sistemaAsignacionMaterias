$(document).ready(function(){
    
    const swalWithBootstrapButtons = Swal.mixin()
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
        btn.addEventListener('click', function(e){

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
})