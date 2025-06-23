<script>
    "use strict";
    $(document).on('click', '.moveToFolder', function(e){
        let id = $('#writter_id').val();
        if(id){
            showSaveToFolderModal(id, 'generated_content');
        }
    })
    function showSaveToFolderModal(id, model) {
        var callParams = {};
        gFilterObj.id = id
        gFilterObj.model = model
        callParams.type = "GET";
        callParams.dataType = "html";
        callParams.url = "{{ route('admin.folders.move-folder-content') }}" + (gFilterObj ? '?' + $.param(gFilterObj) :
            '');
        callParams.data = '';

        ajaxCall(callParams, function(result) {
            $('#move-to-folder-contents').empty().html(result);
            feather.replace();
            hideElement('.move-to-folder-wait');
        }, function onErrorData(err, type, httpStatus) {});
    }
    $("#offcanvasMoveToFolder").submit(function(e) {
        e.preventDefault();
        resetFormErrors('form#offcanvasMoveToFolder');
        loading('#frmActionBtn', 'Saving...');

    
        let callParams = {};

        callParams.type = "POST";
        callParams.url = $("form#offcanvasMoveToFolder").attr("action");
        callParams.data = new FormData($("#offcanvasMoveToFolder")[0]);
        callParams.processData  = false;
        callParams.contentType  = false;
        ajaxCall(callParams, function(result) {
            resetLoading('#frmActionBtn', 'Save');
            id ? toast(result.message) : showSuccess(result.message);
            if (!id) { // only for save
                resetForm('form#offcanvasMoveToFolder');
            }
        
            id ? $('#offcanvasMoveToFolder').offcanvas('hide') : '';
        }, function(err, type, httpStatus) {
            showFormError(err, '#offcanvasMoveToFolder');
            resetLoading('#frmActionBtn', 'Save');
        });

        return false;
    });

</script>