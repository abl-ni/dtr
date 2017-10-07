$('.addproj').click(function (event){
    var added_by = $('.current_user').attr('id');
    $("#pm").val($("#" + added_by).val());
    console.log($("#" + added_by).val());
});

$('#projectname-add').click(function (event) {
    var text = $('#projectname-input').val();
    var pm = $('#pm').find(":selected").val();
    var pm_id = $('#pm').find(":selected").attr('id');
    var tl = $('#tl').find(":selected").val();
    var tl_id = $('#tl').find(":selected").attr('id');
    var added_by = $('.current_user').attr('id');
    
    $.ajax({
        type: 'post',
        url: '/addProject',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: {
            '_token': $('input[name=_token]').val(),
            'name': text,
            'added_by': added_by,
            'pm_id': pm_id,
            'tl_id': tl_id
        },
        success: function(data) {
            location.reload();
        }
    });
    $('#projectname-input').val('');
});

$(document).on('click', '.edit-modal', function(e) {
    $('#update-project').modal('show');
    var id = $(this).data('id');
    
    $.ajax({
        type: 'post',
        url: '/getproject', 
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: {
            '_token': $('input[name=_token]').val(),
            'id': id,
            
        },
        success: function(data) {
            $('#id').val(data.id);
            $('#projectname-updated').val(data.name);
            $("#pm_list").val($("#" + data.pm_id).val());
            $("#dev_list").val($("#" + data.tl_id).val());
        }
    });
    
});


$(document).on('click', '.delete-modal', function(e) {
    $('span#projectname').text($(this).data('name'));
    $('span#projectid').text($(this).data('id'));
    $('#delete-project').modal('show');
});

$(document).on('click', '#project-delete', function(e) {

    $.ajax({
        type: 'post',
        url: '/deleteProject',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }},
        data: {
            '_token': $('input[name=_token]').val(),
            'id': $('#projectid').text() },
        success: function(data) {
            $('.item' + $('#projectid').text()).remove();
        }
    });

});


$(document).on('click', '#project-update', function(e) {
  
    var id = $("#id").val();
    var name = $('#projectname-updated').val();
    var pm_id = $("select#pm_list option:selected").attr('id');
    var tl_id = $("select#dev_list option:selected").attr('id');
    
    $( "select#pm_list" ).change(function() {
        $( "select#pm_list option:selected" ).each(function() {
            pm_id = $( this ).attr('id');
        });
    })
    .trigger( "change" ); 

    $( "select#dev_list" ).change(function() {
        $( "select#dev_list option:selected" ).each(function() {
            tl_id = $( this ).attr('id');
        });
    })
    .trigger( "change" );
    
    console.log(id, name, pm_id, tl_id);
    $.ajax({
        type: 'post',
        url: '/updateProject',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }},
        data: {
            '_token': $('input[name=_token]').val(),
            'id': id,
            'name': name,
            'pm_id' : pm_id,
            'tl_id' : tl_id,
        },
        success: function(data) {
            location.reload();
        }
    });
    
});


$('#select_devs').selectpicker(); 
$(document).on('click', '.add-modal', function(e) {

    var id = $(this).data('id');

    $.ajax({
        type: 'post',
        url: '/getDev', 
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: {
            '_token': $('input[name=_token]').val(),
            'id': id,
        },
        success: function(data) {
            
            if (!$.trim(data)){   
                $('select#select_devs').append($("<option></option>")
                                       .attr("disabled", "disabled")
                                       .text("No Available"))
                .selectpicker('refresh');
            }
            else {
                
                $.each(data, function(key, value) {
                    $('select#select_devs')
                            .append($("<option></option>")
                            .attr("id", value.id)
                            .attr("value", value.id)
                            .text(value.name))
                    .selectpicker('refresh');
                });   
            }    
        }
    });

    $('select#select_devs').html('');

});

$(document).on('click', '.add-modal', function(){
    $('#project_id').val($(this).data('id'));
});


$(document).on('click', '#add_devs_btn', function(e) {
    
    var ids = new Array();
    $( "select#select_devs" ).change(function() {
                $( "select#select_devs option:selected" ).each(function() {
                    ids.push($( this ).attr('id'));
                });
            })
        .trigger( "change" );

    $.ajax({
        type: 'post',
        url: '/addDev',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }},
        data: {
            '_token': $('input[name=_token]').val(),
            'id': $('#project_id').val(),
            'data': ids,
        },
        success: function(data) {
            location.reload();
        }
    });
    
});

$(document).ready(function(){
    $('[data-toggle="popover"]').popover();  
    
    $('body').on('click', function (e) {
        $('[data-toggle="popover"]').each(function () {
            if (!$(this).is(e.target) 
                && $(this).has(e.target).length === 0 
                && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide');
            }
        });    
    });
    
    $('.list_popover').on('click', function(){
        $('.popover-content').append('<ul class="list-group"></ul>');
        $.ajax({
            type: 'post',
            url: '/ListDev',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }},
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $(this).attr('id'),
            },
            success: function(data) {
                $.each(data, function(key, value) {
                    $('ul.list-group')
                    .append($("<li></li>")
                            .attr("class", "list-group-item")
                            .text(value.name));
                });
            }
        });
        
    });
});


