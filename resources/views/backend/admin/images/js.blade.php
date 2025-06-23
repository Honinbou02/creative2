<script>
    "use strict";

    const CSRF_TOKEN = "{{ csrf_token() }}";

    const ACTION_DALL_E_2                   = "dallE2";
    const ACTION_DALL_E_3                   = "dallE3";
    const ACTION_SD_TEXT_TO_IMAGE           = "sdTextToImage";
    const ACTION_SD_IMAGE_TO_IMAGE          = "sdImageToImage";
    const ACTION_SD_UP_SCALING              = "sdUpScaling";
    const ACTION_SD_MULTI_PROMPTING         = "sdMultiPrompting";

    const URL_DALL_E_2                      = "{{ route('admin.images.dallE2') }}";
    const URL_DALL_E_3                      = "{{ route('admin.images.dallE3') }}";
    const URL_SD_TEXT_2_IMAGE               = "{{ route('admin.images.sdText2Image') }}";
    const URL_SD_TEXT_2_IMAGE_MULTI_PROMPT  = "{{ route('admin.images.sdImage2ImageMultiPrompt') }}";
    const URL_SD_IMAGE_2_IMAGE_PROMPT       = "{{ route('admin.images.sdImage2ImagePrompt') }}";
    const URL_SD_IMAGE_2_IMAGE_MASKING      = "{{ route('admin.images.sdImage2ImageMasking') }}";
    const URL_SD_IMAGE_2_IMAGE_UPSCALE      = "{{ route('admin.images.sdImage2ImageUpscale') }}";

    window.nextAction = ACTION_DALL_E_2;

    $(() => {
        hideElement(".sdImgWrapper");
        resetLoading('#generateImage', "{{ localize('Generate Image')}}");
    });

    $(document).on("click", ".actionImageGenerate", function(e) {
        window.nextAction = $(this).data("action");
        nextActionShow();
    });

    // Select Stable Diffusion Next Action
    $(document).on('click', '.sdAction', function() {
        window.nextAction = $(this).data('sd');

        $(".sdAction").removeClass('active');
        $(".tt-check-icon").remove();
        $(this).addClass('active');

        $(this).append(
            '<span class="tt-check-icon"><i data-feather="check" class="icon-14"></i></span>'
        );

        feather.replace();

        nextActionShow();
    });

    // load images
    function getDataList(content_type) {
        loadingInContent('.allImageRow');
        var callParams      = {};
        callParams.type     = "GET";
        callParams.dataType = "html";
        callParams.url      = "{{ route('admin.images.index') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data     = {
            content_type
        };
        ajaxCall(callParams, function(result) {
            $('.allImageRow').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {
            let error = JSON.parse(err.responseText);
            centerToast(error.message, "error");
        });
    }

    $('.showImage, .allImage').on('click', function(){
        $(".showImage").removeClass("active");
        $(this).addClass("active");

        let content_type = $(this).attr("data-content");

        $('.imageItem').fadeOut(100).promise().done(function(){
            // After all product cards are hidden, show only the selected category
            getDataList(content_type)
            $('.' + content_type).fadeIn(300);

        });

    });

    // handle offcanvas for adding an user
    $(document).on('click', '#addFrmOffCanvas', function() {
        $('#addFormSidebar .offcanvas-title').text("{{ localize('Generate AI Image') }}");
        resetFormErrors('form#addFrm');
        resetForm('form#addFrm');
        showElement('.password_wrapper');
        $('form#addFrm').attr('action', "{{ route('admin.chat-categories.store') }}");
        $("form#addFrm[name='_method']").attr('value', 'POST');
    });

    $(document).on("click", "#generateImage", function() {
    
        nextActionShow();
        let nextAction = String(window.nextAction);
        loadingInBtn('#generateImage', "{{ localize('Generating...')}}");

        if (nextAction === ACTION_DALL_E_2) {
            generateDallE2Image();
          
        }
        else if (nextAction === ACTION_DALL_E_3) {
            generateDallE3Image();
          
        }
        else if (nextAction === ACTION_SD_TEXT_TO_IMAGE) {
            generateSDText2Image();
          
        }
        else if (nextAction === ACTION_SD_IMAGE_TO_IMAGE) {
            generateSDImage2ImageMasking();
          
        }
        else if (nextAction === ACTION_SD_UP_SCALING) {
            generateSDImage2ImageUpScale();
          
        }
        else if (nextAction === ACTION_SD_MULTI_PROMPTING) {
            generateSDText2ImageMultiPrompt();
          
        }
        balanceRender();
    });


    // dall-e-2
    function generateDallE2Image() {
        let callParams          = {};
        callParams.type         = "POST";
        callParams.url          = URL_DALL_E_2;

        let title               = $("#dallE2Title").val();
        let style               = $("#dallE2ArtStyle").val();
        let size                = $("#dallE2Size").val();
        let mood                = $("#dallE2Mode").val();
        let number_of_results   = $("#dallE2NumberOfResults").val();


        callParams.data = {
            title:              title,
            style:              style,
            size:               size,
            mode:               mood,
            number_of_results:  number_of_results,
            _token:             CSRF_TOKEN,
            content_purpose:    "{{ appStatic()::DALL_E_2 }}",
        };

        ajaxCall(
            callParams,
            function(response) {
                resetLoading('#generateImage', "{{ localize('Generate Image')}}");
                getDataList();
                centerToast(response.message);
                $('#addFormSidebar').offcanvas('hide');

                $("#dallE2Title").val("");

                // Update Remaining & Used
                $(".balanceRemaining").text(response.optional?.remaining_balance);
                $(".balanceProgressBar").attr("aria-valuenow", response.optional?.image_balance_used);
                $(".balanceProgressBar").style.width = response.optional?.image_balance_used + '%';
            },
            function(XHR, textStatus, errorThrown) {
                resetLoading('#generateImage', "{{ localize('Generate Image')}}");
                centerToast(XHR.responseJSON.message ?? "{{ session(sessionLab()::SESSION_OPEN_AI_ERROR) }}", "error", "btn btn-danger btn-sm");
            },
            1000000, 1500
        );
    }

    // dall-e-3
    function generateDallE3Image() {
        let callParams          = {};
        callParams.type         = "POST";
        callParams.url          = URL_DALL_E_3;

        let title               = $("#dallE3Title").val();
        let style               = $("#dallE3ArtStyle").val();
        let quality             = $("#dallE3quality").val();
        let size                = $("#dallE3Size").val();
        let mood                = $("#dallE3Mode").val();
        let lighting_style      = $("#dallE3LightingStyle").val();
        let number_of_results   = $("#dallE3NumberOfResults").val();

        callParams.data = {
            title:              title,
            style:              style,
            quality:            quality,
            size:               size,
            mood:               mood,
            lighting_style:     lighting_style,
            number_of_results:  number_of_results,
            _token:             CSRF_TOKEN,
            content_purpose:    "{{ appStatic()::DALL_E_3 }}",
        };

        ajaxCall(
            callParams,
            function(response) {
                $("#dallE3Title").val("");
                resetLoading('#generateImage', "{{ localize('Generate Image')}}");
                getDataList();
                centerToast(response.message);
                $('#addFormSidebar').offcanvas('hide');
            },
            function(XHR, textStatus, errorThrown) {
                let error = JSON.parse(XHR.responseText);
                showFormError(XHR,"#generateImage");
                resetLoading('#generateImage', "{{ localize('Generate Image')}}");
                centerToast(error.message, "error", "btn btn-danger btn-sm");
            },
            1000000, 1500
        );
    }

    function nextActionShow() {

        let action = String(window.nextAction);

        if(action === ACTION_SD_TEXT_TO_IMAGE){
            hideElement(".sdImgWrapper");
            hideElement(".multiPromptLists");
            showElement(".sdTitleDiv");
        }

        if (action === ACTION_SD_UP_SCALING || action === ACTION_SD_IMAGE_TO_IMAGE){
            showElement(".sdImgWrapper");
            hideElement(".multiPromptLists");
            showElement(".sdTitleDiv");
        }

        if(action === ACTION_SD_MULTI_PROMPTING){
            showElement(".multiPromptLists");
            hideElement(".sdImgWrapper");
            hideElement(".sdTitleDiv");
        }
    }

    $(document).on("click", ".imgViewModal", function(e) {
        let title       = $(this).data("title");
        let imageUrl    = $(this).data("image-url");
        let size        = $(this).data("size");
        let model       = $(this).data("model");
        let prompt      = $(this).data("prompt");
        let createdAt   = $(this).data("createdAt");
        let platform    = $(this).data("platform");

        $("#modalTitle").text(title);
        $("#modalImg").attr("src", imageUrl);
        $("#modalPrompt").text(prompt);
        $("#modalCreatedAt").text(createdAt);
        $("#modalPlatForm").text(platform);
        $("#modalModel").text(model);
        $("#modalSize").text(size);

    })


    /**
     * Stable Diffusion Start
     * */

    function generateSDText2Image() {

        // Showing Loader
        let callParams          = {};
        callParams.type         = "POST";
        callParams.processData  = false;
        callParams.contentType  = false;
        callParams.url          = URL_SD_TEXT_2_IMAGE;

        let title               = $("#SDTitle").val();
        let style               = $("#SDArtStyle").val();
        let size                = $("#SDSize").val();
        let mood                = $("#SDMode").val();
        let lighting_style      = $("#SDLightingStyle").val();
        let number_of_results   = $("#SDNumberOfResults").val();

        let formData = new FormData();

        formData.append("title", title);
        formData.append("style", style);
        formData.append("size", size);
        formData.append("mood", mood);
        formData.append("lighting_style", lighting_style);
        formData.append("number_of_results", number_of_results);
        formData.append("_token", "{{ csrf_token() }}");
        formData.append("content_purpose",  "{{ appStatic()::SD_TEXT_2_IMAGE }}");

        callParams.data = formData;
        ajaxCall(
            callParams,
            function(response) {
                // Hiding Loader
                resetLoading('#generateImage', "{{ localize('Generate Image')}}");
                getDataList();
                centerToast(response.message);
                $('#addFormSidebar').offcanvas('hide');
            },
            function(XHR, textStatus, errorThrown) {
                // Hiding Loader
                resetLoading('#generateImage', "{{ localize('Generate Image')}}");

                let error = JSON.parse(XHR.responseText);

                centerToast(error.message, "error", "btn btn-danger btn-sm");
            },
            1000000, 1500
        );
    }

    function generateSDText2ImageMultiPrompt() {
        let callParams          = {};
        callParams.type         = "POST";
        callParams.contentType  = false;
        callParams.processData  = false;
        callParams.url          = URL_SD_TEXT_2_IMAGE_MULTI_PROMPT;

        let formData = new FormData();

        let title               = $("#SDTitle").val();
        let style               = $("#SDArtStyle").val();
        let quality             = $("#SDquality").val();
        let size                = $("#SDSize").val();
        let mood                = $("#SDMode").val();
        let lighting_style      = $("#SDLightingStyle").val();
        let number_of_results   = $("#SDNumberOfResults").val();

        // Title Binding.
        $('input[name="title[]"]').each(function(index, element){
            // Add each title to the FormData object
            formData.append('title[]', $(element).val());
        });

        formData.append("style", style);
        formData.append("quality", quality);
        formData.append("size", size);
        formData.append("mood", mood);
        formData.append("lighting_style", lighting_style);
        formData.append("number_of_results", number_of_results);
        formData.append("content_purpose", "{{ appStatic()::SD_TEXT_2_IMAGE_MULTI_PROMPT }}");
        formData.append("_token", "{{ csrf_token() }}");

        callParams.data = formData;

        ajaxCall(
            callParams,
            function(response) {
                // Hiding Loader
                resetLoading('#generateImage', "{{ localize('Generate Image')}}");
                getDataList();
                centerToast(response.message);
                $('#addFormSidebar').offcanvas('hide');
            },
            function(XHR, textStatus, errorThrown) {
                // Hiding Loader
                resetLoading('#generateImage', "{{ localize('Generate Image')}}");
                let error = JSON.parse(XHR.responseText);

                centerToast(error.message, "error", "btn btn-danger btn-sm");
            },
            1000000, 1500
        );
    }

    // Stable Diffusion Image to Image with Prompt
    function generateSDImage2ImagePrompt() {
        let callParams          = {};
        callParams.type         = "POST";
        callParams.contentType  = false;
        callParams.processData  = false;
        callParams.url          = URL_SD_IMAGE_2_IMAGE_PROMPT;

        if ($('#image').val() == '') {
            alert("{{ localize('Please select an image.')}}");
            return false; // Stop the function if no image is selected
        }

        let formData            = new FormData();

        let title               = $("#SDTitle").val();
        let style               = $("#SDArtStyle").val();
        let quality             = $("#SDquality").val();
        let size                = $("#SDSize").val();
        let mood                = $("#SDMode").val();
        let lighting_style      = $("#SDLightingStyle").val();
        let number_of_results   = $("#SDNumberOfResults").val();

        var file_data = $('#image').prop('files')[0];
        formData.append("title", title);
        formData.append("style", style);
        formData.append("quality", quality);
        formData.append("size", size);
        formData.append("mood", mood);
        formData.append("lighting_style", lighting_style);
        formData.append('image', file_data);
        formData.append('number_of_results', number_of_results);
        formData.append("_token", "{{ csrf_token() }}");
        formData.append('content_purpose', "{{ appStatic()::SD_IMAGE_2_IMAGE_PROMPT }}");

        callParams.data = formData;

        ajaxCall(
            callParams,
            function(response) {
                // Hiding Loader
                resetLoading('#generateImage', "{{ localize('Generate Image')}}");
                getDataList();
                centerToast(response.message);
                $('#addFormSidebar').offcanvas('hide');
            },
            function(XHR, textStatus, errorThrown) {
                // Hiding Loader
                resetLoading('#generateImage', "{{ localize('Generate Image')}}");
                let error = JSON.parse(XHR.responseText);

                centerToast(error.message, "error", "btn btn-danger btn-sm");
            },
            1000000, 1500
        );
    }

    // Stable Diffusion Image to Image with Prompt
    function generateSDImage2ImageMasking() {
        let callParams          = {};
        callParams.type         = "POST";
        callParams.contentType  = false;
        callParams.processData  = false;
        callParams.url          = URL_SD_IMAGE_2_IMAGE_MASKING;

        if ($('#image').val() == '') {
            alert("{{ localize('Please select an image.')}}");
            return false; // Stop the function if no image is selected
        }

        let formData            = new FormData();

        let title               = $("#SDTitle").val();
        let style               = $("#SDArtStyle").val();
        let quality             = $("#SDquality").val();
        let size                = $("#SDSize").val();
        let mood                = $("#SDMode").val();
        let lighting_style      = $("#SDLightingStyle").val();
        let number_of_results   = $("#SDNumberOfResults").val();

        var file_data = $('#image').prop('files')[0];
        formData.append("title", title);
        formData.append("style", style);
        formData.append("quality", quality);
        formData.append("size", size);
        formData.append("mood", mood);
        formData.append("lighting_style", lighting_style);
        formData.append('image', file_data);
        formData.append("_token", "{{ csrf_token() }}");
        formData.append('content_purpose', "{{ appStatic()::SD_IMAGE_2_IMAGE_MASKING }}");
        formData.append('number_of_results', number_of_results);

        callParams.data = formData;

        ajaxCall(
            callParams,
            function(response) {
                // Hiding Loader
                resetLoading('#generateImage', "{{ localize('Generate Image')}}");
                getDataList();
                centerToast(response.message);
                $('#addFormSidebar').offcanvas('hide');
            },
            function(XHR, textStatus, errorThrown) {
                // Hiding Loader
                resetLoading('#generateImage', "{{ localize('Generate Image')}}");
                let error = JSON.parse(XHR.responseText);

                centerToast(error.message, "error", "btn btn-danger btn-sm");
            },
            1000000, 1500
        );
    }

    // Stable Diffusion Image to Image with Prompt
    function generateSDImage2ImageUpScale() {
        let callParams          = {};
        callParams.type         = "POST";
        callParams.contentType  = false;
        callParams.processData  = false;
        callParams.url          = URL_SD_IMAGE_2_IMAGE_UPSCALE;

        if ($('#image').val() == '') {
            alert("{{ localize('Please select an image.')}}");
            return false; // Stop the function if no image is selected
        }

        let formData            = new FormData();

        let title               = $("#SDTitle").val();
        let style               = $("#SDArtStyle").val();
        let quality             = $("#SDquality").val();
        let size                = $("#SDSize").val();
        let mood                = $("#SDMode").val();
        let lighting_style      = $("#SDLightingStyle").val();
        let number_of_results   = $("#SDNumberOfResults").val();

        var file_data = $('#image').prop('files')[0];
        formData.append("title", title);
        formData.append("style", style);
        formData.append("quality", quality);
        formData.append("size", size);
        formData.append("mood", mood);
        formData.append("lighting_style", lighting_style);
        formData.append('image', file_data);
        formData.append("_token", "{{ csrf_token() }}");
        formData.append('content_purpose', "{{ appStatic()::SD_IMAGE_2_IMAGE_UPSCALING }}");
        formData.append('number_of_results', number_of_results);

        callParams.data = formData;

        ajaxCall(
            callParams,
            function(response) {
                // Hiding Loader
                resetLoading('#generateImage', "{{ localize('Generate Image')}}");
                getDataList();
                centerToast(response.message);
                $('#addFormSidebar').offcanvas('hide');
            },
            function(XHR, textStatus, errorThrown) {
                // Hiding Loader
                resetLoading('#generateImage', "{{ localize('Generate Image')}}");
                let error = JSON.parse(XHR.responseText);

                centerToast(error.message, "error", "btn btn-danger btn-sm");
            },
            1000000, 1500
        );
    }


    $(document).on('click', '.addPrompt', function() {
        let original = $('.single-prompt').first();
        let clone = original.clone();
        clone.find('input').val('');

        $('.multiPromptLists').append(clone);
    });

    $(document).on('click', '.delPrompt', function() {
        if ($('.single-prompt').length > 1) {
            $(this).closest('.single-prompt').remove();
        }
    });
    // search
    $('body').on('click', '#searchBtn', function(){
        var search      = $('#f_search').val();

        gFilterObj.search    = search;

        if(gFilterObj.hasOwnProperty('page')) {
            delete gFilterObj.page;
        }

        getDataList();
    });
    function balanceRender(type = null) {
        let callParams = {};
        callParams.type = "GET";
        callParams.url = "{{ route('admin.balance-render') }}";
        callParams.data = {
            type: 'image'
        };
        ajaxCall(callParams, function(result) {
                $('#balance-render').html(result.data);
            },
            function(err, type, httpStatus) {
                toast(err.responseJSON.message, 'error');
            });
    }
</script>
