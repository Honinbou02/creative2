<script>
    'use strict';

    // load users
    function getDataList() {
        var callParams      = {};
        callParams.type     = "GET";
        callParams.dataType = "html";
        callParams.url      = "{{ route('admin.chat-experts.index') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data     = '';
        ajaxCall(callParams, function (result) {
            $('.data-list').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }

    // handle offcanvas for adding an user
    $('body').on('click', '#addExpertFormSidebarForOffCanvas', function(e){
        e.preventDefault();
        $('#addExpertFrm .offcanvas-title').text("{{ localize('Add Chat Expert') }}");
        resetFormErrors('form#addExpertFrm');
        resetForm('form#addExpertFrm');
        $('form#addExpertFrm').attr('action', "{{ route('admin.chat-experts.store') }}");
    })

    // search
    $('body').on('click', '#searchBtn', function(){
        var search      = $('#f_search').val();
        var is_active   = $('#f_is_active :selected').val();

        gFilterObj.search    = search;
        loadingInContent('.data-list', "{{ localize('loading...') }}");
        
        if(is_active === '0' || is_active === '1') {
            gFilterObj.is_active = is_active;
        } else if(gFilterObj.hasOwnProperty('is_active')) {
            delete gFilterObj.is_active;
        }

        if(gFilterObj.hasOwnProperty('page')) {
            delete gFilterObj.page;
        }

        getDataList();
    });

    var offcanvasBottom = document.getElementById('offcanvasBottom')
    var secondoffcanvas = document.getElementById('addExpertFormSidebar')

    offcanvasBottom.addEventListener('hidden.bs.offcanvas', function() {
        var bsOffcanvas2 = new bootstrap.Offcanvas(secondoffcanvas)
        bsOffcanvas2.show()
    })
    // add user
    $("#addExpertFrm").submit(function(e) {
        e.preventDefault();

        resetFormErrors('form#addExpertFrm');
        loading('#addExpertBtn', "{{ localize('Saving...') }}");

        let id = $("#addExpertFrm #id").val();

        var callParams  = {};
        callParams.type = "POST";
        callParams.url  = $("form#addExpertFrm").attr("action");
        callParams.data = new FormData($('#addExpertFrm')[0]);

        callParams.processData  = false;
        callParams.contentType  = false;
        ajaxCall(callParams, function (result) {
            resetLoading('#addExpertBtn', "{{ localize('Save') }}");
            toast(result.message);
            if(!id) { // only for save
                resetForm('form#addExpertFrm');
            }
            getDataList();
            $('#addExpertFormSidebar').offcanvas('hide');

        }, function (err, type, httpStatus) {
            showFormError(err, '#addExpertFrm');
            resetLoading('#addExpertBtn', "{{ localize('Save') }}");
        });

        return false;
    });

    // edit user
    $('body').on('click', '.editIcon', function(){
        let userId = parseInt($(this).data("id"));
        let actionUrl = "chat-experts/"+userId+"/edit";
        $('#addExpertFrm .offcanvas-title').text("{{ localize('Edit Chat Expert') }}");
        $('#addExpertFormSidebar').offcanvas('show');
        resetForm('form#addExpertFrm');
        resetFormErrors('form#addExpertFrm');
        $('form#addExpertFrm').attr('action', "chat-experts/"+userId);
        $('form#addExpertFrm input:hidden[name=_method]').val('PUT');
        $('.selected-file').html('');
        var callParams  = {};
        callParams.type = "GET";
        callParams.url  = actionUrl;
        callParams.data = "";
        loadingInContent('#loader', 'loading...');
        hideElement('.offcanvas-body');
        ajaxCall(callParams, function (result) {
            resetLoading('#loader', '');
            showElement('.offcanvas-body');
            if(result.data) {
                let data = result.data;
                $('#addExpertFrm #id').val(data.id);
                $('#addExpertFrm #expert_name').val(data.expert_name);
                $('#addExpertFrm #short_name').val(data.short_name);
                $('#addExpertFrm #description').val(data.description);
                $('#addExpertFrm #role').val(data.role);
                $('#addExpertFrm #avatar').val(data.avatar);
                $('#addExpertFrm #assists_with').val(data.assists_with);
                $('#addExpertFrm #chat_training_data').val(data.chat_training_data);
                $('#addExpertFrm #is_active').val(data.is_active).change();
                if(data.avatar){
                    getChosenFilesCount();
                    showSelectedFilePreviewOnLoad();
                }
            }
        }, function (err, type, httpStatus) {

        });

    });

    getDataList();
</script>
