<link href="<?php echo base_url();?>public/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> 
<script src="https://momentjs.com/downloads/moment.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />

<script src="https://momentjs.com/downloads/moment.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />

<link href="<?= base_url() ?>public_1/lib/main.css" rel="stylesheet" />
<script src="<?= base_url() ?>public_1/lib/main.js"></script>
    

<style>
    #code{width:100%;height:200px}
.grey-bg {  
background-color: #F5F7FA;
}
.fc .fc-list-event.fc-event-forced-url {
    cursor: pointer;
    font-size: 16px !important;
}
.fc-direction-ltr .fc-timegrid-col-events {
    margin: 0 2.5% 0 2px;
    padding: 6px;
}
</style>
<div class="content-page">
<div class="content">
<div class="container-fluid">

<div class="grey-bg container-fluid" style="font-size: 100%"><br>
<section id="minimal-statistics">
<div class="row">
            <div class="col-auto">
                <?= form_open('Projects/calendar_search', array('method' => 'GET')) ?>
                <div class="form-row">
                    <?php 
                       $designation_id =  $this->session->userdata('designation_id');
                       $designation_info  = ($designation_id!='8') ? "disabled" : '' ;
                    ?>
                     <div class="col-auto">
                          <select class="form-control form-control-sm" name="user_id" id="user_id" title="select users to search calendar records..." <?= $designation_info;?>>
                          <option value="" disabled="">Select User</option>
                                      <?php   
                                       $user_id = $this->session->userdata('id');
                                        foreach ($all_users as $key => $value) { 

                                             if(isset($_GET['user_id']) ? $_GET['user_id'] : ''){
                                                     $user_id = $_GET['user_id'];
                                                      $selected = ($value['id']==$user_id) ? "selected" : '' ;
                                             }else{
                                                 $selected = ($value['id']==$user_id) ? "selected" : '' ;
                                             }
                                            
                                            ?>
                                            <option value="<?= $value['id'];?>" <?= $selected;?>><?= $value['first_name']." ".$value['last_name'] ;?></option>
                                      <?php } ?>

                              </select>
                    </div>

                   
                    <div class="col-auto">
                        <div class="input-group date" id="" data-target-input="nearest">
                            <input type="date" class="form-control form-control-sm datetimepicker-input" data-target="" id="from_date" name="from_date" placeholder="From Date" value="<?= isset($_GET['from_date']) ? $_GET['from_date'] : '' ?>" />

                        </div>
                    </div>

                    <div class="col-auto">
                        <div class="input-group date" id="" data-target-input="nearest">
                            <input type="date" class="form-control form-control-sm datetimepicker-input" data-target="" id="to_date" name="to_date" placeholder="To Date" value="<?= isset($_GET['to_date']) ? $_GET['to_date'] : '' ?>" />
                           
                        </div>
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                        <button type="reset" onclick="flushrecord()" class="btn btn-danger btn-sm">Reset</button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>

        <div id='calendar'></div>
    
      
</section>
</div>
</div>
</div>
</div>

<style>
    /* .fc-event-title,.fc-event-time { } */
    /* .fc-custom1-button { opacity: 0.5; } */
</style>

<script>
     var bases_url="<?=base_url() ?>"
    function flushrecord(){
        // ('#from_date').val("");
        // ('#from_date').val("");
         window.location.href = bases_url+"Projects/calendar_view";
    }
    // https://fullcalendar.io/docs/eventTimeFormat
    // https://fullcalendar.io/docs#toc

    var the_count = 0;
    // var table = document.getElementByClassName("fc-list-table tbody");
    // var the_count = table.rows.length;

    // var tableObject = document.getElementsByClassName("fc-list-table");
    // var the_count = tableObject[1].childElementCount;
    
    document.addEventListener('DOMContentLoaded', function() {
        var testvar=<?= $calendarevents; ?>;
        if(testvar != ''){ testvar=testvar.length; }else{ testvar='0';}
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            // https://fullcalendar.io/docs/initialView
            initialView: 'listDay',
            initialDate: '<?= date('Y-m-d') ?>',
            nowIndicator: true,
            
            events: <?= $calendarevents; ?>,
            headerToolbar: {
                    // left: 'prev,next today custom1',
                    left: 'prev,next today custom1',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
                },
                dayMaxEvents: true, // allow "more" link when too many events
                views: {
                    timeGrid: {
                        dayMaxEventRows: 6, // adjust to 6 only for timeGridWeek/timeGridDay
                    }
                },
                eventRender: function(info) {

                $(info.el).tooltip({ 
                    title: info.event.title,
                    placement: "top",
                    trigger: "hover",
                    container: "body"
                });
                },
            // https://fullcalendar.io/docs/eventClick
                eventClick: function(info) {
                    
                    info.jsEvent.preventDefault(); // don't let the browser navigate
                    // info.el.style.borderColor = 'red'; // change the border color just for fun
                    if (confirm(
                        'Company Name: ' + info.event.extendedProps.company_name +
                        '\n\nStaff Name: ' + info.event.extendedProps.staff_name +
                        '\n\nEvent Start: ' + info.event.start +
                        '\n\nDo you want to visit the information page of this event?'
                    )) window.open(info.event.url);
                    if (info.event.url) return; // window.open(info.event.url);
                    // alert('Event: ' + info.event.title + '\nCoordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY + ' View: ' + info.view.type);

                    // eventDidMount: function(info) {
                    //     console.log(info.event.extendedProps);
                    //     // {description: "Lecture", department: "BioChemistry"}
                    // },
                },

            // initialView: 'timeGridDay',
            // listDayFormat: true,
            // listDaySideFormat: true,
            customButtons: {
                // https://fullcalendar.io/docs/customButtons
                custom1: {
                    text: 'Total Count: '+ testvar,
                    // click: function(e) {e.preventDefault();}
                },
                custom2: { text: '<?= isset($results_count) ? 'Day count: '.$results_count : '' ?>',},
            },
            // eventContent: { html: '<i>some html</i>' },
            // eventColor: '#378006',
        });
        calendar.render();
    });

    $(document).ready(function() {

        $('#datetimepicker1').datetimepicker({
            // format: 'DD-MM-YYYY HH:mm:ss',
            format: 'DD-MM-YYYY',
          
        });

        $('#datetimepicker2').datetimepicker({
            format: 'DD-MM-YYYY',
            
        });
    });

    
</script>
