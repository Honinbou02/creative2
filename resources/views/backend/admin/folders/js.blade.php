<script>
    'use strict';

    // load Template Categories
    function getDataList() {
        var callParams      = {};
        callParams.type     = "GET";
        callParams.dataType = "html";
        callParams.url      = "{{ route('admin.folders.index') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data     = '';
        loadingInContent('#folderList', 'loading...');
        ajaxCall(callParams, function(result) {
            $('#folderList').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }

    // handle offcanvas for adding an user
    $('body').on('click', '#addFolderOffCanvas', function() {
        $('#addFolderForm .offcanvas-title').text("{{ localize('Add New Folder') }}");
        resetFormErrors('form#addFolderForm');
        resetForm('form#addFolderForm');
        $('form#addFolderForm').attr('action', "{{ route('admin.folders.store') }}");
        $("form#addFolderForm [name='_method']").attr('value', 'POST');
    })

    // add Folder
    $("#addFolderForm").submit(function(e) {
        e.preventDefault();
        resetFormErrors('form#addFolderForm');
        loading('#frmActionBtn', 'Saving...');

        let id = $("#addFolderForm #id").val();
        let callParams  = {};
        callParams.type = "POST";
        callParams.url  = $("form#addFolderForm").attr("action");
        callParams.data = $("#addFolderForm").serialize();

        ajaxCall(callParams, function(result) {
            resetLoading('#frmActionBtn', 'Save');
            toast(result.message);
            if (!id) { // only for save
                resetForm('form#addFolderForm');
            }
            getDataList();
            $('#addFolderFormSidebar').offcanvas('hide');
        }, function(err, type, httpStatus) {
            showFormError(err, '#addFolderForm');
            resetLoading('#frmActionBtn', 'Save');
        });

        return false;
    });

    // edit user
    $(document).on('click', '.editIcon', function() {
        let userId          = parseInt($(this).data("id"));
        let actionUrl       = $(this).data("update-url");
        let editActionUrl   = $(this).data("url");
        
        $('#addFolderForm .offcanvas-title').text("{{ localize('Update Folder') }}");
        $('#addFolderFormSidebar').offcanvas('show');

        resetForm('form#addFolderForm');
        resetFormErrors('form#addFolderForm');

        $('form#addFolderForm').attr('action', actionUrl);
        $("form#addFolderForm [name='_method']").attr('value', 'PUT');
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
                    let folder = result.data;
                    $('#addFolderForm #id').val(folder.id);
                    $('#addFolderForm #folder_name').val(folder.folder_name);
                }
            },
            function(err, type, httpStatus) {

            });

    });

    // search
    $('body').on('click', '#searchBtn', function() {
        var search = $('#f_search').val();
        var is_active = $('#f_is_active :selected').val();

        gFilterObj.search = search;

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


    getDataList();
</script>
