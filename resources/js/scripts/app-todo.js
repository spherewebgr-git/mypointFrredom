/*
 * DataTables - Tables
 */
$d = jQuery.noConflict();
$d(document).ready(function () {
    "use strict";

    // For date picker
    // $d('.assign-date').datepicker({
    //    container: 'body',
    //    defaultDate: true,
    //    setDefaultDate: 'Nov 12, 2019',
    //    autoClose: true
    // });

    $d('.dropdown-trigger').dropdown({
        constrainWidth: false
    });
    // todo Quill Editor
    // -------------------
    var composeTodoEditor = new Quill(".snow-container .compose-editor", {
        modules: {
            toolbar: ".compose-quill-toolbar"
        },
        placeholder: "Add Description....",
        theme: "snow"
    });
    var commentTodoEditor = new Quill(".snow-container .comment-editor", {
        modules: {
            toolbar: ".comment-quill-toolbar"
        },
        placeholder: "Write a Comment....",
        theme: "snow"
    });
    // select tags
    $d(".select-tags").select2({
        /* the following code is used to disable x-scrollbar when click in select input and
        take 100% width in responsive also */
        dropdownAutoWidth: true,
        width: '100%',
    });
    // Dragula Drag and Drop
    $d("ul.todo-collection").sortable({
        group: "no-drop",
        handle: "i.icon-move"
    });

    $d(".todo-list li").click(function () {
        var $this = $d(this);
        if (!$this.hasClass("sidebar-title")) {
            $d("li").removeClass("active");
            $this.addClass("active");
        }
    });

    // Close other sidenav on click of any sidenav
    if ($d(window).width() > 900) {
        $d("#todo-sidenav").removeClass("sidenav");
    }

    // Remove Row
    $d('.app-todo i[type="button"]').click(function (e) {
        $d(this)
            .closest("tr")
            .remove();
    });

    $d(".app-todo .favorite").on("click", function (e) {
        e.stopPropagation();
        $d(this).toggleClass("amber-text");
    });

    $d(".app-todo .delete-tasks").on("click", function () {
        $d(".collection-item")
            .find("input:checked")
            .closest("li")
            .remove();
    });

    $d(".app-todo .delete-task").on("click", function () {
        $d(this)
            .closest("li")
            .remove();
    });

    // Sidenav
    $d(".sidenav-trigger").on("click", function () {
        if ($d(window).width() < 960) {
            $d(".sidenav").sidenav("close");
            $d(".app-sidebar").sidenav("close");
        }
    });

    // Toggle class of sidenav
    $d("#todo-sidenav").sidenav({
        onOpenStart: function () {
            $d("#sidebar-list").addClass("sidebar-show");
        },
        onCloseStart: function () {
            $d("#sidebar-list").removeClass("sidebar-show");
        }
    });

    //  Notifications & messages scrollable
    if ($d("#sidebar-list").length > 0) {
        var ps_sidebar_list = new PerfectScrollbar("#sidebar-list", {
            theme: "dark"
        });
    }
    if ($d(".app-todo .collection").length > 0) {
        var ps_todo_collection = new PerfectScrollbar(".app-todo .collection", {
            theme: "dark"
        });
    }

    // For todo sidebar on small screen
    if ($d(window).width() < 900) {
        $d(".sidebar-left.sidebar-fixed").removeClass("animate fadeLeft");
        $d(".sidebar-left.sidebar-fixed .sidebar").removeClass("animate fadeLeft");
    }

    // Check and Uncheck to do list line through css
    $d('.todo-collection input[name="foo"]').on('click', function () {
        var parentCls = $d(this).closest('.collection-item');
        if ($d(this).is(':checked')) {
            $d(parentCls).find('.list-content .list-title').css('textDecoration', 'line-through');
            $d(parentCls).find('.list-content .list-desc').css('textDecoration', 'line-through');
        }
        else {
            $d(parentCls).find('.list-content .list-title').css('textDecoration', 'none');
            $d(parentCls).find('.list-content .list-desc').css('textDecoration', 'none');
        }
    });

    // todo search filter
    $d("#todo_filter").on("keyup", function () {
        var value = $d(this).val().toLowerCase();
        if (value != "") {
            $d(".todo-collection .todo-items").filter(function () {
                $d(this).toggle($d(this).text().toLowerCase().indexOf(value) > -1);
            });
            var tbl_row = $d(".todo-items:visible").length; //here tbl_test is table name

            //Check if table has row or not
            if (tbl_row == 0) {
                if (!$d(".no-data-found").hasClass('show')) {
                    $d(".no-data-found").addClass('show');
                }
            }
            else {
                $d(".no-data-found").removeClass('show');
            }
        }
        else {
            // if search filter box is empty
            $d(".todo-collection .todo-items").show();
        }
    });

    // todo-overlay and sidebar hide
    // --------------------------------------------
    var todoOverlay = $d(".todo-overlay"),
        updateTodo = $d(".update-todo"),
        addTodo = $d(".add-todo"),
        todoComposeSidebar = $d(".todo-compose-sidebar"),
        editTodoItemTitle = $d(".edit-todo-item-title"),
        composeQleditor = $d(".compose-editor .ql-editor p"),
        selectTags = $d('.select-tags'),
        todoComplete = $d(".todo-complete"),
        todoTitleLabel = $d(".todo-title-label"),
        labelEditForm = $d("label[for='edit-item-form']");
    $d(".todo-sidebar-trigger").on("click", function () {
        todoOverlay.addClass("show");
        updateTodo.addClass("display-none");
        addTodo.removeClass("display-none");
        todoComposeSidebar.addClass("show");
        editTodoItemTitle.val('');
        composeQleditor.html("");
        labelEditForm.removeClass("active");
        selectTags.val("").trigger('change');
        todoComplete.addClass("hide");
        todoTitleLabel.removeClass("hide")
    })
    $d(
        ".todo-compose-sidebar .update-todo, .todo-compose-sidebar .close-icon, .todo-compose-sidebar .add-todo, .todo-overlay"
    ).on("click", function () {
        todoOverlay.removeClass("show");
        todoComposeSidebar.removeClass("show");
    });
    $d(".tags-toggler").on("click", function () {
        if ($d(".select-tags").is("[disabled]") > 0) {
            $d(".select-tags").removeAttr("disabled");
        }
        else {
            $d(".select-tags").attr("disabled", "true");

        }
    })
    var globalThis;
    $d(".todo-collection .list-content").on("click", function () {
        var $this = $d(this),
            todoTitle = $this.find(".list-title").html();
        globalThis = $this;
        editTodoItemTitle.val(todoTitle);
        labelEditForm.addClass("active");
        composeQleditor.html(todoTitle);
        updateTodo.removeClass("display-none");
        addTodo.addClass("display-none");
        todoOverlay.addClass("show");
        todoComposeSidebar.addClass("show");
        selectTags.val("Paypal").trigger('change');
        todoComplete.removeClass("hide");
        todoTitleLabel.addClass("hide");
    })
    todoComplete.on("click", function () {
        globalThis.parent().find('input[type=checkbox]').prop('checked', true);
        globalThis.parent().find('.list-content .list-title').css('textDecoration', 'line-through');
        globalThis.parent().find('.list-content .list-desc').css('textDecoration', 'line-through');
    })
    if (todoComposeSidebar.length > 0) {
        var ps_compose_sidebar = new PerfectScrollbar(".todo-compose-sidebar", {
            theme: "dark",
            wheelPropagation: false
        });
    }
    // for rtl
    if ($d("html[data-textdirection='rtl']").length > 0) {
        // Toggle class of sidenav
        $d("#todo-sidenav").sidenav({
            edge: "right",
            onOpenStart: function () {
                $d("#sidebar-list").addClass("sidebar-show");
            },
            onCloseStart: function () {
                $d("#sidebar-list").removeClass("sidebar-show");
            }
        });
    }
});

