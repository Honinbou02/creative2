 <script>
    "use strict";

    window.chat_expert_id = "{{ @$chat_expert_id }}";
    window.chat_thread_id = "{{ @$chat_thread_id }}";
    window.content_purpose = "{{ @$content_purpose }}";
    window.content_response = "";
    window.render_type = "";
    window.onMessageArrived = false;
    window.user_id = "{{ userID() }}";
    var geminiAi = "{{isGeminiAi(aiChatEngine())}}"
    var claudeAi = "{{isClaudeAi(aiChatEngine())}}"
    var deepseekAi = "{{isDeepseekAi(aiChatEngine())}}"
    /**
     * Pick Expert from Dropdown.
     * */
    $(document).on("click", ".pickExpert", function() {
        let name           = $(this).data("name");
        let id             = $(this).data("id");
        let img            = $(this).data("img");
        let short_name     = $(this).data("short_name");
        let user_id        = window.user_id;
        
        $(".chatExpertId").val(id);

        window.chat_expert_id = id;
        window.chat_thread_id = null;

        let activeExpertHtml = `<div class="tt-experties d-flex align-items-center me-2">
            <div class="avatar avatar-md flex-shrink-0">
                <img class="rounded-circle"
                     loading="lazy"
                     src="${img}"
                     alt="avatar"
                />
            </div>
            <div class="ms-2 text-start d-none d-md-block">
                <h6 class="mb-0 lh-1">${name}</h6>
                <span class="text-muted fs-sm">${short_name}</span>
            </div>
        </div>
        <span class="material-symbols-rounded fs-20">
          unfold_more
        </span>`;

        $(".activeExpert").html(activeExpertHtml);
        window.render_type    = 'threads';

        chatBodyWrap.html(loaderHTML());

        /**
         * Load Chat Threads based on expert
         * */
        loadChats()
    });

    function loadChats() {
        let chat_expert_id  = window.chat_expert_id;
        let chat_thread_id  = window.chat_thread_id;
        let content_purpose = window.content_purpose;
        let user_id         = window.user_id;
        let render_type     = window.render_type;

        let callParams = {};
        if (content_purpose == 'chat') {
            callParams.url = `{{ route('admin.chats.index') }}?chat_expert_id=${chat_expert_id}&user_id=${user_id}&chat_thread_id=${chat_thread_id}&type=${content_purpose}&render_type=${render_type}`;
        }else if(content_purpose == 'aiImage'){
            callParams.url = `{{ route('admin.chats.aiImageChat') }}?chat_expert_id=${chat_expert_id}&user_id=${user_id}&chat_thread_id=${chat_thread_id}&type=${content_purpose}&render_type=${render_type}`;
        } else if (content_purpose == 'vision') {
            callParams.url = `{{ route('admin.chats.aiVisionChat') }}?user_id=${user_id}&chat_thread_id=${chat_thread_id}&type=${content_purpose}&render_type=${render_type}`;
        } else if (content_purpose == 'pdf') {
            callParams.url = `{{ route('admin.chats.aiPDFChat') }}?chat_expert_id=${chat_expert_id}&user_id=${user_id}&chat_thread_id=${chat_thread_id}&type=${content_purpose}&render_type=${render_type}`;
        } else {
            callParams.url = `{{ route('admin.chats.index') }}?chat_expert_id=${chat_expert_id}&user_id=${user_id}&chat_thread_id=${chat_thread_id}&type=${content_purpose}&render_type=${render_type}`;
        }

        callParams.type = "GET";

        ajaxCall(
            callParams,
            function(response) {
                // Threads
                if(response.data) {
                    $(".chatThreadsList").html(response.data);
                }

                // Chats
                chatBodyWrap.html(response.optional.messages);
                
                window.chat_thread_id = response.optional.chat_thread_id;
                $(".chatThreadId").val(window.chat_thread_id);

                initScrollToChatBottom();
                feather.replace();
            }, // Success Block
            function(XHR, textStatus, errorThrown) {

            } // Error Function Block
        );
    }

    $(document).on("click", ".deleteChatThread", function(e) {
        e.preventDefault();

        // reset id to load the latest thread and chats
        window.chat_thread_id = null;
        window.render_type    = 'threads';
        deleteData($(this), loadChats);
    });


    let currentRouteName        = "{{ currentRoute() }}";
    let avoidChatExpertIdRoutes = @json(conditionAvoidRouteForValidation());

    let avoidChatExpertId = false;


    /**
     * New Conversation
     * */
    $(document).on("click", ".newConversation", function() {
        let callParams = {};

        loading(".newConversation", "{{ localize('Creating...') }} <i data-feather='plus' class='icon-14 ms-1'></i>");
        feather.replace();

        callParams.url  = "{{ route('admin.chats.store') }}";
        callParams.type = "POST";

        let chat_expert_id  = window.chat_expert_id;
        let content_purpose = window.content_purpose;


        if (!avoidChatExpertId && !chat_expert_id) {
            toast('{{ localize('Please select Chat Expert') }}', 'error');
            return;
        }

        let formData = new FormData();

        formData.append("chat_expert_id", chat_expert_id);
        formData.append("content_purpose", content_purpose);
        formData.append("_token", $("meta[name='csrf-token']").attr("content"));

        callParams.data         = formData;
        callParams.processData  = false;
        callParams.contentType  = false;
        emptySearchThread();
        ajaxCall(callParams, function(response) {
                resetLoading(".newConversation", "{{ localize('New Conversation') }} <i data-feather='plus' class='icon-14 ms-1'></i>");
                addChatThread(response.data);
                feather.replace();
            },
            function(XHR, textStatus, errorThrown) {
                resetLoading(".newConversation", "{{ localize('New Conversation') }} <i data-feather='plus' class='icon-14 ms-1'></i>");
                toast(XHR.responseJSON.message, 'error');
                feather.replace();
            }
        );
    })

    // LI Html Adding at left sidebar
    function addChatThread(chatThread) {

        $(".chatThreadId").val(chatThread.id);

        let chatThreadLi = `<li class="d-flex align-items-center justify-content-between" data-chat_thread_id="${chatThread.id}">
                    <a href="#" class="chatThreadLi" data-chat_thread_id="${chatThread.id}">
                        <span>
                          <p class="mb-0">${chatThread.title }</p>
                          <small class="text-muted">${ chatThread.created_at }</small>
                        </span>
                    </a>
                    <div class="dropdown tt-tb-dropdown">
                        <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i data-feather="more-vertical" class="ms-1 fs-sm"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end shadow">
                            <a class="dropdown-item" href="javascript:void(0);">
                                <i data-feather="edit-3" class="me-2"></i>Edit
                            </a>
                            <a class="dropdown-item" href="javascript:void(0);">
                                <i data-feather="trash" class="me-2"></i>Delete
                            </a>
                           
                        </div>
                    </div>
                </li>`;


        $(".chatThreadsList").prepend(chatThreadLi);

        feather.replace();
        window.chat_thread_id = chatThread.id;
        window.render_type    = 'threads';
        $(".chatThreadLi").removeClass("active");
        $(".chatThreadLi li").removeClass("active");
        $(this).addClass("active");
        loadChats();

    }


    /**
     * Chat Starts
     * */

    let chatBodyWrap = $("#chatBodyWrap");
    $(() => {
        initScrollToChatBottom();
        isRouteExists();

        window.chat_thread_id = $(".chatThreadLi").attr("data-chat_thread_id");

        $(".chatThreadId").val(window.chat_thread_id);
        loadChats();
    });

    function isRouteExists(){
        avoidChatExpertIdRoutes.forEach(function (route, index){
            if(currentRouteName == route){
                avoidChatExpertId = true;
                return avoidChatExpertId;
            }
        });

        return avoidChatExpertId;
    }

    $("#chat_form").submit(function(e) {
        e.preventDefault();
        let chat_expert_id = window.chat_expert_id;
        if (!avoidChatExpertId && !chat_expert_id) {
            toast('{{ localize('Please select Chat Expert') }}', 'error');
            return;
        }
        

        let formData = new FormData($("#chat_form")[0]);

        let avatarPath = "{{ avatarImage(user()->avatar) }}";
        let prompt = $("textarea[name='message']").val();        
        
        if (!prompt) {
            toast('{{ localize('Please enter the message') }}', 'error');
            return;
        }
        
        loading(".msgSendBtn", "{{ localize('Sending...') }} <i data-feather='send' class='icon-14 ms-1'></i>");
        feather.replace();
        
        let myMsg = addMyChatMessage(prompt, avatarPath);
        
        chatBodyWrap.append(myMsg);
        chatBodyWrap.append(loaderHTML());
        initScrollToChatBottom();
        
        let callParams = {};
        callParams.url = "{{ currentRoute() === 'admin.chats.aiPDFChat' ? route('admin.chats.pdfChatEmbedding') : route('admin.chats.chatThreadConversation') }}";
        callParams.type = "POST";

        callParams.data = formData;

        callParams.complete = function() {
            $("textarea[name='message']").val(null);
            $('.tt-vision-thumb').html('');
        }

        callParams.processData  = false;
        callParams.contentType  = false;

        ajaxCall(callParams, function(response) {
            resetLoading(".msgSendBtn", "{{ localize('Send') }} <i data-feather='send' class='icon-14 ms-1'></i>");
            removeLoader();
            
            if(response.response_code==400) {
                toast(response.message, 'error');
            }
            
            chatBodyWrap.append(loaderHTML());
            
            initScrollToChatBottom();
            
            if(window.content_purpose == 'aiImage') {
                generateImage();
            }else{
                // Event Source Streaming
                eventSourceStreaming();
            }
            balanceRender();
            feather.replace();
        }, function(XHR, textStatus, errorThrown) {
            resetLoading(".msgSendBtn", "{{ localize('Send') }} <i data-feather='send' class='icon-14 ms-1'></i>");
            removeLoader();
            let errorResponse = JSON.parse(XHR.responseText);
            
            for (let key in errorResponse.errors) {
                if (errorResponse.errors.hasOwnProperty(key)) {
                    toast(errorResponse.errors[key], 'error');
                }
            }
            feather.replace();
            // toast(XHR.responseJSON.message, 'error');
        });
        //  
    }); // Chat Form Submit Closing

    function generateImage() {
        /**
         * #################################
         * #   image Chat  Start     #
         * #################################
         * */

        let formData = $("#chat_form").serialize();
    
        let callParams = {};
        callParams.url = "{{ route('admin.chats.conversation') }}";
        callParams.type = "GET";
        callParams.data = formData;
        ajaxCall(callParams, function(response) {

            window.onMessageArrived = true;

            appendExpertBody();

            let image = `<img src="${response.file_path}"  width="256" loading="lazy" alt="${response.file_path}">
            <div class="tt-overly-icon pt-3 d-flex justify-content-between">
                        <a href="#imageView" data-title="${response.title}"
                            data-image-url="${response.file_path}"
                            class="overly-btn overly-view imgViewModal" data-bs-toggle="modal"
                            data-bs-target="#imageView">
                            <span><i data-feather="eye" class="icon-14"></i></span>
                        </a>
                        <a href="${response.file_path}" download=""
                            class="overly-btn overly-download">
                            <span><i data-feather="download" class="icon-14"></i></span>
                        </a>

                    </div>
            
            `;

            $(".aiResponseBox:last").append(image);
            feather.replace();    

        }, function(XHR, textStatus, errorThrown) {
            console.log("Error Response : ", XHR.responseText);
        },2000000);

        // Call Ajax Request
        // updateBalance();
        $(".msgStopBtn").prop('disabled', false);

        /**
         * #################################
         * #    Image Chat  End      #
         * #################################
         * */
    }

    function eventSourceStreaming() {
        /**
         * #################################
         * #    Chat EventSource Start     #
         * #################################
         * */

            let streamFormData = $("#chat_form").serialize();
            let real_time_data = ($('#realTimeData').is(":checked")) ? true :false;

            streamFormData +="&real_time_data=" + real_time_data

            const URL_CHAT      = "{{ route('admin.chats.conversation') }}";
            const CURRENT_ROUTE = "{{ currentRoute() }}";

            TT.eventSource = new EventSource(`${URL_CHAT}?sourceRoute=${CURRENT_ROUTE}&${streamFormData}`, {
                withCredentials: true
            });

            // On Message
            TT.eventSource.onmessage = function(e) {
                initScrollToChatBottom();
                if (!window.onMessageArrived) {
                    window.onMessageArrived = true;
                    appendExpertBody();
                }

                if (e.data.indexOf("[DONE]") !== -1) {
                    updateBalance();

                    $('.msgSendBtn').prop('disabled', false);
                    $('.msgStopBtn').prop('disabled', true);
                    TT.eventSource.close();
                }
                else {
                    $('.msgStopBtn').prop('disabled', false);
                    let txt = undefined;
                    try {
                        txt = JSON.parse(e.data).choices[0].delta.content;
                        window.content_response = (window.content_response ?? "") + txt;

                        if (txt !== undefined) {
                            let finalText = convertToHtml(window.content_response);
                            let copyBtn = `<button type="button" class="border-0 btn btn-icon btn-soft-primary rounded-circle txt-copy-btn d-none shadow-sm copyChat" data-type="single">
                            <span data-feather="copy"></span>
                        </button>`;
                            $(".aiResponseBox:last").html(finalText);
                            $(".aiResponseBox:last").append(copyBtn);
                            feather.replace();
                        }
                    }
                    catch (e) {
                        $('.msgSendBtn').prop('disabled', false);
                        $('.msgStopBtn').prop('disabled', true);
                    }
                }

                initScrollToChatBottom();
            };

            // On Error
            TT.eventSource.onerror = function(e) {
                updateBalance();

                console.log("Error is", TT.eventSource.readyState, "Error Message : ",e , "Error Data : ", e.data);

                // Check the readyState to confirm if the connection was closed
                if (TT.eventSource.readyState === EventSource.CLOSED) {
                    console.log("Connection closed.");
                }
                else {
                    // If it's an error event, parse and handle the error
                    try {
                        // Try parsing the error response from e.data
                        const errorData = JSON.parse(e.data);
                        console.error("Error Message: ", errorData.message);
                        console.error("Details: ", errorData.errors);
                    } catch (error) {
                        console.error("Error parsing data: ", e.data);
                    }
                }

                TT.eventSource.close(); // Close the connection

                $('.msgSendBtn').prop('disabled', false);
                $('.msgStopBtn').prop('disabled', true);
            };

            // Call Ajax Request
            $(".msgSendBtn").prop('disabled', true);
            $(".msgStopBtn").prop('disabled', true);

        /**
         * #################################
         * #     Chat EventSource End      #
         * #################################
         * */
    }

    function appendExpertBody() {
        if (window.onMessageArrived) {
            removeLoader();

            // Append Expert Body
            chatBodyWrap.append(expertBody());
        }
    }

    function removeLoader() {
        chatBodyWrap.find(".chatLoader").remove();
    }

    function emptyContentResponse() {
        window.content_response = "";
    }

    function updateBalance() {
        window.onMessageArrived = false;
        // Making content response as empty
        emptyContentResponse();
        removeLoader();

        // Update Balance Ajax Request
        if(geminiAi || claudeAi || deepseekAi){
            updateUserBalanceAfterGenerateContent(window.content_purpose, "{{ aiChatEngine() }}");
        }else {
            updateUserBalanceAfterGenerateContent(window.content_purpose, "{{ appStatic()::ENGINE_OPEN_AI }}");
        }
    }

    $(document).on("click", ".msgStopBtn", () => {
        updateBalance();
    });

    /**
     * Chat Thread
     *
     * Load the chats based on Chat Thread & Expert.
     * */
    $(document).on("click", ".chatThreadLi", function(e) {
        if($(this).attr('contenteditable') === "true"){
            return;
        }
        let chat_thread_id = $(this).data("chat_thread_id");
        let chat_expert_id = window.chat_expert_id;
        
        if (!avoidChatExpertId && !chat_expert_id) {
            toast('{{ localize('Please select Chat Expert') }}', 'error');
            return;
        }

        $(".chatThreadId").val(chat_thread_id);

        window.chat_thread_id = chat_thread_id;
        window.render_type    = false;

        // remove prev active class
        $(".chatThreadLi").removeClass("active");
        $(".chatThreadsList li").removeClass("active");
        //Add new active class
        $(this).closest('li').addClass('active');
        $(this).addClass("active");


        // Add Loader
        chatBodyWrap.html(loaderHTML());

        loadChats();
    });

    $(document).on("click", ".imgViewModal", function(e) {
        let title = $(this).data("title");
        let imageUrl = $(this).data("image-url");
        $("#modalTitle").text(title);
        $("#modalImg").attr("src", imageUrl);
    })
    $(document).on('click', '.downloadChatBtn', function(e) {
        let type           = $(this).data('download_type');
        let chat_expert_id = window.chat_expert_id;
        let chat_thread_id = window.chat_thread_id;
        let data           = {type: type, chat_expert_id: chat_expert_id, chat_thread_id: chat_thread_id};
        let url            = `{{ route('admin.chat.download') }}?chat_expert_id=${chat_expert_id}&type=${type}&chat_thread_id=${chat_thread_id}`;

        window.open(url, '_blank'); // Open URL in a new tab
    });

    $(document).on('click', '.copyChat', function(e){
        let type        = $(this).data('type');
        if(type != 'single') {
            downloadChatHistory('copyChat');
            return;
        }
        let textToCopy  =  type == 'single' ? $(this).closest('.aiResponseBox').text() : $('#chatBodyWrap').text();
        let copyText = clearFormatData(textToCopy);

        if (navigator.clipboard && navigator.clipboard.writeText) {
            // Use the Clipboard API if available
            navigator.clipboard.writeText(copyText).then(function() {
                alert('Text copied to clipboard!');
            }).catch(function(err) {
                console.error('Failed to copy text: ', err);
            });
        } else {
            // Fallback for older browsers
            let tempTextarea = $('<textarea>');
            tempTextarea.val(copyText).appendTo('body').select();

            try {
                document.execCommand('copy');
            } catch (err) {
                console.error('Fallback failed to copy text: ', err);
            }

            tempTextarea.remove();
        }
        toast('{{ localize('Content has been copied successfully') }}');
    })

    $(document).on('click', '.shareChat', function(e){
        let type           = 'pdf';
        let chat_expert_id = window.chat_expert_id;
        let chat_thread_id = window.chat_thread_id;
        let data           = {type: type, chat_expert_id: chat_expert_id, chat_thread_id: chat_thread_id};
        let url            = `{{ route('chat.share') }}?chat_expert_id=${chat_expert_id}&type=pdf&chat_thread_id=${chat_thread_id}&share=true`;
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(url).then(function() {
                toast('{{ localize('URL has been copied to clipboard successfully') }}');
            }).catch(function(err) {
                console.error('Failed to copy URL: ', err);
                toast('{{ localize('Failed to copy URL') }}', 'error');
            });
        } else {
            let tempTextarea = document.createElement('textarea');
            tempTextarea.value = url;
            document.body.appendChild(tempTextarea);
            tempTextarea.select();
            try {
                document.execCommand('copy');
                toast('{{ localize('URL has been copied to clipboard successfully to share') }}');
            } catch (err) {
                console.error('Fallback failed to copy URL: ', err);
                toast('{{ localize('Failed to copy URL') }}', 'error');
            }
            document.body.removeChild(tempTextarea);
        }
    })


    $(document).on('click', '.deleteConversation', function(e){
        let chat_expert_id = window.chat_expert_id;
        let chat_thread_id = window.chat_thread_id;
        $('#delete_chat_expert_id').val(chat_expert_id);
        $('#delete_chat_thread_id').val(chat_thread_id);
    })
    $(document).on('click', '.tt_editable', function(e) {  
        e.preventDefault();
        var parentLi    = $(this).closest('li');
        var $updateText = parentLi.find('.tt_update_text');
        $updateText.attr('contenteditable', 'true').focus();    
    });
    $(document).on('focusout', '.tt_update_text', function(e) {
        e.preventDefault();
      
        var $this          = this;
       
        let chat_thread_id = $(this).data('id');      
        let title          = $('#tt_update_text_'+chat_thread_id).text();
        let _token         = "{{ csrf_token() }}";

        let callParams    = {};
        callParams.type   = "POST";
        callParams.url    = "{{route('admin.chat-thread.update')}}";
        callParams._token = _token;
        callParams.data   = {
            chat_thread_id: chat_thread_id,
            _token        : _token,
            title         : title
        };
        ajaxCall(callParams,
            function (result) {
               
            },
            function (err, type, httpStatus) {
               
            }
        );   
    });

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

    $(document).on('keyup', '.searchThread', function(e){
      
        var query       = this.value.toLowerCase(); 
        var chatThreads = document.querySelectorAll('.tt-chat-history-list li'); 
        var found       = false;
        
        chatThreads.forEach(function(thread) {
            var titleElement = thread.querySelector('.tt_update_text'); 
            var titleText    = titleElement.innerText.toLowerCase();
            var originalText = titleElement.innerText; 
            if (titleText.indexOf(query) > -1) {
                thread.classList.remove('d-none'); 
                found = true;
                var startIndex = titleText.indexOf(query); 
                var highlightedText = originalText.substring(startIndex, startIndex + query.length);               
                titleElement.innerHTML = originalText.substring(0, startIndex) +
                    '<span class="highlight">' + highlightedText + '</span>' +
                    originalText.substring(startIndex + query.length);
            } else {
                thread.classList.add('d-none'); 
            }
        });
        if (!found) {
            $('#notFoundMessage').removeClass('d-none');
        } else {
            $('#notFoundMessage').addClass('d-none');
        }
    })
    function emptySearchThread()
    {
        $('.searchThread').val('');
    }
    $("#addSendMailForm").submit(function(e) {
        e.preventDefault();
        resetFormErrors('form#addSendMailForm');
        loading('#frmActionBtn', 'Sending...');

        $('#email_chat_expert_id').val(window.chat_expert_id);
        $('#email_chat_thread_id').val(window.chat_thread_id);

        let callParams = {};

        callParams.type = "POST";
        callParams.url = $("form#addSendMailForm").attr("action");
        callParams.data = $("form#addSendMailForm").serialize();

        ajaxCall(callParams, function(result) {
            resetLoading('#frmActionBtn', 'Send');
            toast(result.message)
            $('#addSendMailSidebar').offcanvas('hide');
        }, function(err, type, httpStatus) {
            showFormError(err, '#addSendMailForm');
            resetLoading('#frmActionBtn', 'Send');
        });

        return false;
    });
    function downloadChatHistory(dtype = 'html') {

      
        let chat_expert_id  = window.chat_expert_id;
        let chat_thread_id  = window.chat_thread_id;
      
        var callParams      = {};
        callParams.type     = "GET";
        callParams.dataType = "html";
        callParams.url      = `{{ route('admin.chat.download') }}?chat_expert_id=${chat_expert_id}&type=${dtype}&chat_thread_id=${chat_thread_id}`;
        callParams.data     = {type: dtype, chat_expert_id: chat_expert_id, chat_thread_id: chat_thread_id};
        ajaxCall(callParams, function(result) {
                var html = $('#downloadChat').html(result);
                let copyText = $("#downloadChat").html();
                copyText = clearFormatData(copyText);
                
                if (navigator.clipboard && navigator.clipboard.writeText) {
                // Use the Clipboard API if available
                navigator.clipboard.writeText(copyText).then(function() {
                    }).catch(function(err) {
                        console.error('Failed to copy text: ', err);
                    });
                } else {
                    // Fallback for older browsers
                    let tempTextarea = $('<textarea>');
                    tempTextarea.val(copyText).appendTo('body').select();

                    try {
                        document.execCommand('copy');
                    } catch (err) {
                        console.error('Fallback failed to copy text: ', err);
                    }

                    tempTextarea.remove();
                }
                toast('{{ localize('Content has been copied successfully') }}');
        }, function onErrorData(err, type, httpStatus) {});

    }
    $('body').on('click', '.promptGroup', function() {
        var id = $(this).data('id');
        $('#allPrm').addClass('active show');
        loadingInContent('#renderTemplate', 'loading...');
        gFilterObj.id = id;
        getPrmot();
    });


    $('body').on('click', '.promptBtn', function() {
            let prompt = $(this).data('prompt');
            alert(prompt);
            $('#textarea-input').val(prompt);
            $('#promptModal').modal('hide');
    });

    function getPrmot()
    {
        var callParams      = {};
        callParams.type     = "GET";
        callParams.dataType = "html";
        callParams.url      = "{{ route('admin.group-prompts') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data     = '';
        
        

        ajaxCall(callParams, function(result) {
            $('#renderPromptLibrary').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }
</script>
