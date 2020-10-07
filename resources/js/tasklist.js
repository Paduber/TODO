$('#save').on('click', function (e) {
    e.preventDefault();
    var data = $('#sendForm').serialize();
    var url = '';
    if($('#taskModal [name=id]').val() == '')
        url = 'ajax/tasks';
    else {
        url = 'ajax/tasks/'+$('#taskModal [name=id]').val();
        data+='&_method=PUT';
    }
    $.post(url, data, function (data) {
        $('#closeForm').click();
        location.reload()
    }).fail(function (jqXHR) {
        if (jqXHR.status === 422) {
            alert('Заполните все поля');
        }
    })
});

$('.taskRow').click(function () {
    var id = $(this).attr('data-id');
    $.get('ajax/tasks/'+id, function (data) {
        Object.keys(data.task).forEach(
            function (index) {
                $('#taskModal [name='+index+']').val(data.task[index]);
            }
        )
        if(data.modify != 'all') {
            $('#sendForm input').attr('readonly', 'readonly');
            $('#sendForm select').attr('disabled', 'disabled');
        }
        if(data.modify == 'partial') {
            $('#sendForm [name=status]').removeAttr('disabled');

        }

        $('#taskModal').modal('show');

    });
})


function clearModal() {
    $('#sendForm input').removeAttr('readonly');
    $('#sendForm select').removeAttr('disabled');
    $('#sendForm')[0].reset();
}

$('#taskModal').on('hidden.bs.modal', function () {
    clearModal();
});

