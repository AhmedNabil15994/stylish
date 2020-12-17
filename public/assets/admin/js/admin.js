/***************************************************************************
 * Modal View Modal
 **************************************************************************/

$(document).on('click', '.btn-modal-view', function () {
    var $this = $(this);
    var url = $this.data('url');
    var originalHtml = $this.html();

    $.ajax({
        url : url,
        method : 'GET',
        success : function (data) {
            $this.prop('disabled',false).html(originalHtml);
            $('#common-modal').modal('show').html(data);
        }
    });
});

var bar = $('.bar');
var percent = $('.percent');

$('.ajax-form').ajaxForm({

    beforeSend: function() {
        // status.text('');
        var percentVal = '0%';
        var posterValue = $('input[name=file]').fieldValue();
        bar.width(percentVal)
        percent.html(percentVal);
    },
    uploadProgress: function(event, position, total, percentComplete) {
        var percentVal = percentComplete + '%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
    success: function(response) {
        // var percentVal = 'Wait, Saving';
        //
        // bar.width(percentVal)
        // percent.html(percentVal);

        if (response.status === "success") {
            var alertSelector = '.SuccessMessage';
            var alertOpSelector = '.ErrorMessage';
        } else if (response.status === "error") {
            var alertSelector = '.ErrorMessage';
            var alertOpSelector = '.SuccessMessage';
        }
        $(alertSelector).html(response.data);
        $(alertSelector).hide().removeClass('hidden').fadeIn();
        setTimeout(function () {
            $(alertSelector).fadeOut().addClass('hidden');
        }, 3000);
        $(alertOpSelector).fadeOut().addClass('hidden');
        if (response.status === "success") {
            window.location.reload();
        }
    },
    complete: function(xhr) {
        // status.html(xhr.responseText);
    }
});

//submit edit forms forms
$(document).on('submit',".edit-form",function(e){
    var form = $(this);
    var url = form.attr('action');
    var formData = new FormData(form[0]);

    if ($(document).find('.tiny-editor').length) {
        for (var i = 0; i < tinymce.editors.length; i++) {
            formData.append('desc' + (i + 1), tinymce.editors[i].getContent());
        }
    }

    $.ajax({
        url : url,
        method : 'POST',
        dataType: 'json',
        data : formData,
        contentType:false,
        cache: false,
        processData:false,
        success : function (response) {
            if (response.status === "success") {
                var alertSelector = '.SuccessMessage';
                var alertOpSelector = '.ErrorMessage';
            } else if (response.status === "error") {
                var alertSelector = '.ErrorMessage';
                var alertOpSelector = '.SuccessMessage';
            }
            $(alertSelector).html(response.data);
            $(alertSelector).hide().removeClass('hidden').fadeIn();
            setTimeout(function () {
                $(alertSelector).fadeOut().addClass('hidden');
            }, 3000);
            $(alertOpSelector).fadeOut().addClass('hidden');
            if (response.status === "success") {
                window.location.reload();
            }
        }
    });
    $.ajaxSetup({
        headers:
            {
                'X-CSRF-Token': $('input[name="_token"]').val()
            }
    });
    return false;
});
// --------------------------Trigger File upload browsing Section ---------------------------
$(document).on('click', '.btn-product-image', function () {
    var btn = $(this);
    var uploadInp = btn.next('input[type=file]');
    uploadInp.change(function () {
        if (validateImgFile(this)) {
            btn.html('');
            previewURL(btn, this);
        }
    }).click();
});

function previewURL(btn, input) {
    if (input.files && input.files[0]) {
        // collecting the file source
        var file = input.files[0];
        // preview the image
        var reader = new FileReader();
        reader.onload = function (e) {
            var src = e.target.result;
            btn.attr('src', src);
        };
        reader.readAsDataURL(file);
    }
}
//validating the file
function validateImgFile(input) {
    if (input.files && input.files[0]) {
        // collecting the file source
        var file = input.files[0];
        // validating the image name
        if (file.name.length < 1) {
            alert("الملف لا يجب ان يكون فارغ");
            return false;
        }
        // validating the image size
        else if (file.size > 20000000) {
            alert("The file is too big");
            return false;
        }
        // validating the image type
        else if (file.type != 'image/png' && file.type != 'image/jpg' && file.type != 'image/gif' && file.type != 'image/jpeg') {
            alert("نوع الملف يجب ان يكون  png, jpg or gif");
            return false;
        }
        return true;
    }
}


////Delete method
$('.deleteBTN').on('click' ,function () {
    var url = $(this).data('url');

    var button = $('.modalDLTBTN');

    button.attr('href' ,url);
});