// Check All Checkbox
function toggle(source) {
    checkboxes = document.getElementsByName("foo");
    for (var i = 0, n = checkboxes.length; i < n; i++) {
        checkboxes[i].checked = source.checked;

        // Check and Uncheck to do list line through css
        var parentCls = $d(checkboxes[i]).closest(".collection-item");
        if (checkboxes[i].checked) {
            $d(parentCls)
                .find(".list-content .list-title")
                .css("textDecoration", "line-through");
            $d(parentCls)
                .find(".list-content .list-desc")
                .css("textDecoration", "line-through");
        } else {
            $d(parentCls)
                .find(".list-content .list-title")
                .css("textDecoration", "none");
            $d(parentCls)
                .find(".list-content .list-desc")
                .css("textDecoration", "none");
        }
    }
}

$d(window).on('resize', function () {
    resizetable();
    $d(".todo-compose-sidebar").removeClass("show");
    $d(".todo-overlay").removeClass("show");
    if ($d(window).width() > 899) {
        $d("#todo-sidenav").removeClass("sidenav");
    }

    if ($d(window).width() < 900) {
        $d("#todo-sidenav").addClass("sidenav");
    }
});
function resizetable() {
    // $d(".app-todo .collection").css({
    //    maxHeight: $d(window).height() - 380 + "px"
    // });
    if ($d(".vertical-layout").length > 0) {
        $d(".app-todo .collection").css({ maxHeight: $d(window).height() - 350 + "px" });
    }
    else {
        $d(".app-todo .collection").css({ maxHeight: $d(window).height() - 410 + "px" });
    }
}
resizetable();