$(document).on('click', '#dtrSubmit-btn', function() {
    var proj_id = $('select#selectProject option:selected').attr('id');
    var ticket_no = $('#ticket-number').val();
    var task_title = $('#task-title').val();
    var roadblock = $('#roadblock').val();
    var hrs_rendered = $('#hours-rendered').val();

    $.ajax({
        type: 'post',
        url: '/Logs',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }},
        data: {
            '_token': $('input[name=_token]').val(),
            'proj_id' : proj_id,
            'ticket_no' : ticket_no,
            'task_title' : task_title,
            'roadblock' : roadblock,
            'hrs_rendered' : hrs_rendered
        },
        success: function(data) {
            $('.form-container')
            .append("<div id='success-alert' class='alert alert-success alert-dismissable fade in'>" +
                    "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>" +
                    "Your Logs are added <strong>successfully!</strong>." +
                    "</div>");
            $("#success-alert").slideUp(500);
            
            $('#ticket-number').val('');
            $('#task-title').val('');
            $('#roadblock').val('');
            $('#hours-rendered').val('');
        }
    });
    
});



$('input[name="daterange"]').daterangepicker();

$(function() {

    var start = moment();
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
        $('#start').val(start.format('YYYY-MM-DD'));
        $('#end').val(end.format('YYYY-MM-DD'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

});


$(document).on('click', '#filterGo-btn', function() {

    var groupby = $('#groupBy').val();
    var start = $('#start').val();
    var end = $('#end').val();
    
    $('#filter-body').html('');
    $.ajax({
        type: 'post',
        url: '/getFilter',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }},
        data: {
            '_token': $('input[name=_token]').val(),
            'groupby' : groupby,
            'starts' : start,
            'ends' : end,
        },
        success: function(data) {
            
            if (!$.trim(data)){ 

                $('#filter-body')
                .append("<h3 style='padding-top:50px' class='text-center'>No Results Found.</h3>");

            }else {
                
                sortArray(data, groupby);
            
            }
            
        }
    });
    
});

function sortArray(data, groupby){
    
    var groups = {};
    for (var i = 0; i < data.length; i++) {
        var id = data[i].id;
        var name = data[i].name;
        if (!groups[id]) {
            groups[id] = [];
        }
        groups[id].push(data[i]);
    }
    data = [];

    for (var id in groups) {
        var count = 0;
        for (var i = 0; i < groups[id].length; i++) {
            count += parseFloat(groups[id][i]['hours_rendered']);
        }
        data.push({id: id, name: groups[id][0]['name'], total: formatTotalHours(count.toFixed(2)), query: groups[id]});
    }
    
    console.log(data);
    return appendElements(data, groupby);
}


function formatTotalHours(count){
    
    var total = count.toString();
    if(total.includes(".")){
        total = total.replace(".", "h");
        return total+'m';
    }
    return total+'h';
    
}

