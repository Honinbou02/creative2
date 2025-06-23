<script>
    "use strict";

    const CSRF_TOKEN = "{{ csrf_token() }}";

    $(() => {
        showHideLoader(false);
        getDataList();
    });

    function showHideLoader(isShow = true){
        if(isShow){
            $(".contentLoader").removeClass("d-none");
        }else{
            $(".contentLoader").addClass("d-none");
        }
    }



    // load Videos
    function getDataList() {
        var callParams = {};
        callParams.type = "GET";
        callParams.dataType = "html";
        callParams.url = "{{ route('admin.videos.index') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data = '';
        ajaxCall(callParams, function(result) {
            $('tbody').empty().html(result);

            feather.replace();
        }, function onErrorData(err, type, httpStatus) {
            let error = JSON.parse(err.responseText);
            centerToast(error.message, "error");
        });
    }
    // search
    $('body').on('click', '#searchBtn', function() {
        var search = $('#f_search').val();
        var is_active = $('#f_is_active :selected').val();

        gFilterObj.search = search;
        loadingInTable("#vedio-list",{
            colSpan: 5,
            prop: false,
        });
       

        if (gFilterObj.hasOwnProperty('page')) {
            delete gFilterObj.page;
        }

        getDataList();
    });
    // handle offcanvas for adding an user
    $(document).on('click', '#addFrmOffCanvas', function() {
        $('#addFormSidebar .offcanvas-title').text("{{ localize('Generate AI Image') }}");
        resetFormErrors('form#addFrm');
        resetForm('form#addFrm');
        showElement('.password_wrapper');
        $('form#addFrm').attr('action', "{{ route('admin.chat-categories.store') }}");
        $("form#addFrm [name='_method']").attr('value', 'POST');
    });

    $(document).on("click", "#generate", async function() {
       let callParams = {};

       if ($('#image').val() == '') {
           alert('Please select an image.');
           return false; // Stop the function if no image is selected
       }

       let file_data = $('#image').prop('files')[0];

       let motion_bucket_id = $("#motion_bucket_id").val();
       let cfg_scale        = $("#cfg_scale").val();
       let seed             = $("#seed").val();

       loading('#generate','Generating....');

       let formData  = new FormData();

        formData.append("motion_bucket_id", motion_bucket_id);
        formData.append("cfg_scale", cfg_scale);
        formData.append("seed", seed);
        formData.append("image", file_data);
        formData.append("_token", CSRF_TOKEN);
        formData.append("content_purpose", "{{ appStatic()::SD_IMAGE_2_VIDEO }}");
       
       callParams.type     = "POST";
       callParams.dataType = "json";
       callParams.url      = "{{ route('admin.videos.sdImage2Video') }}";
       callParams.data     = formData;
       callParams.processData = false;
       callParams.contentType = false;
       ajaxCall(callParams,  function(response) {
               resetLoading('#generate', 'Generate Video');

               if(response.code != 200){
                   centerToast(response.message,"error","btn-danger btn-sm");
               }else{
                   resetLoading('#generate', 'Generate Video');
                   getDataList();
                   centerToast(response.message);
               }
           },
           function(XHR, textStatus, errorThrown) {
               let error = JSON.parse(XHR.responseText);
               centerToast(error.message, "error", "btn btn-danger btn-sm");
           },
           1000000, 1500
       );
    });

</script>