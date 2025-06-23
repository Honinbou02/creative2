<script>
    'use strict';

    // load templates
    function getDataList() {
        var callParams      = {};
        callParams.type     = "GET";
        callParams.dataType = "html";
        callParams.url      = "{{ route('admin.templates.index') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data     = '';
        
        loadingInContent('#renderTemplate', 'loading...');

        ajaxCall(callParams, function(result) {
            $('#renderTemplate').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }

    // handle offcanvas for adding an template
    $('body').on('click', '#addFormSidebarForOffCanvas', function() {
        $('#addTemplateFrm .offcanvas-title').text("{{ localize('Add New Template') }}");
        resetFormErrors('form#addTemplateFrm');
        resetForm('form#addTemplateFrm');
        $("#defaultField").removeClass('d-none');
        $('#input-type-append').html('');
        $('.input_names_prompts').html('');
        $('form#addTemplateFrm input:hidden[name=_method]').val('POST');
        $('form#addTemplateFrm').attr('action', "{{ route('admin.templates.store') }}");
    })

    // search
    $('body').on('click', '#searchBtn', function() {
        var search = $('#f_search').val();
        var is_active = $('#f_is_active :selected').val();

        gFilterObj.search = search;
        loadingInContent('#renderTemplate', 'loading...');

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

    $('body').on('click', '.getTemplates', function() {
        var search = $('#f_search').val();
        var template_category_id = $(this).data('id');
        var is_active = $('#f_is_active :selected').val();
        loadingInContent('#renderTemplate', 'loading...');
        gFilterObj.search = search;
        gFilterObj.template_category_id = template_category_id;

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

    // add template
    $("#addTemplateFrm").submit(function(e) {
        e.preventDefault();
        resetFormErrors('form#addTemplateFrm');
        loading('#addTemplateBtn', 'Saving...');

        let id = $("#addTemplateFrm #id").val();
        let formData = $('#addTemplateFrm').serialize();
        var callParams = {};
        callParams.type = "POST";
        callParams.url = $("form#addTemplateFrm").attr("action");
        callParams.data = formData;

        ajaxCall(callParams, function(result) {
            resetLoading('#addTemplateBtn', 'Save');
            showSuccess(result.message);
            if (!id) { // only for save
                resetForm('form#addTemplateFrm');
            }
            getDataList();
            id ? $('#addTemplateFormSidebar').offcanvas('hide') : '';
        }, function(err, type, httpStatus) {
            showFormError(err, '#addTemplateFrm');
            resetLoading('#addTemplateBtn', 'Save');
        });

        return false;
    });

    // edit template
    $('body').on('click', '.editIcon', function() {

        let tempateID = parseInt($(this).data("id"));
        let actionUrl = $(this).data("url");
        let updateURL = $(this).data("update-url");
        $('#addTemplateFrm .offcanvas-title').text("{{ localize('Edit Template') }}");
        $('#addTemplateFormSidebar').offcanvas('show');
        resetForm('form#addTemplateFrm');
        resetFormErrors('form#addTemplateFrm');
        $('form#addTemplateFrm').attr('action', updateURL);
        $('form#addTemplateFrm input:hidden[name=_method]').val('PUT');

        var callParams = {};
        callParams.type = "GET";
        callParams.url = actionUrl;
        callParams.data = "";
        loadingInContent('#loader', 'loading...');
        hideElement('.offcanvas-body');
        ajaxCall(callParams, function(result) {
            resetLoading('#loader', '');
            showElement('.offcanvas-body');
            if (result.data) {
                let data = result.data;
                $('#addTemplateFrm #id').val(data.id);
                $('#addTemplateFrm #template_name').val(data.template_name);
                $('#addTemplateFrm #icon').val(data.icon);
                $('#addTemplateFrm #description').val(data.description);
                $('#addTemplateFrm #template_category_id').val(data.template_category_id).change();
                $('#addTemplateFrm #prompt').val(data.prompt);
                $('#addTemplateFrm #chat_training_data').val(data.chat_training_data);
                $('#addTemplateFrm #is_active').val(data.is_active).change();
                if(result.optional != ''){
                    $("#defaultField").html('');
                    $('#input-type-append').html(result.optional.view);
                    $('#input-type-append').html(result.optional.view);
                    generateInputNames(true);
                }
            }
        }, function(err, type, httpStatus) {

        });

    });

    getDataList();


    // append data
    $('body').on('click', '#addMoreButton', function() {
        let length = $('#div_count').val();
        let divAppendData = `<div class="row g-2" id="${length}"><div class="col-6 col-md-3">
                        <div class="mb-3">
                            <x-form.label for="input_types" label="{{ localize('Input Type') }}" />
                            <x-form.select name="input_types[]" id="input_types">
                                @foreach (appStatic()::INPUT_TYPES as $value => $intputType)
                                    <option value="{{ $value }}">{{ $intputType }}</option>
                                @endforeach
                            </x-form.select>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="mb-3">
                            <x-form.label for="input_names" label="{{ localize('Input Name') }}" isRequired=true />
                            <x-form.input name="input_names[]" id="input_names" onchange="generateInputNames(true)" type="text" placeholder="{{ localize('Input Name') }}" value="" showDiv=false />
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="mb-3">
                            <x-form.label for="input_labels" label="{{ localize('Input Label') }}" isRequired=true />
                            <x-form.input name="input_labels[]" id="input_labels" type="text" placeholder="{{ localize('Input Label') }}" value="" showDiv=false />
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="mb-3 mt-4">
                            <label></label>
                            <button type="button" data-div_id="${length}" class="ms-1 btn btn-sm btn-soft-danger">
                                <i class="las la-times"></i>
                            </button>
                        </div>
                    </div>`;
        $('#input-type-append').append(divAppendData);

    })
    // remove
    $('body').on('click', '.btn-soft-danger', function() {
        $(this).parent().parent().parent().remove();
        $('textarea[name="prompt"]').val("");
        $('.input_names_prompts').empty();
        generateInputNames();
    })


    TT.inputNames = [];

    function generateInputNames(nullPompt = false) {

        TT.inputNames = [];

        $('input[name="input_names[]"]').each(function() {
            var $this = this;
            var value = $($this).val();
            value = value.toLowerCase().trim().replace(/[^\w\s-]/g, '').replace(/[\s_-]+/g, '-').replace(
                /^-+|-+$/g, '')
            TT.inputNames.push(value);
        })

        let html = '';
        TT.inputNames.forEach(name => {
            if (name != "") {
                var name2 = `"{_${name}_}"`;
                html += "<span class='badge bg-soft-primary cursor-pointer me-2' onclick='addToPrompt(" +
                    "" +
                    name2 + "" +
                    ")'>" + name + "</span>"
            }
        });
        $('.input_names_prompts').empty();
        $('.input_names_prompts').html(html);

        if (html != '') {
            $('.hint').removeClass('d-none')
        } else {
            $('.hint').addClass('d-none')
        }
    }

    // add text to prompt
    function addToPrompt(value) {
        var prompt = $('textarea[name="prompt"]').val() || '';
        $('textarea[name="prompt"]').val(prompt + value);
    }


    $("#templateContentGenerator").submit( function (e){
        e.preventDefault();

        let callParams = {};

        callParams.type = "POST";
        callParams.url  = $(this).attr("action");
        callParams.data = $("#templateContentGenerator").serialize()

        let streamingRoute = $(this).data("route");
        loading('#generateContent', 'Generating....')
        ajaxCall(callParams, function(response) {   
            resetLoading('#generateContent', 'Generate Content');
            if(response.response_code == 201) {
                $('#name').val("{{ localize('Untitled document - ') }} {{ date('Y-m-d-H-i') }}");
                $('#generated_id').val(response.data.id);
                eventSourceStreaming(streamingRoute);
                $('.tt-chat-header').removeClass('d-none');
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


    function eventSourceStreaming(streamingRoute) {
        /**
         * #################################
         * #    AI Writer EventSource Start     #
         * #################################
         * */

        let streamFormData = $("#templateContentGenerator").serialize();
        TT.eventSource = new EventSource(`${streamingRoute}?${streamFormData}`, {
            withCredentials: true
        });

        TT.eventSource.onmessage = function(e) {
            if (e.data.indexOf("[DONE]") !== -1) {
                $('#generateContent').prop('disabled', false);
                $('#stopGenerateContent').prop('disabled', true);
                $('#saveChangeButton').prop('disabled', false);
                TT.eventSource.close();
                updateBalance();
            } else {
                $('#stopGenerateContent').prop('disabled', false);
                let txt = undefined;
                try {
                    txt = JSON.parse(e.data).choices[0].delta.content;
                    
                    window.content_response = (window.content_response ?? "")+ txt;
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
             $('#generateContent').prop('disabled', false);
            console.log("Error is", TT.eventSource.readyState, "Error Message : ", e);
            toast("{{ session(sessionLab()::SESSION_OPEN_AI_ERROR) }}", 'error');
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

        /**
         * Stop Generate
        * */
        $(document).on("click","#stopGenerateContent",function (e) {
            e.preventDefault();
            if (TT.eventSource) {
                TT.eventSource.close();
            }

            
            $('#generateContent').prop('disabled', false);
            $('#stopGenerateContent').prop('disabled', true);

            updateUserBalanceAfterGenerateContent("{{ appStatic()::PURPOSE_TEMPLATE_CONTENT }}", "{{ templatesEngine() }}");

            balanceRender();
        });

    function updateBalance() {
        window.onMessageArrived = false;
        // Making content response as empty
        let purpose = "{{ appStatic()::PURPOSE_TEMPLATE_CONTENT }}";

        // Update Balance Ajax Request
        updateUserBalanceAfterGenerateContent(purpose, "{{ templatesEngine() }}");

        balanceRender();
    }

    var sliderSelector = ".custom-swiper",
        defaultOptions = {
        breakpointsInverse: true,
        observer: true,
        };

    $(document).ready(function () {
        var jSlider = $(sliderSelector);

        jSlider.each(function (i, slider) {
        var data = $(slider).attr("data-swiper") || {};

        if (data) {
            var dataOptions = JSON.parse(data);
        }

        slider.options = $.extend({}, defaultOptions, dataOptions);

        var swiper = new Swiper(slider, slider.options);

        /* stop on hover */
        if (typeof slider.options.autoplay !== "undefined") {
            $(slider).hover(
            function () {
                swiper.autoplay.stop();
            },
            function () {
                swiper.autoplay.start();
            }
            );
        }

        /* stop on hover */
        if (
            typeof slider.options.autoplay !== "undefined" &&
            slider.options.autoplay !== false
        ) {
            slider.addEventListener("mouseenter", function () {
            swiper.autoplay.stop();
            });

            slider.addEventListener("mouseleave", function () {
            swiper.autoplay.start();
            });
        }
        });
    });

    $(document).on('click', '.swiper-slide', function() {
        // Remove the 'swiper-slide-active' class from all slides
        $('.swiper-slide').removeClass('swiper-slide-active');
        
        // Add the 'swiper-slide-active' class to the clicked slide
        $(this).addClass('swiper-slide-active');
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

    $(document).on('click', '.downloadChatBtn', function(e){
        let type = $(this).data('download_type');
        let id   = $('#generated_id').val();
        let data = {type:type, id:id};
        let url  =  `{{ route('admin.download-content') }}?id=${id}&type=${type}`;
        window.open(url, '_blank'); // Open URL in a new tab
    })
    $(document).on("click", ".saveChange", function(e) {
        e.preventDefault();
        let callParams = {};
        let id = $('#generated_id').val();

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
</script>
