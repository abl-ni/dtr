$('#projectname-add').click(function (event) {
    var text = $('#projectname-input').val();
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
            'name': text
        },
        success: function(data) {
            console.log(data);
            $('#table-body').append("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.name + "</td><td><span class='badge'>14</span></td><td><div class='col-sm-12'><button class='edit-modal btn btn-warning btn-sm col-sm-5 col-sm-offset-1' data-id='" + data.id + "' data-name='" + data.name + "' data-target='#update-project'>Update</button><button class='delete-modal btn btn-danger btn-sm col-sm-5 col-sm-offset-1' data-id='" + data.id + "' data-name='" + data.name + "' data-target='#delete-project'>Delete</button></div></td></tr>");
        },
    });
    $('#projectname-input').val('');
});


$(document).on('click', '.edit-modal', function(e) {
    $('#id').val($(this).data('id'));
    $('#projectname-updated').val($(this).data('name'));
    $('#update-project').modal('show');
});


$(document).on('click', '.delete-modal', function(e) {
    $('span#projectname').text($(this).data('name'));
    $('span#projectid').text($(this).data('id'));
    $('#delete-project').modal('show');
});


$(document).on('click', '#project-update', function(e) {
    $.ajax({
        type: 'post',
        url: '/updateProject',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: {
            '_token': $('input[name=_token]').val(),
            'id': $("#id").val(),
            'name': $('#projectname-updated').val()
        },
        success: function(data) {
            $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.name + "</td><td><span class='badge'>14</span></td><td><div class='col-sm-12'><button class='edit-modal btn btn-warning btn-sm col-sm-5 col-sm-offset-1' data-id='" + data.id + "' data-name='" + data.name + "' data-target='#update-project'>Update</button><button class='delete-modal btn btn-danger btn-sm col-sm-5 col-sm-offset-1' data-id='" + data.id + "' data-name='" + data.name + "' data-target='#delete-project'>Delete</button></div></td></tr>");
        }
    });
});


$(document).on('click', '#project-delete', function(e) {
    $.ajax({
        type: 'post',
        url: '/deleteProject',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: {
            '_token': $('input[name=_token]').val(),
            'id': $('#projectid').text()
        },
        success: function(data) {
            $('.item' + $('#projectid').text()).remove();
        }
    });
});

