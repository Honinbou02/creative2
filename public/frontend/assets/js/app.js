/*================
 Template Name: 
 Description: 
 Version: 1.0
 Author: https://themeforest.net/user/themetags
=======================*/
"use strict";

document.addEventListener("DOMContentLoaded", function () {
  const body = document.querySelector("body");

  // Slide Up
  const slideUp = (target, duration = 500) => {
    target.style.transitionProperty = "height, margin, padding";
    target.style.transitionDuration = duration + "ms";
    target.style.boxSizing = "border-box";
    target.style.height = target.offsetHeight + "px";
    target.offsetHeight;
    target.style.overflow = "hidden";
    target.style.height = 0;
    target.style.paddingTop = 0;
    target.style.paddingBottom = 0;
    target.style.marginTop = 0;
    target.style.marginBottom = 0;
    window.setTimeout(() => {
      target.style.display = "none";
      target.style.removeProperty("height");
      target.style.removeProperty("padding-top");
      target.style.removeProperty("padding-bottom");
      target.style.removeProperty("margin-top");
      target.style.removeProperty("margin-bottom");
      target.style.removeProperty("overflow");
      target.style.removeProperty("transition-duration");
      target.style.removeProperty("transition-property");
    }, duration);
  };
  // Slide Down
  const slideDown = (target, duration = 500) => {
    target.style.removeProperty("display");
    let display = window.getComputedStyle(target).display;
    if (display === "none") display = "block";
    target.style.display = display;
    let height = target.offsetHeight;
    target.style.overflow = "hidden";
    target.style.height = 0;
    target.style.paddingTop = 0;
    target.style.paddingBottom = 0;
    target.style.marginTop = 0;
    target.style.marginBottom = 0;
    target.offsetHeight;
    target.style.boxSizing = "border-box";
    target.style.transitionProperty = "height, margin, padding";
    target.style.transitionDuration = duration + "ms";
    target.style.height = height + "px";
    target.style.removeProperty("padding-top");
    target.style.removeProperty("padding-bottom");
    target.style.removeProperty("margin-top");
    target.style.removeProperty("margin-bottom");
    window.setTimeout(() => {
      target.style.removeProperty("height");
      target.style.removeProperty("overflow");
      target.style.removeProperty("transition-duration");
      target.style.removeProperty("transition-property");
    }, duration);
  };

  // Slide Toggle
  const slideToggle = (target, duration = 500) => {
    if (target.attributes.style === undefined || target.style.display === "none") {
      return slideDown(target, duration);
    } else {
      return slideUp(target, duration);
    }
  };

  // Primary Menu
  const mdScreen = "(max-width: 991px)";
  const mdScreenSize = window.matchMedia(mdScreen);
  const containSub1 = document.querySelectorAll(".contain-sub-1 > a");
  const containMegaMenu = document.querySelectorAll(".contain-mega-menu > a");
  const mdScreenSizeActive = screen => {
    if (screen.matches) {
      // if menu has sub
      containSub1.forEach(e => {
        e.addEventListener("click", el => {
          el.preventDefault();
          el.stopPropagation();
          el.target.classList.toggle("active");
          const menuSub = e.nextElementSibling;
          slideToggle(menuSub, 500);
        });
      });
      // if menu has sub end

      // if menu has mega menu
      containMegaMenu.forEach(e => {
        e.addEventListener("click", el => {
          el.preventDefault();
          el.stopPropagation();
          el.target.classList.toggle("active");
          const menuSub = e.nextElementSibling;
          slideToggle(menuSub, 500);
        });
      });
      // if menu has mega menu end
    } else {
      containSub1.forEach(e => {
        e.addEventListener("click", el => {
          el.preventDefault();
        });
      });
      containMegaMenu.forEach(e => {
        e.addEventListener("click", el => {
          el.preventDefault();
        });
      });
    }
  };
  mdScreenSize.addEventListener("change", e => {
    if (e.matches) {
      window.location.reload();
      mdScreenSizeActive(e);
    } else {
      mdScreenSize.removeEventListener("change", e => {
        mdScreenSizeActive(e);
      });
      window.location.reload();
    }
  });
  mdScreenSizeActive(mdScreenSize);

  // Sticky Header
  window.addEventListener("scroll", () => {
    const fixedHeader = document.querySelector(".navbar-overlay");
    const navbarTop = document.querySelector(".navbar-top");
    if (navbarTop) {
      const navTop = navbarTop.offsetHeight;
      const scrolled = window.scrollY;
      const navbarTopRemove = () => {
        if (scrolled > navTop) {
          body.classList.add("navbar-top-toggle");
        } else if (scrolled < navTop) {
          body.classList.remove("navbar-top-toggle");
        } else {
          body.classList.remove("navbar-top-toggle");
        }
      };
      navbarTopRemove();
    }
    if (fixedHeader) {
      const headerTop = fixedHeader.offsetHeight;
      const scrolled = window.scrollY;
      const headerFixed = () => {
        if (scrolled > headerTop) {
          body.classList.add("navbar-sticky-init");
        } else if (scrolled < headerTop) {
          body.classList.remove("navbar-sticky-init");
        } else {
          body.classList.remove("navbar-sticky-init");
        }
      };
      setTimeout(headerFixed, 100);
    }
  });

  // Feedback Slider
  var feedbackSlider = new Swiper(".feedback-slider", {
    autoplay: true,
    loop: true,
    speed: 700,
    spaceBetween: 24,
    centeredSlides: false,
    pagination: {
      el: ".itc-testimonial-slide-dots",
      clickable: true
    },
    navigation: {
      nextEl: ".feedback-button-next",
      prevEl: ".feedback-button-prev"
    },
    breakpoints: {
      0: {
        slidesPerView: 1
      },
      768: {
        slidesPerView: 2
      },
      1200: {
        slidesPerView: 3
      }
    }
  });

  // Feedback Slider
  var feedbackNew = new Swiper(".feedback-new", {
    autoplay: true,
    loop: true,
    speed: 700,
    spaceBetween: 0,
    centeredSlides: false,
    breakpoints: {
      0: {
        slidesPerView: 1
      }
    }
  });

  // Blog
  var blogSlider = new Swiper(".blog_slider_wrapper", {
    autoplay: true,
    loop: true,
    speed: 700,
    spaceBetween: 0,
    centeredSlides: false,
    pagination: {
      el: '.swiper-pagination',
      clickable: true
    },
    breakpoints: {
      0: {
        slidesPerView: 1
      }
    }
  });

  // Feedback 3 Slider
  const feedbackSlider3 = document.querySelector(".feedback-3-slider__init");
  if (feedbackSlider3) {
    new Swiper(feedbackSlider3, {
      autoplay: true,
      loop: true,
      slidesPerView: 1,
      centeredSlides: true,
      spaceBetween: 16,
      pagination: {
        el: ".feedback-3-slider__pagination",
        clickable: true
      },
      breakpoints: {
        992: {
          slidesPerView: 3
        }
      }
    });
  }

  // Feedback Slider 4
  var feedbackSliderFour = new Swiper(".feedback-slider-4", {
    autoplay: true,
    loop: true,
    speed: 700,
    spaceBetween: 24,
    centeredSlides: false,
    pagination: {
      el: ".itc-testimonial-slide-dots",
      clickable: true
    },
    navigation: {
      nextEl: ".feedback-button-next",
      prevEl: ".feedback-button-prev"
    },
    breakpoints: {
      0: {
        slidesPerView: 1
      },
      768: {
        slidesPerView: 2
      }
    }
  });

  // Feedback Slider 5
  const feedbackSliderFive = document.querySelector(".feedback-5-slider__init");
  if (feedbackSliderFive) {
    new Swiper(feedbackSliderFive, {
      autoplay: true,
      loop: true,
      speed: 700,
      slidesPerView: 1,
      effect: "fade"
    });
  }

  // Price show hide
  const priceControlBtn = document.querySelectorAll(".price-control-btn");
  const priceServiceWrapper = document.querySelectorAll(".price-service-wrapper");
  for (let i = 0; i < priceControlBtn.length; i++) {
    priceControlBtn[i].addEventListener("click", function (index) {
      return function () {
        priceServiceWrapper[index].classList.toggle("show");
      };
    }(i));
  }

  // Pricing Switch
  const monthlyPricing = document.querySelectorAll(".monthly-price");
  const yearlyPricing = document.querySelectorAll(".yearly-price");

  //Pricing Toggle with Checkbox
  const priceSwitch = document.querySelectorAll(".pricing-toggle");
  if (priceSwitch) {
    priceSwitch.forEach(priceCheck => {
      priceCheck.addEventListener("change", () => {
        if (priceCheck.checked === true) {
          monthlyPricing.forEach(e => {
            e.style.cssText = `display: none;`;
          });
          yearlyPricing.forEach(e => {
            e.style.cssText = `display: block;`;
          });
        } else {
          monthlyPricing.forEach(e => {
            e.style.cssText = `display: block;`;
          });
          yearlyPricing.forEach(e => {
            e.style.cssText = `display: none;`;
          });
        }
      });
    });
  }

  // Timeline Slider Nav
  const timelineSliderNav = document.querySelector(".timeline-slider-nav");
  const timelineSliderContent = document.querySelector(".timeline-slider-content");
  if (timelineSliderNav && timelineSliderContent) {
    const swiperNav = new Swiper(timelineSliderNav, {
      loop: true,
      slidesPerView: 1,
      freeMode: true,
      watchSlidesProgress: true,
      navigation: {
        nextEl: ".timeline-slider-nav__next",
        prevEl: ".timeline-slider-nav__prev"
      },
      breakpoints: {
        576: {
          slidesPerView: 2
        },
        768: {
          slidesPerView: 3
        },
        1200: {
          slidesPerView: 4
        },
        1400: {
          slidesPerView: 5
        }
      }
    });
    new Swiper(timelineSliderContent, {
      loop: true,
      thumbs: {
        swiper: swiperNav
      }
    });
  }
  // Hero 7 Slider
  const heroSlider7 = document.querySelector(".hero-7-slider");
  if (heroSlider7) {
    new Swiper(heroSlider7, {
      loop: true,
      slidesPerView: 1,
      autoplay: true,
      pagination: {
        el: ".hero-7-slider__pagination",
        clickable: true
      }
    });
  }

  // imgae infinite slider
  const scrollers = document.querySelectorAll(".scroller-x");
  scrollers.forEach(scroller => {
    scroller.setAttribute("data-animated", true);
    const scrollerInner = scroller.querySelector(".scroller-x__list");
    const scrollerContent = Array.from(scrollerInner.children);
    scrollerContent.forEach(item => {
      const duplicatedItem = item.cloneNode(true);
      duplicatedItem.setAttribute("aria-hidden", true);
      scrollerInner.appendChild(duplicatedItem);
    });
  });

  // wow js
  new WOW().init();
});

/**
 * Preloader
 */
const preloader = document.querySelector(".preloader");
window.addEventListener("load", () => {
  if (preloader) {
    preloader.style.display = "none";
  }
});
$(function () {
  "use strict";

  $(".popup-init").magnificPopup({
    type: "iframe"
  });
});