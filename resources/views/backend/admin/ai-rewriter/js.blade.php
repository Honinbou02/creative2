<script>
    'use strict';
    var geminiAi = "{{isGeminiAi(aiRewriterEngine())}}"
    // // load users
    function getDataList() {
        var callParams = {};
        callParams.type = "GET";
        callParams.dataType = "html";
        callParams.url = "{{ route('admin.ai-rewriter.index') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data = '';
        ajaxCall(callParams, function(result) {
            $('tbody').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }

    // // search
    $('body').on('click', '#searchBtn', function() {
        var search = $('#f_search').val();
        var user_type = $('#f_user_type :selected').val();
        var is_active = $('#f_is_active :selected').val();
        loadingInTable("tbody", {
            colSpan: 11,
            prop: false,
        });
        gFilterObj.search = search;
        gFilterObj.user_type = user_type;

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

    $("#aiReWriterForm").submit(function(e) {
        e.preventDefault();

        initScrollToChatBottom();

        let formData = $('#aiReWriterForm').serialize();


        // return;
        let callParams = {};
        callParams.url = "{{ route('admin.ai-writer.store') }}";
        callParams.type = "POST";

        callParams.data = formData;
        loading('#generateContent', 'Generating....')
        ajaxCall(callParams, function(response) {
            resetLoading('#generateContent', 'Generate Content');
            if(response.response_code == 201) {
             
                $('#name').val(response.optional.model.title);
                $('#writter_id').val(response.optional.model.id);
                initScrollToChatBottom();
    
                // Event Source Streaming
                eventSourceStreaming();
                balanceRender();
            }else {
                 response.message ? toast(response.message, 'error') : '';
            }

            $('.tt-chat-header').removeClass('d-none');
        }, function(XHR, textStatus, errorThrown) {
            resetLoading('#generateContent', 'Generate Content');
            showFormError(XHR, '#aiReWriterForm');
            if(!empty(XHR.responseJSON.message)) {

                toast(XHR.responseJSON.message, 'error');
            }

        });

    }); // AI Writer Form Submit Closing

    function eventSourceStreaming() {
        /**
         * #################################
         * #    AI Writer EventSource Start     #
         * #################################
         * */

        let streamFormData = $("#aiReWriterForm").serialize();
        const URL_CHAT = "{{ route('admin.ai-writer.generate') }}";

        TT.eventSource = new EventSource(`${URL_CHAT}?${streamFormData}`, {
            withCredentials: true
        });

        TT.eventSource.onmessage = function(e) {

            if (e.data.indexOf("[DONE]") !== -1) {
                $('#generateContent').prop('disabled', false);
                $('#stopGenerateContent').prop('disabled', true);
                $('#saveChangeBtn').prop('disabled', false);
                TT.eventSource.close();
                updateBalance();
               
            } else {
                $('#stopGenerateContent').prop('disabled', false);
                let txt = undefined;
                try {
                    txt = geminiAi ? e.data : JSON.parse(e.data).choices[0].delta.content;
                    window.content_response = window.content_response + " " + txt;

                    if (txt !== undefined) {
                        let finalText = formatText(window.content_response);                    
                        $(".note-editable").html(finalText);
                    }
                } catch (e) {
                    console.log('error ', e);
                }
            }

        };

        TT.eventSource.onerror = function(e) {
            updateBalance();
            let message = "{{ session(sessionLab()::SESSION_OPEN_AI_ERROR) }}";
            
            message ?  toast("{{ session(sessionLab()::SESSION_OPEN_AI_ERROR) }}", 'error') : '';
            $('#generateContent').prop('disabled', false);
            TT.eventSource.close();
        };

        $("#generateContent").prop('disabled', true);
        $("#stopGenerateContent").prop('disabled', true);

        /**
         * #################################
         * #     Chat EventSource End      #
         * #################################
         * */
    }

    function emptyContentResponse() {
        window.content_response = "";
    }

    function updateBalance() {
        window.onMessageArrived = false;
        // Making content response as empty
        emptyContentResponse();

        // Update Balance Ajax Request
        updateUserBalanceAfterGenerateContent("{{ appStatic()::PURPOSE_GENERATE_TEXT }}", "{{ aiRewriterEngine() }}");
    }

    $(document).on("click", "#stopGenerateContent", (e) => {
        e.preventDefault();
            if (TT.eventSource) {
                TT.eventSource.close();
            }

        updateUserBalanceAfterGenerateContent("{{ appStatic()::PURPOSE_GENERATE_TEXT }}", "{{ aiRewriterEngine() }}");
    });

    $(document).on("click", ".saveChange", function(e) {
        e.preventDefault();
        let callParams = {};
        let id = $('#writter_id').val();

        let formData = {
            id: id,
            name: $('#name').val(),
            content: $('.note-editable').text()
        }
        callParams.type = "POST";
        callParams.url = "{{ route('admin.ai-writer.save-change') }}";
        callParams.data = formData;

        ajaxCall(callParams, function(result) {
            toast(result.message)

        }, function(err, type, httpStatus) {
            console.log(err);
        });

        return false;
    });
    getDataList();

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

    $(document).on('click', '.downloadChatBtn', function(e){
        let type = $(this).data('download_type');
        let id   = $('#writter_id').val();
        let data = {type:type, id:id};
        window.location.href =  `{{ route('admin.download-content') }}?id=${id}&type=${type}`;
    })

    // $("#contentGeneratorAiReWrite").summernote({
    //     height: "100%",
    // });


    var myEditor = $('#contentGeneratorAiReWrite');
    $(myEditor).summernote({
        height: 420,
        fontSizes: ['8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '36', '48' , '64'],
        toolbar: [
            ["font", ["bold", "underline", "italic", "clear"]],
            ['fontname', ['fontname']],
            ["para", ["ul", "ol", "paragraph"]],
            ["style", ["style"]],
            ['fontsize', ['fontsize']],
            ["view", ["undo", "redo"]],
        ],
        callbacks: {
            onInit: function() {

                let customDropdown = `<div class="note-btn-group note-view">
                    <select class="form-select px-3 py-1 rounded-pill dChange cursor-pointer" aria-label="Default select example">
                        <option value="">{{ localize('Select Rewrite Type') }}</option>
                    @foreach (appStatic()::REWRITE_TYPES as $key=>$type)
                        <option value="{{ $key }}">{{ ucfirst(str_replace('_', ' ', $type)) }}</option>
                    @endforeach
                </select></div>`;

                $(customDropdown).appendTo($('.note-toolbar'));
            }
        }
    });

    $(document).on("change", ".dChange", function(e) {
        var range = $(".editor").summernote('createRange');
        let type = $(this).val();
        let txt = $(".note-editable").text();

        aiRewriterAssigntent(type, txt, range)
    });

    function aiRewriterAssigntent(type, text, range) {

        let language = $('#language').val();
        if(!text) {
            toast('Please provide the text', "error");

            return;
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            method: 'POST',
            url: '{{ route('admin.ai-rewriter.rewrite') }}',
            dataType: "json",
            data: {
                type: type,
                text: text,
                language: language
            },
            beforeSend: function() {
                toast('Please wait. Content Generating..', "warning");
            },
            success: function(response) {

                if (response.status == true) {
                    toast( '{{ localize('Generate Successfully, dont forget to save') }}', "success");

                    $(".note-editable").html(response.data.response);
                } else {
                    if (response.message) {
                        toast(response.message, "success");
                    } else {
                        toast('{{ localize('Something went wrong') }}', "error");
                    }
                }
            },
            error: function(xhr) {
                let data       = xhr.responseText;
                let parseError = JSON.parse(data);

                toast(parseError.message, "error");
            }
        })
    }

</script>
