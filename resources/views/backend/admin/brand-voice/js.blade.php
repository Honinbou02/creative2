@include("common.select2")
<script>
    // load Brand Voice List
    function getDataList() {
        var callParams      = {};
        callParams.type     = "GET";
        callParams.dataType = "html";
        callParams.url      = "{{ route('admin.brand-voices.index') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data     = '';
        ajaxCall(callParams, function(result) {
            $('.brandVoiceTbody').empty().html(result);
            initFeather();
        }, function onErrorData(err, type, httpStatus) {});
    }

    getDataList();


    // add Brand Voice
    $("#addBrandVoiceForm").submit(function(e) {
        e.preventDefault();
        resetFormErrors('form#addBrandVoiceForm');
        loading('.saveBrandVoiceBtn', "<i data-feather='save'></i>{{ localize('Brand Voice Saving...') }}");

        let callParams  = {};
        callParams.type = $("form#addBrandVoiceForm").attr("method");
        callParams.url  = $("form#addBrandVoiceForm").attr("action");
        callParams.data = $("form#addBrandVoiceForm").serialize();

        $(".brandVoiceError").remove();

        ajaxCall(callParams, function(result) {
            resetLoading('.saveBrandVoiceBtn', "<i data-feather='save'></i>{{ localize('Save Brand Voice') }}");
            resetForm('form#addBrandVoiceForm');
            showSuccess(result.message);
            $('#addBrandVoiceFromSidebar').offcanvas('hide');

            getDataList();
        }, function(err, type, httpStatus) {
            showFormError(err, '#addBrandVoiceForm');
            resetLoading('.saveBrandVoiceBtn', "<i data-feather='save'></i>{{ localize('Save Brand Voice') }}");
        });

        return false;
    });

    let productServicesTbody = $('.productServicesTbody');

    $(document).on('click', '.addTr', function(e) {
        let $clone = $(this).closest('tr').clone();
        $clone.find('input').val('');

        $('.productServicesTbody').append($clone);
    });

    $(document).on('click', '.removeTr', function() {
        if ($('.productServicesTbody tr').length > 1) {
            $(this).closest('tr').remove();
        }
    });

    let brandVoiceFormBlade = `<?= $brandVoiceForm ?>`;

    // Add Brand Voice
    $(document).on("click","#addBrandVoiceFromSidebarOffCanvas", function (e){
        // Offcanvas title change
        $(".brandVoiceCanvasTitle").text("{{ localize('Add Brand Voice') }}");

        // Form action attribute reverting to the original store
        $('form#addBrandVoiceForm').attr('action', "{{ route('admin.brand-voices.store') }}");

        // Loader added to the Canvas Body
        loading(".brandVoiceCanvasBody", "Loading...");

        // Form Body Replacing
        $('.brandVoiceCanvasBody').empty().html(brandVoiceFormBlade);

        initFeather();
        initSelect2();
    });

    // Edit Brand Voice
    $(document).on("click",".editBrandVoice", function (e){

        // Update form action attribute
        $('form#addBrandVoiceForm').attr('action', $(this).data('update-url'));

        let callParams      = {};
        callParams.type     = "GET";
        callParams.dataType = "html";
        callParams.url      = $(this).data('url');


        $(".brandVoiceCanvasTitle").text("{{ localize('Update Brand Voice') }}");

        loading(".brandVoiceCanvasBody", "Loading...");

        ajaxCall(callParams, function(result) {
            $('.brandVoiceCanvasBody').find('input[name="_method"]').val('PUT');
            $('.brandVoiceCanvasBody').empty().html(result);

            initFeather();
            initSelect2();
        }, function onErrorData(err, type, httpStatus) {
            console.log("Error Response", err.responseJSON);
        });
    });
</script>