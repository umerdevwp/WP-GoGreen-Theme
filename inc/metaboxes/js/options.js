(function ($) {

    function tabsChanged(idx) {
        var $el = $("#gogreen_options .w-tour");
        $el.find(".w-tab-wrapper").css("min-height", "");

        if ($el.find(".w-tab-wrapper").height() < $el.height()) {
            $el.find(".w-tab-wrapper").css("min-height", $el.height());
        }

    }

    $.fn.wydeTabs = function (options) {

        var defaults = {
            saveState: false,
            changed: function () { }
        };

        var settings = $.extend({}, defaults, options || {});

        return this.each(function () {
            var $el = $(this);

            var currentTab = 0;
            if (settings.saveState) {
                var idx = $.cookie("wct");
                if (idx) currentTab = idx;
            }

            if ($el.find(".w-tabs-nav li").length <= currentTab) currentTab = 0;

            $el.find(".w-tabs-nav li:eq(" + currentTab + "), .w-tab:eq(" + currentTab + ")").addClass("active");

            $el.find(".w-tabs-nav li a").off("click").on("click", function (event) {
                event.preventDefault();

                var $link = $(this);
                $el.find(".w-tabs-nav li").removeClass("active");
                $link.parent().addClass("active");

                $el.find(".w-tab").removeClass("active");

                var idx = $el.find(".w-tabs-nav li").index($link.parents("li"));
                if (idx < 0) idx = 0;
                $el.find(".w-tab").eq(idx).addClass("active");

                if (settings.saveState) {
                    $.cookie("wct", idx);
                }

                tabsChanged();

                if (typeof settings.changed == "function") {
                    settings.changed(idx);
                }

                return false;
            });


        });

    };

    $(document).ready(function () {

        $("#gogreen_options .w-tour").wydeTabs();

        /** Header Options **/
        function toggleHeader() {
            $("#cmb2-metabox-header_options .cmb-row:not(.cmb2-id--w-page-header)").toggle($("#_w_page_header").val() != 'hide');
            tabsChanged();
        }
        toggleHeader();
        $("#_w_page_header").change(function () {
            toggleHeader();
        });

        /** Page Options **/
        /** Sidebar **/
        function toggleSidebar() {           
            $(".cmb2-id--w-sidebar-name, .cmb2-id--w-sidebar-style").toggle(!$("#_w_sidebar_position1").is(":checked"));
            tabsChanged();
        }
        toggleSidebar();
        $("#_w_sidebar_position1, #_w_sidebar_position2, #_w_sidebar_position3").click(function () {
            toggleSidebar();
        });

        /** Page Background **/
        function toggleBackground() {
            $(".cmb2-id--w-background-image, .cmb2-id--w-background-size").toggle($("#_w_background").val() == "image");
            $(".cmb2-id--w-background-color").toggle($("#_w_background").val() == "color" || $("#_w_background").val() == "image");
            $(".cmb2-id--w-background-overlay-color, .cmb2-id--w-background-overlay-opacity").toggle(($("#_w_background").val() == "image"));
            tabsChanged();
        }
        toggleBackground();
        $("#_w_background").change(function () {
            toggleBackground();
        });


        /** Title Options **/
        function toggleTitle() {
            $("#cmb2-metabox-title_options .cmb-row:not(.cmb2-id--w-post-custom-title, .cmb2-id--w-title-area)").toggle($("#_w_title_area").val() != "hide");
            tabsChanged();
        }

        toggleTitle();
        $("#_w_title_area").change(function () {
            toggleTitle();
            toggleTitleBackground();
        });

        /** Title Background **/
        function toggleTitleBackground() {
            if ($("#_w_title_area").val() == "hide") return;
            $(".cmb2-id--w-title-background-size").toggle($("#_w_title_background").val() == "image");
            $(".cmb2-id--w-title-background-video").toggle($("#_w_title_background").val() == "video");
            $(".cmb2-id--w-title-background-color").toggle($("#_w_title_background").val() == "color" || $("#_w_title_background").val() == "image");
            $(".cmb2-id--w-title-background-image, .cmb2-id--w-title-overlay-color, .cmb2-id--w-title-overlay-opacity, .cmb2-id--w-title-background-effect").toggle(($("#_w_title_background").val() == "image" || $("#_w_title_background").val() == "video"));
            //$(".cmb2-id--w-title-background-effect").toggle($("#_w_title_background").val() == "image");
            tabsChanged();
        }

        toggleTitleBackground();

        $("#_w_title_background").change(function () {
            toggleTitleBackground();
        });


        /** Post/Portfolio Options **/
        /** Media URL **/
        function togglePostMediaURL() {
            $(".cmb2-id--w-media-info, .cmb2-id--w-embed-url").toggle($("#post-format-audio").is(":checked") || $("#post-format-video").is(":checked"));
            tabsChanged();
        }

        /** Images Gallery **/
        function toggleGallery() {
            $(".cmb2-id--w-gallery-info, .cmb2-id--w-gallery-images").toggle($("#post-format-gallery").is(":checked"));
            tabsChanged();
        }

        /** Post Options **/
        /** Post Link **/
        function togglePostURL() {
            $(".cmb2-id--w-link-info, .cmb2-id--w-post-link").toggle($("#post-format-link").is(":checked"));
            tabsChanged();
        }

        /** Post Quote **/
        function togglePostQuote() {
            $(".cmb2-id--w-quote-info, .cmb2-id--w-post-quote, .cmb2-id--w-post-quote-author").toggle($("#post-format-quote").is(":checked"));
            tabsChanged();
        }

        if ($("#post-formats-select").length) {
            
            toggleGallery();
            togglePostMediaURL();
            togglePostURL();
            togglePostQuote();

            $("#post-formats-select input").click(function () {
                toggleGallery();
                togglePostMediaURL();
                togglePostURL();
                togglePostQuote();
            });
        }

        /** Custom Title Options **/
        function togglePostTitleOptions() {
            if (!$("#_w_post_custom_title").is(":checked")) {
                $("#cmb2-metabox-title_options .cmb-row:not(.cmb2-id--w-post-custom-title)").hide();
            } else {
                toggleTitle();
                toggleTitleBackground();
            }
            $("#cmb2-metabox-title_options .cmb2-id--w-title-area").toggle($("#_w_post_custom_title").is(":checked"));
            tabsChanged();
        }

        if ($("#_w_post_custom_title").length) {
            togglePostTitleOptions();
            $("#_w_post_custom_title").click(function () {
                togglePostTitleOptions();
            });
        }

        /** Post Sidebar Options **/
        function togglePostSidebarOptions() {
            $(".cmb2-id--w-sidebar-position").toggle($("#_w_post_custom_sidebar").is(":checked"));
            $(".cmb2-id--w-sidebar-name").toggle( $("#_w_post_custom_sidebar").is(":checked") && !$("#_w_sidebar_position1").is(":checked") );
            tabsChanged();
        }

        if ($("#_w_post_custom_sidebar").length) {
            togglePostSidebarOptions();
            $("#_w_post_custom_sidebar").click(function () {
                togglePostSidebarOptions();
            });
        } else {
            $("#cmb2-metabox-sidebar_options").show();
        }

    });


})(jQuery);