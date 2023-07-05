
$("#update_company_details_form").submit(function(e) {
    var class_list =[]
    e.preventDefault();
    var formData = new FormData($("#update_company_details_form")[0]);
    var attributeForm = $(this);
    var company_name=$('#company_name').val();
    var company_received=$('#company_received').val();
    var session_user_id=$('#session_user_id').val();
    var research_remark=$(".research_remark").val();
    var country = $("#country").val();
    var address_1=$('#address_1').val(); 
    
    var city_name=$('#city_name').val();
    var state_name=$('#state_name').val();         
    var address_source_url=$('#address_source_url').val(); 
    var staff_email=$('#staff_email').val();
    var staff_email_harvesting=$('#staff_email_harvesting').val();
    var assumed_email=$('#assumed_email').val();
    var job_title=$("#job_title").val();
    var title=$("#title").val(); 
    var tel_number=$("#tel_number").val();
    var website_url=$("#website_url").val();
    var staff_direct_tel=$("#staff_direct_tel").val();
    var web_staff_disposition=$("#web_staff_disposition").find(":selected").text().toLowerCase();
    var web_staff_disposition1=$("#web_staff_disposition").find(":selected").val();
    var voice_staff_disposition=$("#voice_staff_disposition").find(":selected").text().toLowerCase();
    var voice_staff_disposition1=$("#voice_staff_disposition").find(":selected").val();
    var company_disposition=$("#company_disposition").find(":selected").val();
    var company_web_dispositon=$("#company_web_dispositon").find(":selected").val();
    var company_voice_disposition=$("#company_voice_disposition").find(":selected").val();
    var staff_url=$("#staff_url").val();
    var researcher_company_remark=$(".researcher_company_remark").val();
    var caller_company_remark=$(".caller_company_remark").val();
    var voice_remark=$(".voice_remark").val();
    var researcher_company_note=$("#researcher_company_note").val();
    var caller_company_note=$("#caller_company_note").val();
    var staff_id=$("#staff_id").val();
    var postal_code=$("#postal_code").val();
    var first_name=$(".first_name").val();
    var last_name=$(".last_name").val();
    var postal_codes=$("#postal_codes").val();
    var staff_note=$("#staff_note").val();
    var from_date=$(".datetimepicker1").val();
    var company_received=$("#company_received").val();
       if(company_voice_disposition == "")
        {
          $("#valid_error").css('display','block');
          var class_name="Select Company Voice Disposition";
          class_list.push(class_name);
          $('#company_voice_disposition').css('border','1px solid red');
          $('#company_voice_disposition').css('padding','0px');
          $('#company_voice_disposition').css('border-radius','0px');
        }
        else{
          $('#company_voice_disposition').css('border','1px solid #ced4da');
          $('#company_voice_disposition').css('padding','0px');
          $('#company_voice_disposition').css('border-radius','0px');
        }
        if(voice_staff_disposition1 == "")
        {
          $("#valid_error").css('display','block');
          var class_name="Select Voice Staff Disposition";
          class_list.push(class_name);
          $('.voice_staff_disposition').css('border','1px solid red');
          $('.voice_staff_disposition').css('padding','0px');
          $('.voice_staff_disposition').css('border-radius','0px');
        }
        else{
          $('.voice_staff_disposition').css('border','1px solid #ced4da');
          $('.voice_staff_disposition').css('padding','0px');
          $('.voice_staff_disposition').css('border-radius','0px');
        }

        if(from_date == "")
        {
    
         var arrays=['16','17','56','43','46','47','51','52','58','59'];

         if ($.inArray(voice_staff_disposition1, arrays) >= 0) {
            $("#valid_error").css('display','block');
            var class_name="Enter Followup DateTime";
            class_list.push(class_name);
            $('.datetimepicker1').css('border','1px solid red');
            $('.datetimepicker1').css('padding','1px');
            $('.datetimepicker1').css('border-radius','0px');
         } else {
            $('.datetimepicker1').css('border','1px solid #ced4da');
            $('.datetimepicker1').css('padding','0px');
            $('.datetimepicker1').css('border-radius','0px');
         }
      
        } else{
         $("#valid_error").css('display','none');
         $('.datetimepicker1').css('border','1px solid #ced4da');
         $('.datetimepicker1').css('padding','0px');
         $('.datetimepicker1').css('border-radius','0px');
        }

        if(staff_note == "")
        {
          $("#valid_error").css('display','block');
          var class_name="Enter Caller Remark";
          class_list.push(class_name);
          $('#staff_note').css('border','1px solid red');
          $('#staff_note').css('padding','0px');
          $('#staff_note').css('border-radius','0px');
        }
        else{
          $('#staff_note').css('border','1px solid #ced4da');
          $('#staff_note').css('padding','0px');
          $('#staff_note').css('border-radius','0px');
        }


    formData.append('error_count',class_list.length);
    formData.append('web_staff_disposition',web_staff_disposition1);
    formData.append('voice_staff_disposition',voice_staff_disposition1);
    formData.append('company_web_dispositon',company_web_dispositon);
    formData.append('company_voice_disposition',company_voice_disposition);
    formData.append('researcher_company_remark',researcher_company_remark);
    formData.append('caller_company_remark',caller_company_remark);
    formData.append('voice_remark',voice_remark);
    formData.append('researcher_company_note',researcher_company_note);
    formData.append('caller_company_note',caller_company_note);

    jQuery.ajax({
        dataType: "json",
        type: "POST",
        url: attributeForm.attr("action"),
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        mimeType: "multipart/form-data",
        beforeSend: function() {
           
        },
        success: function(response) {
            console.log(response);
          if (response.status == 'success') {
             swal({
              title: "saved",
              text: response.status.msg,
              icon: "success",
              dangerMode: true,
              timer: 1500
           });
           
            } else if (response.status == 'failure') {
             error_msg(response.error);
             swal({
              title: "Warning",
              text: response.error.msg,
              icon: "warning",
              dangerMode: true,
              timer: 1500
           });
            }  
        },
        error: function(error, message) {},
    });
   
     if(class_list.length != '0')
    {
        $("#valid_error").empty();
        jQuery.each(class_list, (index, item) => {
            
          $("#valid_error").css("padding","20px");
          $("#valid_error").css("border","1px solid #D0D0D0");
          $("#valid_error").css("font-size","13px");
          $("#valid_error").css("font-weight","700");
          $("#valid_error").css("overflow","scroll");
          $("#valid_error").css("height","100px");
          $("#valid_error").append("<span class='label label-important' style='color:#FF0000'>"+item+'</span><br>');
        });
        $('#company_submit').addClass('disabled');
        $("#checkall_"+staff_id).empty();
        $("#checkall_"+staff_id).append('<span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"><span class="fa fa-times"></span>');
        
        $("#check_"+staff_id).empty();
        $("#check_"+staff_id).append('<span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"><span class="fa fa-times"></span>');
        

    }else{
       
    $("#valid_error").empty();
    $("#valid_error").css('display','none');
    formData.append('error_count',class_list.length);
    formData.append('web_staff_disposition',web_staff_disposition1);
    formData.append('voice_staff_disposition',voice_staff_disposition1);
    formData.append('company_web_dispositon',company_web_dispositon);
    formData.append('company_voice_disposition',company_voice_disposition);
    formData.append('researcher_company_remark',researcher_company_remark);
    formData.append('caller_company_remark',caller_company_remark);
    formData.append('voice_remark',voice_remark);
    formData.append('researcher_company_note',researcher_company_note);
    formData.append('caller_company_note',caller_company_note);
    jQuery.ajax({
        dataType: "json",
        type: "POST",
        url: attributeForm.attr("action"),
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        mimeType: "multipart/form-data",
        beforeSend: function() {
           
        },
        success: function(response) {
            console.log(response);
          if (response.status == 'success') {
             swal({
              title: "saved",
              text: response.status.msg,
              icon: "success",
              dangerMode: true,
              timer: 1500
           });
           window.location.reload(true);
            } else if (response.status == 'failure') {
             error_msg(response.error);
             swal({
              title: "Warning",
              text: response.error.msg,
              icon: "warning",
              dangerMode: true,
              timer: 1500
           });
            }  
        },
        error: function(error, message) {},
    });
  
    }
    

    if (IsEmail(staff_email) == false && staff_email != '') {
        var class_name="Email is not valid";
        class_list.push(class_name);
	}

    if (staff_tel(staff_direct_tel) == false && staff_direct_tel != '') {
        var class_name="*Enter Valid Direct Tel: Numbers X Number.";
        class_list.push(class_name);
    }

 });


 function IsEmail(email) {
    var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    if (!pattern.test(email)) {
        return false;
    }
    else {
        return true;
    }
}

