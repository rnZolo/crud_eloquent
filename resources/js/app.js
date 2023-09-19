
import DataTable from 'datatables.net-dt';
import 'datatables.net-responsive-dt';
import 'datatables.net-select';
import Toastify from 'toastify-js';
import Swal from 'sweetalert2';

// login show password
$('.pass-show').on('click',function (e) {
    e.preventDefault();
    $('.pass-show').toggleClass('bi-eye-slash-fill bi-eye-fill ')
    if ($('.pass-show').hasClass('bi-eye-fill')) {
        $('.pass-log').attr('type', 'text');
    } else {
        $('.pass-log').attr('type', 'password');
    }
});

let itemTable;
let studentTable;

$(window).on('load', function(){
        // show student table
       // show item table
       showItemTable();
       showStudentsTable();
    // add student button
    $('#modal-open-btn').on("click", function(){
        showForm();
    });
    // close button
    $('#modal-close-btn').on('click keyup', function(){
        showForm();
    });
    // modal create item submit_ajax
    $(document).on('click', '#submit_ajax',function(e){
        e.preventDefault();
        insertItem();
    });
    // call to update Student
    $(document).on('click', '#edit_student',function(e){
        e.preventDefault();
        updateStudent();
    });
    // call to store Student submit_stud
    $(document).on('click', '#submit_stud',function(e){
        e.preventDefault();
        storeStudent();
    });
    // call to filter function
    $(document).on('change', '#filter_by', function(e){
        e.preventDefault();
        studentTable.ajax.reload();
    });
});

