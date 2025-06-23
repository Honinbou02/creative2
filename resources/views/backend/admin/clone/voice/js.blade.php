<script>
    'use strict';

    // voiceCloneFrmID
    $("#voiceCloneFrmID").submit(function(e) {
        e.preventDefault();

        loading('#frmActionBtn', 'Saving...');
        let formId =  $(this).attr("id");

        let callParams  = {};
        callParams.type = "POST";
        callParams.url  = $("form#"+formId).attr("action");
        callParams.data = new FormData($("#"+formId)[0]);
        callParams.processData = false;
        callParams.contentType = false;

        resetFormErrors("#"+formId);
        ajaxCall(callParams, function(result) {
            resetLoading('#frmActionBtn',"{{localize('Save Voice Clone')}}");
            toast(result.message);
        }, function(err, type, httpStatus) {
            resetLoading('#frmActionBtn',"{{localize('Save Voice Clone')}}");

            showFormError(err, '#'+formId);

            toast(err.responseJSON.message, 'error');
        });

        return true;
    });

</script>