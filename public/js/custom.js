$(document).ready(function(){
    $('table#table').DataTable();
    var myChart;

    // Project Page JS
    // Project List DataTable
    var projectList = $('table#project-list').DataTable({
        processing: true,
        ajax: '/projectList',
        'columnDefs': [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 4 ],
                createdCell: function(td, cellData, rowData, row, col){
                    var tmp = "";
                    for (var a = 0; a < cellData.length; a++) {                           
                        tmp +="<li class='list-group-item'>"+cellData[a].username+
                        "<a data-toggle='modal' data-target='#confirmRemove-modal' data-project_id='"+rowData[0]+
                        "' data-user_id='"+cellData[a].userid+" ' data-project='"+rowData[1]+"' data-user='"+cellData[a].username+"' class='pull-right'>"+
                        "<i class='icon icon-close text-danger'></i></a></li>";
                    };

                    var a = $(td).find(">:first-child");
                    a.attr("id", rowData[0]);
                    a.attr("data-content", "<ul class='list-group'>"+tmp+"</ul>");
                },
                render: function ( data, type, row, meta ) {
                    return '<a href="javascript:void(0)" class="list_popover" data-toggle="popover" '+
                    'title="Developers" data-html="true">See List <span class="badge">'+data[0].count+'</span></a>';
                }
            },
            {
                "targets": [ 5 ],
                createdCell: function(td, cellData, rowData, row, col){
                    var a = $(td).find(".add-modal");
                        a.attr("data-id", rowData[0]);
                        a.attr("data-name", rowData[1]);
                        a.attr("data-target", '#add-dev');
                        a.attr("data-toggle", 'modal');

                    var b = $(td).find(".edit-modal");
                        b.attr("data-id", rowData[0]);
                        b.attr("data-name", rowData[1]);
                        b.attr("data-target", '#updateProject-modal');
                        b.attr("data-toggle", 'modal');

                    var c = $(td).find(".delete-modal");
                        c.attr("data-id", rowData[0]);
                        c.attr("data-name", rowData[1]);
                        c.attr("data-target", '#deleteProject-modal');
                        c.attr("data-toggle", 'modal');
                },
                render: function ( data, type, row, meta ) {
                    return '<button class="add-modal btn btn-info btn-sm"><span class="icons icons icon-user-follow icon-modals"></span></button>'+
                    '<button class="edit-modal btn btn-warning btn-sm"><span class="icons icon-pencil icon-modals"></span></button>'+
                    '<button class="delete-modal btn btn-danger btn-sm"><span class="icons icon-trash icon-modals"></span></button>';
                }
            }
        ]
    });

    projectList.on('draw.dt', function () {
        $("[data-toggle=popover]").popover();
    });
    //End Project List DataTable
    // End Project Page JS

    // Modal Forms JS
    $('#addProject-form').submit(function(e){
        e.preventDefault();

        $.ajax({
            url: "/addProject",
            type: "POST",
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data){
                if(data.success){
                    pnotify(data.message, true);
                    projectList.ajax.reload();
                }else{
                    pnotify(data.message, false);
                }
            },
            error: function(error){
                var text = "<ul>";

                $.each( error.responseJSON.errors, function( key, value ) {
                    text += "<li>"+value+"</li>";
                });

                text += "</ul>";
                
                pnotify(text, false);
            }
        })
    });

    $('#addDev').submit(function(e){
        e.preventDefault();

        var ids = new Array();

        $( "select#select_devs option:selected" ).each(function() {
            ids.push($( this ).attr('id'));
        });

        $.ajax({
            type: 'post',
            url: '/addDev',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('#project_id').val(),
                'data': ids,
            },
            dataType: 'json',
            success: function(data) {
                if(data.success){
                    pnotify(data.message, true);
                    projectList.ajax.reload();
                    $('#add-dev').modal('hide');
                }else{
                    pnotify(data.message, false);
                }
            },
            error: function(error) {
                var text = "<ul>";

                $.each( error.responseJSON.errors, function( key, value ) {
                    text += "<li>"+value+"</li>";
                });

                text += "</ul>";
                
                pnotify(text, false);
            }
        });
    });

    $('#add-dev').on('show.bs.modal', function(e) {
        var projectid = $(e.relatedTarget).data('id');

        $('#addDev input[name="projectid"]').val(projectid);

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
                'id': projectid,
            },
            success: function(data) {
                
                if (!$.trim(data)){   
                    $('select#select_devs').html($("<option></option>")
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

    $('#add-dev').on('hidden.bs.modal', function(e) {
        $('select#select_devs').html($("<option></option>")
                               .attr("disabled", "disabled")
                               .text("No Available"))
                               .selectpicker('refresh');
    });

    $('#updateProject-form').submit(function(e){
        e.preventDefault();

        $.ajax({
            type: 'post',
            url: '/updateProject',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if(data.success){
                    pnotify(data.message, true);
                    projectList.ajax.reload();
                    $('#updateProject-modal').modal('hide');
                } else {
                    pnotify(data.message, false);
                }
            },
            error: function(error) {
                var text = "<ul>";

                $.each( error.responseJSON.errors, function( key, value ) {
                    text += "<li>"+value+"</li>";
                });

                text += "</ul>";
                
                pnotify(text, false);
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
    });

    $('#updateProject-modal').on('hidden.bs.modal', function(e) {
        $("input[name='projectname']").val('');
        $("input[name='projectid']").val('');
    });

    // DELETE PROJECT
    $('#deleteProject-modal').on('show.bs.modal', function(e) {
        var projectid = $(e.relatedTarget).data('id');
        var projectname = $(e.relatedTarget).data('name');
        
        $('span#projectname').html(projectname);
        $('#deleteProject-form input[name="projectid"]').val(projectid);
    });

    $('#deleteProject-modal').on('hidden.bs.modal', function(e) {        
        $('span#projectname').html('');
        $('#deleteProject-form input[name="projectid"]').val('');
    });

    $('#deleteProject-form').submit(function(e){
        e.preventDefault();

        $.ajax({
            type: 'post',
            url: '/deleteProject',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if(data.success){
                    pnotify(data.message, true);
                    projectList.ajax.reload();
                    $('#deleteProject-modal').modal('hide');
                } else {
                    pnotify(data.message, false);
                }
            },
            error: function(error) {
                var text = "<ul>";

                $.each( error.responseJSON.errors, function( key, value ) {
                    text += "<li>"+value+"</li>";
                });

                text += "</ul>";
                
                pnotify(text, false);
            }
        });
    });

    // REMOVE USER IN A PROJECT
    $('#confirmRemove-modal').on('show.bs.modal', function(e) {
        var projectid = $(e.relatedTarget).data('project_id');
        var userid = $(e.relatedTarget).data('user_id');
        var projectname = $(e.relatedTarget).data('project');
        var username = $(e.relatedTarget).data('user');

        $('span#projectname').html(projectname);
        $('span#username').html(username);
        $('#removeUser-form input[name="userid"]').val(userid);
        $('#removeUser-form input[name="projectid"]').val(projectid);
    });

    $('#confirmRemove-modal').on('hidden.bs.modal', function(e) {
        $('span#projectname').html('');
        $('span#username').html('');
        $('#removeUser-form input[name="userid"]').val('');
        $('#removeUser-form input[name="projectid"]').val('');
    });

    $("#removeUser-form").submit(function(e){
        e.preventDefault();

        $.ajax({
            type: 'post',
            url: '/removeDev',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if(data.success){
                    pnotify(data.message, true);
                    projectList.ajax.reload();
                    $('#confirmRemove-modal').modal('hide');
                } else {
                    pnotify(data.message, false);
                }
            },
            error: function(error) {
                var text = "<ul>";

                $.each( error.responseJSON.errors, function( key, value ) {
                    text += "<li>"+value+"</li>";
                });

                text += "</ul>";
                
                pnotify(text, false);
            }
        });
    });

    $('#addUser-modal').on('hidden.bs.modal', function(e) {
        $('.register-user')[0].reset();
    });

    $('.register-user').submit(function(e){
        e.preventDefault();

        $.ajax({
            type: 'post',
            url: '/register',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if(data.success){
                    pnotify(data.message, true);
                    userList.ajax.reload();
                    $('#addUser-modal').modal('hide');
                } else {
                    var text = "<ul>";

                    $.each( data.message, function( key, value ) {
                        text += "<li>"+value+"</li>";
                    });

                    text += "</ul>";
                    
                    pnotify(text, false);
                }
            },
            error: function(error) {                
                pnotify('Something went wrong.', false);
            }
        });
    });

    //RESET PASSWORD (ADMIN)
    $('#reset-password').on('show.bs.modal', function(e) {
        var userid = $(e.relatedTarget).data('id');
        var username = $(e.relatedTarget).data('name');
        $("span#username").html(username);
        $("#reset-form input[name='userid']").val(userid);
    });

    $('#reset-password').on('hidden.bs.modal', function(e) {
        $("#reset-form")[0].reset();
        $("span#username").html('');
        $("#reset-form input[name='userid']").val('');
    });

    $("#reset-form").submit(function(e){
        e.preventDefault();

        $.ajax({
            type: 'post',
            url: '/users/reset/password',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if(data.success){
                    pnotify(data.message, true);
                    userList.ajax.reload();
                    $('#reset-password').modal('hide');
                } else {
                    var text = "<ul>";

                    $.each( data.message, function( key, value ) {
                        text += "<li>"+value+"</li>";
                    });

                    text += "</ul>";
                    
                    pnotify(text, false);
                }
            },
            error: function(error) {                
                pnotify('Something went wrong.', false);
            }
        });
    })

    //RESET ROLE TYPE (ADMIN)
    $('#reset-role').on('show.bs.modal', function(e) {
        var userid = $(e.relatedTarget).data('id');
        var username = $(e.relatedTarget).data('name');
        $("span#username").html(username);
        $("#resetrole-form input[name='userid']").val(userid);
    });

    $('#reset-role').on('hidden.bs.modal', function(e) {
        $("span#username").html('');
        $("#resetrole-form input[name='userid']").val('');
    });

    $("#resetrole-form").submit(function(e){
        e.preventDefault();

        $.ajax({
            type: 'post',
            url: '/users/reset/role',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if(data.success){
                    pnotify(data.message, true);
                    userList.ajax.reload();
                    $('#reset-role').modal('hide');
                } else {
                    var text = "<ul>";

                    $.each( data.message, function( key, value ) {
                        text += "<li>"+value+"</li>";
                    });

                    text += "</ul>";
                    
                    pnotify(text, false);
                }
            },
            error: function(error) {                
                pnotify('Something went wrong.', false);
            }
        });
    })

    $('.add-log').submit(function(e){
        e.preventDefault();

        $.ajax({
            type: 'post',
            url: '/addLogs',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if(data.success){
                    pnotify(data.message, true);
                    $('.add-log')[0].reset();
                } else {                    
                    pnotify(data.message, false);
                }
            },
            error: function(error) {
                var text = "<ul>";

                $.each( error.responseJSON.errors, function( key, value ) {
                    text += "<li>"+value+"</li>";
                });

                text += "</ul>";
                
                pnotify(text, false);
            }
        });
    })

    // End Modal Forms JS

    // Reports DataTable
    var reportList = $('table#report-list').DataTable({
        processing: true,
        ajax: '/reportList',
        'columnDefs': [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 7 ],
                render: function ( data, type, row, meta ) {
                    return (data>1)?data+'hrs':data+'hr';
                }
            }
        ],
        rowGroup: {
            startRender: function ( rows, group ) { 
                var ageAvg = rows
                    .data()
                    .pluck(7)
                    .reduce( function (a, b) {
                        var data = parseInt(a)+parseInt(b);
                        return data;
                    });
 
                return $('<tr/>')
                    .append( '<td colspan="6">'+group+'</td>' )
                    .append( '<td>'+((ageAvg>1)?ageAvg+'hrs':ageAvg+'hr')+'</td>' );
            },
            endRender: null,
            dataSrc: 1
        }
    });
    //End Report DataTable

    // User DataTable
    var userList = $('table#user-list').DataTable({
        processing: true,
        ajax: '/userList',
        'columnDefs': [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            },{
                "targets": [ 3 ],
                "width": "10%"
            },
            {
                "targets": [ 4 ],
                "width": "20%",
                createdCell: function(td, cellData, rowData, row, col){
                    var a = $(td).find(".reset");
                        a.attr("data-id", cellData);
                        a.attr("data-name", rowData[1]);
                        a.attr("data-target", '#reset-password');
                        a.attr("data-toggle", 'modal');

                    var b = $(td).find(".update");
                        b.attr("data-id", cellData);
                        b.attr("data-name", rowData[1]);
                        b.attr("data-target", '#reset-role');
                        b.attr("data-toggle", 'modal');
                },
                render: function ( data, type, row, meta ) {
                    return '<div class="btn-group"><button type="button" class="reset btn btn-danger">Reset Password</button>'+
                    '<button type="button" class="update btn btn-warning">Change Role</button></div>';
                }
            }
        ]
    });
    //End User DataTable

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

    $('#select_devs').selectpicker(); 
    $('input[name="daterange"]').daterangepicker();
    $(document).on('click', '#filterGo-btn', function() {
        var groupby = $('#groupBy').find('option:selected').data('group');
        var start = $('#start').val();
        var end = $('#end').val();

        if(document.getElementById("myChart")){
            myChart.destroy();
            barGraphData(start, end);
        }

        if(groupby === 'developer'){
            reportList.rowGroup().dataSrc(1);
        } else if(groupby === 'ticket'){
            reportList.rowGroup().dataSrc(3);
        } else if(groupby === 'project'){
            reportList.rowGroup().dataSrc(2);
        }
        
        reportList.draw();
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

var pnotify = function(str, success){
    PNotify.desktop.permission();

    if(success){            
        (new PNotify({
            title: 'Success',
            text: str,
            type: 'success',
            buttons: {
                sticker: false
            },
            desktop: {
                desktop: true,
            },
            mobile: true
        }));
    } else {
        (new PNotify({
            title: 'Error',
            text: str,
            type: 'error',
            buttons: {
                sticker: false
            },
            desktop: {
                desktop: true,
            },
            mobile: true
        }));
    }
}

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

function formatTotalHours(count){
    
    var total = count.toString();
    if(total.includes(".")){
        total = total.replace(".", "h");
        return total+'m';
    }
    return total+'h';
    
}