function staff_tel(telno){
    var isValid = false;
    var regex = /^[Xx0-9\s]*$/;
    isValid = regex.test(telno);
    return isValid;
   }


  $('#voice_staff_disposition').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
    var task_type=$("#task_type").val();
    var first_name=$("#first_name").val();
    var last_name=$("#last_name").val();
    var fullname=first_name+last_name;

    if(valueSelected == '36' && task_type == "name with unnamed")
    {
      if(session_user_id==8 || session_user_id==1)
      {
      $('#acquired').css("display","none");
      $('#call_staff_left_added').css("display","inline-block");
      $('#calladded').css("display","none");
      
      }else if(session_user_id==8 || session_user_id==1)
      {
      $('#acquired').css("display","none");
      $('#call_staff_left_added').css("display","none");
      $('#calladded').css("display","none");
      }
      $('#callreplacement').css("display","inline-block");
    }
    else 
    {
      if(session_user_id==8 || session_user_id==1)
      {
      $('#acquired').css("display","none");
      $('#call_staff_left_added').css("display","none");
      $('#calladded').css("display","inline-block");
      }
      else if(session_user_id==8 || session_user_id==1)
      {
      $('#acquired').css("display","none");
      $('#call_staff_left_added').css("display","none");
      $('#calladded').css("display","none");
      }
      $('#callreplacement').css("display","none");
    }


});

