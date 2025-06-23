<script>
    'use strict';

    // load users
    function getDataList() {
        var callParams      = {};
        callParams.type     = "GET";
        callParams.dataType = "html";
        callParams.url      = "{{ route('admin.index') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data     = '';
        ajaxCall(callParams, function (result) {
            $('tbody').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }


    // add user
    $("#addCodeGenerator").submit(function(e) {
        e.preventDefault();

        resetFormErrors('form#addCodeGenerator');
        loading('#newCodeGenerate', 'Generating...');

        let id = $("#addCodeGenerator #id").val();

        var callParams  = {};
        callParams.type = "POST";
        callParams.url  = $("form#addCodeGenerator").attr("action");
        callParams.data = new FormData($('#addCodeGenerator')[0]);

        callParams.processData  = false;
        callParams.contentType  = false;
        
        ajaxCall(callParams, function (result) {

            $(".language-markup").html(result.data.response)

            resetLoading('#newCodeGenerate', "{{ localize('Generate Content') }}");
            balanceRender();
            showSuccess(result.message);

        }, function (err, type, httpStatus) {
            showFormError(err, '#addCodeGenerator');
            resetLoading('#newCodeGenerate', 'Save');
            toast(err.responseJSON.message, 'error');
        });

        return false;
    });
    function balanceRender(type = null) {
        let callParams = {};
        callParams.type = "GET";
        callParams.url = "{{ route('admin.balance-render') }}";
        callParams.data = {
            type: type
        };
        ajaxCall(callParams, function(result) {
                $('#balance-render').html(result.data);
            },
            function(err, type, httpStatus) {
                toast(err.responseJSON.message, 'error');
            });
    }
</script>
