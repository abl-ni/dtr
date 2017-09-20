

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
            $('#project-list').append("<a id='" + data.id  + "' name='" + data.name + "' class='list-group-item project-item'>" + data.name + "</a>");
        },
    });
    $('#projectname-input').val('');
});

$(document).on('click', '.project-item', function(e) {
    $('#id').val($(this).attr('id'));
    $('#projectname-updated').val($(this).attr('name'));
    $('#update-project').modal('show');

});

$(document).on('click', '#projectname-update', function(e) {
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
            $('#' + data.id).replaceWith("<a id='" + data.id + "' name='" + data.name + "' class='list-group-item project-item'>" + data.name + "</a>");
        }
    });
});