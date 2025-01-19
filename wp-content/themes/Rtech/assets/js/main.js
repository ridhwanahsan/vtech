(function($) {
    'use strict';
    /*=============================================
	=              Preloader       =
    =============================================*/
    function preloader() {
        $('#preloader').delay(0).fadeOut();
    }
    /*=============================================
    =     Offcanvas Menu      =
    =============================================*/
    function offcanvasMenu() {
        $(".menu-tigger").on("click", function() {
            $(".offCanvas__info, .offCanvas__overly").addClass("active");
            return false;
        });
        $(".menu-close, .offCanvas__overly").on("click", function() {
            $(".offCanvas__info, .offCanvas__overly").removeClass("active");
        });
    }
    /*=============================================
	=          Data Background      =
    =============================================*/
    function dataBackground() {
        $('[data-background]').each(function() {
            $(this).css('background-image', 'url(' + $(this).attr('data-background') + ')');
        });
    }
    /*=============================================
	=           Go to top       =
    =============================================*/
    function progressPageLoad() {
        var progressWrap = document.querySelector('.btn-scroll-top');
        if (progressWrap != null) {
            var progressPath = document.querySelector('.btn-scroll-top path');
            var pathLength = progressPath.getTotalLength();
            var offset = 50;
            progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
            progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
            progressPath.style.strokeDashoffset = pathLength;
            progressPath.getBoundingClientRect();
            progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';
            window.addEventListener('scroll', function(event) {
                var scroll = document.body.scrollTop || document.documentElement.scrollTop;
                var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                var progress = pathLength - (scroll * pathLength) / height;
                progressPath.style.strokeDashoffset = progress;
                var scrollElementPos = document.body.scrollTop || document.documentElement.scrollTop;
                if (scrollElementPos >= offset) {
                    progressWrap.classList.add('active-progress');
                } else {
                    progressWrap.classList.remove('active-progress');
                }
            });
            progressWrap.addEventListener('click', function(e) {
                e.preventDefault();
                window.scroll({
                    top: 0,
                    left: 0,
                    behavior: 'smooth',
                });
            });
        }
    }
    /*=============================================
	=           Aos Active       =
    =============================================*/
    function aosAnimation() {
        AOS.init({
            duration: 1000,
            mirror: true,
            once: true,
            disable: 'mobile',
        });
    }
    /*=============================================
	=           counterState       =
    =============================================*/
    function counterState() {
        var counters = document.querySelectorAll('.counter');
        counters.forEach(function(counter) {
            var countTo = counter.getAttribute('data-count');
            var countNum = parseInt(counter.textContent);
            var duration = 4000;
            var stepDuration = duration / Math.abs(countTo - countNum);
            var increment = countTo > countNum ? 1 : -1;
            var timer = setInterval(function() {
                countNum += increment;
                counter.textContent = countNum;
                if (countNum == countTo) {
                    clearInterval(timer);
                    //alert('finished');
                }
            }, stepDuration);
        });
    }
    /*=============================================
	=    		Magnific Popup		      =
    =============================================*/
    function magnificPopup() {
        $('.popup-image').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true,
            },
        });
        /* magnificPopup video view */
        $('.popup-video').magnificPopup({
            type: 'iframe',
        });
        $('.popup-video-2').magnificPopup({
            type: 'iframe',
        });
    }
    /*=============================================
	=    		 Wow Active  	         =
    =============================================*/
    function wowAnimation() {
        var wow = new WOW({
            boxClass: 'wow',
            animateClass: 'animated',
            offset: 0,
            mobile: false,
            live: true,
        });
        wow.init();
    }

    function customSwiper() {
        const slider1 = new Swiper('.slider-group-3', {
            slidesPerView: 3,
            spaceBetween: 30,
            slidesPerGroup: 1,
            centeredSlides: false,
            loop: true,
            autoplay: {
                delay: 400000,
            },
            breakpoints: {
                1200: {
                    slidesPerView: 3,
                },
                992: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 2,
                },
                576: {
                    slidesPerView: 1,
                },
                0: {
                    slidesPerView: 1,
                },
            },
            pagination: {
                el: '.swiper-pagination-style-1',
                clickable: true,
                // renderBullet: function (index, className) {
                //     return '<span class="' + className + '">' + (menu[index]) + '</span>';
                // },
            },
            navigation: {
                nextEl: '.swiper-button-next-style-1',
                prevEl: '.swiper-button-prev-style-1',
            },
            on: {
                afterInit: function() {
                    // set padding left slide
                    var leftPadding = 0;
                    var swipperRoot = $('.swipper-root');
                    if (swipperRoot.length > 0) {
                        leftPadding = swipperRoot.offset().left;
                    }
                    if ($('.box-swiper-padding').length > 0) {
                        $('.box-swiper-padding').css('padding-left', leftPadding + 'px');
                    }
                },
            },
        });

        const slider6 = new Swiper('.slider-group-4', {
            slidesPerView: 4,
            spaceBetween: 30,
            slidesPerGroup: 1,
            centeredSlides: false,
            loop: true,
            autoplay: {
                delay: 4000,
            },
            breakpoints: {
                1200: {
                    slidesPerView: 4,
                },
                992: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 2,
                },
                576: {
                    slidesPerView: 1,
                },
                0: {
                    slidesPerView: 1,
                },
            },
            pagination: {
                el: '.swiper-pagination-style-2',
                clickable: true,
                // renderBullet: function (index, className) {
                //     return '<span class="' + className + '">' + (menu[index]) + '</span>';
                // },
            },
            navigation: {
                nextEl: '.swiper-button-next-style-6',
                prevEl: '.swiper-button-prev-style-6',
            },
            on: {
                afterInit: function() {
                    // set padding left slide
                    var leftPadding = 0;
                    var swipperRoot = $('.swipper-root');
                    if (swipperRoot.length > 0) {
                        leftPadding = swipperRoot.offset().left;
                    }
                    if ($('.box-swiper-padding').length > 0) {
                        $('.box-swiper-padding').css('padding-left', leftPadding + 'px');
                    }
                },
            },
        });

        const slider7 = new Swiper('.slider-group-7', {
            slidesPerView: 7,
            spaceBetween: 30,
            slidesPerGroup: 1,
            centeredSlides: false,
            loop: true,
            autoplay: {
                delay: 400000,
            },
            breakpoints: {
                1200: {
                    slidesPerView: 7,
                },
                992: {
                    slidesPerView: 6,
                },
                768: {
                    slidesPerView: 5,
                },
                576: {
                    slidesPerView: 4,
                },
                476: {
                    slidesPerView: 3,
                },
                376: {
                    slidesPerView: 3,
                },
                0: {
                    slidesPerView: 2,
                },
            },
            pagination: {
                el: '.swiper-pagination-style-2',
                clickable: true,
                // renderBullet: function (index, className) {
                //     return '<span class="' + className + '">' + (menu[index]) + '</span>';
                // },
            },
            navigation: {
                nextEl: '.swiper-button-next-style-6',
                prevEl: '.swiper-button-prev-style-6',
            },
            on: {
                afterInit: function() {
                    // set padding left slide
                    var leftPadding = 0;
                    var swipperRoot = $('.swipper-root');
                    if (swipperRoot.length > 0) {
                        leftPadding = swipperRoot.offset().left;
                    }
                    if ($('.box-swiper-padding').length > 0) {
                        $('.box-swiper-padding').css('padding-left', leftPadding + 'px');
                    }
                },
            },
        });

        const slider5 = new Swiper('.slider-group-2', {
            slidesPerView: 2,
            spaceBetween: 30,
            slidesPerGroup: 1,
            centeredSlides: false,
            loop: true,
            autoplay: {
                delay: 1000000,
            },
            breakpoints: {
                1200: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 2,
                },
                676: {
                    slidesPerView: 1,
                },
                0: {
                    slidesPerView: 1,
                },
            },
            pagination: {
                el: '.swiper-pagination-style-2',
                clickable: true,
                // renderBullet: function (index, className) {
                //     return '<span class="' + className + '">' + (menu[index]) + '</span>';
                // },
            },
            navigation: {
                nextEl: '.swiper-button-next-style-6',
                prevEl: '.swiper-button-prev-style-6',
            }
        });

        const slider2 = new Swiper('.slider-2', {
            slidesPerView: 4,
            spaceBetween: 30,
            slidesPerGroup: 1,
            centeredSlides: false,
            loop: true,
            autoplay: {
                delay: 4000,
            },
            breakpoints: {
                1200: {
                    slidesPerView: 4,
                },
                992: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 2,
                },
                576: {
                    slidesPerView: 1,
                },
                0: {
                    slidesPerView: 1,
                },
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            on: {
                afterInit: function() {
                    // set padding left slide
                    var leftPadding = 0;
                    var swipperRoot = $('.swipper-root');
                    if (swipperRoot.length > 0) {
                        leftPadding = swipperRoot.offset().left;
                    }
                    if ($('.box-swiper-padding').length > 0) {
                        $('.box-swiper-padding').css('padding-left', leftPadding + 'px');
                    }
                },
            },
        });
        const slider3 = new Swiper('.swiper-group-auto', {
            slidesPerView: "auto",
            spaceBetween: 30,
            slidesPerGroup: 1,
            centeredSlides: false,
            loop: true,
            autoplay: {
                delay: 4000,
            },
            breakpoints: {
                1200: {
                    slidesPerView: "auto",
                },
                992: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 2,
                },
                576: {
                    slidesPerView: 1,
                },
                0: {
                    slidesPerView: 1,
                },
            },
            navigation: {
                nextEl: '.swiper-button-next-style-2',
                prevEl: '.swiper-button-prev-style-2',
            },
            on: {
                afterInit: function() {
                    // set padding left slide
                    var leftPadding = 0;
                    var swipperRoot = $('.swipper-root');
                    if (swipperRoot.length > 0) {
                        leftPadding = swipperRoot.offset().left + 15;
                    }
                    if ($('.box-swiper-padding').length > 0) {
                        $('.box-swiper-padding').css('padding-left', leftPadding + 'px');
                    }
                },
            },
        });
        const slider4 = new Swiper('.slider-group-1', {
            slidesPerView: 1,
            spaceBetween: 0,
            slidesPerGroup: 1,
            centeredSlides: false,
            loop: true,
            autoplay: {
                delay: 40000,
            },
            navigation: {
                nextEl: '.swiper-button-next-style-1',
                prevEl: '.swiper-button-prev-style-1',
            },
            pagination: {
                el: '.swiper-pagination-style-1',
                clickable: true,
            },
        });

        var swiper_animate_items = null;
        $(".swiper-group-slide-text").each(function() {
            swiper_animate_items = new Swiper(this, {
                spaceBetween: 40,
                slidesPerView: "auto",
                slidesPerGroup: 1,
                loop: true,
                speed: 50000,
                centeredSlides: true,
                allowTouchMove: false,
                effect: "slide",
                navigation: {
                    nextEl: ".swiper-button-next-animate",
                    prevEl: ".swiper-button-prev-animate",
                    clickable: false
                },
                autoplay: {
                    enabled: 1,
                    delay: 1,
                    waitForTransition: 1,
                    disableOnInteraction: 0,
                    stopOnLastSlide: 1,
                    reverseDirection: 1
                },
                breakpoints: {
                    1199: {
                        slidesPerView: "auto"
                    },
                    600: {
                        slidesPerView: "auto"
                    },
                    575: {
                        slidesPerView: 1
                    },
                    350: {
                        slidesPerView: 1
                    }
                }
            });
        });

        var centerSlide = new Swiper(".swiper-center-slide", {
            spaceBetween: 60,
            slidesPerView: 3,
            slidesPerGroup: 1,
            centeredSlides: true,
            roundLengths: false,
            initialSlide: 1,
            loop: true,
            navigation: {
                nextEl: ".swiper-button-next-center",
                prevEl: ".swiper-button-prev-center"
            },
            breakpoints: {
                1199: {
                    slidesPerView: 3
                },
                600: {
                    slidesPerView: 2
                },
                575: {
                    slidesPerView: 1
                },
                350: {
                    slidesPerView: 1
                }
            }
        });
    }
    var sliderTab;
    var _tabIndex = 1;

    function customSwiperTab(index) {
        _tabIndex = index;
        if (typeof sliderTab != 'undefined') {
            sliderTab.destroy();
        }
        new Swiper('.slider-group-3-tab-' + index, {
            slidesPerView: 3,
            spaceBetween: 30,
            slidesPerGroup: 1,
            centeredSlides: false,
            loop: true,
            autoplay: {
                delay: 400000,
            },
            breakpoints: {
                1200: {
                    slidesPerView: 3,
                },
                992: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 2,
                },
                576: {
                    slidesPerView: 1,
                },
                0: {
                    slidesPerView: 1,
                },
            },
            pagination: {
                el: '.swiper-pagination-style-tab',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next-style-tab',
                prevEl: '.swiper-button-prev-style-tab',
            },
            on: {
                afterInit: function() {
                    // set padding left slide
                    var leftPadding = 0;
                    var swipperRoot = $('.swipper-root');
                    if (swipperRoot.length > 0) {
                        leftPadding = swipperRoot.offset().left;
                    }
                    if ($('.box-swiper-padding').length > 0) {
                        $('.box-swiper-padding').css('padding-left', leftPadding + 'px');
                    }
                },
            },
        });
        sliderTab = document.querySelector('.slider-group-3-tab-' + index).swiper;
    }

    var sliderTab2;
    var _tabIndex2 = 1;

    function customSwiperTab2(index) {
        _tabIndex2 = index;
        if (typeof sliderTab2 != 'undefined') {
            sliderTab2.destroy();
        }
        if ($('.slider-group-4-tab-' + index).length > 0) {
            new Swiper('.slider-group-4-tab-' + index, {
                slidesPerView: 4,
                spaceBetween: 30,
                slidesPerGroup: 1,
                centeredSlides: false,
                loop: true,
                autoplay: {
                    delay: 4000,
                },
                breakpoints: {
                    1200: {
                        slidesPerView: 4,
                    },
                    992: {
                        slidesPerView: 3,
                    },
                    768: {
                        slidesPerView: 2,
                    },
                    576: {
                        slidesPerView: 1,
                    },
                    0: {
                        slidesPerView: 1,
                    },
                },
                pagination: {
                    el: '.swiper-pagination-style-tab',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next-style-tab',
                    prevEl: '.swiper-button-prev-style-tab',
                },
                on: {
                    afterInit: function() {
                        // set padding left slide
                        var leftPadding = 0;
                        var swipperRoot = $('.swipper-root');
                        if (swipperRoot.length > 0) {
                            leftPadding = swipperRoot.offset().left;
                        }
                        if ($('.box-swiper-padding').length > 0) {
                            $('.box-swiper-padding').css('padding-left', leftPadding + 'px');
                        }
                    },
                },
            });
            sliderTab2 = document.querySelector('.slider-group-4-tab-' + index).swiper;
        }
    }
    /*=============================================
	=           Page Load       =
    =============================================*/
    $(window).on('load', function() {
        preloader();
        progressPageLoad();
        offcanvasMenu();
        dataBackground();
        aosAnimation();
        counterState();
        customSwiper();
        magnificPopup();
        wowAnimation();
    });

    $(".box-button-change-package a.btn").on("click", function(e) {
        e.preventDefault();
        $(".box-button-change-package a.btn").removeClass("btn-active");
        $(this).addClass("btn-active");
        var _value = $(this).data("type");
        $(".package-item").hide();
        $('.' + _value).show();
    });
    $(window).resize(function() {
        var leftPadding = 0;
        var swipperRoot = $('.swipper-root');
        if (swipperRoot.length > 0) {
            leftPadding = swipperRoot.offset().left;
        }
        if ($('.container-testimonials .testimonial-right').length > 0) {
            $('.container-testimonials .testimonial-right').css('margin-right', leftPadding + 'px');
        }

        if ($(".auto-padding").length > 0) {
            $('.auto-padding').css('padding-left', leftPadding + 'px');
            setTimeout(function() {
                customSwiperTab(_tabIndex);
            }, 500);
        }
    }).resize();
    $('.nav-tabs a').on('show.bs.tab', function() {
        var _tab = $(this).data("index");
        if (_tab > 0) {
            customSwiperTab(_tab);
        }
    });
    $(".box-button-filter a").on('show.bs.tab', function() {
        var _tab = $(this).data("index");
        if (_tab > 0) {
            customSwiperTab2(_tab);
        }
    });

    $(".filter-content").on("click", function(e) {
        e.preventDefault();
        var filter = $(this).data("filter");
        $('.filter-content').removeClass('active');
        $(this).addClass('active');
        $(".item-filter").hide();
        if (filter == "all") {
            $(".item-filter").show();
        } else {
            $("." + filter).show();
        }
        masonryFilter();
    });
    $(".btn-open-search").on("click", function() {
        openSearch();
    });

    function masonryFilter() {
        if ($('.row-masonry').length > 0) {
            $('.row-masonry').masonry({
                columnWidth: '.col-lg-4',
                itemSelector: '.col-lg-4',
                percentPosition: true
            });
        }
    }

    function circleText() {
        const texts = document.querySelectorAll(".circle-text");
        texts.forEach(text => {
            if (text) {
                text.innerHTML = text.textContent.replace(/\S/g, "<span>$&</span>");
                const elements = text.querySelectorAll("span");
                elements.forEach((element, i) => {
                    element.style.transform = "rotate(" + i * 16 + "deg)";
                });
            }
        });
    }

    function odometerCounter() {
        if ($('.odometer').length > 0) {
            $('.odometer').appear(function(e) {
                var odo = $('.odometer');
                odo.each(function() {
                    var countNumber = $(this).attr('data-count');
                    $(this).html(countNumber);
                });
            });
        }
    }

    function aosAnimation() {
        AOS.init({
            duration: 1000,
            mirror: true,
            once: true,
            disable: 'mobile',
        });
    }

    $(window).on('load', function() {
        circleText();
        odometerCounter();
        aosAnimation();
        customSwiperTab2(1);
        masonryFilter();
    });
})(jQuery);

function openSearch() {
    document.getElementById("myOverlay").style.display = "block";
}

function closeSearch() {
    document.getElementById("myOverlay").style.display = "none";
}


