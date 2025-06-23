<script>
    'use strict';

    // handle offcanvas for adding an user
    $('body').on('click', '#addWorpressCredentialFormOffCanvas', function() {
        $('#addWorpressCredentialForm .offcanvas-title').text("{{ localize('Add Website') }}");
        resetFormErrors('form#addWorpressCredentialForm');
       
        showElement('.password_wrapper');
        $('form#addWorpressCredentialForm').attr('action', "{{ route('admin.wordpress-credentials.store') }}");
        $("form#addWorpressCredentialForm [name='_method']").attr('value', 'POST');
    })

    // add Website
    $("#addWorpressCredentialForm").submit(function(e) {
        e.preventDefault();
        resetFormErrors('form#addWorpressCredentialForm');
        loading('#frmActionBtn', 'Saving...');

        let id = $("#addWorpressCredentialForm #id").val();
        let callParams = {};

        callParams.type = "POST";
        callParams.url = $("form#addWorpressCredentialForm").attr("action");
        callParams.data = new FormData($("#addWorpressCredentialForm")[0]);
        callParams.processData  = false;
        callParams.contentType  = false;
        ajaxCall(callParams, function(result) {
            resetLoading('#frmActionBtn', 'Save');
            toast(result.message);
            $('#addWorpressCredentialFormSidebar').offcanvas('hide');
        }, function(err, type, httpStatus) {
            showFormError(err, '#addWorpressCredentialForm');
            resetLoading('#frmActionBtn', 'Save');
        });

        return false;
    });

</script>