/**======================================================For Researcher Login ==========================================================*/
$("#added").click(function(e) {
   // alert("I AM NS ADDED BUTTON")
   if (confirm("Are You Sure! You want to add this record") == true) {
    $("#update_company_details_form").submit();
    var project_id=$('#project_id').val();
    var staff_id=$('#staff_id').val();
    var assigned_by=$('#assigned_by').val();
    var web_staff_disposition1=$("#web_staff_disposition").find(":selected").val();
    $.ajax({
       url: bases_url+'Projects/insert_noresult_row',
       type: 'post',
       dataType: "json",
       data: {
          project_id: project_id,staff_id:staff_id,assigned_by:assigned_by,web_staff_disposition1
       },
       success: function( data ) {
          if (data.status == 'success') {
             var url= bases_url + 'Projects/my_projects/'+btoa(data.error.project_id)+'/'+btoa(data.error.staff_id)+'/'+btoa(data.error.company_name);
             window.location.href = url;
          }
       }
    });
 } else {
   text = "You canceled!";
 }
   
  });

  $("#replacement").click(function(e) {
   // alert("I AM SL Replacement BUTTON")
   if (confirm("Are You Sure! You want to add this record") == true) {
    $("#update_company_details_form").submit();
    var project_id=$('#project_id').val();
    var staff_id=$('#staff_id').val();
    var assigned_by=$('#assigned_by').val();
    var voice_staff_disposition1=$("#voice_staff_disposition").find(":selected").val();
    var web_staff_disposition1=$("#web_staff_disposition").find(":selected").val();


    $.ajax({
       url: bases_url+'Projects/insert_replacement_row',
       type: 'post',
       dataType: "json",
       data: {
          project_id: project_id,staff_id:staff_id,assigned_by:assigned_by,web_staff_dispo:web_staff_disposition1,voice_staff_dispositions:voice_staff_disposition1
       },
       success: function( data ) {
          if (data.status == 'success') {
             var url= bases_url + 'Projects/my_projects/'+btoa(data.error.project_id)+'/'+btoa(data.error.staff_id)+'/'+btoa(data.error.company_name);
            window.location.href = url;
          }
          else if(data.status == 'failure')
          {
            swal({
                title: "Warning",
                text: 'nn',
                icon: "warning",
                dangerMode: true,
                timer:70000
             });
          }
       }
    });
 } else {
   text = "You canceled!";
 }
   
  });
  
    $("#staff_left_added").click(function(e) {
    //alert("I AM SL Added BUTTON")
    if (confirm("Are You Sure! You want to add this record") == true) {
        $("#update_company_details_form").submit();
    var web_staff_disposition1=$("#web_staff_disposition").find(":selected").val();
    var project_id=$('#project_id').val();
    var staff_id=$('#staff_id').val();
    var assigned_by=$('#assigned_by').val();
    $.ajax({
       url: bases_url+'Projects/insert_staff_row',
       type: 'post',
       dataType: "json",
       data: {
          project_id: project_id,staff_id:staff_id,assigned_by:assigned_by,web_staff_dispo:web_staff_disposition1
       },
       success: function( data ) {
          if (data.status == 'success') {
             var url= bases_url + 'Projects/my_projects/'+btoa(data.error.project_id)+'/'+btoa(data.error.staff_id)+'/'+btoa(data.error.company_name);
             window.location.href = url;
          }
          else if(data.status == 'failure')
          {
            swal({
                title: "Warning",
                text: data.error.msg,
                icon: "warning",
                dangerMode: true,
                timer:70000
             });


          }
       }
    });
     } else {
       text = "You canceled!";
     }
   
  });
  
  $("#staff_left_addesd").click(function(e) {

        // alert("I AM SL Added BUTTON")
    ("#update_company_details_form").submit();
    var project_id=$('#project_id').val();
    var staff_id=$('#staff_id').val();
    var assigned_by=$('#assigned_by').val();
    $.ajax({
       url: bases_url+'Projects/insert_staff_row',
       type: 'post',
       dataType: "json",
       data: {
          project_id: project_id,staff_id:staff_id,assigned_by:assigned_by
       },
        success: function( data ) {
          if (data.status == 'success') {
             var url= bases_url + 'Projects/my_projects/'+btoa(data.error.project_id)+'/'+btoa(data.error.staff_id)+'/'+btoa(data.error.company_name);
             window.location.href = url;
          }
          else if(data.status == 'failure')
          {
            swal({
                title: "Warning",
                text: data.error.msg,
                icon: "warning",
                dangerMode: true,
                timer:70000
             });
          }
       }
    });
  });


   $("#acquired").click(function(e) {
    var first_name=$(".first_name").val();
    var last_name=$(".last_name").val();
    if(first_name =="" || last_name=="")
    {
        swal({
            title: "Warning",
            text: "Enter First Name Or Last Name",
            icon: "warning",
            dangerMode: true,
            timer:70000
         });
    }else{
 //alert("I AM SL Added BUTTON")
 if (confirm("Are You Sure! You want to add this record") == true) {
    $("#update_company_details_form").submit();
var web_staff_disposition1=$("#web_staff_disposition").find(":selected").val();
var voice_staff_disposition1=$("#voice_staff_disposition").find(":selected").val();
var project_id=$('#project_id').val();
var staff_id=$('#staff_id').val();
var assigned_by=$('#assigned_by').val();
$.ajax({
   url: bases_url+'Projects/insert_acquired_row',
   type: 'post',
   dataType: "json",
   data: {
      project_id: project_id,staff_id:staff_id,assigned_by:assigned_by,web_staff_dispo:web_staff_disposition1,voice_staff_dispositions:voice_staff_disposition1
   },
   success: function( data ) {
      if (data.status == 'success') {
         var url= bases_url + 'Projects/my_projects/'+btoa(data.error.project_id)+'/'+btoa(data.error.staff_id)+'/'+btoa(data.error.company_name);
         window.location.href = url;
      }
      else if(data.status == 'failure')
      {
        swal({
            title: "Warning",
            text: data.error.msg,
            icon: "warning",
            dangerMode: true,
            timer:70000
         });


      }
   }
});
 } else {
   text = "You canceled!";
 }
}
   
   
  });

  /**======================================================For Caller Login ==========================================================*/
  $("#calladded").click(function(e) {
    // alert("I AM NS ADDED BUTTON")
       if (confirm("Are You Sure! You want to add this record") == true) {
           $("#update_company_details_form").submit();
            var project_id=$('#project_id').val();
            var staff_id=$('#staff_id').val();
            var assigned_by=$('#assigned_by').val();
            var web_staff_disposition1=$("#company_voice_disposition").find(":selected").val();
            var voice_staff_disposition1=$("#voice_staff_disposition").find(":selected").val();
            var company_received=$('#company_received').val();

             $.ajax({
               url: bases_url+'Projects/insert_noresult_row',
               type: 'post',
               dataType: "json",
               data: {
                  project_id: project_id,staff_id:staff_id,assigned_by:assigned_by,web_staff_disposition1:web_staff_disposition1,voice_staff_disposition1:voice_staff_disposition1,company_received:company_received
               },
               success: function( data ) {
                  if (data.status == 'success') {
                     var url= bases_url + 'Projects/my_projects/'+btoa(data.error.project_id)+'/'+btoa(data.error.staff_id)+'/'+btoa(data.error.company_name);
                     window.location.href = url;
                  }
               }
            });
        } else {
          text = "You canceled!";
        }
   
   });

   $("#callreplacement").click(function(e) {
    // alert("I AM SL Replacement BUTTON")
     if (confirm("Are You Sure! You want Replace this record") == true) {
       $("#update_company_details_form").submit();
     var project_id=$('#project_id').val();
     var staff_id=$('#staff_id').val();
     var assigned_by=$('#assigned_by').val();
     var voice_staff_disposition1=$("#voice_staff_disposition").find(":selected").val();
     var web_staff_disposition1=$("#company_voice_disposition").find(":selected").val();
 
     $.ajax({
        url: bases_url+'Projects/insert_replacement_row',
        type: 'post',
        dataType: "json",
        data: {
           project_id: project_id,staff_id:staff_id,assigned_by:assigned_by,web_staff_dispo:web_staff_disposition1,voice_staff_dispositions:voice_staff_disposition1
        },
        success: function( data ) {
           if (data.status == 'success') {
              var url= bases_url + 'Projects/my_projects/'+btoa(data.error.project_id)+'/'+btoa(data.error.staff_id)+'/'+btoa(data.error.company_name);
             window.location.href = url;
           }
           else if(data.status == 'failure')
           {
             swal({
                 title: "Warning",
                 text: 'nn',
                 icon: "warning",
                 dangerMode: true,
                 timer:70000
              });
           }
        }
     });
    } else {
      text = "You canceled!";
    }
    
   });


