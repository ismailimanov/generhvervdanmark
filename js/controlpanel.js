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
    });

    function updateChat(){
        chatid = $("#chatid").val();
        receiver = $("#receiver").val();

        $.ajax({
            type: "POST",
            url: "ajax.chat.php",
            data: {"chatid":chatid, "receiver":receiver},
            success: function (output) {
                $('.chatBoxes').html(output);
            }
        });
    }
    updateChat();
    setInterval(function(){
        updateChat();
    }, 3000);

    tinymce.init({
        selector: '#panelText',
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons paste textcolor colorpicker textpattern imagetools toc'
        ],
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        image_advtab: true,
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
        ]
    });
});