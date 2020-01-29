(function ($) {
    "use strict";

    /*****************************************
    *   Initialize Shortcodes
    /*****************************************/
    function initSections(){

        var fullHeightSections = function(){
            $(".w-section.w-full-height, .row.w-full-height").each(function(){
                var $el = $(this);
                var innerHeight = $(window).height() - ( parseInt( $el.css("padding-top") ) + parseInt( $el.css("padding-bottom") ) + parseInt( $el.css("margin-top") ) + parseInt( $el.css("margin-bottom") ) );
                $el.css("min-height", innerHeight);
            });
        };


        $(window).smartresize(function(){
            fullHeightSections();
        });

        fullHeightSections();
        

        if ( wyde.browser.md || wyde.browser.lg ) {
            initSectionParallax();
        }
    }

    function initSectionParallax() {

        setTimeout(function () {
            $(".w-section.w-parallax, .row.w-parallax").wydeParallax();
        }, 500);
        
    }

    /* Button */
    function initButton() {
        
        $(".w-link-button[href^='#'], a.w-button[href^='#'], a.w-ghost-button[href^='#']").on("click", function (event) {
            var $el = $(this);
            var hash = $el.attr("href");
            if (!hash) {
                return true;
            } else if (hash == '#') {
                event.preventDefault();
                return false;
            } else {
                event.preventDefault();

                var target = hash;

                if (hash == "#nextsection") {
                    target = $el.parents(".w-section").next(".w-section");
                    if (!target.length) target = $(".w-section").first();
                } else if (hash == "#prevsection") {
                    target = $el.parents(".w-section").prev(".w-section");
                    if (!target.length) target = $(".w-section").last();
                }

                wyde.page.scrollTo(target);

                return false;
            }
        });

        $(".w-link-button").each(function () {

            var $el = $(this);  

            var outline = $el.hasClass("outline");
            var icon = $el.hasClass("w-with-icon");

            var color = $el.css("color");               
            if (!color) color = "";

            var bgColor = "";
            if( !outline ){
                bgColor = $el.css("background-color");
            }

            var hoverColor = $el.data("hover-color");               
            if(!hoverColor) hoverColor = "";
                            

            $el.hover(function () {    

                if( hoverColor || !icon ){ 
                    if( outline ){
                        $el.css({
                            "color": hoverColor,
                            "background-color": color
                        });                       
                    }else if( $el.hasClass("none") ){ 

                        $el.css({
                            "color": hoverColor
                        });   

                    }else{
                          

                        $el.css({
                            "color": bgColor,
                            "background-color": ""
                        });        
                        
                    }
                }

            }, function () {
                if( hoverColor || !icon ){ 
                    if( outline ){

                        $el.css({
                            "color": color,
                            "background-color": ""
                        });

                    }else if( $el.hasClass("none") ){ 

                        $el.css({
                            "color": color
                        });   

                    }else{
                        
                            $el.css({
                                "color": color,
                                "background-color": bgColor
                            });                

                    }
                }
                
            });        

        });

    };

    /* Icon Block */
    function initIconBlock() {

        $(".w-icon-block:not(.w-none):not(.w-effect-none)").each(function () {
            var $el = $(this);
            var color = $el.css("border-color");
            $el.hover(function () {
                $el.css("color", color);
            }, function () {
                $el.css("color", "");
            });

        });

    }

    /* Gallery Sliders */
    function initGalleryCarousel(p) {        
        if (!p) p = document.body;
        $(p).find(".w-fadeslider").wydeFadeSlider();
    }

    /* WooCommerce Products */
    function initWooCommerceProducts() {

        $(window).on("added_to_cart", function (event, fragments, cart_hash, button) {
            $(button).next(".added_to_cart").show();
            setTimeout(function () {
                $(button).next(".added_to_cart").addClass("active");
            }, 100);

            setTimeout(function () {
                $(button).next(".added_to_cart").removeClass("active");
            }, 5000);

            setTimeout(function () {
                $(button).next(".added_to_cart").hide();
            }, 5200);

        });

        /* Single Product Thumbnails */
        $(".single-product .product-thumbnails").addClass("owl-carousel").owlCarousel({
            navText: ["", ""],
            items: 3,
            nav: true,
            dots: false,
            margin: 8,
            themeClass: ""
        });

        $(".single-product .woocommerce-product-gallery__wrapper a").attr("data-rel", "prettyPhoto[product]");

        $(".woocommerce-review-link[href^='#']").on("click", function (event) {
            var $el = $(this);
            var hash = $el.attr("href");
            if (!hash) {
                return true;
            } else if (hash == '#') {
                event.preventDefault();
                return false;
            } else {
                event.preventDefault();
                wyde.page.scrollTo(hash);
                return false;
            }
        });
        
    }

    /* Carousel */
    function initCarousel(p) {

        if (!p) p = document.body;

        $(p).find(".owl-carousel").each(function () {

            var $el = $(this);

            $el.waitForImages({
                finished: function () {

                    var items = 1;
                    if ($el.data("items") != undefined) items = parseInt($el.data("items"));

                    var loop = false;
                    if ($el.data("loop") != undefined) loop = $el.data("loop");
                    if ($el.find(">div").length <= 1) loop = false;

                    var animateIn = false;
                    var animateOut = false;
                    if ($el.data("transition")) {
                        switch ($el.data("transition")) {
                            case "fade":
                                animateIn = "fadeIn";
                                animateOut = "fadeOut";
                                break;
                        }
                    }

                    var autoPlay = false;
                    if ($el.data("autoPlay") != undefined) autoPlay = $el.data("autoPlay");

                    var speed = 4000;
                    if ($el.data("speed") != undefined) speed = parseInt( $el.data("speed") ) * 1000;

                    var autoHeight = false;
                    if ($el.data("autoHeight") != undefined) autoHeight = $el.data("autoHeight");

                    var navigation = true;
                    if ($el.data("navigation") != undefined) navigation = $el.data("navigation");

                    var pagination = false;
                    if ($el.data("pagination") != undefined) pagination = $el.data("pagination");

                    var center = false;
                    if ($el.data("center") != undefined) center = $el.data("center");

                    $el.owlCarousel({
                        autoHeight: autoHeight,
                        autoplayHoverPause: true,
                        navText: ["", ""],
                        items: items,
                        slideBy: items,
                        autoplay: (autoPlay != false),
                        autoplayTimeout: autoPlay ? speed : false,
                        autoplaySpeed: 800,
                        nav: navigation,
                        dots: pagination,
                        loop: loop,
                        center: center,
                        themeClass: "",
                        animateIn: animateIn,
                        animateOut: animateOut,                        
                        responsive: {
                            0: {
                                items: 1,
                                slideBy: 1
                            },
                            559: {
                                items: items > 2 ? 2 : items,
                                slideBy: items > 2 ? 2 : items
                            },
                            992: {
                                items: items > 3 ? 3 : items,
                                slideBy: items > 3 ? 3 : items
                            },
                            1200: {
                                items: items,
                                slideBy: items
                            }
                        }
                    });
                },
                waitForAll: false
            });

        });

        $(p).find(".portfolio-slider .post-media").each(function () {

            var $el = $(this);
            $el.addClass("owl-carousel").waitForImages({
                finished: function () {
                    var loop = $el.find("> div").length > 1;
                    var items = 4;
                    $el.owlCarousel({
                        autoplayHoverPause: true,
                        navText: ["", ""],
                        items: items,
                        autoplay: false,
                        nav: true,
                        dots: false,
                        loop: loop,
                        center: true,
                        themeClass: "",
                        responsive: {
                            0: {
                                items: 1,
                                slideBy: 1
                            },
                            559: {
                                items: items > 2 ? 2 : items,
                                slideBy: items > 2 ? 2 : items
                            },
                            992: {
                                items: items > 3 ? 3 : items,
                                slideBy: items > 3 ? 3 : items
                            },
                            1200: {
                                items: items,
                                slideBy: items
                            }
                        },
                        onInitialized: function () {
                            initPrettyPhoto(this.$stage.find(".cloned"));
                        }
                    });
                },
                waitForAll: false
            });

        });

        $(p).find(".w-slider").each(function () {

            var $el = $(this);

            var animateIn = false;
            var animateOut = false;
            var transition = $el.data("transition");
            if (transition) {
                switch (transition) {
                    case "fade":
                        animateIn = "fadeIn";
                        animateOut = "fadeOut";
                        break;
                }
            }

            var autoPlay = false;
            if ($el.data("autoPlay") != undefined) autoPlay = $el.data("autoPlay");

            var speed = 4000;
            if ($el.data("speed") != undefined) speed = parseInt( $el.data("speed") ) * 1000;
    
            var navigation = false;
            if ($el.data("navigation") != undefined) navigation = $el.data("navigation");

            var pagination = false;
            if ($el.data("pagination") != undefined) pagination = $el.data("pagination");
            
            $el.waitForImages({
                finished: function () {
                    
                    var owl = $el.find(".w-slides").addClass("owl-carousel").owlCarousel({
                        autoHeight: true,
                        autoplayHoverPause: true,
                        navText: ["", ""],
                        items: 2,
                        autoplay: (autoPlay != false),
                        autoplayTimeout: autoPlay ? speed : false,
                        autoplaySpeed: 800,
                        center: true,
                        nav: navigation,
                        dots: pagination,
                        loop: true,
                        themeClass: "",
                        animateIn: animateIn,
                        animateOut: animateOut                       
                        
                    });
                }
            });

        });


    }

    /* Scroll More */
    function initScrollMore() {

        $(".w-scrollmore").each(function () {

            var $el = $(this);

            var nextSelector = ".w-showmore .w-next";
            if (!$el.find(nextSelector).length) return;
            var trigger = 3;
            if ($el.data("trigger") != null) trigger = parseInt($el.data("trigger") || 0);

            var contentSelector = ".w-item";
            if ($el.data("selector") != null) contentSelector = $el.data("selector");

            $el.wydeScrollmore({
                autoTriggers: trigger,
                nextSelector: nextSelector,
                contentSelector: contentSelector,
                callback: function (newElements) {

                    // Isotope masonry
                    var $view = $el.find(".w-view");
                    var iso = $view.data("isotope");
                    if (iso) iso.appended(newElements);

                    // Slider
                    initCarousel(newElements);
                    initGalleryCarousel(newElements);

                    // Ajax Page
                    if (wyde.page.ajax_page) {
                        wyde.page.updateLink(newElements);
                    }

                    // PrettyPhoto
                    initPrettyPhoto(newElements);


                }
            });
        });
    }

    /* Team Carousel */
    function initTeamCarousel() {
        $(".w-team-slider").each(function () {
            var $el = $(this);

            if( wyde.browser.xs || wyde.browser.sm ){
                $(".member-content, .member-detail").css("max-height", $(window).height()-100);
            }

            $el.find(".cover-image").prettyPhoto({
                theme: '',
                hook: 'data-rel',
                deeplinking: false,
                social_tools: false,
                overlay_gallery: false,
                show_title: false,
                horizontal_padding: 0,
                allow_resize: true,
                default_width: ($(window).width() > 1170) ? 1170 : "100%",
                default_height: 658,
                changepicturecallback: function(){
                    $(".pp_inline .member-content .w-close-button").on("click", function(event){
                        event.preventDefault();
                        $.prettyPhoto.close();
                        return false;
                    });
                    setTimeout(function () {
                        $(".pp_inline .member-detail").wydeScroller({fadeOutBottom:true});
                    }, 100);
                },
                markup: '<div class="pp_pic_holder"> \
                            <div class="ppt">&nbsp;</div> \
                            <div class="pp_content_container"> \
                                    <div class="pp_content"> \
                                        <div class="pp_loaderIcon"><span class="w-loader"></span></div> \
                                        <div class="pp_fade"> \
                                            <a href="#" class="pp_expand" title="Expand the image"></a> \
                                            <div class="pp_hoverContainer"> \
                                                <a class="pp_previous" href="#"></a> \
                                                <a class="pp_next" href="#"></a> \
                                            </div> \
                                            <div id="pp_full_res"></div> \
                                            <div class="pp_details"> \
                                                <div class="pp_nav"> \
                                                    <a href="#" class="pp_arrow_previous"></a> \
                                                    <span class="currentTextHolder">0/0</span> \
                                                    <a href="#" class="pp_arrow_next"></a> \
                                                </div> \
                                            </div> \
                                        </div> \
                                    </div> \
                            </div> \
                        </div> \
                        <div class="pp_overlay"></div>',
                inline_markup: '<div class="pp_inline">{content}</div>',
                iframe_markup: '<div class="video-wrapper"><iframe src ="{path}" width="100%" height="{height}" frameborder="no" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>'

            });

        });
    }

    /* Grid View */
    function initGridView() {

        $(".w-portfolio-grid, .w-blog-posts.w-masonry, .w-image-gallery.w-masonry, .portfolio-masonry .w-masonry").each(function () {

            var $grid = $(this);

            var isMasonry = $grid.hasClass("w-masonry");

            var $view = $grid.find(".w-view");

            var refreshGrid = function(){               

                if(wyde.browser.xs){
                    if($view.data("isotope")){
                        $view.isotope("destroy");
                    }                            
                }else{

                    $view.isotope({
                        itemSelector: ".w-item",
                        transitionDuration: '0.6s',
                        layoutMode: isMasonry ? "masonry" : "fitRows",
                        masonry: { columnWidth: isMasonry ? $view.width() / 12 : ".w-item" }
                    });                                          

                }

            }      

            $(window).smartresize(function () {
                refreshGrid();                        
            });

            $grid.find(".w-filter").each(function () {

                var $el = $(this);
                var $filters = $el.parents(".w-filterable");
                var $p = $filters.length ? $filters : $(document.body);

                $el.find("li a").click(function (event) {

                    event.preventDefault();
                    var hash = getHash(this.href);
                    if (hash) {
                        hash = hash.replace("#", ".");
                        if (hash == ".all") hash = "*";

                        var $view = $p.find(".w-view").isotope({ filter: hash });
                                
                        var elems = $view.isotope("getFilteredItemElements");
                        if(!elems.length && $p.hasClass("w-scrollmore") ){
                            $p.find(".w-showmore .w-next").trigger("click");                                    
                        }
                    }

                    $el.find("li").removeClass("active");
                    $(this).parent().addClass("active");                    
                    return false;
                });
            });                     

            $grid.waitForImages({
                finished: function () {
                     refreshGrid();
                },
                waitForAll: false
            });

        });

    }

    /* PrettyPhoto */
    function initPrettyPhoto(el) {

        if (!el) el = document.body;

        var $elements = $(el);

        if (!$elements.length) return;

        if ($elements.prop("tagName") != "A") $elements = $elements.find("a[data-rel^='prettyPhoto']");

        $elements.prettyPhoto({
            theme: '',
            hook: 'data-rel',
            deeplinking: false,
            social_tools: false,
            overlay_gallery: false,
            show_title: (window.wyde && wyde.page && wyde.page.lightbox_title == true),
            horizontal_padding: 0,
            allow_resize: true,
            default_width: 1170,
            default_height: 658,
            changepicturecallback: function () {},
            markup: '<div class="pp_pic_holder"><div class="ppt">&nbsp;</div>'+
                        '<div class="pp_content_container">'+
                                '<div class="pp_content">'+
                                    '<div class="pp_loaderIcon"><span class="w-loader"></span></div>'+
                                    '<div class="pp_fade">'+
                                        '<a href="#" class="pp_expand" title="Expand the image"></a>'+
                                        '<div class="pp_hoverContainer">'+
                                            '<a class="pp_previous" href="#"></a><a class="pp_next" href="#"></a>'+
                                        '</div>'+
                                        '<div id="pp_full_res"></div>'+
                                        '<div class="pp_details">'+
                                            '<div class="pp_nav">'+
                                                '<a href="#" class="pp_arrow_previous"></a>'+
                                                '<a href="#" class="pp_arrow_next"></a>'+                                                
                                                '<span class="currentTextHolder">0/0</span>'+                                              
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="pp_overlay"></div>',
            inline_markup: '<div class="pp_inline"><a href="#" class="pp_close"></a>{content}</div>',
            iframe_markup: '<div class="video-wrapper"><iframe src ="{path}" width="100%" height="{height}" frameborder="no" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>'

        });
    }

    /* Blog Posts */
    function initBlogPosts() {

        if( typeof($.fn.mediaelementplayer) == "function"){
            setTimeout(function(){
                $("audio.wp-audio-shortcode, video.wp-video-shortcode").mediaelementplayer();
            }, 500);
        }
 
        $(".post-detail .meta-comment a").on("click", function () {
            var $el = $(this);
            var hash = getHash($el.attr("href"));
            if (!hash) {
                return true;
            } else if (hash == '#') {
                event.preventDefault();
                return false;
            } else {
                event.preventDefault();
                wyde.page.scrollTo(hash);
                return false;
            }
        });
        
    }

    /* Main Slider */
    function initMainSlider() {

        $(".w-revslider").find(".w-scroll-button a").off("click").on("click", function (event) {
            event.preventDefault();
            var $nextSection = getNextSection($(this).parents(".w-section"));
            if ($nextSection.length) {
                wyde.page.scrollTo($nextSection);
            }
            return false;
        });
    }

    function getNextSection(current) {
        var $sections = $(".w-section");
        var idx = $sections.index(current);
        return $sections.eq(idx + 1);
    }

    function initTouchDevices(){
        if (wyde.browser.touch){
            $(".w-portfolio-grid .w-item figure, .w-flickr").addClass("touch-hover");
            $(".touch .touch-hover").unbind("mouseenter mouseleave").hover(function() {            
                $(this).addClass("hover");
            }, function(){
                $(this).removeClass("hover");
            });
        }
    }

    /**
     * Generate VC Round Charts
     *
     * Legend must be generated manually. If color is array (gradient), then legend won't show it.
     */
    $.fn.vcRoundChart = function () {
        this.each( function (   ) {
            var data,
                gradient,
                chart,
                i,
                j,
                $this = $( this ),
                ctx = $this.find( 'canvas' )[ 0 ].getContext( '2d' ),
                stroke_width = $this.data( 'vcStrokeWidth' ) ? parseInt( $this.data( 'vcStrokeWidth' ), 10 ) : 0,
                options = {
                    showTooltips: $this.data( 'vcTooltips' ),
                    animationEasing: $this.data( 'vcAnimation' ),
                    segmentStrokeColor: $this.data( 'vcStrokeColor' ),
                    segmentShowStroke: 0 !== stroke_width,
                    segmentStrokeWidth: stroke_width,
                    responsive: true
                },
                color_keys = [
                    'color',
                    'highlight'
                ];

            // If plugin has been called on already initialized element, reload it
            if ( $this.data( 'chart' ) ) {
                $this.data( 'chart' ).destroy();
            }

            data = $this.data( 'vcValues' );

            ctx.canvas.width = $this.width();
            ctx.canvas.height = $this.width();

            // If color/highlight is array (of 2 colors), replace it with generated gradient
            for ( i = data.length - 1;
                  0 <= i;
                  i -- ) {
                for ( j = color_keys.length - 1;
                      0 <= j;
                      j -- ) {
                    if ( 'object' === typeof( data[ i ][ color_keys[ j ] ] ) && 2 === data[ i ][ color_keys[ j ] ].length ) {
                        gradient = ctx.createLinearGradient( 0, 0, 0, ctx.canvas.height );
                        gradient.addColorStop( 0, data[ i ][ color_keys[ j ] ][ 0 ] );
                        gradient.addColorStop( 1, data[ i ][ color_keys[ j ] ][ 1 ] );
                        data[ i ][ color_keys[ j ] ] = gradient;
                    }
                }
            }

            if ( 'doughnut' === $this.data( 'vcType' ) ) {
                chart = new Chart( ctx ).Doughnut( data, options );
            } else {
                chart = new Chart( ctx ).Pie( data, options );
            }
            $this.data( 'vcChartId', chart.id );
            // We can later access chart to call methods on it
            $this.data( 'chart', chart );
        } );

        return this;
    };

    /**
     * Allows users to rewrite function inside theme.
     */    
    window.vc_round_charts = function ( model_id ) {
        var selector = '.vc_round-chart';
        if ( 'undefined' !== typeof( model_id ) ) {
            selector = '[data-model-id="' + model_id + '"] ' + selector;
        }
        $( selector ).vcRoundChart();
    };

    /**
     * Generate VC Line Charts
     *
     * Legend must be generated manually. If color is array (gradient), then legend won't show it.
     */
    $.fn.vcLineChart = function () {
        this.each( function () {
            var data,
                gradient,
                chart,
                i,
                j,
                $this = $( this ),
                ctx = $this.find( 'canvas' )[ 0 ].getContext( '2d' ),
                options = {
                    showTooltips: $this.data( 'vcTooltips' ),
                    animationEasing: $this.data( 'vcAnimation' ),
                    datasetFill: true,
                    responsive: true
                },
                color_keys = [
                    'fillColor',
                    'strokeColor',
                    'highlightFill',
                    'highlightFill',
                    'pointHighlightFill',
                    'pointHighlightStroke'
                ];

            // If plugin has been called on already initialized element, reload it
            if ( $this.data( 'chart' ) ) {
                $this.data( 'chart' ).destroy();
            }

            data = $this.data( 'vcValues' );

            ctx.canvas.width = $this.width();
            ctx.canvas.height = $this.width();

            // If color/highlight is array (of 2 colors), replace it with generated gradient
            for ( i = data.datasets.length - 1;
                  0 <= i;
                  i -- ) {
                for ( j = color_keys.length - 1;
                      0 <= j;
                      j -- ) {
                    if ( 'object' === typeof( data[ 'datasets' ][ i ][ color_keys[ j ] ] ) && 2 === data[ 'datasets' ][ i ][ color_keys[ j ] ].length ) {
                        gradient = ctx.createLinearGradient( 0, 0, 0, ctx.canvas.height );
                        gradient.addColorStop( 0, data[ 'datasets' ][ i ][ color_keys[ j ] ][ 0 ] );
                        gradient.addColorStop( 1, data[ 'datasets' ][ i ][ color_keys[ j ] ][ 1 ] );
                        data[ 'datasets' ][ i ][ color_keys[ j ] ] = gradient;
                    }
                }
            }

            if ( 'bar' === $this.data( 'vcType' ) ) {
                chart = new Chart( ctx ).Bar( data, options );
            } else {
                chart = new Chart( ctx ).Line( data, options );
            }
            $this.data( 'vcChartId', chart.id );
            // We can later access chart to call methods on it
            $this.data( 'chart', chart );
        } );

        return this;
    };

   
    window.vc_line_charts = function ( model_id ) {
        var selector = '.vc_line-chart';
        if ( 'undefined' !== typeof( model_id ) ) {
            selector = '[data-model-id="' + model_id + '"] ' + selector;
        }
        $( selector ).vcLineChart();
    };
    


    function initVCCharts(){
        !window.vc_iframe && vc_round_charts();
        !window.vc_iframe && vc_line_charts();
    }

    function initRetinaDisplay(){

        $("img[data-retina]").each(function(){
            var $el = $(this);
            var image = new Image();
            image.src = $el.attr("src");
            image.onload = function(){
                $el.attr({
                    width:this.width,
                    height:this.height
                });
                $el.retina();
            };                   
        });
    }

    function initGMaps(){

        $(".w-gmaps").each(function(){

            var $el = $(this);

            // If it has been initialized, exit function to prevent duplication.
            if( $el.data("initialized") == true ) return;

            var options = {                    
                    gmaps: {
                        locations: false,
                        zoom: 8,
                        type: 2,
                        center: { lat: 37.6, lng: -95.665 }
                    },
                    color: "#ff0000",
                    height: 500,
                    mapStyles : []
            };
            
            if($el.data("showInfo")) options.showInfo = true;
            
            var gmaps = $.parseJSON(decodeURIComponent($el.data("maps")));
            if(gmaps) options.gmaps = gmaps;

            if(!options.gmaps.locations && $el.data("locations")){
                
                options.gmaps.locations = $.extend({}, 
                    options.gmaps.locations, 
                    $.parseJSON( decodeURIComponent( $el.data("locations") ) ) || {} 
                );

            }

            if($el.data("icon")){
                $.each(options.gmaps.locations, function(i, v){
                    options.gmaps.locations[i].icon = $el.data("icon");
                });
            } 

            if($el.data("color")) options.color = $el.data("color");
            if($el.height()) options.height = $el.height();

            options.mapStyles = [
                  {
                    "featureType": "road.highway",
                    "elementType": "geometry.stroke",
                    "stylers": [
                      { "color": "#aaaaaa" }
                    ]
                  },{
                    "featureType": "road.highway",
                    "elementType": "geometry.fill",
                    "stylers": [
                      { "color": "#c6c6c6" }
                    ]
                  },{
                    "featureType": "road.arterial",
                    "elementType": "geometry.fill",
                    "stylers": [
                      { "color": "#e9e9e9" }
                    ]
                  },{
                    "featureType": "road.arterial",
                    "elementType": "geometry.stroke",
                    "stylers": [
                      { "color": "#cecece" }
                    ]
                  },{
                    "featureType": "road.local",
                    "elementType": "geometry.stroke",
                    "stylers": [
                      { "color": "#cecece" }
                    ]
                  },{
                    "featureType": "road.local",
                    "elementType": "geometry.fill",
                    "stylers": [
                      { "color": "#e9e9e9" }
                    ]
                  },{
                    "featureType": "landscape",
                    "elementType": "geometry.fill",
                    "stylers": [
                      { "color": "#f9f9f9" }
                    ]
                  },{
                    "featureType": "poi",
                    "elementType": "geometry",
                    "stylers": [
                      { "color": "#eceeed" }
                    ]
                  },{
                    "featureType": "transit.station",
                    "elementType": "geometry.fill",
                    "stylers": [
                      { "saturation": -100 },
                      { "lightness": 22 }
                    ]
                  },{
                    "featureType": "administrative.locality",
                    "elementType": "labels.text.fill",
                    "stylers": [
                      { "color": options.color }                  
                    ]
                  },{
                    "featureType": "road",
                    "elementType": "labels",
                    "stylers": [
                      { "lightness": 1 },
                      { "gamma": 1.02 },
                      { "hue": options.color }
                    ]
                  },{
                    "featureType": "road.highway",
                    "elementType": "labels"  },{
                    "featureType": "water",
                    "stylers": [
                      { "lightness": 48 }
                    ]
                  }
            ];

            $el.wydeGMaps(options);

        });

    }

    window.initGMaps = initGMaps;


    function initTabs(){
        
        $(".w-tabs, .w-icon-tabs, .w-tour").each(function(){
            var $el = $(this);
            var interval = $el.data("interval") ? parseInt($el.data("interval")) : 0;
            $el.wydeTabs({interval : interval });
        });
        
    }

    function initSocialStream(){

        // Flickr Stream
        $(".w-flickr").each(function(){

            var $el = $(this);

            $el.wydeFlickrStream({
                id: $el.data("id"),
                type: $el.data("type"),
                size: $el.data("size"),
                count: parseInt($el.data("count")),
                columns: parseInt($el.data("columns"))
            });

        });

        // Facebook Page        
        $(".w-facebook-box").each(function(){

            var $el = $(this);

            var width,
                height;
                

            if ($el.data("width")) width = parseInt($el.data("width"));
            if ($el.data("height")) height = parseInt($el.data("height"));

            $el.wydeFacebookLike({
                width: width,
                height: height,
                show_facepile: $el.data("showFacepile"),
                small_header: $el.data("smallHeader"),
                tabs: $el.data("tabs"),
                page_url: $el.data("pageUrl")
            });     

        }); 

        // Instagram Feed
        if( wyde_shortcodes_settings && wyde_shortcodes_settings.instagram ){
        
            $(".w-instagram").each(function(){

                var $el = $(this);
                var name = $el.data("name");            
                var max = parseInt( $el.data("max") );
                var wrapper = "<div></div>";
                var size = $el.data("size");

                if(!$el.hasClass("w-slider")){
                    var columns = parseInt( $el.data("columns") );
                    var colName = "";
                    if (columns != 5) {
                        colName = "col-" + Math.abs(Math.floor(12 / columns));
                    } else {
                        colName = "five-cols";
                    }
                    wrapper = '<li class="w-item '+colName+'"></li>';
                }

                var $view = $el.find(".w-instagram-photos").wydeInstagram({
                        accessToken: wyde_shortcodes_settings.instagram,
                        query: name,
                        max: max,
                        size: size,
                        wrapper: wrapper
                    },
                    function(){

                        $el.find(".w-loader").remove();
                        
                        if( $el.hasClass("w-slider") ){

                            var items = 1;
                            if ($el.data("items") != undefined) items = parseInt($el.data("items"));

                            var loop = false;
                            if ($el.data("loop") != undefined) loop = $el.data("loop");
                            if ($el.find(">div").length <= 1) loop = false;

                            var animateIn = false;
                            var animateOut = false;
                            if ($el.data("transition")) {
                                switch ($el.data("transition")) {
                                    case "fade":
                                        animateIn = "fadeIn";
                                        animateOut = "fadeOut";
                                        break;
                                }
                            }

                            var autoPlay = false;
                            if ($el.data("autoPlay") != undefined) autoPlay = $el.data("autoPlay");

                            var speed = 4000;
                            if ($el.data("speed") != undefined) speed = parseInt( $el.data("speed") ) * 1000;

                            var navigation = true;
                            if ($el.data("navigation") != undefined) navigation = $el.data("navigation");

                            var pagination = false;
                            if ($el.data("pagination") != undefined) pagination = $el.data("pagination");

                            $view.addClass("owl-carousel").owlCarousel({
                                autoplayHoverPause: true,
                                navText: ["", ""],
                                items: items,
                                slideBy: items,
                                autoplay: (autoPlay != false),
                                autoplayTimeout: autoPlay ? speed : false,
                                autoplaySpeed: 800,
                                nav: navigation,
                                dots: pagination,
                                loop: loop,
                                themeClass: "",
                                animateIn: animateIn,
                                animateOut: animateOut,                        
                                responsive: {
                                    0: {
                                        items: 1,
                                        slideBy: 1
                                    },
                                    559: {
                                        items: items > 2 ? 2 : items,
                                        slideBy: items > 2 ? 2 : items
                                    },
                                    992: {
                                        items: items > 3 ? 3 : items,
                                        slideBy: items > 3 ? 3 : items
                                    },
                                    1200: {
                                        items: items,
                                        slideBy: items
                                    }
                                }
                            });

                        }
                    });   

                $view.wydeInstagram("getUserFeed");         

            });

        }

        // Twitter  
        if($(".w-twitter").length){

            initTwitterWidget();

            if(!twttr) return;
                         
            twttr.ready( function (twttr) {

                twttr.events.bind("loaded", function (event) {

                    $(".w-twitter").each(function(){

                        var $el = $(this);

                        $el.wydeTwitterTimeline({
                            username: $el.data("name"),
                            count: $el.data("count"),                           
                            theme: $el.data("theme"),
                            transparent: $el.data("transparent"),
                            showHeader: $el.data("showHeader"),
                            showScrollbar: $el.data("showScrollbar"),
                            showBorder: $el.data("showBorder"),            
                            borderColor: $el.data("borderColor"),
                            width: $el.data("width"),
                            height: $el.data("height"),    
                        });

                    });                  
                        

                });

            });
        }
            

    }


    /*****************************************
    Call on Wyde Page Ready event 
    /*****************************************/
    $(window).on("wyde.page.ready", function () {  

        if( !window.wyde )  return;

        initRetinaDisplay();
        initButton();
        initIconBlock();
        initCarousel();
        initGalleryCarousel();
        initGridView();
        initBlogPosts();
        initWooCommerceProducts();
        initScrollMore();       
        initGMaps();  
        initTabs();
        initSocialStream();

        $(".w-progress-bar").wydeProgressBar();
        $(".w-accordion").wydeAccordion();
        $(".w-toggle").wydeToggle();        
        $(".w-counter-box").wydeCounterBox();
        $(".w-donut-chart").wydeDonutChart();       
        
        initTeamCarousel();
        initPrettyPhoto();
        initMainSlider();
        initVCCharts();
        initTouchDevices();      
        
        $("[data-animation]").wydeAnimated( { mobileEnabled: wyde.page.mobile_animation } );
        
        initSections();

    });

})(jQuery);