<script>
    'use strict';

    // load Template Categories
    function getDataList() {
        var callParams      = {};
        callParams.type     = "GET";
        callParams.dataType = "html";
        callParams.url      = "{{ route('admin.blog-categories.index') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data     = '';

        ajaxCall(callParams, function(result) {
            $('tbody').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }

    // handle offcanvas for adding an user
    $('body').on('click', '#addBlogCategoryFormOffCanvas', function() {
        $('#addBlogCategoryForm .offcanvas-title').text("{{ localize('Add Category') }}");
        resetFormErrors('form#addBlogCategoryForm');
        resetForm('form#addBlogCategoryForm');
        showElement('.password_wrapper');
        $('form#addBlogCategoryForm').attr('action', "{{ route('admin.blog-categories.store') }}");
        $("form#addBlogCategoryForm [name='_method']").attr('value', 'POST');
    })

    // search
    $('body').on('click', '#searchBtn', function() {
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

    // add Category
    $("#addBlogCategoryForm").submit(function(e) {
        e.preventDefault();
        resetFormErrors('form#addBlogCategoryForm');
        loading('#frmActionBtn', 'Saving...');

        let id = $("#addBlogCategoryForm #id").val();
        let callParams = {};

        callParams.type = "POST";
        callParams.url = $("form#addBlogCategoryForm").attr("action");
        callParams.data = $("form#addBlogCategoryForm").serialize();

        ajaxCall(callParams, function(result) {
            resetLoading('#frmActionBtn', 'Save');
            id ? toast(result.message) : showSuccess(result.message);
            if (!id) { // only for save
                resetForm('form#addBlogCategoryForm');
            }
            $('#addBlogCategoryFormSidebar').offcanvas('hide');
        }, function(err, type, httpStatus) {
            showFormError(err, '#addBlogCategoryForm');
            resetLoading('#frmActionBtn', 'Save');
        });

        return false;
    });

    // edit user
    $(document).on('click', '.editIcon', function() {
        let userId = parseInt($(this).data("id"));
        let actionUrl = $(this).data("update-url");
        let editActionUrl = $(this).data("url");
      
        $('#addBlogCategoryForm .offcanvas-title').text("{{ localize('Update Category') }}");
        $('#addBlogCategoryFormSidebar').offcanvas('show');

        resetForm('form#addBlogCategoryForm');
        resetFormErrors('form#addBlogCategoryForm');
        $('form#addBlogCategoryForm').attr('action', actionUrl);
        $("form#addBlogCategoryForm [name='_method']").attr('value', 'PUT');
        $("#frmActionBtn").html('{{ localize('update') }}');
        let callParams = {};
        callParams.type = "GET";
        callParams.url = editActionUrl;
        callParams.data = "";
        loadingInContent('#loader', 'loading...');
        hideElement('.offcanvas-body');
        ajaxCall(callParams, function(result) {
            resetLoading('#loader', '');
            showElement('.offcanvas-body');
                if (result.data) {
                    let category = result.data;
                    $('#addBlogCategoryForm #_method').val("PUT");
                    $('#addBlogCategoryForm #id').val(category.id);
                    $('#addBlogCategoryForm #category_name').val(category.category_name);
                    $('#addBlogCategoryForm #is_active').val(category.is_active).change();
                }
            },
            function(err, type, httpStatus) {

            });

    });


    getDataList();
</script>
@if(isModuleActive('WordpressBlog'))
<script>
        $(document).on('click', '#syncAllCategory', function(e) {
            e.preventDefault();
            $('#syncText').html('Syncing.......');
            callParams = {};
            callParams.type = "GET";
            callParams.url = "{{route('admin.sync.all.categories')}}";
            ajaxCall(callParams, function(result) {
                $('#syncText').html("{{localize('Sync to wordpress')}}");
                resetLoading('#frmActionBtn', 'Save');
                id ? toast(result.message) : showSuccess(result.message);                
                getDataList();
              
            }, function(err, type, httpStatus) {
                showFormError(err, '#addCategoryForm');
                resetLoading('#frmActionBtn', 'Save');
            });
            return false;
        });
</script>
@endif