/*================================================================================
  Item Name: Materialize - Material Design Admin Template
  Version: 5.0
  Author: PIXINVENT
  Author URL: https://themeforest.net/user/pixinvent/portfolio
================================================================================*/

$p = jQuery.noConflict();

// Globally variables
var sidenavMain = $p(".sidenav-main"),
   contentOverlay = $p(".content-overlay"),
   navCollapsible = $p(".navbar .nav-collapsible"),
   breadcrumbsWrapper = $p("#breadcrumbs-wrapper");

// Functions
//----------

// Menu: Default menu collapse check
defaultMenuCollapse();
function defaultMenuCollapse() {
   if ($p("body").hasClass("menu-collapse") && $p(window).width() > 993) {
      //  Toggle navigation expan and collapse
      sidenavMain.removeClass("nav-lock");
      $p(".nav-collapsible .navbar-toggler i").text("radio_button_unchecked");
      navCollapsible.removeClass("sideNav-lock");
      toogleMenuCollapse();
      navigationCollapse();
   }
}

// Menu: Function for toggle class for menu collapse
function toogleMenuCollapse() {
   if (sidenavMain.hasClass("nav-expanded") && !sidenavMain.hasClass("nav-lock")) {
      sidenavMain.toggleClass("nav-expanded");
      $p("#main").toggleClass("main-full");
   } else {
      $p("#main").toggleClass("main-full");
   }
}

// Menu: Collapse navigation
function navigationCollapse() {
   if (!$p(".sidenav-main.nav-collapsible").hasClass("nav-lock")) {
      var openLength = $p(".collapsible .open").children().length;
      $p(".sidenav-main.nav-collapsible, .navbar .nav-collapsible")
         .addClass("nav-collapsed")
         .removeClass("nav-expanded");
      $p("#slide-out > li.open > a")
         .parent()
         .addClass("close")
         .removeClass("open");
      setTimeout(function () {
         // Open only if collapsible have the children
         if (openLength > 1) {
            var collapseEl = $p(".sidenav-main .collapsible");
            var collapseInstance = M.Collapsible.getInstance(collapseEl);
            collapseInstance.close($p(".collapsible .close").index());
         }
      }, 100);
   }
}

// Left side drawer chat tab: Add message on click of send btn
function slideOutChat() {
   var message = $p(".search").val();
   if (message != "") {
      var html =
         '<li class="collection-item display-flex avatar justify-content-end pl-5 pb-0" data-target="slide-out-chat"><div class="user-content speech-bubble-right">' +
         '<p class="medium-small">' +
         message +
         "</p>" +
         "</div></li>";
      $p("#right-sidebar-nav #slide-out-chat .chat-body .collection").append(html);
      $p(".search").val("");
      var charScroll = $p("#right-sidebar-nav #slide-out-chat .chat-body .collection");
      if (charScroll.length > 0) {
         charScroll[0].scrollTop = charScroll[0].scrollHeight;
      }
   }
}

// Preload-transitions class remove after page load
$p(window).on("load", function () {
   $p("body").removeClass("preload-transitions");
});

