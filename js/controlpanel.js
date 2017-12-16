$(document).ready(function(){
    $('#teacherDropdownButton').click(function(){
        $('#teacherDropdown').toggleClass('opened');
    });

    $('#settingsDropdownButton').click(function(){
        $('#settingsDropdown').toggleClass('opened');
    });

    $('#koerelaerer').DataTable( {
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Danish.json"
        },
        "order": []
    } );
});