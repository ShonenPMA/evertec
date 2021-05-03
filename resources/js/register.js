const axios = require('axios');
const { identity } = require('lodash');
const Swal = require('sweetalert2');
const country = document.querySelector('#country');
const state = document.querySelector('#state');
const city = document.querySelector('#city');

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
country.addEventListener('change', function()
{
    //Borrando las opciones de la ciudad
    city.innerHTML = '<option value="">Seleccionar ciudad</option>';
    //Borrando las opciones de estado
    state.innerHTML = '<option value="">Seleccionar estado</option>';

    //Cargar lista para estado
    if(country.value != '')
    {
        const data = new FormData();
        data.append('country', country.value);
        data.append('load', 'state');
        axios.post(
            window.location.href,
            data,
                {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN' : csrfToken
                }
            })
            .then(function(response){
                const data = response.data
                data.forEach(element => {
                    const option = document.createElement('option');
                    option.value = element['id']
                    option.text = element['name']

                    state.add(option);

                });
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


state.addEventListener('change', function(){
    //Borrando las opciones de la ciudad
    city.innerHTML = '<option value="">Seleccionar ciudad</option>';

    //Cargar lista para estado
    if(state.value != '')
    {
        const data = new FormData();
        data.append('state', state.value);
        data.append('load', 'city');
        axios.post(
            window.location.href,
            data,
                {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN' : csrfToken
                }
            })
            .then(function(response){
                const data = response.data
                data.forEach(element => {
                    const option = document.createElement('option');
                    option.value = element['id']
                    option.text = element['name']

                    city.add(option);

                });
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
})