function appendElements(data, groupby){

    var total = 0;
    
    switch(groupby){

        case 'Group by Developers':
            $('#filter-body')
            .append("<div class='groupItem'>" +
                    "<table class='table table-list-search' id='default'>" +
                    "<thead>"  +
                    "<tr>" +
                    "<th id='name' class='col-md-1'></th>" +
                    "<th id='pname' class='col-md-1'>Project Name</th>" +
                    "<th id='ticket' class='col-md-1'>Ticket #</th>" +
                    "<th id='task' class='col-md-1'>Task Title</th>" +
                    "<th id='roadblock' class='col-md-2'>Roadblock</th>" +
                    "<th id='date' class='col-md-1'>Date</th>" +
                    "<th id='hours' class='col-md-1'>Hours</th>" +
                    "</tr>" +
                    "</thead>" +
                    "<tbody id='table-body'>" +
                    "</tbody>" +  
                    "</table>" +
                    "</div>");
            break;
        case 'Group by Projects':
            $('#filter-body')
            .append("<div class='groupItem'>" +
                    "<table class='table table-list-search' id='default'>" +
                    "<thead>"  +
                    "<tr>" +
                    "<th id='name' class='col-md-1'></th>" +
                    "<th id='pname' class='col-md-1'>Name</th>" +
                    "<th id='ticket' class='col-md-1'>Ticket #</th>" +
                    "<th id='task' class='col-md-1'>Task Title</th>" +
                    "<th id='roadblock' class='col-md-2'>Roadblock</th>" +
                    "<th id='date' class='col-md-1'>Date</th>" +
                    "<th id='hours' class='col-md-1'>Hours</th>" +
                    "</tr>" +
                    "</thead>" +
                    "<tbody id='table-body'>" +
                    "</tbody>" +  
                    "</table>" +
                    "</div>");
            break;
        case 'Group by Tickets':
            $('#filter-body')
            .append("<div class='groupItem'>" +
                    "<table class='table table-list-search' id='default'>" +
                    "<thead>"  +
                    "<tr>" +
                    "<th id='name' class='col-md-1'></th>" +
                    "<th id='pname' class='col-md-1'></th>" +
                    "<th id='ticket' class='col-md-1'>Project Name</th>" +
                    "<th id='task' class='col-md-1'>Name</th>" +
                    "<th id='roadblock' class='col-md-2'>Roadblock</th>" +
                    "<th id='date' class='col-md-1'>Date</th>" +
                    "<th id='hours' class='col-md-1'>Hours</th>" +
                    "</tr>" +
                    "</thead>" +
                    "<tbody id='table-body'>" +
                    "</tbody>" +  
                    "</table>" +
                    "</div>");
            break;
    }
    
    $.each(data, function(key, value) {
        
       switch(groupby){
       
        case 'Group by Developers':
               $('#table-body')
               .append("<tr style='border-top: none;'>" +
                       "<td colspan='6'><strong>" + value.name.toUpperCase() + "</strong></td>" +
                       "<td colspan='1'><strong>" + value.total + "</strong></td>" +
                       "</tr>" +
                       "<tr>" +
                       "<td colspan='7'><table style='width:100%' class='item"+ value.id +"'></table></td>" +  
                       "</tr>");

               $.each(value.query, function(innerKey, innerValue){
                   $('table.item'+ value.id)
                   .append("<tr class='item' style='border-bottom: 1px solid #f5f5f5;'>" +
                           "<td class='col-md-1'></td>" +
                           "<td class='col-md-1'>" + innerValue.project_name + "</td>" +
                           "<td class='col-md-1'>" + innerValue.task_no + "</td>" +
                           "<td class='col-md-1'>" + innerValue.task_title + "</td>" +
                           "<td class='col-md-2'>" + innerValue.roadblock + "</td>" +
                           "<td class='col-md-1'>" + innerValue.date_created + "</td>" +
                           "<td class='col-md-1'>" + formatTotalHours(innerValue.hours_rendered) + "</td>" +
                           "</tr>");

               });
               break;
               
           case 'Group by Projects':
               $('#table-body')
               .append("<tr style='border-top: none;'>" +
                       "<td colspan='6'><strong>" + value.name.toUpperCase() + "</strong></td>" +
                       "<td colspan='1'><strong>" + value.total + "</strong></td>" +
                       "</tr>" +
                       "<tr>" +
                       "<td colspan='7'><table style='width:100%' class='item"+ value.id +"'></table></td>" +  
                       "</tr>");

               $.each(value.query, function(innerKey, innerValue){
                   $('table.item'+ value.id)
                   .append("<tr class='item' style='border-bottom: 1px solid #f5f5f5;'>" +
                           "<td class='col-md-1'></td>" +
                           "<td class='col-md-1'>" + innerValue.username + "</td>" +
                           "<td class='col-md-1'>" + innerValue.task_no + "</td>" +
                           "<td class='col-md-1'>" + innerValue.task_title + "</td>" +
                           "<td class='col-md-2'>" + innerValue.roadblock + "</td>" +
                           "<td class='col-md-1'>" + innerValue.date_created + "</td>" +
                           "<td class='col-md-1'>" + formatTotalHours(innerValue.hours_rendered) + "</td>" +
                           "</tr>");

               });
               break;
               
           case 'Group by Tickets':
               $('#table-body')
               .append("<tr style='border-top: none;'>" +
                      "<td colspan='6'><strong>" + value.name.toUpperCase() + "</strong><br>" +
                        "<strong> <span class='badge'>#" + value.id + "</span></strong>" +
                      "</td>" +
                       "<td colspan='1'><strong>" + value.total + "</strong></td>" +
                       "</tr>" +
                       "<tr>" +
                       "<td colspan='7'><table style='width:100%' class='item"+ value.id +"'></table></td>" +  
                       "</tr>");

               $.each(value.query, function(innerKey, innerValue){
                   $('table.item'+ value.id)
                   .append("<tr class='item'style='border-bottom: 1px solid #f5f5f5;'>" +
                           "<td class='col-md-1'></td>" +
                           "<td class='col-md-1'></td>" +
                           "<td class='col-md-1'>" + innerValue.project_name + "</td>" +
                           "<td class='col-md-1'>" + innerValue.username + "</td>" +
                           "<td class='col-md-2'>" + innerValue.roadblock + "</td>" +
                           "<td class='col-md-1'>" + innerValue.date_created + "</td>" +
                           "<td class='col-md-1'>" + formatTotalHours(innerValue.hours_rendered) + "</td>" +
                           "</tr>");

               });
               break;
       
       }
        
    });
    
    

}



