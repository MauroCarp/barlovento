
const btnsMenuAgro = document.querySelectorAll('.menuAgro')

for (const menu of btnsMenuAgro) {
    
    menu.addEventListener('click',()=>{

        let menuAgro = menu.getAttribute('data-agro')
    
        document.getElementById('tituloAgro').innerText = `Cargar ${menuAgro}`
        document.getElementById('btnCargarAgro').setAttribute('data-agro',menuAgro)
        document.getElementById('btnCargarAgro').innerText = `Cargar ${menuAgro}`
    
    })

}

const btnEliminarArchivo = document.querySelectorAll('.eliminarArchivoAgro')

    
    if(btnEliminarArchivo.length > 0){
    
        for (const btn of btnEliminarArchivo) {
            
            btn.addEventListener('click',()=>{

                let campo = btn.getAttribute('campo')
        
                let tabla = btn.getAttribute('seccion')
    
                let [campania1,campania2] = document.getElementById('campania').innerText.split('/')
        
                swal({
                    title: `¿Está seguro de borrar el archivo del campo ${campo} de la campaña ${campania1}/${campania2}?`,
                    text: "¡Si no lo está puede cancelar la acción!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Si, borrar archivo!'
                  }).then(function(result){
                    if (result.value) {
                      
                        window.location.href = `index.php?ruta=agro/agro&tabla=${tabla}&campo=${campo}&campania1=${campania1}&campania2=${campania2}`
        
                    }
            
              })

            })
            
        }
    
    }
