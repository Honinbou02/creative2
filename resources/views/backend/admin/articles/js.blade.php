<script>
    "use strict";

    const PURPOSE_KEYWORDS         = "{{ appStatic()::PURPOSE_KEYWORD }}";
    const PURPOSE_TITLE            = "{{ appStatic()::PURPOSE_TITLE }}";
    const PURPOSE_CONTENT          = "{{ appStatic()::PURPOSE_CONTENT }}";
    const PURPOSE_OUTLINE          = "{{ appStatic()::PURPOSE_OUTLINE }}";
    const PURPOSE_IMAGE            = "{{ appStatic()::PURPOSE_IMAGE }}";
    const PUBLISHED_TO_WORDPRESS   = "publish_to_wordpress";
    const PURPOSE_META_DESCRIPTION = "{{ appStatic()::PURPOSE_META_DESCRIPTION }}";

    const URL_ARTICLES             = "{{ route("admin.generator.generateArticles") }}";
    const URL_KEYWORDS             = "{{ route("admin.generator.generateKeywords") }}";
    const URL_TITLES               = "{{ route("admin.generator.generateTitles") }}";
    const URL_OUTLINES             = "{{ route("admin.generator.generateOutlines") }}";
    const URL_IMAGES               = "{{ route("admin.generator.generateImages") }}";
    const URL_META_DESCRIPTION     = "{{ route("admin.generator.generateMetaDescriptions") }}";
    const CSRF_TOKEN               = "{{ csrf_token() }}";
    var geminiAi                   = "{{isGeminiAi(aiBlogWizardEngine())}}";
    var engine                     = "{{aiBlogWizardEngine()}}";
    /**
     * Generate Actions
     * 1= keyword Generate
     * 2= title Generate
     * 3= outline Generate
     * 4= Image
    * */

    window.currentAction = null;

    $(()=>{
        hideTitlesRow();
        hideOutlinesRow();
        hideImagesRow();

        $('#contentGenerator').summernote({
            disableResizeEditor: true,
            height: 300,
        });
    });

    function hideAll(){
        // Add d-none to the keywordSeoCheckbox
        hideElement('.keywordSeoCheckbox');
        hideElement('.keywordsNumberOfResultDiv');
        hideElement('.numberOfResultDiv');
        changeText("label[for='number_of_results']", "{{ localize('Number of Result') }}");

        hideKeywordsRow();
        hideTitlesRow();
        hideMetaDescriptionsRow();
        hideOutlinesRow();
        hideImagesRow();
        hideAdvancedImageOptionRow();
        hideWithPressRow();
    }


    // Generate BTN
    $(document).on("click", ".sidecanvas-toggler", function (e) {
        e.preventDefault();
        hideAll();
        window.currentAction = $(this).data("content-purpose");
        resetLoading('.generateContents', "{{ localize('Generate Content') }}");

        // Purpose Keywords
        if(window.currentAction === PURPOSE_KEYWORDS){
            showElement('.withoutWordpressRow');

            $('.keywordSeoCheckbox').removeClass('d-none');
            $('#generated-title').html('{{localize("Generate Keywords")}}');
            resetLoading('.generateContents', "{{ localize('Generate Keywords') }}");

            // showElement(".keywordsRow");
            showElement(".keywordsNumberOfResultDiv");
            hideElement(".numberOfResultDiv");

            return ;
        }

        // When currentAction is not keywords means. add d-none to keywordsNumberOfResultDiv and remove d-none from numberOfResultDiv
        // hideElement(".keywordsNumberOfResultDiv");
        showElement(".numberOfResultDiv");

        // Purpose Titles
        if(window.currentAction === PURPOSE_TITLE){
            // showElement('.titlesRow');

            $('#generated-title').html('{{localize("Generate Title")}}');
            changeText("label[for='number_of_results']", "<span class='text-danger'>*</span> {{ localize('Number of Title') }}");
            resetLoading('.generateContents', "{{ localize('Generate Title') }}");

            return ;
        }

        // Meta Description
        if(window.currentAction === PURPOSE_META_DESCRIPTION){
            showElement('.withoutWordpressRow');
            // showElement(".metaDescriptionsRow");

            $('#generated-title').html('{{localize("Generate Meta Descriptions")}}');
            changeText("label[for='number_of_results']", "<span class='text-danger'>*</span> {{ localize('Number of Meta Description') }}");
            resetLoading('.generateContents', "{{ localize('Generate Meta Description') }}");

            return ;
        }

        // Purpose Outline
        if(window.currentAction === PURPOSE_OUTLINE){
            showElement('.withoutWordpressRow');

            $('#generated-title').html('{{localize("Generate Outlines")}}');
            changeText("label[for='number_of_results']", "<span class='text-danger'>*</span> {{ localize('Number of Outline') }}");
            resetLoading('.generateContents', "{{ localize('Generate Outline') }}");

            return ;
        }

        // Purpose Image
        if(window.currentAction === PURPOSE_IMAGE){
            showElement('.withoutWordpressRow');

            $('#generated-title').html('{{localize("Generate Image")}}');
            showElement('.imagesRow');

            return ;
        }

        // Purpose Wordpress
        if(window.currentAction === PUBLISHED_TO_WORDPRESS){
            $('#generated-title').html('{{localize("Publish to Wordpress")}}');
            showElement('.wordpressBlogRow');

            return ;
        }
    });

    /**
     * Keyword Generation
    * */
    $(document).on("click", ".generateContents", function (e) {
        let topic                   = $("input[name='topic']").val().trim();
        let number_of_results       = $("#addFrm #number_of_results").val().trim();
        let number_of_main_keywords = $("#addFrm #number_of_main_keywords").val().trim();
        let number_of_keywords      = $("#addFrm #number_of_keywords").val().trim();
        let language                = $("#addFrm #language").val().trim();
        let tone                    = $("#addFrm #tone").val().trim();
        let article_id              = $("#article_id").val().trim();
        let mainKeywords            = $("#focusKeyword").val().trim();
        let contentKeywords         = $("#contentKeywords").val().trim();
        let contentTitle            = $("#title").val().trim();
        let contentMetaDescriptions = $("#contentMetaDescriptions").val().trim();

        let data = {
            article_id,
            topic, 
            number_of_results, 
            number_of_main_keywords, 
            number_of_keywords, 
            mainKeywords,
            contentKeywords,
            contentTitle,
            contentMetaDescriptions,
            language,
            tone,
        };


        let currentAction = String(window.currentAction);
        switch (currentAction) {
            case PURPOSE_KEYWORDS:
                return generateKeywords(data);
                break;
            case PURPOSE_TITLE:
                if(article_id.length>0){
                    return generateTitles(data);
                }
                break;
            case PURPOSE_META_DESCRIPTION:
                if(article_id){
                    return generateMetaDescriptions(data);
                }
                break;
            case PURPOSE_OUTLINE:
                if(article_id.length>0){
                    return generateOutlines(data);
                }
                break;
            case PURPOSE_IMAGE:
                let prompt = $('#image_prompt').val();
                showElement('.imagesRow');

                if(!prompt){
                    toast("{{localize('Please write something in image field')}}", 'warning');
                    return;
                }
                if(article_id.length>0){
                    data.prompt = prompt;
                    return generateImages(data);
                }
                break;
            case PUBLISHED_TO_WORDPRESS:
                return publishToWordpress();
                break;
            default:
                console.log(`Sorry, we are out of ${expr}.`);
        }
    });

    /**
     * ##################################
     * #    Keyword Generation START    #
     * ##################################
    * */
    function generateKeywords(data){
        loading('.generateContents',  "{{ localize('Generating...') }}");
        showElement(".keywordsRow");
        loadingInContent(".keyword-list");

        let callParams  = {};
        callParams.type = "POST";
        callParams.url  = URL_KEYWORDS;

        callParams.data = {
            _token                 : CSRF_TOKEN,
            topic                  : data.topic,
            number_of_results      : data.number_of_results,
            number_of_main_keywords: data.number_of_main_keywords,
            number_of_keywords     : data.number_of_keywords,
            lang                   : data.language,
            tone                   : data.tone,
            content_purpose        : PURPOSE_KEYWORDS,
            article_id             : data.article_id.length > 0 ? data.article_id : null,
            seo_check              : $("#checkSeoForKeyword").is(':checked') ? 1 : 0
        };
        ajaxCall(callParams, function (result) {
            balanceRender();
                resetLoading('.generateContents', "{{ localize('Generate Keywords') }}");
            // Main Keywords
            if(result.data.main_keywords){
                $(".render-keywords").html(result.data.main_keywords);
            }

            // Related Keywords
            if(result.data.related_keywords){
                $(".related-keywords").html(result.data.related_keywords);
            }

            // is Article id found
            if(result.optional?.article_id){
                $("#article_id").val(result.optional.article_id);
            }

        },
        function (err, type, httpStatus) {
            balanceRender();

            resetLoading('.generateContents', "{{ localize('Generate Keywords') }}");
            const message = err.responseJSON.message;
            toast(message, "error");
        });
    }

    // Related Keywords
    $(document).on("click",".relatedKeywordInput",function (e) {

        let checkedKeywords = $('.relatedKeywordInput:checked').map(function() {
            return $(this).val();
        }).get().join(",");

        $("#contentKeywords").val(checkedKeywords);
    });

    // Main Keywords
    $(document).on("click",".mainKeywordInput",function (e) {

        let checkedMainKeywords = $('.mainKeywordInput:checked').map(function() {
            return $(this).val();
        }).get().join(",");

        $("#focusKeyword").val(checkedMainKeywords);
    })

    let keywordsArray = [];
    $(document).on("click","#addKeyword",function (e) {
        let keyword = $("#yourKeyword").val();

        if(keyword.length > 0){
            if (!keywordsArray.includes(keyword)) {
                keywordsArray.push(keyword);

                // Append New Custom Keyword
                appendKeywordLi(keyword);

                $(this).val(null);
            }
        }
    });

    function appendKeywordLi(keyword){
        let randomID = Math.random().toString(36).substr(2, 9);

        let keywordHTML = `<li class="keyword-list__item">
                <div class="form-check tt-checkbox mb-0">
                    <x-form.input
                        name="keywords[]"
                        type="checkbox"
                        class="form-check-input cursor-pointer mb-0 keywordInput"
                        id="keywordList${randomID}"
                        value="${keyword}"
                        :showDiv="false"
                    />

                    <x-form.label for="keywordList${randomID}" class="form-label mb-0" >${keyword}</x-form.label>
                </div>
            </li>`;

        $(".render-keywords").prepend(keywordHTML);
    }
    /**
     * ##################################
     * #    Keyword Generation END      #
     * ##################################
     * */

    /**
     * ##################################
     * #    Title Generation START      #
     * ##################################
     * */

    function generateTitles(data){
        loading('.generateContents', 'Generating...');
        showElement(".titlesRow");
        loadingInContent(".keyword-list");

        let callParams  = {};
        callParams.type = "POST";
        callParams.url  = URL_TITLES;

        callParams.data = {
            _token            : CSRF_TOKEN,
            topic             : data.topic,
            mainKeywords      : data.mainKeywords,
            contentKeywords   : data.contentKeywords,
            number_of_results : data.number_of_results,            
            lang              : data.language,
            tone              : data.tone,
            content_purpose   : PURPOSE_TITLE,
            article_id        : data.article_id
        };
        ajaxCall(callParams, function (result) {
                balanceRender();

                resetLoading('.generateContents', "{{ localize('Generate Title') }}");
                // toast(result.message);
                $(".render-titles").html(result.data);
            },
            function (err, type, httpStatus) {
                balanceRender();

                resetLoading('.generateContents', "{{ localize('Generate Title') }}");

                const message = err.responseJSON.message;
                toast(message, "error");
            });
    }

    $(document).on("click",".titleRadioInput",function (e) {
        let checkedTitles = $('input[name="title"]:checked').val();
        $("#title").val(checkedTitles);
    });

    /**
     * ##################################
    * #    Title Generation END      #
    * ##################################
    * */

    /**
     * #############################################
     * #    META-Description Generation START      #
     * #############################################
     * */

     function generateMetaDescriptions(data){
        showElement(".metaDescriptionsRow");
        loading('.generateContents', "{{ localize('Generating...') }}");
        loadingInContent(".render-meta_descriptions");

        let callParams  = {};
        callParams.type = "POST";
        callParams.url  = URL_META_DESCRIPTION;
        callParams.data = {
            _token            : CSRF_TOKEN,
            topic             : data.topic,
            contentKeywords   : data.contentKeywords,
            mainKeywords      : data.mainKeywords,
            title             : data.contentTitle,
            number_of_results : data.number_of_results,
            lang              : data.language,
            tone              : data.tone,
            content_purpose   : PURPOSE_OUTLINE,
            article_id        : data.article_id
        };

        ajaxCall(callParams, function (result) {
                balanceRender();

                resetLoading('.generateContents', "{{ localize('Generate Meta Description') }}");
                $(".render-meta_descriptions").html(result.data);
            },
            function (err, type, httpStatus) {
                balanceRender();

                resetLoading('.generateContents', "{{ localize('Generate Meta Description') }}");
                toast(err.responseJSON.message,"error");
            });
    }

    // Meta Description
    $(document).on("click",".metaDescriptionInput",function (e) {
        let checkedMetaDescription = $('.metaDescriptionInput:checked').map(function() {
            return $(this).val();
        }).get().join(",");

        $("#contentMetaDescriptions").val(checkedMetaDescription);

        //Title Update
        $(".articleTitle").html($("#title").val());

        // Meta Description Update
        $(".articleMetaDescription").html(checkedMetaDescription);
    });

    /**
     * ##################################
     * #    Outline Generation START      #
     * ##################################
     * */

    function generateOutlines(data){
        showElement(".outlinesRow");
        loading('.generateContents', "{{ localize('Generating...') }}");
        loadingInContent(".render-outlines");

        let callParams  = {};
        callParams.type = "POST";
        callParams.url  = URL_OUTLINES;

        callParams.data = {
            _token            : CSRF_TOKEN,
            topic             : data.topic,
            mainKeywords      : data.mainKeywords,
            contentKeywords   : data.contentKeywords,
            title             : data.contentTitle,
            metaDescription   : data.contentMetaDescriptions,
            number_of_results : data.number_of_results,
            lang              : data.language,
            tone              : data.tone,
            content_purpose   : PURPOSE_OUTLINE,
            article_id        : data.article_id
        };
        ajaxCall(callParams, function (result) {
                balanceRender();

                resetLoading('.generateContents', 'Generate Outline');
                $(".render-outlines").html(result.data);
            },
            function (err, type, httpStatus) {
                balanceRender();

                resetLoading('.generateContents', 'Generate Outline');
                toast(err.responseJSON.message,"error");

        });
    }

    $(document).on("click", ".outlineRadioInput", function (e) {
        $(this).prop("checked", true);
        $(".outline-lists").html(null);

        let outlineList = $(this).val().split(',');

        outlineList.forEach(function(item) {
            let trimmedItem = item.trim();
            let newOutline = `<div class="single-outline d-flex align-items-center mb-2 gap-2">
                            <span>#</span>
                            <input class="form-control form-control-sm" type="text" name="outlines[]" value="${trimmedItem}" required>
                            <button class="btn btn-secondary addOutline btn-icon" type="button"><i data-feather="plus"></i></button>
                            <button class="btn btn-icon btn-soft-danger delOutline" type="button" ><i data-feather="minus"></i></button>
                            </div>`;
            $('.outline-lists').append(newOutline);
        });

        feather.replace(); // Reinitialize feather icons
    });

    $(document).on('click', '.addOutline', function() {
        let original = $('.single-outline').first();
        let clone = original.clone();
        clone.find('input').val('');

        $('.outline-lists').append(clone);
    });

    $(document).on('click', '.delOutline', function() {
        if ($('.single-outline').length > 1) {
            $(this).closest('.single-outline').remove();
        }
    });
    /**
     * ##################################
     * #    Outline Generation END      #
     * ##################################
     * */

    /**
     * ##################################
     * #    Image Generation START      #
     * ##################################
     * */
    function generateImages(data)
    {
        let callParams  = {};
        callParams.type = "POST";
        callParams.url  = URL_IMAGES;

        callParams.data = {
            _token            : CSRF_TOKEN,
            title             : data.title,
            contentKeywords   : data.contentKeywords,
            mainKeywords      : data.mainKeywords,
            number_of_results : data.number_of_results,
            prompt            : data.prompt,
            content_purpose   : PURPOSE_IMAGE,
            article_id        : data.article_id,

        };
        loading('.generateContents', 'Generating...');
        ajaxCall(callParams, function (result) {
                resetLoading('.generateContents', 'Generate Content');
                $(".render-images").append(result.data);
                toast(result.message);
            },
            function (err, type, httpStatus) {
                resetLoading('.generateContents', 'Generate Content');

                console.log("Failed to Generate Images", err.responseText);

                const message = err.responseJSON.message;
                toast(message,"error");
        }, 3000000);
    }

    $(document).on("click", ".selection-clicked-image", function(e) {
            e.preventDefault();
            let callParams = {};
            let id         = getArticleId();
            let imagePath  = $(this).val();
            var url = "{{ route('admin.articles.update',":id") }}";
                url = url.replace(':id', id);
            let formData = {
                id  : id,
                type : 'image',
                selected_image : imagePath,
            }
            callParams.type = "PUT";
            callParams.url  = url;
            callParams.data = formData;

        feather.replace(); // Reinitialize feather icons
    });
    /**
     * ##################################
     * #    Image Generation END        #
     * ##################################
     * */


    function resetArticleBtn(){
        resetLoading('.generateFinalContent', "<i data-feather='rotate-cw' class='icon-12'></i> {{ localize('Generate Article') }}");

        $('.StopGenerate').prop('disabled', true);
        $('.saveChange').prop('disabled', false); 
        $('.generateSocialPostButton').prop('disabled', false);

        feather.replace(); // Reinitialize feather icons
    }

   /**
     * Generate full article
    * */
    $("#frmArticleGenerate").on("submit",function (e) {
        e.preventDefault();
        resetFormErrors('form#frmArticleGenerate');
        loading('.generateFinalContent', 'Article Generating...');

        let topic                  = $('#contentTopic').val().trim();
        let focusKeyword           = $('#focusKeyword').val().trim();
        let contentKeywords        = $('#contentKeywords').val().trim();
        let title                  = $('#title').val().trim();
        let contentMetaDescription = $('#contentMetaDescriptions').val().trim();
        let language               = $('#language :selected').val().trim();
        let tone                   = $('#tone :selected').val().trim();
        let maxArticleLength       = $('#maxArticleLength :selected').val().trim();

        // Check if topic is empty
        if(!topic.length){
            resetArticleBtn();
            toast("{{ localize('Topic can not be  empty.') }}", 'error');
            return;
        }

        if(!focusKeyword.length){
            resetArticleBtn();

            toast("{{ localize('Main Keyword can not be empty') }}", 'error');
            return;
        }
        if(focusKeyword.split(' ').length > 6){
            resetArticleBtn();

            toast("{{ localize('Focus Keyword should be equal or less than 6 words') }}", 'error');
            return;
        }

        if(!contentKeywords.length){
            resetArticleBtn();

            toast("{{ localize('Related keywords can not be empty') }}", 'error');
            return;
        }

        if(!title.length){
            resetArticleBtn();

            toast("{{ localize('Title can not be  empty.') }}", 'error');
            return;
        }

        if(!contentMetaDescription.length){
            resetArticleBtn();

            toast("{{ localize('Meta Description can not be empty') }}", 'error');
            return;
        }

        // Validate outlines input fields
        let outlines = $("input[name='outlines[]']").map(function() {
            return $(this).val().trim();
        }).get();

        // Check if any outline is empty
        if (outlines.some(outline => outline.length === 0)) {

            resetArticleBtn();
            toast("{{ localize('All outlines must have content.') }}", 'error');

            return;
        }
        

        // let imagePath  = $('input[name="flexRadioDefaultImage"]:checked').val();
        
        // Image attaching to the article
        // if(imagePath) {
            //     var img = $('<img>').attr('src', imagePath).attr('alt', 'Description of Image');
            //     $(".note-editable").append(img);
            // }
            
        let isEdit             = $("#frmArticleGenerate").attr("data-is_edit");
        let isWordpressArticle = $("#frmArticleGenerate").attr("data-is_wordpress_article");

        let formData   = $("#frmArticleGenerate").serialize();
        // Make Generate elements save/update ajax request
        if(isEdit && isWordpressArticle){
            storeUpdateArticleBody(formData)

            return true;
        }

        // Empty the editor
        $(".note-editable").html('');
        
        $("#text-input").val(title).animate({ opacity: 1 }, { duration: 3000});

        // Event Streaming Start
        articleEventStream(formData);
    });

    function storeUpdateArticleBody(formData){
        let callParams  = {};
        callParams.type = $("#frmArticleGenerate").attr("method");
        callParams.url  = $("#frmArticleGenerate").attr("action");
        callParams.data = formData;

        ajaxCall(callParams, function(result) {
            toast(result.message);
            // Handle success actions here
        }, function(err, type, httpStatus) {
            console.log(err.responseJSON);

            toast(err.responseJSON.message, "error");
            // Handle error actions here
        });
    }

    var TT_ERROR = "{{ appStatic()::TT_ERROR }}";

    function articleEventStream(formData){
        // Event Source initialized
        TT.eventSource = new EventSource(`${URL_ARTICLES}?${formData}`, {
            withCredentials: true
        });

        let buffer = '';
        let streamedContent = '';
        window.full_article_content = '';

        // Event Source on message received
        TT.eventSource.onmessage = function(e) {

            /**
             * ##################################################
             *         Event Source Error Handling Start
             *         Default Error Receive :
             *         Error msg must contain
             *         "event error" from backend
             * ##################################################
            * */
            // Default Error Receive : Error msg must contain "event error" from backend
            if(e.data.indexOf(TT_ERROR) !== -1) {

                e.data = e.data.replace(TT_ERROR, "");

                toast(e.data, "error");

                TT.eventSource.close();

                resetArticleBtn();

                updateUserBalanceAfterGenerateContent("articles", engine);
                balanceRender();

                return;
            }

            /**
             * ##################################################
             *         Event Source Error Handling END
             * ##################################################
             * */

            $('.generateFinalContent').prop('disabled', true);
            $('.StopGenerate').prop('disabled', false);

            // When streaming is done
            if (e.data == "[DONE]") {
                resetArticleBtn();

                toast("{{ localize('Article Generated Successfully') }}");

                TT.eventSource.close();

                updateUserBalanceAfterGenerateContent("articles", engine);
                balanceRender();
                resetLoading(".articleSeoCheckerBtn", "<button class='d-flex align-items-center gap-1 btn btn-sm btn-primary px-3 py-1 rounded-pill' type='button'><i data-feather='activity'></i>{{ localize('Check SEO') }}</button>");
            }
            else {
                let txt = undefined;
                try {
                    if(e.data !== undefined) {
                        txt = JSON.parse(e.data).choices[0].delta.content;
                        if (txt !== undefined) {
                            txt = txt.replace(/(?:\r\n|\r|\n)/g, '');
    
                            window.full_article_content = (window.full_article_content ?? "") + txt;
    
                            $(".note-editable").html(window.full_article_content);
                        }
                    }
                } catch (e) {
                    console.log("Catch Article Stream Error : ", e, e.data);
                }
            }
        };

        // Event Source on error
        TT.eventSource.onerror = function(e) {
            resetArticleBtn();

            TT.eventSource.close();

            // Error Toast
            toast("{{ localize("Event source fired error") }}", "error");

            // Update User Balance
            updateUserBalanceAfterGenerateContent("articles", engine);

            // Balance Render
            balanceRender();
        };
    }

    /**
     * Stop Generate
    * */
    $(document).on("click", ".StopGenerate", function (e) {
        e.preventDefault();
        loading('.StopGenerate', "{{ localize('Generation Stopping...') }}");
        resetLoading('.generateFinalContent', "<i data-feather='rotate-cw' class='icon-12'></i> {{ localize('Generate Article') }}");
        // Closing event source
        if (TT.eventSource) {
            TT.eventSource.close();
        }

        updateUserBalanceAfterGenerateContent("articles", engine);
        balanceRender();
        resetLoading('.StopGenerate', "<i data-feather='stop-circle' class='icon-14'></i> {{ localize('Stop Generation') }}");
        feather.replace(); // Reinitialize feather icons
    });

    $(document).on('click', '.downloadChatBtn', function(e) {
        let type = $(this).data('download_type');
        let article_id = $("#article_id").val();
        let data = {type:type, id:id};
        let url  =  `{{ route('admin.download-content') }}?article_id=${article_id}&type=${type}`;
        window.open(url, '_blank'); // Open URL in a new tab
    });

    TT.stockImagePlatform = "unsplash"; // update this on tab click

    $(document).on("click", ".image-platform", function(e) {
        TT.stockImagePlatform = $(this).data("platform");
    });
    $(document).on("click", "#searchStockImage", function(e) {
        let value = $("#stockImage").val();

        loading('.aiImageSearchResult', 'Loading...');

            let callParams = {};

            callParams.type = "GET";
            callParams.url = `{{ route('admin.generator.imageSearch') }}?q=${value}&platform=${TT.stockImagePlatform}`;

            ajaxCall(callParams, function(response) {
                $('.aiImageSearchResult').html(response.data);
            },
            function(err) {
                console.log("Search Error",err.responseJSON);
            });
    });

    $(document).on("click",".unsplashImageDiv", function (e){
        let thisDiv = $(this)
        let imgSrc = thisDiv.attr("data-src");
        let imgAlt = thisDiv.attr("data-alt");

        $(".contentImg img").attr("src", imgSrc);
        $(".contentImg img").attr("alt", imgAlt);


        // Create image HTML
        const imgHtml = `<img src="${imgSrc}" alt="${imgAlt}" title="Your Article." style="max-width:100%;">`;

        $("#imageURL").val(imgSrc);
        $("#imageALT").val(imgAlt);
    });

    $(document).on('click', '.add-to-article-content-btn', function(e) {
        let imageURL   = $("#imageURL").val();
        let imageALT   = $("#imageALT").val();
        let imageTitle = $("#imageTitle").val();
        let content    = $(".note-editable").html();
        let imgHtml    = `<img src="${imageURL}" alt="${imageALT}" title="${imageTitle}" />`;

        $('#contentGenerator').summernote('insertNode', $(imgHtml)[0]);

        // Closing the OffCanvas
        $('#offcanvasSelectedImage').offcanvas('hide');
    });

    function hideKeywordsRow(){
        hideElement(".keywordsRow");
    }

    function hideMetaDescriptionsRow(){
        hideElement(".metaDescriptionsRow");
    }

    function hideWithoutWithPressRow(){
        hideElement("#withoutWordpressRow");
    }
    function hideWithPressRow(){
        hideElement("#wordpressBlogRow");
    }
    function hideAdvancedOptionRow(){
        hideElement("#advanced_option");
    }
    function hideAdvancedImageOptionRow(){
        hideElement("#advanced_option_image");
    }

    function hideTitlesRow(){
        hideElement(".titlesRow");
    }

    function hideOutlinesRow(){
        hideElement(".outlinesRow");
    }

    function hideImagesRow(){
        hideElement(".imagesRow");
    }

    
    /**
     * ##################################
     * #    Social Post Generation      #
     * ##################################
     * 
    **/
    function showGenerateSocialPostForm(articleId) {
        loadingInContent('#social-post-contents');

        gFilterObj.id             = articleId ?? $("#article_id").val();;
        var callParams            = {};
        callParams.type           = "GET";
        callParams.dataType       = "html";
        callParams.url            = "{{ route('admin.socials.posts.show-article-post-generation-form') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data           = '';

        ajaxCall(callParams, function(result) {
            $('#social-post-contents').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }

    
    $(document).on("submit", ".social-post-form", function (e) {
        e.preventDefault();
        let selectedPlatformCount = $("input[name='platform_ids[]']:checked").length;
        if(selectedPlatformCount === 0){
            toast("{{ localize('Please select at least one platform') }}", "error");
            return;
        }

        loading('.generateSocialPostBtn', "{{ localize('Generating...') }}"); 

        let callParams         = {};
        callParams.type        = "POST";
        callParams.url         = $("form#offcanvasSocialPosts").attr("action");
        callParams.data        = new FormData($("#offcanvasSocialPosts")[0]);
        callParams.processData = false;
        callParams.contentType = false;
        ajaxCall(callParams, function(result) {
            resetLoading('.generateSocialPostBtn', "<i data-feather='rotate-cw' class='icon-14'></i> {{ localize('Generate Posts') }}");
            $('.article-social-post-container').empty().html(result.data);
            toast(result.message, 'success');
            feather.replace();
        }, function(err, type, httpStatus) {
            resetLoading('.generateSocialPostBtn', "<i data-feather='rotate-cw' class='icon-14'></i> {{ localize('Generate Posts') }}");
            feather.replace();
        });
    });

    $(document).on("change", "input[name='article_social_post_ids[]']", function (e) {
        let selectedPostsCount = $("input[name='article_social_post_ids[]']:checked").length;
        if(selectedPostsCount > 0){
            $(".create-social-post-btn").prop("disabled", false);
        }else{
            $(".create-social-post-btn").prop("disabled", true);
        }
    });
    
    $(document).on("click", ".create-social-post-btn", function (e) {
        let id = $(this).data("id"); 
        let url = "{{ route('admin.socials.posts.create') }}?id=" + id;
        window.open(url, '_blank');
    });
     /**
     * ##################################
     * #   Social Post Generation Ends  #
     * ##################################
     * 
    **/

</script>
