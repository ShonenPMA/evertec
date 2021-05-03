const Swal = require('sweetalert2');
if (localStorage.getItem('mensaje')!=undefined && localStorage.getItem('mensaje')!="") {
    let mensaje = localStorage.getItem('mensaje');
    localStorage.removeItem('mensaje');
    Swal.fire('Proceso Completado',mensaje,'success');
}
