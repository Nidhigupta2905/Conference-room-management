window.$ = require( 'jquery' );
import 'datatables.net';

$('body').on('click', '#delete_button', function (e) {
    e.preventDefault();

    var id = $(this).data('id');
    var _token = $('input[name=_token]').val();
    // var url = e.target;

    const data = {
        "id": id,
        "_token": _token,
        "_method": "DELETE",
    }

    $.ajax({
        type: "POST",
        url: $(this).attr('action'),
        data: data,
        success: function (response) {
            console.log(response);

            const id = "#meeting_data_" + response.data;
            $(id).remove();
        }
    });

});


    $('#meeting_list_table').DataTable();


