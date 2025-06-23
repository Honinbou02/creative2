<script>
    'use strict';

    // load Template Categories
    function getDataList() {
        var callParams      = {};
        callParams.type     = "GET";
        callParams.dataType = "html";
        callParams.url      = "{{ route('admin.template-categories.index') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data     = '';

        loadingInTable("tbody",{
                    colSpan: 11,
                    prop: false,
        });
       
        ajaxCall(callParams, function(result) {
            $('tbody').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }

    // handle offcanvas for adding an user
    $('body').on('click', '#addTemplateCategoryFormOffCanvas', function() {
        $('form#addTemplateCategoryForm .offcanvas-title').text("{{ localize('Add Template Category') }}");
        resetFormErrors('form#addTemplateCategoryForm');
        resetForm('form#addTemplateCategoryForm');
        $('form#addTemplateCategoryForm').attr('action', "{{ route('admin.template-categories.store') }}");
        $("form#addTemplateCategoryForm [name='_method']").attr('value', 'POST');
    })

    // search
    $('body').on('click', '#searchBtn', function(e) {
        e.preventDefault();
        var search = $('#f_search').val();
        var is_active = $('#f_is_active :selected').val();

        gFilterObj.search = search;
        loadingInTable("tbody",{
                    colSpan: 11,
                    prop: false,
        });
        if (is_active === '0' || is_active === '1') {
            gFilterObj.is_active = is_active;
        } else if (gFilterObj.hasOwnProperty('is_active')) {
            delete gFilterObj.is_active;
        }


        if (gFilterObj.hasOwnProperty('page')) {
            delete gFilterObj.page;
        }

        getDataList();
    });

    // add Template Category
    $("#addTemplateCategoryForm").submit(function(e) {
        e.preventDefault();
        resetFormErrors('form#addTemplateCategoryForm');
        loading('#frmActionBtn', 'Saving...');

        let id = $("#addTemplateCategoryForm #id").val();
        let callParams = {};

        callParams.type = "POST";
        callParams.url = $("form#addTemplateCategoryForm").attr("action");
        callParams.data = new FormData($("#addTemplateCategoryForm")[0]);
        callParams.processData  = false;
        callParams.contentType  = false;

        ajaxCall(callParams, function(result) {

            resetLoading('#frmActionBtn', 'Save');
            id ? toast(result.message) : showSuccess(result.message);
            if (!id) { // only for save
                resetForm('form#addTemplateCategoryForm');
            }
            getDataList();
            id ? $('#addTemplateCategoryFormSidebar').offcanvas('hide') : '';
        }, function(err, type, httpStatus) {
            showFormError(err, '#addTemplateCategoryForm');
            resetLoading('#frmActionBtn', 'Save');
        });

        return false;
    });

    // edit user
    $(document).on('click', '.editIcon', function() {
        let userId        = parseInt($(this).data("id"));
        let actionUrl     = $(this).data("update-url");
        let editActionUrl = $(this).data("url");

        $('#addTemplateCategoryForm .offcanvas-title').text("{{ localize('Update Template Category') }}");
        $('#addTemplateCategoryFormSidebar').offcanvas('show');

        resetForm('form#addTemplateCategoryForm');
        resetFormErrors('form#addTemplateCategoryForm');
        hideElement('.password_wrapper');
        $('form#addTemplateCategoryForm').attr('action', actionUrl);
        $("form#addTemplateCategoryForm [name='_method']").attr('value', 'PUT');
        $("#frmActionBtn").html('{{ localize('update') }}');
        let callParams  = {};
        callParams.type = "GET";
        callParams.url  = editActionUrl;
        callParams.data = "";
        loadingInContent('#loader', 'loading...');
        hideElement('.offcanvas-body');
        ajaxCall(callParams, function(result) {
            resetLoading('#loader', '');
            showElement('.offcanvas-body');
                if (result.data) {
                    let chatCategory = result.data;
                    $('#addTemplateCategoryForm #_method').val("PUT");
                    $('#addTemplateCategoryForm #id').val(chatCategory.id);
                    $('#addTemplateCategoryForm #category_name').val(chatCategory.category_name);
                    $('#addTemplateCategoryForm #icon').val(chatCategory.icon);
                    $('#addTemplateCategoryForm #is_active').val(chatCategory.is_active).change();
                }
            },
            function(err, type, httpStatus) {

            });

    });
    getDataList();
</script>
