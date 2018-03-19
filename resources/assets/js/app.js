/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
//
// const app = new Vue({
//     el: '#app'
// });

window.$(document).ready(function() {
    $('.datatable').DataTable({
        responsive: true,
        autoWidth: false
    });
    var selected_table = $('.datatable-select-checkbox').DataTable( {
        responsive: true,
        autoWidth: false,
        select: {
            style:    'os'
        },
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'selectAll',
                action : function(e, dt, node, config) {
                    e.preventDefault();
                    dt.rows({ search: 'applied'}).select();
                    $('.buttons-select-none').removeClass('disabled');
                }
            },
            {
                extend: 'selectNone',
                action : function(e, dt, node, config) {
                    e.preventDefault();
                    dt.rows({ search: 'applied'}).deselect();
                }
            }
        ]
    } );

    $('div.dataTables_filter, div.dataTables_paginate').addClass('float-right');
    // $('div.dataTables_filter, div.dataTables_length').addClass('form-inline');
    $('div.dataTables_wrapper').addClass('p-0');
    $('.buttons-select-none').removeClass('disabled');

    // selected_table.rows($('.datatable-select-checkbox input:checked').parent()).select();

    selected_table.on( 'select', function ( e, dt, type, indexes ) {
        if ( type === 'row' ) {
            $(selected_table.rows( indexes ).nodes()).find('input:checkbox').attr('checked', true);
        }
    } );
    selected_table.on( 'deselect', function ( e, dt, type, indexes ) {
        if ( type === 'row' ) {
            $(selected_table.rows( indexes ).nodes()).find('input:checkbox').attr('checked', false);
        }
    } );


    $("form").on('submit', function(e) {
        var $form = $(this);
        // Iterate over all checkboxes in the table
        selected_table.table($('.datatable-select-checkbox', this)).$('input[type="checkbox"]').each(function () {
            // If checkbox doesn't exist in DOM
            if (!$.contains(document, this)) {
                if($(this).is(':checked')){
                    // Create a hidden element
                    $form.append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', this.name)
                            .val(this.value)
                    );
                }
            }
        });
    });
} );

// window.$(document).ready(function(){
//     $(".datepicker").datepicker({
//         dateFormat:'yy-mm-dd'
//     });
// });
