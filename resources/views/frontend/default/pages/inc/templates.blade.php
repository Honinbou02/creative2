@foreach ($templates as $template)

    <div class="col-md-6 col-xl-3">
        <div class="p-6 rounded-3 wt_card_style h-100 d-flex flex-column">
            <span class="d-inline-block mb-5">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="48" height="48" rx="24" fill="white" fill-opacity="0.1"/>
                    <path d="M23.4858 21.3706C23.6506 20.8765 24.3495 20.8765 24.5142 21.3706L25.4824 24.2752C25.914 25.57 26.93 26.586 28.2247 27.0176L31.1294 27.9858C31.6235 28.1505 31.6235 28.8494 31.1294 29.0142L28.2247 29.9824C26.93 30.414 25.914 31.43 25.4824 32.7247L24.5142 35.6294C24.3495 36.1235 23.6506 36.1235 23.4858 35.6294L22.5176 32.7247C22.086 31.4299 21.07 30.414 19.7753 29.9824L16.8706 29.0142C16.3765 28.8494 16.3765 28.1505 16.8706 27.9858L19.7753 27.0176C21.07 26.586 22.086 25.57 22.5176 24.2753L23.4858 21.3706Z" fill="url(#paint0_linear_1724_7564)"/>
                    <path d="M17.6915 13.7224C17.7903 13.4259 18.2097 13.4259 18.3085 13.7224L18.8895 15.4652C19.1484 16.242 19.758 16.8516 20.5348 17.1105L22.2777 17.6915C22.5741 17.7903 22.5741 18.2097 22.2777 18.3085L20.5349 18.8894C19.758 19.1484 19.1484 19.758 18.8895 20.5348L18.3085 22.2776C18.2097 22.5741 17.7903 22.5741 17.6915 22.2776L17.1106 20.5348C16.8516 19.758 16.242 19.1484 15.4652 18.8894L13.7224 18.3085C13.4259 18.2097 13.4259 17.7903 13.7224 17.6915L15.4652 17.1105C16.242 16.8516 16.8516 16.242 17.1106 15.4652L17.6915 13.7224Z" fill="url(#paint1_linear_1724_7564)"/>
                    <path d="M28.2943 12.1482C28.3602 11.9506 28.6398 11.9506 28.7057 12.1482L29.093 13.3101C29.2656 13.828 29.672 14.2344 30.1899 14.407L31.3518 14.7943C31.5494 14.8602 31.5494 15.1398 31.3518 15.2057L30.1899 15.593C29.672 15.7656 29.2656 16.172 29.093 16.6899L28.7057 17.8518C28.6398 18.0494 28.3602 18.0494 28.2943 17.8518L27.907 16.6899C27.7344 16.172 27.328 15.7656 26.8101 15.593L25.6483 15.2057C25.4506 15.1398 25.4506 14.8602 25.6483 14.7943L26.8101 14.407C27.328 14.2344 27.7344 13.828 27.9071 13.3101L28.2943 12.1482Z" fill="url(#paint2_linear_1724_7564)"/>
                    <defs>
                    <linearGradient id="paint0_linear_1724_7564" x1="13.5" y1="24" x2="31.5" y2="24" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#202877"/>
                    <stop offset="0.360189" stop-color="#372E95"/>
                    <stop offset="0.536415" stop-color="#5331B1"/>
                    <stop offset="1" stop-color="#9629E6"/>
                    </linearGradient>
                    <linearGradient id="paint1_linear_1724_7564" x1="13.5" y1="24" x2="31.5" y2="24" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#202877"/>
                    <stop offset="0.360189" stop-color="#372E95"/>
                    <stop offset="0.536415" stop-color="#5331B1"/>
                    <stop offset="1" stop-color="#9629E6"/>
                    </linearGradient>
                    <linearGradient id="paint2_linear_1724_7564" x1="13.5" y1="24" x2="31.5" y2="24" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#202877"/>
                    <stop offset="0.360189" stop-color="#372E95"/>
                    <stop offset="0.536415" stop-color="#5331B1"/>
                    <stop offset="1" stop-color="#9629E6"/>
                    </linearGradient>
                    </defs>
                </svg>                                        
            </span>
            <h6 class="text-white fs-16 mb-3">{{ $template->template_name }}</h6>
            <p class="fs-14 mb-5">{{ $template->description }}</p>
            <p class="mb-0 mt-auto small">{{$template->template_word_counts()}} {{ localize('Words Generated') }}</p>
        </div>
    </div>
@endforeach
