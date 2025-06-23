@section("js")
    <script>
    "use strict";

    const PURPOSE_KEYWORDS       = "keywords";
    const PURPOSE_TITLE          = "titles";
    const PURPOSE_CONTENT        = "contents";
    const PURPOSE_OUTLINE        = "outlines";
    const PURPOSE_IMAGE          = "image";
    const PUBLISHED_TO_WORDPRESS = "publish_to_wordpress";

    const URL_ARTICLES  = "{{ route("admin.generator.generateArticles") }}";
    const URL_KEYWORDS  = "{{ route("admin.generator.generateKeywords") }}";
    const URL_TITLES    = "{{ route("admin.generator.generateTitles") }}";
    const URL_OUTLINES  = "{{ route("admin.generator.generateOutlines") }}";
    const URL_IMAGES    = "{{ route("admin.generator.generateImages") }}";
    const CSRF_TOKEN    = "{{ csrf_token() }}";
    var geminiAi        = "{{isGeminiAi(aiBlogWizardEngine())}}";
    var engine          = "{{aiBlogWizardEngine()}}";
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
    })
   

    $(document).on("click",".sidecanvas-toggler",function (e) {
        e.preventDefault();
        window.currentAction = $(this).data("content-purpose");

        if(window.currentAction === PURPOSE_KEYWORDS){
            showElement('.withoutWordpressRow');

            $('#generated-title').html('{{localize("Generate Keywords")}}');
            showElement(".keywordsRow");
            hideTitlesRow();
            hideOutlinesRow();
            hideImagesRow();
            hideAdvancedImageOptionRow();
            hideWithPressRow();
        }
        else if(window.currentAction === PURPOSE_TITLE){
            showElement('.withoutWordpressRow');

            $('#generated-title').html('{{localize("Generate Title")}}');
            showElement(".titlesRow");
            hideKeywordsRow();
            hideOutlinesRow();
            hideImagesRow();
            hideAdvancedImageOptionRow();
            hideWithPressRow();
        }
        else if(window.currentAction === PURPOSE_OUTLINE){
            showElement('.withoutWordpressRow');

            $('#generated-title').html('{{localize("Generate Outlines")}}');
            showElement(".outlinesRow");

            hideKeywordsRow();
            hideTitlesRow();
            hideImagesRow();
            hideAdvancedImageOptionRow();
            hideWithPressRow();
        }else if(window.currentAction === PURPOSE_IMAGE){
            showElement('.withoutWordpressRow');

            $('#generated-title').html('{{localize("Generate Image")}}');
            showElement('.imagesRow');
            hideOutlinesRow();
            hideKeywordsRow();
            hideTitlesRow();
            hideAdvancedOptionRow();
            hideWithPressRow();
        }else if(window.currentAction === PUBLISHED_TO_WORDPRESS){
            $('#generated-title').html('{{localize("Publish to Wordpress")}}');
            showElement('.wordpressBlogRow');
            hideWithoutWithPressRow();
            hideImagesRow();
            hideKeywordsRow();
            hideTitlesRow();
            hideAdvancedOptionRow();
        }
    });

    function hideKeywordsRow(){
        hideElement(".keywordsRow");
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
     * Keyword Generation
    * */
    $(document).on("click",".generateContents",function (e) {

        let topic                   = $("input[name='topic']").val().trim();
        let number_of_results       = $("#addFrm #number_of_results").val().trim();
        let number_of_main_keywords = $("#addFrm #number_of_main_keywords").val().trim();
        let number_of_keywords      = $("#addFrm #number_of_keywords").val().trim();
        let language                = $("#addFrm #language").val().trim();
        let article_id              = $("#article_id").val().trim();
        let mainKeywords            = $("#focusKeyword").val().trim();
        let contentKeywords         = $("#contentKeywords").val().trim();
        let contentTitle            = $("#title").val().trim();
        let contentMetaDescriptions = $("#contentMetaDescriptions").val().trim();

        // console.log("Next Action is : ",window.currentAction);
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
        };


       //  return true;

        let currentAction = String(window.currentAction);

        if (currentAction === PURPOSE_KEYWORDS) {        
         
            return generateKeywords(data);
        }
        else if(currentAction === PURPOSE_TITLE){
       
            if(article_id.length>0){
                return generateTitles(data);
            }
        }
        else if(currentAction === PURPOSE_OUTLINE){

            if(article_id.length>0){
                return generateOutlines(data);
            }
        }
        else if(currentAction === PURPOSE_IMAGE){
            let prompt = $('#image_prompt').val();
            showElement('.imagesRow');

            if(!prompt){
                toast("{{localize('Please write something in image field')}}", 'warning');
                return;
            }
            if(article_id.length>0){
                return generateImages(data);
            }
        }
        else if(currentAction === PUBLISHED_TO_WORDPRESS){
            return publishToWordpress();
        }
    });

    /**
     * ##################################
     * #    Keyword Generation START    #
     * ##################################
    * */
    function generateKeywords(data){

        let callParams  = {};
        callParams.type = "POST";
        callParams.url  = URL_KEYWORDS;

        callParams.data = {
            _token                 : CSRF_TOKEN,
            topic                  : data.topic,
            number_of_main_keywords: data.number_of_main_keywords,
            number_of_keywords     : data.number_of_keywords,
            lang                   : data.language,
            content_purpose        : PURPOSE_KEYWORDS,
            article_id             : data.article_id.length > 0 ? data.article_id : null
        };
        loading('.generateContents', 'Generating...');
        ajaxCall(callParams, function (result) {
            resetLoading('.generateContents', 'Generate Content');
            toast(result.message);
            $(".render-keywords").append(result.data);

            // is Article id found
            if(result.optional?.article_id){
                $("#article_id").val(result.optional.article_id);
            }
        },
        function (err, type, httpStatus) {
            resetLoading('.generateContents', 'Generate Content');
            const message = err.responseJSON.message;
            toast(message, "error");
        });
    }


    $(document).on("click",".keywordInput",function (e) {

        let checkedKeywords = $('.keywordInput:checked').map(function() {
            return $(this).val();
        }).get().join(",");

        $("#contentKeywords").val(checkedKeywords);
    });

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
        let callParams  = {};
        callParams.type = "POST";
        callParams.url  = URL_TITLES;

        callParams.data = {
            _token            : CSRF_TOKEN,
            topic             : data.topic,
            contentKeywords   : data.contentKeywords,
            mainKeywords      : data.mainKeywords,
            number_of_results : data.number_of_results,            
            lang              : data.language,
            content_purpose   : PURPOSE_TITLE,
            article_id        : data.article_id
        };
        loading('.generateContents', 'Generating...');
        ajaxCall(callParams, function (result) {
               resetLoading('.generateContents', 'Generate Content');           
                toast(result.message);
                $(".render-titles").append(result.data);
            },
            function (err, type, httpStatus) {
               resetLoading('.generateContents', 'Generate Content');

                const message = err.responseJSON.message;
                console.log(message);
            });
    }

    $(document).on("click",".titleRadioInput",function (e) {
       let checkedTitles = $('input[name="title"]:checked').val();
       $("#title").val(checkedTitles);

        console.log("Selected Titles", checkedTitles);
    });

    /**
     * ##################################
         * #    Title Generation END      #
         * ##################################
         * */

        /**
         * ##################################
         * #    Outline Generation START      #
         * ##################################
         * */

        function generateOutlines(data){
           
            let callParams  = {};
            callParams.type = "POST";
            callParams.url  = URL_OUTLINES;

            callParams.data = {
                _token            : CSRF_TOKEN,
                title             : data.title,
                keywords          : data.contentKeywords,
                mainKeywords      : data.mainKeywords,
                number_of_results : data.number_of_results,
                lang              : data.language,
                content_purpose   : PURPOSE_OUTLINE,
                article_id        : data.article_id
            };
            loading('.generateContents', 'Generating...');
            ajaxCall(callParams, function (result) {
                    resetLoading('.generateContents', 'Generate Content');           
                    toast(result.message);
                    $(".render-outlines").append(result.data);
                },
                function (err, type, httpStatus) {
                    const message = err.responseJSON.message;
                    toast(message);
                    resetLoading('.generateContents', 'Generate Content');           

                });
        }

        $(document).on("click",".outlineRadioInput",function (e) {
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
        function generateImages(title,contentKeywords, number_of_results, prompt, article_id)
        {
            let callParams  = {};
            callParams.type = "POST";
            callParams.url  = URL_IMAGES;

            callParams.data = {
                _token            : CSRF_TOKEN,
                title             : title,
                keywords          : contentKeywords,
                number_of_results : number_of_results,
                prompt            : prompt,
                content_purpose   : PURPOSE_IMAGE,
                article_id        : article_id,
              
            };
            loading('.generateContents', 'Generating...');
            ajaxCall(callParams, function (result) {
                    resetLoading('.generateContents', 'Generate Content');           
                    $(".render-images").append(result.data);
                    toast(result.message);
                },
                function (err, type, httpStatus) {
                    resetLoading('.generateContents', 'Generate Content');

                    console.log("Failed to Generate Images", err);
                    console.log("Failed to Generate Images", err.responseText);

                    const message = err.responseJSON.message;
                    toast(message);
            }, 3000000);
        }
        function publishToWordpress(website, categories, tags, status, author)
        {

        }
        /**
         * ##################################
         * #    Article Generation Start    #
         * ##################################
         * */

        $("#frmArticleGenerate").on("submit",function (e) {
            e.preventDefault();
       
            resetFormErrors('form#frmArticleGenerate');
             $(".note-editable").html('');
            let status     = $('#status').val();
            let author     = $('#author').val();
            let website    = $('input[name="website"]:checked').val();
            let title      = $('#frmArticleGenerate input[name="title"]').val();
            let topic      = $('#contentTopic').val();
            if(!topic){
                toast("{{ localize('Topic can not be  empty, Generate Keywords first') }}", 'error');
                return;
            }
            if(!title) {
                $('#text-input').val(topic);
            }

            let categories =  $('input[name="categories[]"]:checked').map(function(_, el) {
                return $(el).val();
            }).get();
            let tags       = $('#wp_tags').val();
           

            let formData   = $("#frmArticleGenerate").serialize() + "&website=" + website + "&author=" + author + "&status=" + status  + "&categories=" + categories+ "&tags=" + tags;
            let imagePath  = $('input[name="flexRadioDefaultImage"]:checked').val();
           if(imagePath) {

               var img = $('<img>').attr('src', imagePath).attr('alt', 'Description of Image');
               $(".note-editable").append(img);
           }
            
            TT.eventSource = new EventSource(`${URL_ARTICLES}?${formData}`, {
                withCredentials: true
            });

            TT.eventSource.onmessage = function(e) {
                $('.generateFinalContent').prop('disabled', true);
                $('.StopGenerate').prop('disabled', false);
                if (e.data == "[DONE]") {
                    toast("{{ localize('Article Generated Successfully') }}");
                    $('.generateFinalContent').prop('disabled', false);
                    $('.StopGenerate').prop('disabled', true);
                    $('.saveChange').prop('disabled', false);
                    TT.eventSource.close();
                    updateUserBalanceAfterGenerateContent("articles", engine);
                }
                else {
                    let txt = undefined;
                    try {
                        txt = geminiAi ? e.data : JSON.parse(e.data).choices[0].delta.content;

                        if (txt !== undefined) {
                            txt = txt.replace(/(?:\r\n|\r|\n)/g, '<br>');

                            let oldValue = $(".note-editable").html();

                            let value = oldValue + txt;
                            if(value.indexOf('****') !== -1) {
                                value = value.replace(/\*\*\*(.*?)\*\*\*/g,
                                    '<h6 class="mb-0 mt-3 h6">$1</h6>');
                            }
                            else if(value.indexOf('***') !== -1) {
                                value = value.replace(/\*\*\*(.*?)\*\*\*/g,
                                    '<h5 class="mb-0 mt-3 h5">$1</h5>');
                            }
                            else if(value.indexOf('**') !== -1) {
                                value = value.replace(/\*\*(.*?)\*\*/g,
                                    '<h4 class="mb-0 mt-3 h4">$1</h4>');
                            }

                             $(".note-editable").html(value);
                        }
                    } catch (e) {
                        console.log("Article Stream Error : ", e);
                    }
                }
            };

            TT.eventSource.onerror = function(e) {
                updateUserBalanceAfterGenerateContent("articles", engine);
                toast("{{ localize("Event source fired error") }}", "error");
                TT.eventSource.close();
            };
        });


        /**
         * Stop Generate
        * */
        $(document).on("click",".StopGenerate",function (e) {
            e.preventDefault();
            if (TT.eventSource) {
                TT.eventSource.close();
            }

            updateUserBalanceAfterGenerateContent("articles", engine);
        });

        $(document).on("click", ".saveChange", function(e) {
            e.preventDefault();
            let callParams = {};
            let title = $('#text-input').val();
            let id = $("#article_id").val();
            var url = "{{ route('admin.articles.update',":id") }}";
                url = url.replace(':id', id);
            let content_purpose = 'articles';
            loading('#saveChangeBtn', 'Saving...');
            let formData = {
                id  : id,
                title  : title,
                type : 'article',
                article : $('.note-editable').html()
            }
            
            callParams.type = "PUT";
            callParams.url  = url;
            callParams.data = formData;

            ajaxCall(callParams, function(result) {
                toast(result.message) ;
                resetLoading('#saveChangeBtn', 'Save Change');
            }, function(err, type, httpStatus) {
                toast(err.responseJSON.message); 
            });

            return false;
        });
        $(document).on("click", ".publishedToWordpress", function(e) {
            e.preventDefault();         
            
            let status     = $('#status').val();
            let author     = $('#author').val();
            let website    = $('input[name="website"]:checked').val();
            if(!website){
                toast("{{localize('Please setup for published post to wordpress')}}", "warning");
                return;
            }
            let categories =  $('input[name="categories[]"]:checked').map(function(_, el) {
                return $(el).val();
            }).get();
            let tags       = $('#wp_tags').val();
            loading('.publishedToWordpress', 'publishing...');
            let callParams = {};

            callParams.type = "POST";
            callParams.url = "{{ route('admin.wordpress-posts-published.store') }}";
            callParams.data = {
                article_id : $('#article_id').val(),
                status    : status,
                author    : author,
                website   : website,
                categories: categories,
                tags      : tags,
            };
            // callParams.processData  = false;
            // callParams.contentType  = false;
            ajaxCall(callParams, function(result) {
                resetLoading('.publishedToWordpress', 'Published');
                toast(result.message);
                $('#offcanvasPublishedToWordpress').offcanvas('hide');
                getDataList();
            }, function(err, type, httpStatus) {
                showFormError(err, '#offcanvasPublishedToWordpress');
                resetLoading('#frmActionBtn', 'Save');
            });

             return false;
        });
        $(document).on("click", ".selection-clicked-image", function(e) {
            e.preventDefault();
            let callParams = {};
            let id         = $("#article_id").val();
            let imagePath  = $(this).val();
            var url = "{{ route('admin.articles.update',":id") }}";
                url = url.replace(':id', id);
            let formData = {
                id  : id,
                type : 'image',
                selected_image : imagePath,
            }
            console.log(formData);
            callParams.type = "PUT";
            callParams.url  = url;
            callParams.data = formData;

            ajaxCall(callParams, function(result) {
                toast("{{localize('Image Selected Successfully')}}") ;
            
            }, function(err, type, httpStatus) {
                toast(err.responseJSON.message); 
            });

            return false;
        });
        /**
         * ##################################
         * #    Article Generation END      #
         * ##################################
         * */
         $("#addSendMailForm").submit(function(e) {
            e.preventDefault();
            resetFormErrors('form#addSendMailForm');
            loading('#frmActionBtn', 'Sending...');
            let article_id = $("#article_id").val();
            if(!article_id){
                toast('{{ localize('The article has not been generated yet') }}', 'error');
                $('#addSendMailSidebar').offcanvas('hide');
                resetLoading('#frmActionBtn', 'Send');
                return;
            }
            $('#email_article_id').val(article_id);

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

        $(document).on('click', '.downloadChatBtn', function(e) {
            let type = $(this).data('download_type');
            let article_id = $("#article_id").val();
            let data = {type:type, id:id};
            let url  =  `{{ route('admin.download-content') }}?article_id=${article_id}&type=${type}`;
            window.open(url, '_blank'); // Open URL in a new tab
        });
    </script>
@endsection
