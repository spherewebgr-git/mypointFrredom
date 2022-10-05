/*================================================================================
  Item Name: Materialize - Material Design Admin Template
  Version: 5.0
  Author: PIXINVENT
  Author URL: https://themeforest.net/user/pixinvent/portfolio
================================================================================*/

$s = jQuery.noConflict();

var searchListLi = $s(".search-list li"),
   searchList = $s(".search-list"),
   contentOverlay = $s(".content-overlay"),
   searchSm = $s(".search-sm"),
   searchBoxSm = $s(".search-input-sm .search-box-sm"),
   searchListSm = $s(".search-list-sm");

$s(function () {
   "use strict";

   // On search input focus, Add search focus class
   $s(".header-search-input")
      .focus(function () {
         $s(this)
            .parent("div")
            .addClass("header-search-wrapper-focus");
      })
      .blur(function () {
         $s(this)
            .parent("div")
            .removeClass("header-search-wrapper-focus");
      });

   //Search box form small screen
   $s(".search-button").click(function (e) {
      if (searchSm.is(":hidden")) {
         searchSm.show();
         searchBoxSm.focus();
      } else {
         searchSm.hide();
         searchBoxSm.val("");
      }
   });

   // search input get focus
   $s('.search-input-sm').on('click', function () {
      searchBoxSm.focus();
   });

   $s(".search-sm-close").click(function (e) {
      searchSm.hide();
      searchBoxSm.val("");
   });

   // Search scrollbar
   if ($s(".search-list").length > 0) {
      var ps_search_nav = new PerfectScrollbar(".search-list", {
         wheelSpeed: 2,
         wheelPropagation: false,
         minScrollbarLength: 20
      });
   }
   if (searchListSm.length > 0) {
      var ps_search2_nav = new PerfectScrollbar(".search-list-sm", {
         wheelSpeed: 2,
         wheelPropagation: false,
         minScrollbarLength: 20
      });
   }

   // Quick search
   //-------------
   var $sfilename = $s(".header-search-wrapper .header-search-input,.search-input-sm .search-box-sm").data("search");

   // Navigation Search area Close
   $s(".search-sm-close").on("click", function () {
      searchBoxSm.val("");
      searchBoxSm.blur();
      searchListLi.remove();
      searchList.addClass("display-none");
      if (contentOverlay.hasClass("show")) {
         contentOverlay.removeClass("show");
      }
   });

   // Navigation Search area Close on click of content overlay
   contentOverlay.on("click", function () {
      searchListLi.remove();
      contentOverlay.removeClass("show");
      searchSm.hide();
      searchBoxSm.val("");
      searchList.addClass("display-none");
      $s(".search-input-sm .search-box-sm, .header-search-input").val("");
   });

   // Search filter
   $s(".header-search-wrapper .header-search-input, .search-input-sm .search-box-sm").on("keyup", function (e) {
      contentOverlay.addClass("show");
      searchList.removeClass("display-none");
      var $sthis = $s(this);
      if (e.keyCode !== 38 && e.keyCode !== 40 && e.keyCode !== 13) {
         if (e.keyCode == 27) {
            contentOverlay.removeClass("show");
            $sthis.val("");
            $sthis.blur();
         }
         // Define variables
         var value = $s(this)
            .val()
            .toLowerCase(), //get values of inout on keyup
            liList = $s("ul.search-list li"); // get all the list items of the search
         liList.remove();
         // If input value is blank
         if (value != "") {
            var $sstartList = "",
               $sotherList = "",
               $shtmlList = "",
               $sactiveItemClass = "",
               a = 0;
            // getting json data from file for search results
            $s.getJSON("/json/" + $sfilename + ".json", function (data) {
               for (var i = 0; i < data.listItems.length; i++) {
                  // Search list item start with entered letters and create list
                  if (
                     (data.listItems[i].name.toLowerCase().indexOf(value) == 0 && a < 4) ||
                     (!(data.listItems[i].name.toLowerCase().indexOf(value) == 0) &&
                        data.listItems[i].name.toLowerCase().indexOf(value) > -1 &&
                        a < 4)
                  ) {
                     if (a === 0) {
                        $sactiveItemClass = "current_item";
                     } else {
                        $sactiveItemClass = "";
                     }
                     $sstartList +=
                        '<li class="auto-suggestion ' +
                        $sactiveItemClass +
                        '">' +
                        '<a class="collection-item" href=' +
                        data.listItems[i].url +
                        ">" +
                        '<div class="display-flex">' +
                        '<div class="display-flex align-item-center flex-grow-1">' +
                        '<span class="material-icons" data-icon="' +
                        data.listItems[i].icon +
                        '">' +
                        data.listItems[i].icon +
                        "</span>" +
                        '<div class="member-info display-flex flex-column"><span class="black-text">' +
                        data.listItems[i].name +
                        '</span><small class="grey-text">' +
                        data.listItems[i].category +
                        "</small>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</a>" +
                        "</li>";
                     a++;
                  }
               }
               if ($sstartList == "" && $sotherList == "") {
                  $sotherList = $s("#search-not-found").html();
               }
               var $smainPage = $s("#page-search-title").html();
               var defaultList = $s("#default-search-main").html();

               $shtmlList = $smainPage.concat($sstartList, $sotherList, defaultList); // merging start with and other list
               $s("ul.search-list").html($shtmlList); // Appending list to <ul>
            });
         } else {
            // if search input blank, hide overlay
            if (contentOverlay.hasClass("show")) {
               contentOverlay.removeClass("show");
               searchList.addClass("display-none");
            }
         }
      }
      // for large screen search list
      if ($s(".header-search-wrapper .current_item").length) {
         searchList.scrollTop(0);
         searchList.scrollTop($s('.search-list .current_item:first').offset().top - searchList.height());
      }
      // for small screen search list
      if ($s(".search-input-sm .current_item").length) {
         searchListSm.scrollTop(0);
         searchListSm.scrollTop($s('.search-list-sm .current_item:first').offset().top - searchListSm.height());
      }
   });

   // small screen search box form submit prevent
   $s('#navbarForm').on('submit', function (e) {
      e.preventDefault();
   })
   // If we use up key(38) Down key (40) or Enter key(13)
   $s(window).on("keydown", function (e) {
      var $scurrent = $s(".search-list li.current_item"),
         $snext,
         $sprev;
      if (e.keyCode === 40) {
         $snext = $scurrent.next();
         $scurrent.removeClass("current_item");
         $scurrent = $snext.addClass("current_item");
      } else if (e.keyCode === 38) {
         $sprev = $scurrent.prev();
         $scurrent.removeClass("current_item");
         $scurrent = $sprev.addClass("current_item");
      }

      if (e.keyCode === 13 && $s(".search-list li.current_item").length > 0) {
         var selected_item = $s("li.current_item a");
         window.location = $s("li.current_item a").attr("href");
         $s(selected_item).trigger("click");
      }
   });

   searchList.mouseenter(function () {


      if ($s(".search-list").length > 0) {
         ps_search_nav.update();
      }
      if (searchListSm.length > 0) {
         ps_search2_nav.update();
      }
   });
   // Add class on hover of the list
   $s(document).on("mouseenter", ".search-list li", function (e) {
      $s(this)
         .siblings()
         .removeClass("current_item");
      $s(this).addClass("current_item");
   });
   $s(document).on("click", ".search-list li", function (e) {
      e.stopPropagation();
   });
});

//Collapse menu on below 994 screen
$s(window).on("resize", function () {
   // search result remove on screen resize
   if ($s(window).width() < 992) {
      $s(".header-search-input").val("");
      $s(".header-search-input").closest(".search-list li").remove();
   }
   if ($s(window).width() > 993) {
      searchSm.hide();
      searchBoxSm.val("");
      $s(".search-input-sm .search-box-sm").val("");
   }
});
