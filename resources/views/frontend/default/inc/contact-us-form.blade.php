<!-- Form -->
<section class="form_support pt-60 pb-120">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="d-inline-block text-center px-5 py-1 rounded-pill border border-1 border-primary mb-4">
                    <p class="fs-14 fw-normal mb-0">{{ localize("Get in touch") }}</p>
                </div>
                <h2 class="fs-48 mb-3">{{ localize("We’ve Got you Covered 24/7 Support") }}</h2>
                <p class="mb-5">{{ localize("We are loved from thousands customers worldwide and get trusted from big companies.") }}</p>
                <div class="d-flex align-items-center gap-3">
                        <span>
    						<svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
    							<rect width="56" height="56" rx="28" fill="white" fill-opacity="0.05"/>
    							<path d="M39.6742 22.1665L29.2092 28.8165C28.849 29.0422 28.4325 29.1618 28.0075 29.1618C27.5825 29.1618 27.166 29.0422 26.8058 28.8165L16.3408 22.1665M18.6742 18.6665H37.3408C38.6295 18.6665 39.6742 19.7112 39.6742 20.9998V34.9998C39.6742 36.2885 38.6295 37.3332 37.3408 37.3332H18.6742C17.3855 37.3332 16.3408 36.2885 16.3408 34.9998V20.9998C16.3408 19.7112 17.3855 18.6665 18.6742 18.6665Z" stroke="url(#paint0_linear_2592_3733)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
    							<defs>
    							<linearGradient id="paint0_linear_2592_3733" x1="16.3408" y1="27.9998" x2="39.6742" y2="27.9998" gradientUnits="userSpaceOnUse">
    							<stop stop-color="#805AF9"/>
    							<stop offset="1" stop-color="#6632F8"/>
    							</linearGradient>
    							</defs>
    						</svg>
    					</span>
                    <div>
                        <a href="" class="text-body fs-18 text-decoration-none">{{ getSetting('contact_email') }}</a>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3 mt-4">
                    <span>
                            <svg width="56" height="56" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="40" height="40" rx="20" fill="white" fill-opacity="0.05"/>
                                <path d="M21.7136 11.6666C23.4121 11.8456 24.9987 12.5989 26.211 13.8021C27.4232 15.0052 28.1885 16.5861 28.3802 18.2833M21.7136 14.9999C22.5332 15.1615 23.2852 15.5658 23.8722 16.1602C24.4592 16.7546 24.8539 17.5117 25.0052 18.3333M28.3386 24.0999V26.5999C28.3395 26.832 28.292 27.0617 28.199 27.2744C28.106 27.487 27.9697 27.6779 27.7986 27.8348C27.6276 27.9917 27.4257 28.1112 27.2059 28.1855C26.986 28.2599 26.753 28.2875 26.5219 28.2666C23.9576 27.988 21.4944 27.1117 19.3302 25.7083C17.3168 24.4288 15.6097 22.7217 14.3302 20.7083C12.9219 18.5343 12.0454 16.0591 11.7719 13.4833C11.7511 13.2528 11.7785 13.0206 11.8523 12.8013C11.9262 12.582 12.0449 12.3805 12.2009 12.2096C12.3569 12.0387 12.5467 11.9022 12.7584 11.8087C12.97 11.7152 13.1989 11.6668 13.4302 11.6666H15.9302C16.3347 11.6626 16.7267 11.8058 17.0334 12.0695C17.34 12.3332 17.5403 12.6995 17.5969 13.0999C17.7024 13.9 17.8981 14.6855 18.1802 15.4416C18.2924 15.7399 18.3166 16.064 18.2502 16.3757C18.1837 16.6873 18.0293 16.9733 17.8052 17.1999L16.7469 18.2583C17.9332 20.3445 19.6606 22.072 21.7469 23.2583L22.8052 22.1999C23.0318 21.9759 23.3179 21.8215 23.6295 21.755C23.9411 21.6885 24.2653 21.7128 24.5636 21.8249C25.3196 22.107 26.1052 22.3027 26.9052 22.4083C27.31 22.4654 27.6797 22.6693 27.944 22.9812C28.2083 23.2931 28.3487 23.6912 28.3386 24.0999Z" stroke="url(#paint0_linear_2603_29232)" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                <defs>
                                <linearGradient id="paint0_linear_2603_29232" x1="11.7651" y1="19.9699" x2="28.3802" y2="19.9699" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#805AF9"/>
                                <stop offset="1" stop-color="#6632F8"/>
                                </linearGradient>
                                </defs>
                            </svg>													
                        </span>
                    <div>
                        <a href="" class="text-body fs-18 text-decoration-none">{{ getSetting('contact_phone') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="wt_card_style_nhover p-7 rounded-3">
                    <form action="{{ route('contact-us.store') }}" class="contact-us-form" id="contact-us-form">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <label class="text-white text-opacity-75 mb-2">{{ localize("Name") }} <span class="text-danger">*</span> </label>
                                <input type="text" name="name"  required autocomplete="name" class="form-control px-4 py-3 wt_card_style_nhover fs-14" placeholder="Enter Name">
                            </div>
                            <div class="col-lg-6">
                                <label class="text-white text-opacity-75 mb-2">{{ localize("Phone") }} <span class="text-danger">*</span> </label>
                                <input type="text" name="phone" required autocomplete="phone" class="form-control px-4 py-3 wt_card_style_nhover fs-14" placeholder="Enter Number">
                            </div>
                            <div class="col-lg-6">
                                <label class="text-white text-opacity-75 mb-2">{{ localize("Email") }} <span class="text-danger">*</span> </label>
                                <input type="email" name="email" required autocomplete="email" class="form-control px-4 py-3 wt_card_style_nhover fs-14" placeholder="Your Mail">
                            </div>
                            <div class="col-lg-12">
                                <label class="text-white text-opacity-75 mb-2">{{ localize("Message") }} <span class="text-danger">*</span> </label>
                                <textarea class="textarea-control form-control px-4 py-3 wt_card_style_nhover fs-14" placeholder="Message" required autocomplete="message" name="message"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn bg-gradient-1 rounded-pill px-3 py-2 fs-14 d-inline-flex align-items-center gap-2 mt-5 text-white text-opacity-75">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="24" height="24" rx="12" fill="white"></rect>
                                <path d="M6.4391 11.6526C6.4391 11.6526 12.4482 11.6526 17.8677 11.6526M17.8677 11.6526C13.9526 11.6526 13.23 7.65259 13.23 7.65259M17.8677 11.6526C13.9526 11.6526 13.23 15.6526 13.23 15.6526" stroke="url(#paint0_linear_1722_4739)" stroke-width="1.1"></path>
                                <defs>
                                    <linearGradient id="paint0_linear_1722_4739" x1="12.1534" y1="7.65259" x2="12.1534" y2="15.6526" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#805AF9"></stop>
                                        <stop offset="1" stop-color="#6632F8"></stop>
                                    </linearGradient>
                                </defs>
                            </svg>
                            {{ localize("Get In Touch") }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Form -->