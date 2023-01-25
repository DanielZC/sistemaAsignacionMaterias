$(document).ready(function(){
    
    $('#tabla_asignaciones').DataTable();

    let materiasAsignadas = []
    let creditos = 0
    let asignaturas = document.getElementById('asignaturas')

    const modal = new bootstrap.Modal('#ModalInformacion')      
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

    if(asignaturas.value != '')
    {
        if(asignaturas.value.length > 2)
        {
            let ids = asignaturas.value
    
            if(ids.includes('[') && ids.includes(']'))
            {
                let division1 = asignaturas.value.split('[')[1]
                let division2 = division1.split(']')[0]
    
                ids = division2.split(',')
            }
            else
            {
                ids = ids.split(',')
            }
            
            let _creditos = 0

            for (let id of ids) {
    
                if(id.includes('"'))
                {
                    id = id.split('"')[1]
                }
    
                let strId = `btnAsignar_${id}`
                let materia = document.getElementById(strId).offsetParent.parentElement.children[0].textContent
                let credito = document.getElementById(strId).offsetParent.parentElement.children[1].textContent
    
                crearInsignea(id, materia)
    
                materiasAsignadas.push(parseInt(id))
                document.getElementById(strId).classList.add('disabled')
                _creditos += parseInt(credito)
            }

            creditos = _creditos
            document.getElementById('creditos').innerText = creditos
        }
    }

    function crearInsignea(id, materia) {
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
    }

    function eliminarInsignea(id) {
        let elemento = document.getElementById(id)
        let padre = elemento.parentNode

        padre.removeChild(elemento)
    }

    document.getElementById('btnEnviar').addEventListener('click', function(e){
        e.preventDefault()
        
        document.getElementById('asignaturas').value = materiasAsignadas
        console.log(materiasAsignadas.length)
        console.log(creditos)
        if(materiasAsignadas.length != 0 && creditos >= 7)
        {
            document.getElementById('formAsignarMateria').submit()
        }
        
        if(materiasAsignadas.length == 0)
        {
            document.getElementById('errorAsignacion').textContent = 'Debe asignar materias'
        }

        if(creditos < 7)
        {
            Toast.fire({
                icon: 'warning',
                title: 'La cantidad minima de creditos para registrar un estudiante es 7 '
            })
        }
    })

    document.getElementsByName('asignar').forEach(btn => {
        btn.addEventListener('click', function(){
    
            let id = parseInt(this.attributes.item(4).nodeValue)
            let materia = this.offsetParent.parentElement.children[0].textContent
            let credito = this.offsetParent.parentElement.children[1].textContent
            
            crearInsignea(id, materia)

            materiasAsignadas.push(id)
            this.classList.add('disabled')
            creditos += parseInt(credito)
            document.getElementById('creditos').innerText = creditos
        })
    })

    document.getElementsByName('desasignar').forEach(btn => {
        btn.addEventListener('click', function(){

            let id = parseInt(this.attributes.item(4).nodeValue)

            if(materiasAsignadas.includes(id))
            {
                let index = materiasAsignadas.indexOf(id)
                let credito = this.offsetParent.parentElement.children[1].textContent
                eliminarInsignea(id)

                this.previousElementSibling.classList.remove('disabled')
                materiasAsignadas.splice(index, 1)
                creditos -= credito
                document.getElementById('creditos').innerText = creditos
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