$(document).ready(function(){
    $('table#table').DataTable();
    var myChart;

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

    //EDIT PROJECT
    $("select.selectpicker").selectpicker();
    $('#updateProject-modal').on('show.bs.modal', function(e) {
        var projectid = $(e.relatedTarget).data('id');
        var projectname = $(e.relatedTarget).data('name');
        var pmid = $(e.relatedTarget).data('pm_id');
        var tlid = $(e.relatedTarget).data('tl_id');
        
        $("input[name='projectname']").val(projectname);
        $("input[name='projectid']").val(projectid);
        $("select[name='pm'].selectpicker").selectpicker('val', pmid);
        $("select[name='dev'].selectpicker").selectpicker('val', tlid);
         
        $("#updateProject-form").attr("action", "updateProject/" + projectid + "");
    });

    // DELETE PROJECT
    $('#deleteProject-modal').on('show.bs.modal', function(e) {
        var projectid = $(e.relatedTarget).data('id');
        var projectname = $(e.relatedTarget).data('name');
        
        $('span#projectname').html(projectname);

        $("#deleteProject-form").attr("action", "deleteProject/" + projectid + "");
    });

    // REMOVE USER IN A PROJECT
    $('#confirmRemove-modal').on('show.bs.modal', function(e) {
        var projectid = $(e.relatedTarget).data('project_id');
        var userid = $(e.relatedTarget).data('user_id');
        var projectname = $(e.relatedTarget).data('project');
        var username = $(e.relatedTarget).data('user');

        $('span#projectname').html(projectname);
        $('span#username').html(username);
        $('#userid').val(userid);

        $("#removeUser-form").attr("action", "removeDev/" + projectid + "");
    });

    //RESET PASSWORD (ADMIN)
    $('#reset-password').on('show.bs.modal', function(e) {
        var userid = $(e.relatedTarget).data('id');
        var username = $(e.relatedTarget).data('name');
        $("span#username").html(username);
        $("#reset-form").attr("action", "users/resetPassword/" + userid + "");
    });

    //RESET ROLE TYPE (ADMIN)
    $('#reset-role').on('show.bs.modal', function(e) {
        var userid = $(e.relatedTarget).data('id');
        var username = $(e.relatedTarget).data('name');
        $("span#username").html(username);
        $("#resetrole-form").attr("action", "users/" + userid + "");
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

    $('input[name="daterange"]').daterangepicker();

        $(document).on('click', '#filterGo-btn', function() {

        var groupby = $('#groupBy').val();
        var start = $('#start').val();
        var end = $('#end').val();

        myChart.destroy();
        barGraphData(start, end);
        
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

    // Chart

    if(document.getElementById("myChart")){
        var ctx = document.getElementById("myChart").getContext('2d');
        var barGraphData = function (start = null, end = null){
            $.ajax({
                method: 'GET',
                data: {'start':start, 'end':end},
                async: true,
                url: '/reports/total_hours_per_project',
                success: function(data){
                    var data = JSON.parse(data);
                    myChart = new Chart(ctx, {
                        'type': 'pie',
                        'data': data.data,
                        'options': data.options
                    });
                }
            })
        }

        barGraphData();     
    }
    // End Chart
});

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
                    "<table class='table table-list-search display' id='default'>" +
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
                           "<td class='col-md-1'>" + innerValue.ticket_no + "</td>" +
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
                           "<td class='col-md-1'>" + innerValue.ticket_no + "</td>" +
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