$(document).ready(function (e) {
   $('#user_list').select2();
   var table = $('#company_staff_count_datatable').DataTable({
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
               console.log(company_name);
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
});