// click edit or del btn on index table
$('#index_table').on('click',function(e){
    if($(e.target).hasClass('edit-btn')){
        editStudentForm(e.target.id);
    }
    if($(e.target).hasClass('del-btn')){
        destroyStudent(e.target.id);
    }

});
// create/show student editForm
function editStudentForm(credentials){
    showForm();
    $('#store_ajax button').attr('id', 'edit_student').text('Apply Changes');
    $.ajax({
        url: `/admin/student/${credentials}/edit`, // admin/student/{student_type}_{id}/edit
        type: 'get',
        error: function(status){
            if(status.status == 400){
                Toastify({
                    text: "Student not Found",
                    className: "error",
                    style: {
                      background: "#991b1b",
                    }
                  }).showToast();
            }
        },  
        success: function(data){
           setInput('#store_ajax', data);
           $('#edit_student').data({id:data.id, old_id_number:data.id_number, old_student_type:data.student_type});
        } 
    });
}
// store/save students
function storeStudent(){
    $.ajax({
        url: '/admin/student',
        type: 'post',
        data: getInput('#store_ajax'),
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        },
        error: function(status){
            if(status.status == 422 || status.status == 400){
                let errors = status.responseJSON.errors;
                setInput('#store_ajax', getInput('#store_ajax'), errors);
            }
        }, 
        success: function(data){
            // console.log(data);
            clearInput('#store_ajax');
            studentTable.ajax.reload();
            Toastify({
                text: "Student Successfully Enrolled",
                className: "info",
                style: {
                  background: "#15803d",
                }
              }).showToast();
        }
    });
}
// update students
function updateStudent(){
    Swal.fire({
        title: 'Are you sure?',
        text: "We will Update your Information!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1e40af',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Update it!'
      }).then((result) => {
        if (result.isConfirmed) {
            let data = getInput('#store_ajax'),
            rawInputs = getInput('#store_ajax');
           // OLD Student, id number AND ID 
            $.extend(data, $('#edit_student').data());
            $.ajax({
                url: `/admin/student/${data.id}`, // admin/student/{id}
                type: 'put',
                data: data,
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                },
                error: function(status){
                    if(status.status == 422 || status.status == 400){
                        let errors = status.responseJSON.errors;
                        setInput('#store_ajax', getInput('#store_ajax'), errors);
                        Toastify({
                            text: "Student Failed to Update",
                            className: "error",
                            style: {
                              background: "#991b1b",
                            }
                          }).showToast();
                    }
                }, 
                success: function(res){
                    console.log(res, '200 update');
                    showForm();
                    editStudentForm(`${data.student_type}_${res.id}`);
                    studentTable.ajax.reload();
                    Toastify({
                        text: "Student Successfully Updated",
                        className: "info",
                        style: {
                        background: "#15803d",
                        }
                    }).showToast();
                }
            });
        }
      })

}
// destroy students
function destroyStudent(credentials){
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#991b1b',
        cancelButtonColor: '#1e40af',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/student/${credentials}` , // admin/student/{student_type}_{id}
                type: 'delete',
                data: getInput('#store_ajax'),
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                },
                error: function(status){
                    if(status.status == 400){
                        Toastify({
                            text: "Student Failed to Delete",
                            className: "error",
                            style: {
                              background: "#991b1b",
                            }
                          }).showToast();
                    }
                },
                success: function(data){
                    console.log(data);
                    clearInput('#store_ajax');
                    $('#index_table tr').removeClass('selected');
                    studentTable.ajax.reload();
                    Toastify({
                        text: "Student Successfully Deleted",
                        className: "info",
                        style: {
                          background: "#15803d",
                        }
                      }).showToast();
                }

            });

        }
      })
  
}
// show student table
function showStudentsTable(){
        studentTable = new DataTable('#index_table', {
        serverSide: true,
        processing: true,
        scrollX: true,
        // stateSave: true,
        select: 'multi',
        rowId: 'id_number', 
        ajax: { url: '/admin/ajax',
                data: function(filter_by){
                    filter_by.filter_by = $('#filter_by').val() // {filter_by:"all"}
                }
        },
        columns: [
            { data: 'student_type', title: 'Student Type',  className: 'w-fit capitalize', },
            { data: 'id_number', title: 'ID Number',  className: 'w-fit',},
            { data: 'name', title: 'Name',  className: 'w-fit', },
            { data: 'age', title: 'Age',  className: 'w-fit', },
            { data: 'gender', title: 'Gender', className: 'w-fit',},
            { data: 'city', title: 'City',  className: 'w-fit', },
            { data: 'mobile_number', title: 'Mobile Number',  className: 'w-fit', },
            { data: 'grades', title: 'Grade',  className: 'w-fit', },
            { data: 'email', title: 'Email',  className: 'w-fit', },
            {   
                title: 'Actions',
                className: 'w-fit text-center action_holder',
                searchable: false,
                orderable: false,
                render: function(data, type, full, meta) {
                    return `<span  class='btn w-[150px] bg-blue-800 hover:bg-blue-700 text-white edit-btn bi bi-pencil-square' 
                            gap-3 id="${full.student_type}_${full.id}">EDIT</span>
                            <a id="${full.student_type}_${full.id}" 
                            class='btn w-[150px] bg-red-800 hover:bg-red-700 text-white bi bi-trash3-fill del-btn bi bi-trash3-fill gap-3'
                             data-confirm-delete="true">DELETE</a>`
                }
            },
        ]
        
    });
}
// toggle modal create form
function showForm(){
    clearInput('#store_ajax');
    $('.my-modal').toggleClass('hide show');
    $('#edit_student').data();
    $('#store_ajax button').attr('id', 'submit_stud').text('Create Student');
}
// get input value
function getInput(formID){
    return  {   'student_type': $(`${formID} select[name=student_type]`).val(),
                'id_number': $(`${formID} input[name=id_number]`).val(),
                'name': $(`${formID} input[name=name]`).val(),
                'age': $(`${formID} input[name=age]`).val(),
                'gender': $(`${formID} select[name=gender]`).val(),
                'city': $(`${formID} input[name=city]`).val(),
                'mobile_number': $(`${formID} input[name=mobile_number]`).val(),
                'email': $(`${formID} input[name=email]`).val(),
                'grades': $(`${formID} input[name=grades]`).val(),
   }
}
// se input value
function setInput(formId, values, errors = 0){
    for (let key in values) {
        let infoVal = values[key] ?? '';
        if(key != 'student_type' & key != 'gender'){
            $(`${formId} input[name=${key}]`).val(`${infoVal}`);
            if(errors[key]){   
                $(`${formId} input[name=${key}]`).addClass('border-2 border-red-500');
                $(`${formId} #err_${key}`).text(errors[key][0]);  
            }else{
                $(`${formId} input[name=${key}]`).removeClass('border-2 border-red-500');
                $(`${formId} #err_${key}`).text(''); 
            }
        }else{
            $(`${formId} select[name=${key}]`).val(`${infoVal}`).attr('Selected', true);  
            if(errors[key]){
                $(`${formId} select[name=${key}]`).addClass('ring-2 ring-red-500 border-0');
                $(`${formId} #err_${key}`).text(errors[key][0]);  
                // console.log();
            }else{
                $(`${formId} select[name=${key}]`).removeClass('ring-2 ring-red-500 border-0');
                $(`${formId} #err_${key}`).text('');  
            }
        }
    }              
}
// clear inputs
function clearInput(formId){
    $(`${formId} input`).val('').removeClass('border-2 border-red-500');
    $(`${formId} select`).val('').removeClass('ring-2 ring-red-500 border-0');
    $(`${formId} label span`).text('');
}
// get selected row
function getRowSelected(){
    let id_nums = document.querySelectorAll('#index_table tr.selected');
    let id_numbers=[];
    id_nums.forEach(id_number =>{
        id_numbers.push(id_number.id);
    })
    return id_numbers;
}

