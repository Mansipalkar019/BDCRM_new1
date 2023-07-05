$(document).ready(function (e) {
   var label_name='';
   $.ajax({
      dataType: 'json',
      type: 'POST',
      url: bases_url + 'projects/get_input_type',
      data: {
         label_name: label_name,
      },
      success: function (response) {
         $('#input_type').html(response);
      }
   });
   $.ajax({
      url: bases_url + 'projects/get_all_input_fields',
      type: 'post',
      dataType: "json",
      
      success: function (response) {
         $('#project_id').html(response);
      },
   });

   $('#user_list').select2();
   var table = $('#company_staff_count_datatable').DataTable({
       retrieve: true,
      'ajax': {
         'url': bases_url + 'projects/display_all_company_staff',
         'type': "POST",
         'data': function (data) {
            // Read values
            var id = $('#id').val();
            var slot_count = $('#slot_allocation').val();
            var workalloc = $('#workalloc').val();

            // Append to data
            data.id = id;
            data.slot_count = slot_count;
            data.workalloc = workalloc;
         }
      },
      "columns": [{
            "data": null
         },
         {
            "data": "staff_count",     

              render: function (data, type, row) {               
                 let staff_count = row.staff_count;
                   var display_status_name = '<span><a href=' + bases_url + 'Projects/get_staff_info?id="' + btoa(row['project_id']) + '"&received_company_name="' + btoa(unescape(encodeURIComponent(row['received_company_name']))) + '" class="badge btn btn-primary btn-sm">' + staff_count + '</a></span>';
                 return display_status_name;
         },
         },
         {

            "data": "completed_updated_status"
         },
         {
            "data": "received_company_name"
         },
         {
            "data": "created_date"
         },
         {
            "data": "user_name"
         },
         {
            "data": "project_id",
            render: function (data, type, row) {
               let project_id = row.project_id;
               var display_status_name = "<a href=" + bases_url + 'Projects/my_projects/' + btoa(row['project_id']) + '/' + btoa(row['id']) + '/' + btoa(unescape(encodeURIComponent(row['received_company_name']))) + "><i class='fa-solid fa-eye'></i></i></a>";
               return display_status_name;
            },
         },
      ],
      "order": [
         [0, 'desc']
      ]
   });
     var designation_name = $('#designation_name').val();
     if(designation_name=="Researcher"){
         $('#company_staff_count_datatable').DataTable().column(2).visible(false);
    $('#company_staff_count_datatable').DataTable().column(6).visible(false);

     }
     if(designation_name=="Superadmin"){
         $('#company_staff_count_datatable').DataTable().column(6).visible(false);
     }
   $('#slot_allocation').keyup(function () {
      table.ajax.reload();
      var id = $('#id').val();
      var slot_count = $('#slot_allocation').val();
      var workalloc = $('#workalloc').val();
      $.ajax({
         url: bases_url + 'projects/display_all_company_staff',
         type: 'post',
         dataType: "json",
         data: {
            id: id,
            slot_count: slot_count,
            workalloc: workalloc
         },
         success: function (response) {
            $('#total_staff_count').val(response.total_staff_count);
         },
      });
   });
   $('#workalloc').change(function () {
      table.ajax.reload();
      var id = $('#id').val();
      var slot_count = $('#slot_allocation').val();
      var workalloc = $('#workalloc').val();
      $.ajax({
         url: bases_url + 'projects/display_all_company_staff',
         type: 'post',
         dataType: "json",
         data: {
            id: id,
            slot_count: slot_count,
            workalloc: workalloc
         },
         success: function (response) {
            $('#total_staff_count').val(response.total_staff_count);
         },
      });
   });
   table.on('order.dt search.dt', function () {
      table.column(0, {
         search: 'applied',
         order: 'applied'
      }).nodes().each(function (cell, i) {
         cell.innerHTML = i + 1;
      });
   }).draw();
   $('#btn-search-by-date').click(function () {
      var company_name = [];
      var slot_allocation = $('#slot_allocation').val();
      var user_list = $('#user_list').val();
      var id = $('#id').val();
      var total_staff_count=$('#total_staff_count').val();
      if (slot_allocation == "") {
          Swal.fire({
               title: 'Warning',
               text: "Please Enter Slot Allocation Count",
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#FD7E14',
               confirmButtonText: 'Yes!',
               cancelButtonText: 'No.',

            });
      } else {
         for (var i = 0; i < slot_allocation; i++) {
            d = table.rows({
               search: 'applied'
            }).nodes()[i];
            if (d) {
               var td = d.getElementsByTagName("td")[3];
               // var assigned_td = d.getElementsByTagName("td")[4];
               // var assigned_td_1 = assigned_td.innerHTML;
               // if (assigned_td_1) {
               //    slot_allocation++;
               // } else {
               var td_text = td.innerHTML;
               company_name.push(td_text);
               // }
            }
         }
         if (user_list == "") {
            Swal.fire({
               title: 'Warning',
               text: "Please Select User",
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#FD7E14',
               confirmButtonText: 'OK!',
            });
         } else {
            if (company_name) {
              
               $.ajax({
                  dataType: 'json',
                  type: 'POST',
                  url: bases_url + 'projects/save_company_allocation_data',
                  data: {
                     company_name: company_name,
                     user_list: user_list,
                     project_id: id,
                     total_staff_count:total_staff_count,
                  },
                  success: function (response) {
                     if(response.status=='success'){
                        Swal.fire(
                          'Good job!',
                           response.message,
                          'success'
                        ).then((result) => {
                          if (result.isConfirmed) {
                            location.reload();
                          }
                        })
                        setTimeout(function(){location.reload()},3000);
                     } else if(response.status=='failure'){
                        
                        Swal.fire({
                          title: 'Oops...',
                          text: response.message,
                          icon: 'error',
                          confirmButtonColor: '#3085d6',
                          confirmButtonText: 'Ok'
                        }).then((result) => {
                          if (result.isConfirmed) {
                            setTimeout(function(){location.reload()},2000);
                          }
                        })
                     }
                  
                  }
               });
            }
         }
      }
   });
   
   $('.project_id').on('change',function(e){

      var optionnselected=$("#project_id").val();
      var label_name=optionnselected;
      $.ajax({
         dataType: 'json',
         type: 'POST',
         url: bases_url + 'projects/get_input_type',
         data: {
            label_name: label_name,
         },
         success: function (response) {
            $('#input_type').html(response);
         }
      });
   });
});
var i=1;
$('#addRows1').click(function() {  
    label_name = '';
  if(i>1){
     var selected = ($('#project_id_'+i+' :selected').text());
  }else{
       var selected = ($('#project_id :selected').text());
  }        
   
   if(selected!='Select Feilds'){
       
   i++;
   $.ajax({
      url: bases_url + 'projects/get_all_input_fields',
      type: 'post',
      dataType: "json",
     
      success: function (response) {
      html2=""; 
      html2 += '<div id="inputFormRow">';
      html2 += '<div class="input-group" style="margin-top: 1%;margin-left: 111px;">';         
      html2 += '<div class="form-group"><select  class="form-control form-control-sm assign_id_'+i+'" id="assign_id_'+i+'" name="assignment[]" style="width:100px;"><option value="AND">AND</option><option value="OR">OR</option></select></div><div class="form-group"><select class="form-control project_id_'+i+' form-control-sm" id="project_id_'+i+'" name="input_field[]" style="width:200px;margin-left:15px;" onchange="onchangeinput('+i+')" required>'+response+'</select></div><div class="form-group"><select  class="form-control form-control-sm project_id" id="project_id" name="operator[]" style="margin-left:15px;width:200px;"><option value="=">=</option><option value="!=">!=</option><option value="LIKE">LIKE</option><option value="NOT LIKE">NOT LIKE</option><option value="NULL">NULL</option></select></div><div class="form-group"><span id="input_type_'+i+'"></span></div><button class="btn btn-danger btn-sm" id="removeRow" style="margin-left:25px;height: 30px;"><i class="fa fa-trash"></i></button>';   
      html2 += '</div>';
      html2 += '</div>';
      $('#newRow').append(html2);
      $.ajax({
         dataType: 'json',
         type: 'POST',
         url: bases_url + 'projects/get_input_type',
         data: {
            label_name: label_name,
         },
         success: function (response) {
            $('#input_type_'+i).html(response);
         }
      });

      },
   });
  }else{
      alert("Can't Proceed, Please choose the fields in which you want to search.")
  }
   
   
   
});
function onchangeinput(val)
{
   var label_name=$("#project_id_"+val).val();
   $.ajax({
      dataType: 'json',
      type: 'POST',
      url: bases_url + 'projects/get_input_type',
      data: {
         label_name: label_name,
      },
      success: function (response) {
         $('#input_type_'+val).html(response);
      }
   });
}
$(document).on('click', '#removeRow', function() {
   $(this).closest('#inputFormRow').remove();
});



$("#slot_allocation").on("change", function(event){
  $slot_allocation=$('#slot_allocation').val();
  $('#company_count').val($slot_allocation);
});


function ResetFilters(){
  
}

function advancesearch(){
   $("#advancesearchId").show();
  
}