<script>
    'use strict';
    // load Template Categories
    function getDataList() {
        var callParams      = {};
        var url             = '{{ route("admin.platforms.index") }}';
        callParams.type     = "GET";
        callParams.dataType = "html";
        callParams.url      = url + (gFilterObj ? '?' + $.param(gFilterObj): '');
        callParams.data     = '';
        ajaxCall(callParams, function(result) {
            $('tbody').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }

    // search
    $('body').on('click', '#searchBtn', function() {
        var search = $('#f_search').val();
        loadingInTable("tbody",{
            colSpan: 11,
            prop: false,
        });
        gFilterObj.search = search;
        if (gFilterObj.hasOwnProperty('page')) {
            delete gFilterObj.page;
        }

        getDataList();
    });
    var offcanvasBottom = document.getElementById('offcanvasBottom')
    var secondoffcanvas = document.getElementById('addPlatformFormSidebar')

    offcanvasBottom.addEventListener('hidden.bs.offcanvas', function() {
        var bsOffcanvas2 = new bootstrap.Offcanvas(secondoffcanvas)
        bsOffcanvas2.show()
    })
    getDataList();
    
    // handle offcanvas for configuring a platform
    $(document).on('click', '.configurePlatformBtn', function() {
        loadingInContent("#configurePlatformFormContainer");

        // ajax call to get the folder list/ html
        let callParams = {};
        let id = $(this).data('id');

        let formData = {
            id: id,
        }
        callParams.type     = "POST";
        callParams.url      = "{{ route('admin.platforms.configure-form') }}";
        callParams.data     = formData;
        callParams.dataType = 'html';

        if (id == null || id == '') {
            return;
        }
        ajaxCall(callParams, function(result) {
            $('#configurePlatformFormContainer').empty().html(result);
            feather.replace();
        }, function(err, type, httpStatus) {
            console.log(err);
            feather.replace();
        });
    })

    $(document).on("click", "#frmActionBtn", function(e) {
        e.preventDefault();
        let callParams = {};
        let formData = $('#configurePlatformForm').serialize();
        callParams.type = "POST";
        callParams.url = "{{ route('admin.platforms.configure') }}";
        callParams.data = formData;

        loading('#frmActionBtn', 'Saving...');
        ajaxCall(callParams, function(result) {
            toast(result.message);
            getDataList();
            resetLoading('#frmActionBtn', 'Save Changes');
            $('#configurePlatformFormSidebar').offcanvas('hide');
        }, function(err, type, httpStatus) {
            showFormError(err, "#configurePlatformForm");
            resetLoading('#frmActionBtn', 'Save Changes');
        });

        return false;
    });

    // handle offcanvas for creating a platform
    $(document).on('click', '.addPlatformBtn', function() {
        loadingInContent("#addPlatformFormContainer");

        // ajax call to get the folder list/ html
        let callParams = {};
        let id = $(this).data('id');

        let formData = {
            id: id,
        }
        callParams.type     = "POST";
        callParams.url      = "{{ route('admin.platforms.edit') }}";
        callParams.data     = formData;

        if (id == null || id == '') {
            return;
        }
        ajaxCall(callParams, function(result) {
            $('#addPlatformFormContainer').empty().html(result.data);
            showSelectedFilePreviewOnLoad();
            feather.replace();
        }, function(err, type, httpStatus) {
            feather.replace();
        });
    })

    $(document).on("click", "#addFormActionBtn", function(e) {
        e.preventDefault();
        let callParams = {};
        let formData = $('#addPlatformForm').serialize();
        callParams.type = "POST";
        callParams.url = "{{ route('admin.platforms.update') }}";
        callParams.data = formData;

        loading('#addFormActionBtn',  '{{ localize('Saving') }}...');
        ajaxCall(callParams, function(result) {
            toast(result.message);
            getDataList();
            resetLoading('#addFormActionBtn', '{{ localize('Save Changes') }}');
            
            $('#addPlatformFormSidebar').offcanvas('hide');
        }, function(err, type, httpStatus) {
            showFormError(err, "#addPlatformForm");
            resetLoading('#addFormActionBtn',  '{{ localize('Save Changes') }}');
        });

        return false;
    });
</script>
