/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });


import DataTable from 'datatables.net-dt';
import 'datatables.net-responsive-dt';
import Toastify from 'toastify-js'


$('.pass-show').on('click',function (e) {
    e.preventDefault();
    $('.pass-show').toggleClass('bi-eye-slash-fill bi-eye-fill ')
    if ($('.pass-show').hasClass('bi-eye-fill')) {
        $('.pass-log').attr('type', 'text');
    } else {
        $('.pass-log').attr('type', 'password');
    }
});

    
var itemTable;
$(document).ready(function(){
    // show student table
    let studentTable = new DataTable('#index_table', {
        scrollX: true,
        order: [[2, 'desc']],
        // responsive: true,
    });

    $('#modal-open-btn').on("click", function(){
        showForm();
    });

    $('#modal-close-btn').on('click keyup', function(){
        showForm();
    });

    // modal create item
    $('#submit_ajax').click(function(e){
        e.preventDefault();
        insertItem();
    });

    // show item table
    showItemTable();
    
   

});

$('#item_table').on('click',function(e){
    console.log(e.target.id);
    editForm(e.target.id);

});


 // store item using ajax
function insertItem(){
    let item_number = $('input[name=item_number]').val();
    let item_name = $('input[name=item_name]').val();
    let item_price = $('input[name=item_price]').val();
    let item_category = $('input[name=item_category]').val();
    let item_stock = $('input[name=item_stock]').val();

    $.ajax({
        url: '/product/item/store',
        type: 'post',
        data: {item_number:item_number, item_name:item_name,
            item_price:item_price, item_category:item_category, item_stock:item_stock },
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        },
        // error: function(e){
        //     console.log(e);
        // },  
        success: function(data){
            itemTable.ajax.reload();
            clearInput('#store_ajax input');
            Toastify({
                text: "This is a toast",
                className: "info",
                style: {
                  background: "#15803d",
                }
              }).showToast();
        } 
    });
}

function editForm(id){
    showForm();
    $('#store_ajax button').attr('id', 'edit_ajax');

    $.ajax({
        url: `product/item/${id}/edit`,
        type: 'get',
        // error: function(e){
        //     console.log(e);
        // },  
        success: function(data){
           console.log(data);
        } 
    });
}

// show item table using ajax
function showItemTable(){
        itemTable = new DataTable('#item_table', {
        serverSide: true,
        processing: true,
        scrollX: true,
        stateSave: true,
        ajax: {
            url:'ajx'
        },
        method: 'get',
        columns: [
            { data: 'item_number', title: 'Item Number',  className: 'w-fit ', },
            { data: 'item_name', title: 'Item Name',  className: 'w-fit',},
            { data: 'item_price', title: 'Item Price',  className: 'w-fit', },
            { data: 'item_category', title: 'Item Category',  className: 'w-fit', },
            { data: 'item_stock', 
                title: 'Item Stock', 
                className: 'w-fit',
             },
            {   
                title: 'Actions',
                className: 'w-fit text-center action_holder',
                searchable: false,
                orderable: false,
                render: function(data, type, full, meta) {
                    // console.log(full.id);
                    return `<span  class='btn w-[150px] bg-blue-800 hover:bg-blue-700 text-white edit-btn' id="${full.id}">EDIT</span>
                            <a id="${full.id}" class='btn w-[150px] bg-red-800 hover:bg-red-700 text-white' data-confirm-delete="true">DELETE</a>`
                }
            },
        ]
        
    });
}
// show studen table
function showStudentTable(){

    let studentTable = new DataTable('#index_table', {
        scrollX: true,
        order: [[2, 'desc']],
        // responsive: true,
    });
}
// toggle modal create form
function showForm(){
    $('.my-modal').toggleClass('hide show');
}
// clear inputs
function clearInput(inputs){
    $(inputs).val('');
}

    