$p(function () {
   "use strict";


   // function for detect touch device
   function is_touch_device() {
      var prefixes = ' -webkit- -moz- -o- -ms- '.split(' ');
      var mq = function (query) {
         return window.matchMedia(query).matches;
      }
      if (('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch) {
         return true;
      }
      // include the 'heartz' as a way to have a non matching MQ to help terminate the join
      // https://git.io/vznFH
      var query = ['(', prefixes.join('touch-enabled),('), 'heartz', ')'].join('');
      return mq(query);
   }

   // Plugin initialization
   //---------------------

   // add active class in parent of li of main sidenav
   $p(".sidenav-main .sidenav").find("li.active").parents("li").addClass("active");
   //Init tabs
   $p(".tabs").tabs();

   // initialize datepicker
   $p('.datepicker').datepicker({
      autoClose: true,
      format: 'dd/mm/yyyy',
      container: 'body',
      onDraw: function () {
         // materialize select dropdown not proper working on mobile and tablets so we make it browser default select
         $p('.datepicker-container').find('.datepicker-select').addClass('browser-default');
         $p(".datepicker-container .select-dropdown.dropdown-trigger").remove()
      }
   });

   // Swipeable Tabs Demo Init
   if ($p("#tabs-swipe-demo").length) {
      $p("#tabs-swipe-demo").tabs({
         swipeable: true
      });
   }

   $p("select").formSelect();
   // Set checkbox on forms.html to indeterminate
   var indeterminateCheckbox = document.getElementById("indeterminate-checkbox");
   if (indeterminateCheckbox !== null) indeterminateCheckbox.indeterminate = true;

   // Materialize Slider
   $p(".slider").slider({
      full_width: true
   });

   // Common, Translation & Horizontal Dropdown
   $p(".dropdown-trigger").dropdown();

   // Common, Translation
   $p(".dropdown-button").dropdown({
      inDuration: 300,
      outDuration: 225,
      constrainWidth: false,
      hover: true,
      gutter: 0,
      coverTrigger: true,
      alignment: "left"
   });

   // Notification, Profile, Translation, Settings Dropdown & Horizontal Dropdown
   $p(".notification-button, .profile-button, .translation-button, .dropdown-settings").dropdown({
      inDuration: 300,
      outDuration: 225,
      constrainWidth: false,
      hover: false,
      gutter: 0,
      coverTrigger: false,
      alignment: "right"
   });

   $p(".dropdown-menu").dropdown({
      inDuration: 300,
      outDuration: 225,
      constrainWidth: false,
      hover: false,
      gutter: 0,
      coverTrigger: false,
      alignment: "right",
      closeOnClick: false,
   });

   // horizonatal nav nested dropdown
   $p(".dropdownSub-menu").dropdown({
      closeOnClick: false,
      constrainWidth: false,
      alignment: "left",
      inDuration: 300,
      outDuration: 225,
      gutter: 0,
      coverTrigger: true,
      hover: true
   });
   // horzontal nested dropdown close and open on mouse enter and leave
   $p(".dropdown-submenu").on("mouseenter", function () {
      var $pthis = $p(this);
      $p(this).find(".dropdownSub-menu").dropdown('open');
      var dd = $pthis.find('.dropdown-content');

      if (dd) {
         var ddLeft = dd.offset().left,
            ddWidth = dd.width();
         // Add class to horizontal sub menu if screen width is small
         if ($p("html[data-textdirection='rtl']").length > 0) {
            if (ddLeft >= ddWidth) {
               $pthis.find(".dropdown-content").removeClass("right-open").addClass("left-open");
            }
            else {
               $pthis.find(".dropdown-content").removeClass("left-open").addClass("right-open");
            }
         }
         else {
            if (((window.innerWidth) - (ddLeft + ddWidth)) <= (ddWidth)) {
               $pthis.find(".dropdown-content").removeClass("left-open").addClass("right-open");
            }
            else {
               $pthis.find(".dropdown-content").removeClass("right-open").addClass("left-open");
            }
         }
      }
   })

   $p(".dropdown-submenu").on("mouseleave", function () {
      var $pthis = $p(this);
      $pthis.find(".dropdownSub-menu").dropdown('close');
      // remove left and right open class in mouse leave
      $pthis.find(".dropdown-content").removeClass("right-open");
      $pthis.find(".dropdown-content").removeClass("left-open");

   })
   // Fab
   $p(".fixed-action-btn").floatingActionButton();
   $p(".fixed-action-btn.horizontal").floatingActionButton({
      direction: "left"
   });
   $p(".fixed-action-btn.click-to-toggle").floatingActionButton({
      direction: "left",
      hoverEnabled: false
   });
   $p(".fixed-action-btn.toolbar").floatingActionButton({
      toolbarEnabled: true
   });

   // Materialize Tabs
   $p(".tab-demo")
      .show()
      .tabs();
   $p(".tab-demo-active")
      .show()
      .tabs();

   // Materialize scrollSpy
   $p(".scrollspy").scrollSpy();

   // Materialize tooltip
   $p(".tooltipped").tooltip({
      delay: 50
   });

   // Collapsible inside page not for sidebar
   var allCollapse = document.querySelectorAll(".collapsible");
   M.Collapsible.init(allCollapse);
   // Collapsible expandable
   var elem = document.querySelector('.collapsible.expandable');
   var instance = M.Collapsible.init(elem, {
      accordion: false
   });

   // Breadcrumbs with bg image (vertical-dark-menu-template)
   if (breadcrumbsWrapper.attr("data-image")) {
      var imageUrl = breadcrumbsWrapper.attr("data-image");
      breadcrumbsWrapper.addClass("breadcrumbs-bg-image");
      breadcrumbsWrapper.css("background-image", "url(" + imageUrl + ")");
   }

   // Main Menu (SideNav)
   //------------------
   var collapsibleSubCollapsible = $p("li.active .collapsible-sub .collapsible");
   var sidemainCollapse = document.querySelectorAll(".sidenav-main .collapsible");

   // Init collapsible
   M.Collapsible.init(sidemainCollapse, {
      accordion: true,
      onOpenStart: function () {
         // Removed open class first and add open at collapsible active
         $p(".collapsible > li.open").removeClass("open");
         setTimeout(function () {
            $p("#slide-out > li.active > a")
               .parent()
               .addClass("open");
         }, 10);
      }
   });

   // Add open class on init
   if ($p("body").hasClass("menu-collapse")) {
      var sidenavCollapse = $p(".sidenav-main .collapsible");
      if ($p("#slide-out > li.active").children().length > 1) {
         $p("#slide-out > li.active > a")
            .parent()
            .addClass("close");
      }
      M.Collapsible.getInstance(sidenavCollapse)
         .close($p(".collapsible .close")
            .index())
   } else {
      if ($p("#slide-out > li.active").children().length > 1) {
         $p("#slide-out > li.active > a")
            .parent()
            .addClass("open");
      }
   }

   // Open active menu for multi level
   if (collapsibleSubCollapsible.find("a.active").length > 0) {
      collapsibleSubCollapsible
         .find("a.active")
         .closest("div.collapsible-body")
         .show();
      collapsibleSubCollapsible
         .find("a.active")
         .closest("div.collapsible-body")
         .closest("li")
         .addClass("active");
   }

   // Auto Scroll menu to the active item
   var position;
   if (
      $p(".sidenav-main li a.active")
         .parent("li.active")
         .parent("ul.collapsible-sub").length > 0
   ) {
      position = $p(".sidenav-main li a.active")
         .parent("li.active")
         .parent("ul.collapsible-sub")
         .position();
   } else {
      position = $p(".sidenav-main li a.active")
         .parent("li.active")
         .position();
   }
   setTimeout(function () {
      if (position !== undefined) {
         $p(".sidenav-main ul")
            .stop()
            .animate({ scrollTop: position.top - 300 }, 300);
      }
   }, 300);

   // On SideNav toggle button click: collapse menu
   $p(".nav-collapsible .navbar-toggler").click(function () {
      // Toggle navigation expan and collapse on radio click
      toogleMenuCollapse();
      // Set navigation lock / unlock with radio icon
      if (
         $p(this)
            .children()
            .text() == "radio_button_unchecked"
      ) {
         $p(this)
            .children()
            .text("radio_button_checked");
         sidenavMain.addClass("nav-lock");
         navCollapsible.addClass("sideNav-lock");
      } else {
         $p(this)
            .children()
            .text("radio_button_unchecked");
         sidenavMain.removeClass("nav-lock");
         navCollapsible.removeClass("sideNav-lock");
      }
   });

   // Expand navigation on mouseenter event
   $p(".sidenav-main.nav-collapsible, .navbar .brand-sidebar").mouseenter(function () {
      if (!$p(".sidenav-main.nav-collapsible").hasClass("nav-lock")) {
         $p(".sidenav-main.nav-collapsible, .navbar .nav-collapsible")
            .addClass("nav-expanded")
            .removeClass("nav-collapsed");
         $p("#slide-out > li.close > a")
            .parent()
            .addClass("open")
            .removeClass("close");
         setTimeout(function () {
            // Open only if collapsible have the children
            if ($p(".collapsible .open").children().length > 1) {
               var collapseEl = $p(".sidenav-main .collapsible");
               var collapseInstance = M.Collapsible.getInstance(collapseEl);
               collapseInstance.open($p(".collapsible .open").index());
            }
         }, 100);
      }
   });

   // Collapse navigation on mouseleave event
   $p(".sidenav-main.nav-collapsible, .navbar .brand-sidebar").mouseleave(function () {
      navigationCollapse();
   });

   // Right side slide-out
   //---------------------

   //Main Left Sidebar Menu // sidebar-collapse
   $p(".sidenav").sidenav({
      edge: "left" // Choose the horizontal origin
   });

   //Main Right Sidebar
   $p(".slide-out-right-sidenav").sidenav({
      edge: "right"
   });

   //Main Right Sidebar Chat
   $p(".slide-out-right-sidenav-chat").sidenav({
      edge: "right"
   });

   // check for if touch device
   if (!is_touch_device()) {
      // Right side slide-out (Chat, settings & timeline)
      if ($p("#slide-out.leftside-navigation").length > 0) {
         if (!$p("#slide-out.leftside-navigation").hasClass("native-scroll")) {
            var ps_leftside_nav = new PerfectScrollbar(".leftside-navigation", {
               wheelSpeed: 2,
               wheelPropagation: false,
               minScrollbarLength: 20
            });
         }
      }
      if ($p(".slide-out-right-body").length > 0) {
         var ps_slideout_right = new PerfectScrollbar(".slide-out-right-body #messages, .chat-body .collection", {
            suppressScrollX: true,
            wheelPropagation: false
         });
         var ps_slideout_right = new PerfectScrollbar(".slide-out-right-body #settings", {
            suppressScrollX: true,
            wheelPropagation: false
         });
         var ps_slideout_right = new PerfectScrollbar(".slide-out-right-body #activity", {
            suppressScrollX: true,
            wheelPropagation: false
         });
      }
      if ($p(".chat-body .collection").length > 0) {
         var ps_slideout_chat = new PerfectScrollbar(".chat-body .collection", {
            suppressScrollX: true
         });
      }
      // for horizonatal nav scroll
      if ($p("#ul-horizontal-nav").length > 0) {
         var ps_horizontal_nav = new PerfectScrollbar("#ul-horizontal-nav", {
            wheelPropagation: false,
         });
      }

      $p("#ul-horizontal-nav").on("mouseenter", function () {
         ps_horizontal_nav.update();
      })
   }
   else {
      $p('.leftside-navigation,.slide-out-right-body, .chat-body .collection, #ul-horizontal-nav').css('overflow', "scroll");
   }

   //Chat search filter
   $p("#messages .header-search-input").on("keyup", function () {
      $p(".chat-user").css("animation", "none");
      var value = $p(this)
         .val()
         .toLowerCase();
      if (value != "") {
         $p(".right-sidebar-chat .right-sidebar-chat-item").filter(function () {
            $p(this).toggle(
               $p(this)
                  .text()
                  .toLowerCase()
                  .indexOf(value) > -1
            );
         });
      } else {
         // if search filter box is empty
         $p(".right-sidebar-chat .right-sidebar-chat-item").show();
      }
   });

   // Chat scroll till bottom of the chat content area
   var chatScrollAuto = $p("#right-sidebar-nav #slide-out-chat .chat-body .collection");
   if (chatScrollAuto.length > 0) {
      chatScrollAuto[0].scrollTop = chatScrollAuto[0].scrollHeight;
   }

   // Fullscreen
   function toggleFullScreen() {
      if (
         (document.fullScreenElement && document.fullScreenElement !== null) ||
         (!document.mozFullScreen && !document.webkitIsFullScreen)
      ) {
         if (document.documentElement.requestFullScreen) {
            document.documentElement.requestFullScreen();
         } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
         } else if (document.documentElement.webkitRequestFullScreen) {
            document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
         } else if (document.documentElement.msRequestFullscreen) {
            if (document.msFullscreenElement) {
               document.msExitFullscreen();
            } else {
               document.documentElement.msRequestFullscreen();
            }
         }
      } else {
         if (document.cancelFullScreen) {
            document.cancelFullScreen();
         } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
         } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
         }
      }
   }
   $p(".toggle-fullscreen").click(function () {
      toggleFullScreen();
   });

   // Detect touch screen and enable scrollbar if necessary
   function is_touch_device() {
      try {
         document.createEvent("TouchEvent");
         return true;
      } catch (e) {
         return false;
      }
   }
   if (is_touch_device()) {
      $p("#nav-mobile").css({
         overflow: "auto"
      });
   }

   //Change language according to data-language of dropdown item
   $p(".dropdown-language .dropdown-item").on("click", function () {
      var $pthis = $p(this);
      $pthis.siblings(".selected").removeClass("selected");
      $pthis.addClass("selected");
      var selectedFlag = $pthis.find(".flag-icon").attr("class");
      $p(".translation-button .flag-icon")
         .removeClass()
         .addClass(selectedFlag);
   });
   // set language flag icon as
   var language = $p('html')[0].lang;
   if (language !== null) {
      // get the selected flag class
      var selectedFlag = $p(".dropdown-language .dropdown-item").find("a[data-language=" + language + "] .flag-icon").attr("class");
      // set the class in button
      $p(".translation-button .flag-icon")
         .removeClass()
         .addClass(selectedFlag);
   }

   // Horizontal-nav active parent
   if ($p("#ul-horizontal-nav li.active").length > 0) {
      $p('#ul-horizontal-nav li.active').closest('ul').parents('li').addClass('active');
   }

   // RTL specific
   if ($p("html[data-textdirection='rtl']").length > 0) {
      //Main Left Sidebar Menu // sidebar-collapse
      $p(".sidenav").sidenav({
         edge: "right" // Choose the horizontal origin
      });
      $p(".slide-out-right-sidenav").sidenav({
         edge: "left"
      });
      //Main Right Sidebar Chat
      $p(".slide-out-right-sidenav-chat").sidenav({
         edge: "left"
      });
   }
});

//Collapse menu on below 994 screen
$p(window).on("resize", function () {
   if ($p(window).width() < 994) {
      if (sidenavMain.hasClass("nav-collapsed")) {
         sidenavMain.removeClass("nav-collapsed").addClass("nav-lock nav-expanded");
         navCollapsible.removeClass("nav-collapsed").addClass("sideNav-lock");
      }
   } else if ($p(window).width() > 993 && $p("body").hasClass("menu-collapse")) {
      if (sidenavMain.hasClass("nav-lock")) {
         sidenavMain.removeClass("nav-lock nav-expanded").addClass("nav-collapsed");
         navCollapsible.removeClass("sideNav-lock").addClass("nav-collapsed");
      }
   }
});