$("#call_staff_left_added").click(function(e) {
    if (confirm("Are You Sure! You want Add this record") == true) {
        $("#update_company_details_form").submit();
      var project_id=$('#project_id').val();
      var staff_id=$('#staff_id').val();
      var assigned_by=$('#assigned_by').val();
      var voice_staff_disposition1=$("#voice_staff_disposition").find(":selected").val();
      var web_staff_disposition1=$("#company_voice_disposition").find(":selected").val();
      $.ajax({
        url: bases_url+'Projects/insert_staff_row',
        type: 'post',
        dataType: "json",
        data: {
           project_id: project_id,staff_id:staff_id,assigned_by:assigned_by,web_staff_dispo:web_staff_disposition1,voice_staff_dispositions:voice_staff_disposition1
        },
         success: function( data ) {
           if (data.status == 'success') {
              var url= bases_url + 'Projects/my_projects/'+btoa(data.error.project_id)+'/'+btoa(data.error.staff_id)+'/'+btoa(data.error.company_name);
              window.location.href = url;
           }
           else if(data.status == 'failure')
           {
             swal({
                 title: "Warning",
                 text: data.error.msg,
                 icon: "warning",
                 dangerMode: true,
                 timer:70000
              });
           }
        }
     });
      
     } else {
       text = "You canceled!";
     }


});

$("#callacquired").click(function(e) {
    // alert("I AM NS ADDED BUTTON")
       if (confirm("Are You Sure! You want to add this record") == true) {
           $("#update_company_details_form").submit();
            var project_id=$('#project_id').val();
            var staff_id=$('#staff_id').val();
            var assigned_by=$('#assigned_by').val();
            var web_staff_disposition1=$("#web_staff_disposition").find(":selected").val();
            var voice_staff_disposition1=$("#voice_staff_disposition").find(":selected").val();

            //  alert(web_staff_disposition1);
            //  alert(voice_staff_disposition1);
             $.ajax({
               url: bases_url+'Projects/insert_acquired_row',
               type: 'post',
               dataType: "json",
               data: {
                  project_id: project_id,staff_id:staff_id,assigned_by:assigned_by,web_staff_dispo:web_staff_disposition1,voice_staff_dispositions:voice_staff_disposition1
               },
               success: function( data ) {
                  if (data.status == 'success') {
                     var url= bases_url + 'Projects/my_projects/'+btoa(data.error.project_id)+'/'+btoa(data.error.staff_id)+'/'+btoa(data.error.company_name);
                     window.location.href = url;
                  }
               }
            });
        } else {
          text = "You canceled!";
        }
   
   });
