const axios = require('axios');
const Swal = require('sweetalert2');
const buttons = document.querySelectorAll('button[type=submit]');
    Array.prototype.forEach.call(buttons,function(button){
        button.addEventListener('click',function(event){
            event.preventDefault();
            const form = button.closest('form');
            const data = new FormData(form);
            const action = form.action || window.location.href;
            const method = (form._method ? form._method.value : null) || 'post';
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if(method.toLowerCase() === 'delete'){
                Swal.fire({
            	  title: "Estás seguro?",
            	  text: "No podras recuperarlo en el futuro",
            	  icon: "warning",
            	  showCancelButton: true,
            	  confirmButtonColor: "#DD6B55",
            	  confirmButtonText: "Sí, borralo!",
            	  cancelButtonText: "Cancelar",

            	}).then((result)=>{
            		if(result.value){
            			send();
            		}
            	})
            }else{
                send();
            }

            function send(){
                Swal.fire({
                    title: 'Por favor, espere...',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                });
                axios.post(action,data,{
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN' : csrfToken
                    }
                })
                .then(function(response){
                    const data = response.data || null;
                    if(data.message){
                        localStorage.setItem('mensaje',data.message);
                        if(data.redirect != null){
                            window.location.href = data.redirect;
                        }else if(data.function != null){
                            localStorage.removeItem('mensaje');
                            Swal.fire('Proceso Completado',data.message,'success');
                            eval(data.function + '()');
                        }
                        else{
                            window.location.reload();
                        }
                    }
                }).catch(function (error) {
                    let message =  error.response.data.message || error.response.data.statusText || error.response.statusText
                    if(error.response.data.errors){
                        message = error.response.data.errors[Object.keys(error.response.data.errors)[0]][0]
                    }
                    let type=error.type || 'error'
                    Swal.fire({
                        title: 'Oops...',
                        html: message,
                        icon: type
                    })
                });

            }
        });
    });
