import Tabulator from 'tabulator-tables'
import 'tabulator-tables/dist/css/semantic-ui/tabulator_semantic-ui.min.css'
const axios = require('axios');
const Swal = require('sweetalert2');
const myTabulators = document.querySelectorAll('#products');
const myTables = [];

Array.prototype.forEach.call(myTabulators,function(myTabulator,index){
    const id = myTabulator.getAttribute('id');
    myTables[index] = new Tabulator('#'+id,{
        locale:true,
        langs: {
            'es-es':{
                "pagination":{
                    "page_size":"Cantidad a mostrar", //label for the page size select element
                    "page_title":"Ver Página",//tooltip text for the numeric page button, appears in front of the page number (eg. "Show Page" will result in a tool tip of "Show Page 1" on the page 1 button)
                    "first":"Primera", //text for the first page button
                    "first_title":"Primera página", //tooltip text for the first page button
                    "last":"Última",
                    "last_title":"Última página",
                    "prev":"Anterior",
                    "prev_title":"Página Anterior",
                    "next":"Siguiente",
                    "next_title":"Página Siguiente",
                    "all":"Todo",
                },
                "headerFilters":{
                    "default":"Filtrar columna", //default header filter placeholder text
                }
            }
        },
        responsiveLayout:false,
        height: '100%',
        layout: 'fitColumns',
        resizableColumns:true,
        pagination:"remote",
        ajaxURL: window.location.href + "/list",
        ajaxParams: {"_token" : document.querySelector('meta[name="csrf-token"]').getAttribute('content')},
        paginationSize:5,
        paginationSizeSelector:[2,5, 10, 50, 100],
        columns: [
            {title:"Nombre", field:"name", headerFilter: true},
            {title:"Precio", field:"price", headerFilter: true},
            {title:"Descuento", field:"discount", headerFilter: true},
            {title:"Total de visitas", field:"total_views", headerFilter: true},
            {title:"Total de ordenes", field:"total_orders", headerFilter: true},
            {title:"Editar", field:"buttonEdit", formatter:"html", headerFilter: false},
            {title:"Eliminar", field:"buttonDelete", formatter:"html", headerFilter: false},
        ]
    })
})


