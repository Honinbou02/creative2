<script>
    'use strict';

    // load Template Categories
    function getDataList() {
        var callParams = {};
        callParams.type = "GET";
        callParams.dataType = "html";
        callParams.url = "{{ route('admin.blogs.index') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data = '';
        ajaxCall(callParams, function(result) {
            $('tbody').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }

    // handle offcanvas for adding an user
    $('body').on('click', '#addBlogFormOffCanvas', function() {
        $('#addBlogForm .offcanvas-title').text("{{ localize('Add New Article') }}");
        resetFormErrors('form#addBlogForm');
        resetForm('form#addBlogForm');
        removeAllImage();
        $('#addBlogForm #meta_image').val('');
        $('#addBlogForm #blog_image').val('');
        $('form#addBlogForm').attr('action', "{{ route('admin.blogs.store') }}");
        $("form#addBlogForm [name='_method']").attr('value', 'POST');
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


        if (gFilterObj.hasOwnProperty('Blog')) {
            delete gFilterObj.Blog;
        }

        getDataList();
    });

    // add Blog
    $("#addBlogForm").submit(function(e) {
        e.preventDefault();
        resetFormErrors('form#addBlogForm');
        loading('#frmActionBtn', 'Saving...');

        let id = $("#addBlogForm #id").val();
        let callParams = {};

        callParams.type = "POST";
        callParams.url = $("form#addBlogForm").attr("action");
        callParams.data = $("form#addBlogForm").serialize();

        ajaxCall(callParams, function(result) {
            resetLoading('#frmActionBtn', 'Save');
            id ? toast(result.message) : showSuccess(result.message);
            if (!id) { // only for save
                resetForm('form#addBlogForm');
            }
            $('#addBlogForm #meta_image').val('');
            $('#addBlogForm #blog_image').val('');
            getDataList();
            $('#addBlogFormSidebar').offcanvas('hide');
        }, function(err, type, httpStatus) {
            showFormError(err, '#addBlogForm');
            resetLoading('#frmActionBtn', 'Save');
        });

        return false;
    });

    // edit user
    $(document).on('click', '.editIcon', function() {
        let userId = parseInt($(this).data("id"));
        let actionUrl = $(this).data("update-url");
        let editActionUrl = $(this).data("url");

        $('#addBlogForm .offcanvas-title').text("{{ localize('Update Blog') }}");
        $('#addBlogFormSidebar').offcanvas('show');
        $('.selected-file').html('');
        resetForm('form#addBlogForm');
        resetFormErrors('form#addBlogForm');
        hideElement('.password_wrapper');
        $('form#addBlogForm').attr('action', actionUrl);
        $("form#addBlogForm [name='_method']").attr('value', 'PUT');
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
            if (result) {
                let blogTags = "[3]";
                let Blog = result.data.blog;
                    $('#addBlogForm #_method').val("PUT");
                    $('#addBlogForm #id').val(Blog.id);
                    $('#addBlogForm #title').val(Blog.title);
                    $('#editor').summernote('code', Blog.description);
                    $('#addBlogForm #meta_title').val(Blog.meta_title);
                    $('#addBlogForm #meta_image').val(Blog.meta_image);
                    $('#addBlogForm #blog_image').val(Blog.blog_image);
                    $('#addBlogForm #meta_description').val(Blog.meta_description);
                    $('#addBlogForm #short_description').val(Blog.short_description);
                    $('#addBlogForm #is_active').val(Blog.is_active).change();
                
                    
                    $('#addBlogForm #blog_category_id').val(Blog.blog_category_id).change();
                    getChosenFilesCount();
                    showSelectedFilePreviewOnLoad();
                }
            },
            function(err, type, httpStatus) {

            });

    });

    getDataList();

    var offcanvasBottom = document.getElementById('offcanvasBottom')
    var secondoffcanvas = document.getElementById('addBlogFormSidebar')

    offcanvasBottom.addEventListener('hidden.bs.offcanvas', function() {
        var bsOffcanvas2 = new bootstrap.Offcanvas(secondoffcanvas)
        bsOffcanvas2.show()
    })
</script>
