<script>
    'use strict';

    // load text to speeches
    function getDataList() {
        var callParams      = {};
        callParams.type     = "GET";
        callParams.dataType = "html";
        callParams.url      = "{{ route('admin.text-to-speeches.index') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data     = '';
        loadingInTable("tbody",{
            colSpan: 11,
            prop: false,
        });
        ajaxCall(callParams, function(result) {
            $('tbody').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }

    getDataList();

    // search
    $('body').on('click', '#searchBtn', function() {
        var search = $('#f_search').val();
        var engine = $('#f_engine :selected').val();

        gFilterObj.search = search;
        gFilterObj.engine = engine;
        loadingInTable("tbody",{
            colSpan: 11,
            prop: false,
        });
        if (gFilterObj.hasOwnProperty('page')) {
            delete gFilterObj.page;
        }

        getDataList();
    });

    // append textarea and say as for azure
    $('body').on('click', '.azureAddMoreText', function() {

        let data = `<div class="speech mt-3">
                        <div class="col-12 mb-3">
                            <x-form.select class="form-select form-select-sm azure-say-as">
                                <option value="0" selected>{{ localize('say-as') }}</option>
                                <option value="currency">{{ localize('currency') }}</option>
                                <option value="telephone">{{ localize('telephone') }}</option>
                                <option value="verbatim">{{ localize('verbatim') }}</option>
                                <option value="date">{{ localize('date') }}</option>
                                <option value="characters">{{ localize('characters') }}</option>
                                <option value="cardinal">{{ localize('cardinal') }}</option>
                                <option value="ordinal">{{ localize('ordinal') }}</option>
                                <option value="fraction">{{ localize('fraction') }}</option>
                                <option value="bleep">{{ localize('bleep') }}</option>
                                <option value="unit">{{ localize('unit') }}</option>
                                <option value="unit">{{ localize('time') }}</option>
                            </x-form.select>
                            </div>
                        <div class="col-12">
                            <div class="position-relative z-1">
                                <x-form.textarea name="content[]" id="azureContent" row="5" cols="5" placeholder="" />
                                <x-form.button  type="button" class="btn bttn--icon btn--decrement border-danger w-5 h-5 rounded-circle lh-1 removeButton">
                                    <span class="material-symbols-rounded text-danger fs-18 lh-1">
                                close </span></x-form.button>
                            </div>
                        </div>
                    </div>`;
        $('#azureMultiField').append(data);
    })
    // append textarea and say as for google
    $('body').on('click', '.googleAddMoreText', function() {
        let data = ` <div class="speech mt-3">
                        <div class="col-12 mb-3">
                            <x-form.select class="form-select form-select-sm azure-say-as">
                                <option value="0" selected>{{ localize('say-as') }}</option>
                                <option value="currency">{{ localize('currency') }}</option>
                                <option value="telephone">{{ localize('telephone') }}</option>
                                <option value="verbatim">{{ localize('verbatim') }}</option>
                                <option value="date">{{ localize('date') }}</option>
                                <option value="characters">{{ localize('characters') }}</option>
                                <option value="cardinal">{{ localize('cardinal') }}</option>
                                <option value="ordinal">{{ localize('ordinal') }}</option>
                                <option value="fraction">{{ localize('fraction') }}</option>
                                <option value="bleep">{{ localize('bleep') }}</option>
                                <option value="unit">{{ localize('unit') }}</option>
                                <option value="unit">{{ localize('time') }}</option>
                            </x-form.select>
                            </div>
                        <div class="col-12">
                            <div class="position-relative z-1">
                                <x-form.textarea name="content[]" id="azureContent" row="5" cols="5" placeholder="" />
                                <x-form.button  type="button" class="btn bttn--icon btn--decrement border-danger w-5 h-5 rounded-circle lh-1 removeButton">
                                    <span class="material-symbols-rounded text-danger fs-18 lh-1">
                                close </span></x-form.button>
                            </div>
                        </div>
                    </div>`;
        $('#googleMultiField').append(data);
    })

    // remove append textrea and say as
    $('body').on('click', '.removeButton', function() {
        $(this).closest('.speech').remove();
    })

    // add text to speech
    $(".addTextToSpeechForm").submit(function(e) {
        e.preventDefault();
        let engine  = $(this).data('engine');
        let form    = '#TextToSpeech'+engine+'Form';
        resetFormErrors('form'+form);
        loading('#frmActionBtn'+engine, 'Generating...');

        let callParams  = {};
        callParams.type = "POST";
        callParams.url  = $("form"+form).attr("action");
        callParams.data = new FormData($(form)[0]);
        callParams.processData = false;
        callParams.contentType = false;
       
        ajaxCall(callParams, function(result) {
            resetLoading('#frmActionBtn'+engine, 'Generate Speech');
            showSuccess(result.message);
            resetForm('form'+form);
            getDataList();
            balanceRender("{{appStatic()::PURPOSE_TEXT_TO_VOICE}}")
        }, function(err, type, httpStatus) {
            showFormError(err, form);
            centerToast(err.responseJSON.message, "error");
            resetLoading('#frmActionBtn'+engine, 'Generate Speech');
        });

        return false;
    });


    // count text open ai and elevenLabs
    function exceedLimitType(type, maxLenght = null) {
        let textLenght = $("#input-textarea-" + type).val().length;
        let characCount = $("#charac-count-" + type);
        exceedLimit(textLenght, maxLenght, characCount);
    }

    function exceedLimit(textLenght, maxLenght, characCount) {
        if (textLenght > maxLenght) {
            toast('{{ localize('Content exceeds limit') }}', 'warning');
        }
        $(characCount).html(textLenght);
    }

</script>
<script>
    const googleVoicesData = <?php echo json_encode($google_languages_voices); ?>;
    const azureVoicesData = <?php echo json_encode($azure_languages_voices); ?>;

    function clearData() {
        $('.speeches .speech').remove();
        $('.defaultcontent').val('');
        $('#title').val('');
    }
    $(document).ready(function() {
        "use strict";
        googlePopulateVoiceSelect();
        azurePopulateVoiceSelect();

        $("#googleLanguages").on("change", function() {
            googlePopulateVoiceSelect();
        });

        $("#azureLanguages").on("change", function() {
            azurePopulateVoiceSelect();
        });

        function googlePopulateVoiceSelect() {
            const googleSelectedLanguage = $("#googleLanguages").val();
            const googlSelectedOptions = googleVoicesData[googleSelectedLanguage];
            const googleVoiceSelect = $("#googleVoice");
            populateVoiceSelect(googleSelectedLanguage, googlSelectedOptions, googleVoiceSelect);
        }

        function azurePopulateVoiceSelect() {
            const azureSelectedLanguage = $("#azureLanguages").val();
            const azureSelectedOptions = azureVoicesData[azureSelectedLanguage];
            const azureVoiceSelect = $("#azureVoice");
            populateVoiceSelect(azureSelectedLanguage, azureSelectedOptions, azureVoiceSelect);
        }

        function populateVoiceSelect(selectedLanguage, selectedOptions, voiceSelect) {
            voiceSelect.empty();

            if (selectedOptions) {
                selectedOptions.forEach(option => {
                    $("<option></option>")
                        .val(option.value)
                        .text(option.label)
                        .appendTo(voiceSelect);
                });
            }
        }

        // say as changes and append data for google
        $(document).on('change', '.google-say-as', function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'currency') {
                selectedValue = "<say-as interpret-as='currency' language='en-US'>$42.01</say-as>";
            } else if (selectedValue === 'telephone') {
                selectedValue =
                    "<say-as interpret-as='telephone' google:style='zero-as-zero'>1800-202-1212</say-as>";
            } else if (selectedValue === 'verbatim') {
                selectedValue = "<say-as interpret-as='verbatim'>abcdefg</say-as>";
            } else if (selectedValue === 'date') {
                selectedValue =
                    "<say-as interpret-as='date' format='yyyymmdd' detail='1'>1960-09-10</say-as>";
            } else if (selectedValue === 'characters') {
                selectedValue = "<say-as interpret-as='characters'>can</say-as>";
            } else if (selectedValue === 'cardinal') {
                selectedValue = "<say-as interpret-as='cardinal'>12345</say-as>";
            } else if (selectedValue === 'ordinal') {
                selectedValue = "<say-as interpret-as='ordinal'>1</say-as>";
            } else if (selectedValue === 'fraction') {
                selectedValue = "<say-as interpret-as='fraction'>5+1/2</say-as>";
            } else if (selectedValue === 'bleep') {
                selectedValue = "<say-as interpret-as='expletive'>censor this</say-as>";
            } else if (selectedValue === 'unit') {
                selectedValue = "<say-as interpret-as='unit'>10 foot</say-as>";
            } else if (selectedValue === 'time') {
                selectedValue = "<say-as interpret-as='time' format='hms12'>2:30pm</say-as>";
            }
            var textarea = $(this).closest('.googleSpeech').find('textarea');
            var existingValue = textarea.val();
            textarea.val(existingValue + selectedValue);
            $(this).val('0');
        });
        // say as changes and append data for azure
        $(document).on('change', '.azure-say-as', function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'currency') {
                selectedValue = "<say-as interpret-as='currency' language='en-US'>$42.01</say-as>";
            } else if (selectedValue === 'telephone') {
                selectedValue =
                    "<say-as interpret-as='telephone' google:style='zero-as-zero'>1800-202-1212</say-as>";
            } else if (selectedValue === 'verbatim') {
                selectedValue = "<say-as interpret-as='verbatim'>abcdefg</say-as>";
            } else if (selectedValue === 'date') {
                selectedValue =
                    "<say-as interpret-as='date' format='yyyymmdd' detail='1'>1960-09-10</say-as>";
            } else if (selectedValue === 'characters') {
                selectedValue = "<say-as interpret-as='characters'>can</say-as>";
            } else if (selectedValue === 'cardinal') {
                selectedValue = "<say-as interpret-as='cardinal'>12345</say-as>";
            } else if (selectedValue === 'ordinal') {
                selectedValue = "<say-as interpret-as='ordinal'>1</say-as>";
            } else if (selectedValue === 'fraction') {
                selectedValue = "<say-as interpret-as='fraction'>5+1/2</say-as>";
            } else if (selectedValue === 'bleep') {
                selectedValue = "<say-as interpret-as='expletive'>censor this</say-as>";
            } else if (selectedValue === 'unit') {
                selectedValue = "<say-as interpret-as='unit'>10 foot</say-as>";
            } else if (selectedValue === 'time') {
                selectedValue = "<say-as interpret-as='time' format='hms12'>2:30pm</say-as>";
            }
            var textarea = $(this).closest('.speech').find('textarea');
            var existingValue = textarea.val();
            textarea.val(existingValue + selectedValue);
            $(this).val('0');
        });

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
</script>

