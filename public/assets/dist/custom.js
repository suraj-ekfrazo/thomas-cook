$(document).ready(function() {
	$('#documents').fileuploader({
        addMore: true,
        limit: 50,
        extensions: ['jpg', 'jpeg', 'png', 'docx', 'xls', 'xlsx','pdf'],
    });

    $('#profile').fileuploader({
        addMore: false,
        limit: 1,
        extensions: ['jpg', 'jpeg', 'png'],
    });

});
