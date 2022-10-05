$i = jQuery.noConflict();

$i(document).ready(function () {
  /********Invoice List ********/
  /* --------------------------- */

  /* Invoice edit */
  /* ------------*/

  /* form repeater jquery */
  var uniqueId = 1;
  if ($i(".invoice-item-repeater").length) {
    $i(".invoice-item-repeater").repeater({
      show: function () {
        /* Assign unique id to new dropdown */
        $i(this).find(".dropdown-button").attr("data-target", "dropdown-discount" + uniqueId + "");
        $i(this).find(".dropdown-content").attr("id", "dropdown-discount" + uniqueId + "");
        uniqueId++;
        /* showing the new repeater */
        $i(this).slideDown();
      },
      hide: function (deleteElement) {
        $i(this).slideUp(deleteElement);
      }
    });
  }
  /* Onclick of Invoice Apply button Discount value change */
  $i(document).on("click", ".invoice-apply-btn", function () {
    var $this = $i(this);
    var discount = $this.closest(".dropdown-content").find("#discount").val();
    var tax1 = $this.closest(".dropdown-content").find("#Tax1 option:selected").val();
    var tax2 = $this.closest(".dropdown-content").find("#Tax2 option:selected").val();
    $this.parents().eq(4).find(".discount-value").html(discount + "%");
    $this.parents().eq(4).find(".tax1").html(tax1);
    $this.parents().eq(4).find(".tax2").html(tax2);
    $i('.dropdown-button').dropdown("close"); /*dropdown close */
  });
  /* Dropdown close onclick of cancel btn*/
  $i(document).on("click", ".invoice-cancel-btn", function () {
    $i('.dropdown-button').dropdown("close");
  });
  /* on product change also change product description */
  $i(document).on("change", ".invoice-item-select", function (e) {
    var selectOption = this.options[e.target.selectedIndex].text;
    /*switch case for product select change also change product description */
    switch (selectOption) {
      case "Frest Admin Template":
        $i(e.target)
          .closest(".invoice-item-filed")
          .find(".invoice-item-desc")
          .val("The most developer friendly & highly customisable HTML5 Admin");
        break;
      case "Stack Admin Template":
        $i(e.target)
          .closest(".invoice-item-filed")
          .find(".invoice-item-desc")
          .val("Ultimate Bootstrap 4 Admin Template for Next Generation Applications.");
        break;
      case "Robust Admin Template":
        $i(e.target)
          .closest(".invoice-item-filed")
          .find(".invoice-item-desc")
          .val(
            "Robust admin is super flexible, powerful, clean & modern responsive bootstrap admin template with unlimited possibilities"
          );
        break;
      case "Apex Admin Template":
        $i(e.target)
          .closest(".invoice-item-filed")
          .find(".invoice-item-desc")
          .val("Developer friendly and highly customizable Angular 7+ jQuery Free Bootstrap 4 gradient ui admin template. ");
        break;
      case "Modern Admin Template":
        $i(e.target)
          .closest(".invoice-item-filed")
          .find(".invoice-item-desc")
          .val("The most complete & feature packed bootstrap 4 admin template of 2019!");
        break;
    }
  });
  /* Initialize Dropdown */
  $i('.dropdown-button').dropdown({
    constrainWidth: false, // Does not change width of dropdown to that of the activator
    closeOnClick: false
  });
  $i(document).on("click", ".invoice-repeat-btn", function (e) {
    /* Dynamically added dropdown initialization */
    $i('.dropdown-button').dropdown({
      constrainWidth: false, // Does not change width of dropdown to that of the activator
      closeOnClick: false
    });
  })

  if ($i(".invoice-print").length > 0) {
    $i(".invoice-print").on("click", function () {
      window.print();
    })
  }
})
