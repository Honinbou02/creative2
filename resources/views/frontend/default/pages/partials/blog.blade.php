@if($blog_1 || $blog_2 || $blog_3 || $blog_4)
<section id="blog">
    <div class="price-wrapper px-4 pt-120 pb-120 bg-gray-100 rounded-3 position-relative z-1">
        <div class="container">
            <div class="text-center mb-10">
                <h2 class="text-dark mb-0">{{localize('All Blog')}}</h2>
            </div>
            <div class="row g-4">
                <div class="col-xl-7">
                    <div class="row g-4">
                        @if($blog_1)
                        <div class="col-md-6">
                            <div class="bg-white p-8 rounded-4">
                                <div class="d-flex align-items-center justify-content-between gap-3 mb-8">
                                    <div class="px-4 py-1 rounded-3 border border-dark border-opacity-25 d-inline-flex align-items-center gap-2">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.7139 16.4158C11.8642 15.6238 13.2579 15.1605 14.7615 15.1605C15.438 15.1605 16.0914 15.2542 16.71 15.429C16.9253 15.4898 17.1567 15.4463 17.3352 15.3115C17.5138 15.1765 17.6186 14.9659 17.6186 14.7423V4.27662C17.6186 3.95732 17.4063 3.67688 17.0987 3.58998C16.3549 3.37981 15.5707 3.26758 14.7615 3.26758C13.2982 3.26758 11.9196 3.63434 10.7139 4.28073V16.4158Z" fill="#63687A" />
                                            <path d="M9.28562 4.28073C8.07987 3.63434 6.70124 3.26758 5.238 3.26758C4.42875 3.26758 3.64456 3.37981 2.90075 3.58998C2.59319 3.67688 2.38086 3.95732 2.38086 4.27662V14.7423C2.38086 14.9659 2.48575 15.1765 2.66425 15.3115C2.84274 15.4463 3.07419 15.4898 3.28954 15.429C3.90811 15.2542 4.5615 15.1605 5.238 15.1605C6.74166 15.1605 8.13522 15.6238 9.28562 16.4158V4.28073Z" fill="#63687A" />
                                        </svg>
                                        <p class="text-body-2 fs-14 fw-medium mb-0 ">{{ $blog_1 ? $blog_1->category->category_name : 'not found'}}</p>
                                    </div>
                                    <span class="w-6 h-6 flex-shrink-0 bg-dark-subtle rounded-circle d-flex align-items-center justify-content-center">
                                        <span class="text-black fs-14 -rotate-25"><i class="las la-arrow-right"></i></span>
                                    </span>
                                </div>
                                <img src="{{ avatarImage($blog_1->blog_image)}}" alt="image" class="img-fluid w-100 mb-6">
                                <a href="{{route('blog', $blog_1->slug)}}" class="text-decoration-none">
                                    <h6 class="text-dark fs-20 mb-4">{{$blog_1->title}}</h6>
                                </a>
                                <p class="text-body-2 mb-0">{{$blog_1->short_description}}</p>
                            </div>
                        </div>
                        @endif
                        @if($blog_2)
                        <div class="col-md-6">
                            <div class="bg-primary p-8 rounded-4">
                                <div class="d-flex align-items-center justify-content-between gap-3 mb-8">
                                    <div class="px-4 py-1 rounded-3 border border-white border-opacity-25 d-inline-flex align-items-center gap-2">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.7139 16.4158C11.8642 15.6238 13.2579 15.1605 14.7615 15.1605C15.438 15.1605 16.0914 15.2542 16.71 15.429C16.9253 15.4898 17.1567 15.4463 17.3352 15.3115C17.5138 15.1765 17.6186 14.9659 17.6186 14.7423V4.27662C17.6186 3.95732 17.4063 3.67688 17.0987 3.58998C16.3549 3.37981 15.5707 3.26758 14.7615 3.26758C13.2982 3.26758 11.9196 3.63434 10.7139 4.28073V16.4158Z" fill="white" />
                                            <path d="M9.28562 4.28073C8.07987 3.63434 6.70124 3.26758 5.238 3.26758C4.42875 3.26758 3.64456 3.37981 2.90075 3.58998C2.59319 3.67688 2.38086 3.95732 2.38086 4.27662V14.7423C2.38086 14.9659 2.48575 15.1765 2.66425 15.3115C2.84274 15.4463 3.07419 15.4898 3.28954 15.429C3.90811 15.2542 4.5615 15.1605 5.238 15.1605C6.74166 15.1605 8.13522 15.6238 9.28562 16.4158V4.28073Z" fill="white" />
                                        </svg>
                                        <p class="text-white fs-14 fw-medium mb-0 ">{{$blog_2->category->category_name}}</p>
                                    </div>
                                    <span class="w-6 h-6 flex-shrink-0 bg-dark-subtle rounded-circle d-flex align-items-center justify-content-center">
                                        <span class="text-black fs-14 -rotate-25"><i class="las la-arrow-right"></i></span>
                                    </span>
                                </div>
                                <img src="{{avatarImage($blog_2->blog_image)}}" alt="image" class="img-fluid w-100 mb-6">
                                <a href="{{route('blog', $blog_2->slug)}}" class="text-decoration-none">
                                    <h6 class="text-white fs-20 mb-4">{{$blog_2->title}}</h6>
                                </a>
                                <p class="text-white mb-0">{{$blog_2->short_description}}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-5">
                    @if($blog_3)
                    <div class="bg-white p-8 rounded-4">
                        <div class="d-flex align-items-center justify-content-between gap-3 mb-5">
                            <div class="px-4 py-1 rounded-3 border border-dark border-opacity-25 d-inline-flex align-items-center gap-2">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.7139 16.4158C11.8642 15.6238 13.2579 15.1605 14.7615 15.1605C15.438 15.1605 16.0914 15.2542 16.71 15.429C16.9253 15.4898 17.1567 15.4463 17.3352 15.3115C17.5138 15.1765 17.6186 14.9659 17.6186 14.7423V4.27662C17.6186 3.95732 17.4063 3.67688 17.0987 3.58998C16.3549 3.37981 15.5707 3.26758 14.7615 3.26758C13.2982 3.26758 11.9196 3.63434 10.7139 4.28073V16.4158Z" fill="#63687A" />
                                    <path d="M9.28562 4.28073C8.07987 3.63434 6.70124 3.26758 5.238 3.26758C4.42875 3.26758 3.64456 3.37981 2.90075 3.58998C2.59319 3.67688 2.38086 3.95732 2.38086 4.27662V14.7423C2.38086 14.9659 2.48575 15.1765 2.66425 15.3115C2.84274 15.4463 3.07419 15.4898 3.28954 15.429C3.90811 15.2542 4.5615 15.1605 5.238 15.1605C6.74166 15.1605 8.13522 15.6238 9.28562 16.4158V4.28073Z" fill="#63687A" />
                                </svg>
                                <p class="text-body-2 fs-14 fw-medium mb-0 ">{{$blog_3->category->category_name}}</p>
                            </div>
                            <span class="w-6 h-6 flex-shrink-0 bg-dark-subtle rounded-circle d-flex align-items-center justify-content-center">
                                <span class="text-black fs-14 -rotate-25"><i class="las la-arrow-right"></i></span>
                            </span>
                        </div>
                        <a href="{{route('blog', $blog_3->slug)}}" class="text-decoration-none">
                            <h6 class="text-dark fs-20 mb-4">{{$blog_3->title}}</h6>
                        </a>
                        <p class="text-body-2 mb-0">{{$blog_3->short_description}}</p>
                    </div>
                    @endif
                    @if($blog_4)
                    <div class="bg-white p-8 rounded-4 mt-5">
                        <div class="d-flex align-items-center justify-content-between gap-3 mb-5">
                            <div class="px-4 py-1 rounded-3 border border-dark border-opacity-25 d-inline-flex align-items-center gap-2">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.7139 16.4158C11.8642 15.6238 13.2579 15.1605 14.7615 15.1605C15.438 15.1605 16.0914 15.2542 16.71 15.429C16.9253 15.4898 17.1567 15.4463 17.3352 15.3115C17.5138 15.1765 17.6186 14.9659 17.6186 14.7423V4.27662C17.6186 3.95732 17.4063 3.67688 17.0987 3.58998C16.3549 3.37981 15.5707 3.26758 14.7615 3.26758C13.2982 3.26758 11.9196 3.63434 10.7139 4.28073V16.4158Z" fill="#63687A" />
                                    <path d="M9.28562 4.28073C8.07987 3.63434 6.70124 3.26758 5.238 3.26758C4.42875 3.26758 3.64456 3.37981 2.90075 3.58998C2.59319 3.67688 2.38086 3.95732 2.38086 4.27662V14.7423C2.38086 14.9659 2.48575 15.1765 2.66425 15.3115C2.84274 15.4463 3.07419 15.4898 3.28954 15.429C3.90811 15.2542 4.5615 15.1605 5.238 15.1605C6.74166 15.1605 8.13522 15.6238 9.28562 16.4158V4.28073Z" fill="#63687A" />
                                </svg>
                                <p class="text-body-2 fs-14 fw-medium mb-0 ">{{$blog_4->category->category_name}}</p>
                            </div>
                            <span class="w-6 h-6 flex-shrink-0 bg-dark-subtle rounded-circle d-flex align-items-center justify-content-center">
                                <span class="text-black fs-14 -rotate-25"><i class="las la-arrow-right"></i></span>
                            </span>
                        </div>
                        <a href="{{route('blog', $blog_3->slug)}}" class="text-decoration-none">
                            <h6 class="text-dark fs-20 mb-4">{{$blog_4->title}}</h6>
                        </a>
                        <p class="text-body-2 mb-0">{{$blog_4->short_description}}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif