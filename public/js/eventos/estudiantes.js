$(document).ready(function(){
    
    $('#tabla_asignaciones').DataTable();

    let materiasAsignadas = []

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

    document.getElementsByName('asignar').forEach(btn => {
        btn.addEventListener('click', function(){

            let id = parseInt(this.attributes.item(3).nodeValue)
            let materia = this.offsetParent.parentElement.children[0].textContent
            let divColMd2 = document.createElement('div')

            divColMd2.classList.add('col-md-auto')
            divColMd2.id = id
            
            let divAlert = document.createElement('div')

            divAlert.classList.add('alert', 'alert-primary', 'm-0', 'p-1')
            divColMd2.appendChild(divAlert)
            
            let small = document.createElement('small')

            small.textContent = materia
            divAlert.appendChild(small)
            document.getElementById('listaMaterias').appendChild(divColMd2)
            materiasAsignadas.push(id)
            this.classList.add('disabled')
        })
    })

    document.getElementsByName('desasignar').forEach(btn => {
        btn.addEventListener('click', function(){

            let id = parseInt(this.attributes.item(3).nodeValue)

            if(materiasAsignadas.includes(id))
            {
                let elemento = document.getElementById(id)
                let padre = elemento.parentNode
                let index = materiasAsignadas.indexOf(id)
    
                padre.removeChild(elemento)
                this.previousElementSibling.classList.remove('disabled')
                materiasAsignadas.splice(index, 1)    
            }
        })
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
                    url: `${url}/estudiantes/ver/${id}`,
                    method: 'GET',
                    success: function(response) {
                        if(response.tipo == 'ok')
                        {
                            modal.show()
                            
                            document.getElementById('nombre').innerText = response.estudiante.nombre
                            document.getElementById('documento').innerText = response.estudiante.documento
                            document.getElementById('email').innerText = response.estudiante.email
                            document.getElementById('telefono').innerText = response.estudiante.telefono
                            document.getElementById('ciudad').innerText = response.estudiante.ciudad
                            document.getElementById('semestre').innerText = response.estudiante.semestre
                            document.getElementById('direccion').innerText = response.estudiante.direccion
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