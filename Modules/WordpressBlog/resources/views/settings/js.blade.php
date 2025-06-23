<script>
    'use strict';
    $(document).ready(function() {
        getChosenFilesCount();
        showSelectedFilePreviewOnLoad();
    });
    $(".settingsForm").submit(function(e) {
        e.preventDefault();
        loading('.settingsSubmitButton', 'Saving...');
        let formId =  $(this).attr("id");
   
        let callParams  = {};
        callParams.type = "POST";
        callParams.url  = $("form#"+formId).attr("action");
        callParams.data = new FormData($("#"+formId)[0]);
        callParams.processData = false;
        callParams.contentType = false;
        ajaxCall(callParams, function(result) {
            resetLoading('.settingsSubmitButton',"{{localize('Save Configuration')}}");
            console.log(result);
            toast(result.message);
          
        }, function(err, type, httpStatus) {
            resetLoading('.settingsSubmitButton',"{{localize('Save Configuration')}}");
            toast(err.responseJSON.message, 'error');

        });

        return true;
    });

</script>