<script>
    'use strict';
    
    // compose-input
    $(document).on('change', '.compose-input', function() {
        let firstInputValue = $('.compose-input').first().val();
        if (firstInputValue === '') {
            $('.compose-input').each(function() {
                if ($(this).val() !== '') {
                    firstInputValue = $(this).val();
                    return false; // break the loop
                }
            });
        }
        $('.compose-input').each(function() {
            if ($(this).val() === '') {
                $(this).val(firstInputValue);
            }
        });
        previewText();
    });
    
    // preview texts
    function previewText() {
        $(document).on('keyup', '.compose-input', function() {
            let platformList = @json(appStatic()::PLATFORM_LIST);
            platformList.forEach(platform => {
                let previewDiv = '#'+platform+'_preview_text';
                let postDetails = '#'+platform+'_post_details'; 
                
                $(`${previewDiv}`).html(''); // Clear previous HTML
                $(`${previewDiv}`).html($(`${postDetails}`).val()); // Add firstInputValue as text
            });
        })
    }
    previewText();
    
    // quickTextClickBtn
    $(document).on('click', '.quickTextClickBtn', function() {
        let desc = $(this).data('text');
        $(".create-post-input").val(desc);
        $(".preview-div").html(desc);
    });

    // social-post-media
    $(document).on('change', '.social-post-media', function() {
        // show social preview
        // Being handled by uppyScripts
    });
    
    // ai assistant - form
    $(document).on('click', '.ai-assistant-btn', function() {

        loadingInContent("#generateContentFormContainer");

        // ajax call to get the folder list/ html
        let callParams  = {};
        callParams.type = "GET";
        callParams.url  = "{{ route('admin.socials.posts.ai-assistant-form') }}";

        ajaxCall(callParams, function(result) {
            $('#generateContentFormContainer').empty().html(result.data);
            feather.replace();
        }, function(err, type, httpStatus) {
            feather.replace();
        });
    });

    // copy prompt
    $(document).on('click', '.promptBtn', function() { 
        let prompt = $(this).data('prompt');
        if(prompt) $('#prompt-input').val(prompt);
    });

    // aiAssistantContentGenerator
    $(document).on('submit', '#aiAssistantContentGenerator', function(e) { 
        e.preventDefault();
        let callParams = {};
        callParams.type = "POST";
        callParams.url  = $(this).attr("action");
        callParams.data = $("#aiAssistantContentGenerator").serialize()

        let streamingRoute = $(this).data("route");
        loading('#generateContent', 'Generating....')
        ajaxCall(callParams, function(response) {   
            resetLoading('#generateContent', 'Generate Content');
            if(response.response_code == 201) {
                $('#generated_id').val(response.data.id);
                eventSourceStreaming(streamingRoute);
                balanceRender();
                // toast(response.message); 
            }else {
                toast(response.message, 'error');
                }
            },
            function(err, type, httpStatus) {
                resetLoading('#generateContent', 'Generate Content');                
                window.releaseForServerRequest = true;
                const errorMsg = err?.responseJSON?.message;
                toast(errorMsg, "error");
                balanceRender();
            }
        );
    });

    // event streaming
    function eventSourceStreaming(streamingRoute) { 
        let streamFormData = $("#aiAssistantContentGenerator").serialize();
        TT.eventSource = new EventSource(`${streamingRoute}?${streamFormData}`, {
            withCredentials: true
        });

        TT.eventSource.onmessage = function(e) {
            if (e.data.indexOf("[DONE]") !== -1) {
                $('#generateContent').prop('disabled', false);
                $('#stopGenerateContent').prop('disabled', true);
                $('#saveChangeButton').prop('disabled', false);
                window.content_response = null;
                TT.eventSource.close();
                updateBalance(); 
                updateUserBalanceAfterGenerateContent("{{ appStatic()::PURPOSE_AI_ASSISTANT_CONTENT }}", "{{ aiAssistantEngine() }}");
            } else {
                $('#stopGenerateContent').prop('disabled', false);
                let txt = undefined;
                try {
                    txt = JSON.parse(e.data).choices[0].delta.content;
                    
                    window.content_response = (window.content_response ?? "")+ txt;
                    if (txt !== undefined) {
                        let finalText = formatText(window.content_response);
                        $(".contentGenerator").html(finalText);
                    }
                } catch (e) {
                    console.log('error ', e);
                }
            }

        };

        TT.eventSource.onerror = function(e) {
             updateBalance();
            updateUserBalanceAfterGenerateContent("{{ appStatic()::PURPOSE_AI_ASSISTANT_CONTENT }}", "{{ aiAssistantEngine() }}");

             $('#generateContent').prop('disabled', false);
            console.log("Error is", TT.eventSource.readyState, "Error Message : ", e);
            toast("{{ session(sessionLab()::SESSION_OPEN_AI_ERROR) }}", 'error');
            TT.eventSource.close();

        };

        $("#generateContent").prop('disabled', true);
        $("#stopGenerateContent").prop('disabled', true); 
    }

    // stop Generate 
    $(document).on("click","#stopGenerateContent",function (e) {
        e.preventDefault();
        if (TT.eventSource) {
            TT.eventSource.close();
        }
        
        window.content_response = null;
        
        $('#generateContent').prop('disabled', false);
        $('#stopGenerateContent').prop('disabled', true);

        updateUserBalanceAfterGenerateContent("{{ appStatic()::PURPOSE_AI_ASSISTANT_CONTENT }}", "{{ aiAssistantEngine() }}");

        balanceRender();
    });

    function updateBalance() {
        window.onMessageArrived = false;
        // Making content response as empty
        emptyContentResponse();
        // Update Balance Ajax Request 
        updateUserBalanceAfterGenerateContent(window.content_purpose, "{{ aiAssistantEngine() }}");
       
    }
    
    function emptyContentResponse() {
        window.content_response = "";
    }


    function balanceRender(type = null) {
        let callParams = {};
        callParams.type = "GET";
        callParams.url = "{{ route('admin.balance-render') }}";
        callParams.data = {
            type: type
        };
        ajaxCall(callParams, function(result) {
                $('#balance-render').html(result.data);
            },
            function(err, type, httpStatus) {
                toast(err.responseJSON.message, 'error');
            });
    }

    // make me a post btn
    $(document).on("click","#saveChangeButton",function () {
        let value = $('#contentGenerator').html(); 
        value = value.replace(/<br\s*\/?>/gi, "\n");
        value = value.replace(/<\/?[^>]+(>|$)/g, "");
        $(".create-post-input").val(value);
        $('#generateContentFromSidebar').offcanvas('hide');
    });

    // select-all-checker
    $(document).on('change', '#select-all-checker', function() {
        $('.platform_account_ids').prop('checked', $(this).is(':checked'));
    });

    // schedule picker
     $(".schedule-picker").flatpickr({
        enableTime: true,
        wrap: true
    });

    // schedule-picker-input
    $(document).on('change', '.schedule-picker-input', function() {
        let value = $(this).val();
        if(value != ''){
            $('.date-picker-clear-btn').removeClass('d-none');
            $('.schedule-picker-input').removeClass('visually-hidden');
        }else   {
            $('.date-picker-clear-btn').addClass('d-none');
            $('.schedule-picker-input').addClass('visually-hidden');
        }
    });
 
    // createPostForm
    $(document).on('submit', '#createPostForm', function(e) {
        e.preventDefault(); 
        // Check if platform_account_ids are selected
        if ($('.platform_account_ids:checked').length === 0) {
            toast('{{ localize('Please select at least one platform account.') }}', "error");
            return;
        }
        
        loading('#publishNowBtn', '{{ localize('Posting') }}..');
        let callParams = {};
        callParams.type = "POST";
        callParams.url  = $(this).attr("action");
        callParams.data = $("#createPostForm").serialize(); 
        
        ajaxCall(callParams, function(response) {
            resetLoading('#publishNowBtn', '{{ localize('Post') }}');
            resetForm('form#createPostForm');
            toast(response.message); 
        },
        function(err, type, httpStatus) {
            showFormError(err, "#createPostForm");
            resetLoading('#publishNowBtn', '{{ localize('Post') }}');
            const errorMsg = err?.responseJSON?.message;
            toast(errorMsg, "error");
        }
        );
    });
</script>
