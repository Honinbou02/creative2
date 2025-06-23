<script>
    'use strict';
    // load Template Categories
    function getDataList() {
        var callParams      = {};
        var url             = '{{ route("admin.socials.posts.index") }}';
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
        
        var post_status         = $('#f_post_status :selected').val();
        gFilterObj.post_status  = post_status;

        if (gFilterObj.hasOwnProperty('page')) {
            delete gFilterObj.page;
        }

        getDataList();
    });
    getDataList();

    // handle offcanvas for creating a quickText
    $(document).on('click', '.addQuickTextBtn', function() {
        resetFormErrors('#addQuickTextForm');
        loadingInContent("#addQuickTextFormContainer");

        // ajax call to get the folder list/ html
        let callParams = {};
        let id = $(this).data('id');
        if(id != undefined){
            $('#offcanvas-title').html('{{ localize('Update Quick Text') }}')
        }else{ 
            $('#offcanvas-title').html('{{ localize('Add Quick Text') }}')
        }

        let formData = {
            id: id || null,
        }
        callParams.type     = "POST";
        callParams.url      = "{{ route('admin.quick-texts.form') }}";
        callParams.data     = formData;

        ajaxCall(callParams, function(result) {
            $('#addQuickTextFormContainer').empty().html(result.data);
            feather.replace();
        }, function(err, type, httpStatus) {
            feather.replace();
        });
    })

    $(document).on("click", "#addFormActionBtn", function(e) {
        e.preventDefault();

        let id  = $('.id').val();
        
        let callParams      = {};
        let formData        = $('#addQuickTextForm').serialize();
        callParams.type     = "POST";
        callParams.url      = id != '' ? "{{ route('admin.quick-texts.update') }}" : "{{ route('admin.quick-texts.store') }}";
        callParams.data     = formData;

        loading('#addFormActionBtn',  '{{ localize('Saving') }}...');
        ajaxCall(callParams, function(result) {
            toast(result.message);
            getDataList();
            resetFormErrors('#addQuickTextForm');
            resetLoading('#addFormActionBtn', '{{ localize('Save Changes') }}');
            
            $('#addQuickTextFromSidebar').offcanvas('hide');
        }, function(err, type, httpStatus) {
            showFormError(err, "#addQuickTextForm");
            resetLoading('#addFormActionBtn',  '{{ localize('Save Changes') }}');
        });

        return false;
    });
</script>