// disable multi-btn if 1 select
$(document).on('click', '#whole', function(e){
    e.preventDefault();
    let selected = getRowSelected()
    if(selected.length > 1){
        $('#multi_del').attr('disabled', false);
    }else{
        $('#multi_del').attr('disabled', true);
    }
  
});
// multiple delete
$(document).on('click', '#multi_del', function(e){
    e.preventDefault();
        let id_numbers = getRowSelected();
        console.log({id_numbers}, id_numbers.length);
        Swal.fire({
            title: 'Are you sure?',
            text: `All ${id_numbers.length} rows will be deleted!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#991b1b',
            cancelButtonColor: '#1e40af',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/student/delete_selected` , // admin/student/delete_selected
                    type: 'delete',
                    data: {id_numbers},
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    },
                    error: function(status){
                        if(status.status == 400){
                            Toastify({
                                text: "Students Failed to Delete",
                                className: "error",
                                style: {
                                  background: "#b91c1c",
                                }
                              }).showToast();
                        }
                    },
                    success: function(data){
                        // console.log(data);
                        studentTable.ajax.reload();
                        Toastify({
                            text: "Student Successfully Deleted",
                            className: "info",
                            style: {
                              background: "#15803d",
                            }
                          }).showToast();
                    }
    
                });
    
            }
          })
});
// select all
$(document).on('click', '#select_all', function(e){
        $(e.target).toggleClass('checked bi bi-check-square-fill');
        if($(e.target).hasClass('checked')){
            $('#index_table tr').addClass('selected'); // addclass to selected  rows
        }else{
            $('#index_table tr').removeClass('selected'); // remove class of selected rows
        }
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
// create Item editForm
function editItemForm(credentials){
    showForm();
    // console.log(credentials);
    $.ajax({
        url: `product/item/${credentials}/edit`, // admin/student/{student_type}_{id}/edit
        type: 'get',
        // error: function(e){
        //     console.log(e);
        // },  
        success: function(data){
        //    console.log(data);
        } 
    });
}// show item table using ajax
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
                // console.log(full);
                return `<span  class='btn w-[150px] bg-blue-800 hover:bg-blue-700 text-white edit-btn' id="${full.student_type}_${full.id}">EDIT</span>
                        <a id="${full.id}" class='btn w-[150px] bg-red-800 hover:bg-red-700 text-white' data-confirm-delete="true">DELETE</a>`
            }
        },
    ]
    
});
}