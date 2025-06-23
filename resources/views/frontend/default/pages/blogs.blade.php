@extends('frontend.default.layouts.default')

@section('title')
    {{ localize('Blogs') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <!-- Breadcrumb -->
    <div class="breadcrumb_area pt-120">
        <div class="container">
            <div class="d-inline-block text-center px-4 py-2 rounded-pill bg-white bg-opacity-10 border border-1 border-white border-opacity-25 mb-4">
                <div class="d-flex align-items-center gap-2">
                    <a href="index.html" class="text-decoration-none text-white fs-12 fw-bold">{{localize('Home')}}</a>
                    <span class="text-white fs-12 fw-bold"><i class="las la-minus"></i></span>
                    <a href="index.html" class="text-decoration-none text-white fs-12 fw-bold">{{localize('Blog Listing')}}</a>
                </div>
            </div>
            <h2 class="text-white fs-48 mb-0">{{localize('Blog Listing')}}</h2>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <!-- Blog Slider -->
    <div class="pt-60 pb-60">
        <div class="container">
            <div class="blog_slider_wrapper swiper pb-60">
                <div class="swiper-wrapper">
                    @foreach ($latestLimit as $blog)  
                        <div class="swiper-slide">
                            <div class="blog_slider_item animation-gradient rounded-3 position-relative overflow-hidden">
                                <div class="brige bg-gradient-1">
                                    <h6 class="text-white fs-16 mb-0">{{localize('Latest News')}}</h6>
                                </div>
                                <div class="feature-1-content p-5 rounded-3">
                                    <div class="row align-items-center g-4">
                                        <div class="col-lg-5">
                                            <img src="{{avatarImage($blog->blog_image)}}" alt="Image" class="img-fluid w-100">
                                        </div>
                                        <div class="col-lg-7">
                                            <div>
                                                <div class="d-flex align-items-center gap-2 mb-3">
                                                    <span>
                                                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M9.66797 19.5312V11.5332H8.71875C8.09766 11.8672 7.35352 12.3066 6.75 12.7402V13.7832C7.3125 13.3965 8.20312 12.8516 8.63672 12.6172H8.6543V19.5312H9.66797Z" fill="white"/>
                                                            <path d="M11.4492 17.5742C11.5195 18.5352 12.3398 19.6836 14.0039 19.6836C15.8906 19.6836 17.0039 18.084 17.0039 15.377C17.0039 12.4766 15.832 11.375 14.0742 11.375C12.6855 11.375 11.3789 12.3828 11.3789 14.0879C11.3789 15.8281 12.6152 16.7422 13.8926 16.7422C15.0117 16.7422 15.7383 16.1797 15.9668 15.5586H16.0078C16.002 17.5332 15.3164 18.8047 14.0508 18.8047C13.0547 18.8047 12.5391 18.1309 12.4746 17.5742H11.4492ZM15.8789 14.0996C15.8789 15.1426 15.041 15.8691 14.1035 15.8691C13.2012 15.8691 12.3867 15.2949 12.3867 14.0703C12.3867 12.834 13.2598 12.2539 14.1387 12.2539C15.0879 12.2539 15.8789 12.8516 15.8789 14.0996Z" fill="white"/>
                                                            <path d="M5.25 0.5C5.66421 0.5 6 0.835786 6 1.25V2H18V1.25C18 0.835786 18.3358 0.5 18.75 0.5C19.1642 0.5 19.5 0.835786 19.5 1.25V2H21C22.6569 2 24 3.34315 24 5V21.5C24 23.1569 22.6569 24.5 21 24.5H3C1.34315 24.5 0 23.1569 0 21.5V5C0 3.34315 1.34315 2 3 2H4.5V1.25C4.5 0.835786 4.83579 0.5 5.25 0.5ZM3 3.5C2.17157 3.5 1.5 4.17157 1.5 5V21.5C1.5 22.3284 2.17157 23 3 23H21C21.8284 23 22.5 22.3284 22.5 21.5V5C22.5 4.17157 21.8284 3.5 21 3.5H3Z" fill="white"/>
                                                            <path d="M3.75 6.5C3.75 6.08579 4.08579 5.75 4.5 5.75H19.5C19.9142 5.75 20.25 6.08579 20.25 6.5V8C20.25 8.41421 19.9142 8.75 19.5 8.75H4.5C4.08579 8.75 3.75 8.41421 3.75 8V6.5Z" fill="white"/>
                                                        </svg>                                        
                                                    </span>
                                                    <p class="fw-medium mb-0 mt-1">{{dateFormat($blog->created_at)}}</p>
                                                </div>
                                                <a href="" class="text-decoration-none">
                                                    <h3 class="text-white max-text-28 mb-5">{{$blog->title}}</h3>
                                                </a>
                                                <p class="mb-5">{{$blog->short_description}}</p>
                                                <a class="btn btn-lg bg-gradient-1 border-0 fw-semibold rounded-pill d-inline-flex align-items-center gap-2" href="{{route('blog', $blog->slug)}}" role="button">{{localize('Explore More')}}
                                                    <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M0.357144 7C0.357144 7 9.37073 7 17.5 7M17.5 7C11.6275 7 10.5435 1 10.5435 1M17.5 7C11.6275 7 10.5435 13 10.5435 13" stroke="white" stroke-width="1.6"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                 
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
    <!-- /Blog Slider -->

    <!-- Blog List -->
    <div class="pt-60 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center mb-40">
                        <h2 class="text-white fs-48 mb-3">{{localize('Insight Resource')}}</h2>
                        <p class="mb-0">{{localize('When new material doesn’t quite click for a student, several factors might be contributing to the disconnect. In particular, learning gaps are a common culprit.')}}</p>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                @foreach ($blogs as $blog)  

                <div class="col-md-6 col-lg-4">
                    <div class="blog_list_item bg-gradient-dark rounded-4 overflow-hidden h-100">
                        <div class="blog_thumb">
                            <img src="{{avatarImage($blog->blog_image)}}" alt="Image" class="img-fluid w-100">
                        </div>
                        <div class="p-6">
                            <div class="d-flex align-items-center gap-2 mb-4">
                                <span>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.66797 19.5312V11.5332H8.71875C8.09766 11.8672 7.35352 12.3066 6.75 12.7402V13.7832C7.3125 13.3965 8.20312 12.8516 8.63672 12.6172H8.6543V19.5312H9.66797Z" fill="white"></path>
                                        <path d="M11.4492 17.5742C11.5195 18.5352 12.3398 19.6836 14.0039 19.6836C15.8906 19.6836 17.0039 18.084 17.0039 15.377C17.0039 12.4766 15.832 11.375 14.0742 11.375C12.6855 11.375 11.3789 12.3828 11.3789 14.0879C11.3789 15.8281 12.6152 16.7422 13.8926 16.7422C15.0117 16.7422 15.7383 16.1797 15.9668 15.5586H16.0078C16.002 17.5332 15.3164 18.8047 14.0508 18.8047C13.0547 18.8047 12.5391 18.1309 12.4746 17.5742H11.4492ZM15.8789 14.0996C15.8789 15.1426 15.041 15.8691 14.1035 15.8691C13.2012 15.8691 12.3867 15.2949 12.3867 14.0703C12.3867 12.834 13.2598 12.2539 14.1387 12.2539C15.0879 12.2539 15.8789 12.8516 15.8789 14.0996Z" fill="white"></path>
                                        <path d="M5.25 0.5C5.66421 0.5 6 0.835786 6 1.25V2H18V1.25C18 0.835786 18.3358 0.5 18.75 0.5C19.1642 0.5 19.5 0.835786 19.5 1.25V2H21C22.6569 2 24 3.34315 24 5V21.5C24 23.1569 22.6569 24.5 21 24.5H3C1.34315 24.5 0 23.1569 0 21.5V5C0 3.34315 1.34315 2 3 2H4.5V1.25C4.5 0.835786 4.83579 0.5 5.25 0.5ZM3 3.5C2.17157 3.5 1.5 4.17157 1.5 5V21.5C1.5 22.3284 2.17157 23 3 23H21C21.8284 23 22.5 22.3284 22.5 21.5V5C22.5 4.17157 21.8284 3.5 21 3.5H3Z" fill="white"></path>
                                        <path d="M3.75 6.5C3.75 6.08579 4.08579 5.75 4.5 5.75H19.5C19.9142 5.75 20.25 6.08579 20.25 6.5V8C20.25 8.41421 19.9142 8.75 19.5 8.75H4.5C4.08579 8.75 3.75 8.41421 3.75 8V6.5Z" fill="white"></path>
                                    </svg>                                        
                                </span>
                                <p class="fw-medium mb-0 mt-1">{{dateFormat($blog->created_at)}}</p>
                            </div>
                            <a href="" class="text-decoration-none">
                                <h6 class="text-white fs-20 mb-4">{{$blog->title}}</h6>
                            </a>
                            <p class="max-text-32 mb-3">{{$blog->short_description}}</p>
                            <a class="btn border-0 fw-semibold rounded-pill d-inline-flex align-items-center gap-2 px-0" href="{{route('blog', $blog->slug)}}" role="button">{{localize('Explore More')}}
                                <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.357144 7C0.357144 7 9.37073 7 17.5 7M17.5 7C11.6275 7 10.5435 1 10.5435 1M17.5 7C11.6275 7 10.5435 13 10.5435 13" stroke="white" stroke-width="1.6"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- /Blog List -->
@endsection
