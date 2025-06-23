<script>
    'use strict';

    // load users
    function getDataList() {
        var callParams      = {};
        callParams.type     = "GET";
        callParams.dataType = "html";
        callParams.url      = "{{ route('admin.chat-categories.index') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data     = '';
        ajaxCall(callParams, function (result) {
            $('tbody').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }

    // handle offcanvas for adding an user
    $('body').on('click', '#addFrmOffCanvas', function(){
        $('#addFrm .offcanvas-title').text("{{ localize('Add Chat Category') }}");
        resetFormErrors('form#addFrm');
        resetForm('form#addFrm');
        showElement('.password_wrapper');
        $('form#addFrm').attr('action', "{{ route('admin.chat-categories.store') }}");
        $("form#addFrm [name='_method']").attr('value', 'POST');
    })

    // search
    $('body').on('click', '#searchBtn', function(e){
        e.preventDefault();
        var search      = $('#f_search').val();
        var is_active   = $('#f_is_active :selected').val();
        loadingInTable("tbody",{
                    colSpan: 11,
                    prop: false,
        });
        gFilterObj.search    = search;

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

    // add Chat Category
    $("#addFrm").submit(function(e) {
        e.preventDefault();
        resetFormErrors('form#addFrm');
        loading('#frmActionBtn', 'Saving...');

        let id = $("#addFrm #id").val();
        let callParams  = {};

        callParams.type = "POST";
        callParams.url  = $("form#addFrm").attr("action");
        callParams.data = new FormData($("#addFrm")[0]);

        callParams.processData = false;
        callParams.contentType = false;
        
        ajaxCall(callParams, function (result) {

            resetLoading('#frmActionBtn', 'Save');
            showSuccess(result.message);
            if(!id) { // only for save
                resetForm('form#addFrm');
            }
            getDataList();
            $('#addFormSidebar').offcanvas('hide');
        }, function (err, type, httpStatus) {
            showFormError(err, '#addFrm');
            resetLoading('#frmActionBtn', 'Save');
        });

        return false;
    });

    // edit user
    $(document).on('click', '.editIcon', function(){
        let userId = parseInt($(this).data("id"));
        let actionUrl = $(this).data("update-url");
        let editActionUrl = $(this).data("url");

        $('#addFrm .offcanvas-title').text("{{ localize('Update Chat Category') }}");
        $('#addFormSidebar').offcanvas('show');

        resetForm('form#addFrm');
        resetFormErrors('form#addFrm');
        hideElement('.password_wrapper');
        $('form#addFrm').attr('action', actionUrl);
        $("form#addFrm [name='_method']").attr('value', 'PUT');

        let callParams  = {};
        callParams.type = "GET";
        callParams.url  = editActionUrl;
        callParams.data = "";
        loadingInContent('#loader', 'loading...');
        hideElement('.offcanvas-body');
        ajaxCall(callParams, function (result) {
            resetLoading('#loader', '');
            showElement('.offcanvas-body');
            if(result.data) {
                let chatCategory = result.data;
                $('#addFrm #_method').val("PUT");
                $('#addFrm #id').val(chatCategory.id);
                $('#addFrm #category_name').val(chatCategory.category_name);
                $('#addFrm #is_active').val(chatCategory.is_active).change();
            }
        },
        function (err, type, httpStatus) {

        });

    });

    getDataList();
</script>
