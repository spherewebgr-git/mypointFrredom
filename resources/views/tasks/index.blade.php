{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Λίστα Υπενθυμίσεων')

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-sidebar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/quill.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-todo.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
        <!-- Search for small screen-->
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Λίστα Υπενθυμίσεων</span></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12">
        <div class="container">
            <!-- Sidebar Area Starts -->
            <div class="todo-overlay"></div>
            <div class="sidebar-left sidebar-fixed">
                <div class="sidebar">
                    <div class="sidebar-content">
                        <div class="sidebar-header">
                            <div class="sidebar-details">
                                <h5 class="m-0 sidebar-title"><i class="material-icons app-header-icon text-top">check_box</i> To-Do</h5>
                                <div class="row valign-wrapper mt-10 pt-2 animate fadeLeft">
                                    <div class="col s3 media-image">
                                        <img src="../../../app-assets/images/user/2.jpg" alt="" class="circle z-depth-2 responsive-img">
                                        <!-- notice the "circle" class -->
                                    </div>
                                    <div class="col s9">
                                        <p class="m-0 subtitle font-weight-700">Lawrence Collins</p>
                                        <p class="m-0 text-muted">lawrence.collins@xyz.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="sidebar-list" class="sidebar-menu list-group position-relative animate fadeLeft ps">
                            <div class="sidebar-list-padding app-sidebar" id="todo-sidenav">
                                <ul class="todo-list display-grid">
                                    <li class="active"><a href="#!" class="text-sub"><i class="material-icons mr-2"> mail_outline </i> Όλα</a>
                                    </li>
                                    <li class="sidebar-title">Φίλτρα</li>
                                    <li><a href="#!" class="text-sub"><i class="material-icons mr-2"> star_border </i> Με αστέρι</a></li>
                                    <li><a href="#!" class="text-sub"><i class="material-icons mr-2"> date_range </i> Σήμερα</a></li>
                                    <li>
                                        <a href="#!" class="text-sub"><i class="material-icons mr-2"> check </i> Ολοκληρωμένα</a></li>
                                    <li class="sidebar-title">ΠΕΛΑΤΗΣ</li>
                                    <div class="clients-list">

                                    </div>

                                </ul>
                            </div>
                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
                        <a href="#" data-target="todo-sidenav" class="sidenav-trigger hide-on-large-only"><i class="material-icons">menu</i></a>
                    </div>
                </div>
            </div>
            <!-- Sidebar Area Ends -->

            <!-- Content Area Starts -->
            <div class="app-todo">
                <div class="content-area content-right">
                    <div class="app-wrapper">
                        <div class="app-search">
                            <i class="material-icons mr-2 search-icon">search</i>
                            <input type="text" placeholder="Αναζήτηση Υπενθύμισης" class="app-filter" id="todo_filter">
                        </div>
                        <div class="card card card-default scrollspy border-radius-6 fixed-width">
                            <div class="card-content p-0 pb-1">
                                <div class="todo-header">
                                    <div class="list-content"></div>
                                    <div class="todo-action">
                                        <span class="sort-task"><i class="material-icons grey-text">sort</i></span>
                                        <div class="select-action">
                                            <!-- Dropdown Trigger -->
                                            <a class="dropdown-trigger grey-text" href="#" data-target="dropdown1">
                                                <i class="material-icons">more_vert</i>
                                            </a><ul id="dropdown1" class="dropdown-content" tabindex="0">
                                                <li tabindex="0"><a href="#!">Όλα</a></li>
                                                <li tabindex="0"><a href="#!">Ολοκληρωμένα</a></li>
                                                <li tabindex="0"><a href="#!">Προς επίλυση</a></li>
                                                <li tabindex="0"><a href="#!">Με αστέρι</a></li>
                                                <li tabindex="0"><a href="#!">Χωρίς αστέρι</a></li>
                                            </ul>
                                            <!-- Dropdown Structure -->

                                        </div>
                                    </div>
                                </div>
                                @if(isset($tasks))
                                <ul class="collection todo-collection ps ps--active-y" style="max-height: 587px;">
                                    @foreach($tasks as $task)

                                    <li class="collection-item todo-items" data-done="" data-client="{{getClient($task->client_id)['company']}}" data-starred="" data-priority="{{$task->priority}}">
                                        <div class="todo-move">
                                            <i class="material-icons icon-move">more_vert</i>
                                        </div>
                                        <div class="list-left">
                                            <form class="change-task-state" method="post" action="{{route('tasks.state', ['task' => $task])}}">
                                                @csrf
                                                <label>
                                                    <input type="checkbox" class="change-status" name="taskstatus" @if($task->completed == 1) checked @endif>
                                                    <span></span>
                                                </label>
                                            </form>

                                            <i class="material-icons favorite">star_border</i>
                                        </div>
                                        <div class="list-content">
                                            <div class="list-title-area">
                                                <div class="list-title" @if($task->completed == 1) style="text-decoration: line-through;" @endif>{{$task->taskName}}</div>
                                                @if($task->client_id)
                                                <span class="company badge grey lighten-2" data-company="{{getClient($task->client_id)['company']}}">{{\Illuminate\Support\Str::limit(getClient($task->client_id)['company'], 50, $end='...')}}</span>
                                                    @endif
                                            </div>

                                            <div class="list-desc" @if($task->completed == 1) style="text-decoration: line-through;" @endif>{{$task->description}}</div>

                                        </div>
                                        <div class="list-right">
                                            <div class="list-date"> {{ Carbon\Carbon::parse($task->task_date)->format('d M') }} </div>
                                            <div class="delete-task"><a href="{{route('tasks.delete', ['task' => $task])}}"><i class="material-icons">delete</i></a></div>
                                        </div>
                                    </li>
                                    @endforeach

                                    <li class="collection-item no-data-found">
                                        <h6 class="center-align font-weight-500">No Results Found</h6>
                                    </li>
                                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                    </div>
                                    <div class="ps__rail-y" style="top: 0px; height: 587px; right: 0px;">
                                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 445px;"></div>
                                    </div>
                                </ul>
                                @endif;
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Content Area Ends -->

            <!-- Add new todo popup -->
            <div style="bottom: 54px; right: 19px;" class="fixed-action-btn direction-top">
                <a class="btn-floating btn-large primary-text gradient-shadow todo-sidebar-trigger">
                    <i class="material-icons">note_add</i>
                </a>
            </div>
            <!-- Add new todo popup Ends-->

            <!-- todo compose sidebar -->
            <div class="todo-compose-sidebar ps ps--active-y">
                <div class="card quill-wrapper">
                    <div class="card-content pt-0">
                        <div class="card-header display-flex pb-2">
                            <h3 class="card-title todo-title-label">ΝΕΑ ΥΠΕΝΘΥΜΙΣΗ</h3>

                            <div class="close close-icon">
                                <i class="material-icons">close</i>
                            </div>
                        </div>
                        @if(isset($task))
                        <!-- form start -->
                        <form action="{{route('tasks.store')}}" class="edit-todo-item mt-10 mb-10">
                            @csrf
                            <div class="input-field">
                                <input type="text" name="task_title" class="edit-todo-item-title" id="edit-item-form">
                                <label for="edit-item-form">Δώστε τίτλο υπενθύμισης</label>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 priority-label">
                                    <input name="priority" id="priority" type="range" min="1" max="5" value="5" />
                                    <label for="priority">Προτεραιότητα</label>
                                    <div class="priority-info">
                                        <div class="maximum">Υψηλή</div>
                                        <div class="medium">Μέτρια</div>
                                        <div class="minimum">Χαμηλή</div>
                                    </div>
                                </div>
                            </div>

                            <div class="input-field display-flex align-items-center">
                                <i class="material-icons mr-5">contacts</i>
                                @if(isset($clients))
                                <select name="taskClient" class="browser-default select-tags select2-hidden-accessible">
                                    @foreach($clients as $client)
                                        <option value="{{$client->id}}">{{$client->company}}</option>
                                    @endforeach
                                </select>
                                @endif
{{--                                <span class="select2 select2-container select2-container--default select2-container--disabled" dir="ltr" data-select2-id="2" style="width: 100%;">--}}
{{--                                    <span class="selection"><span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="true"><ul class="select2-selection__rendered"><li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" placeholder="" disabled="" style="width: 0.75em;"></li></ul></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>--}}
{{--                                <i class="material-icons ml-5 tags-toggler cursor-pointer">add_circle_outline</i>--}}
                            </div>
                            <div class="divider"></div>
                            <div class="display-flex align-items-center mt-5">
                                <span class="mr-5">Ημ/νία Δημιουργίας:</span>
                                <small>{{ Carbon\Carbon::createFromTimestamp(strtotime($task->created_at))->diffForHumans() }}</small>
                            </div>
                            <div class="input-field">
                                <div class="snow-container mt-7">
                                    <div class="comment-editor ql-container ql-snow">
                                        <div class="ql-editor ql-blank" data-gramm="false" contenteditable="true" data-placeholder="Περισσότερες πληροφορίες....">
                                            <p><br></p>
                                        </div>
                                        <div class="ql-clipboard" contenteditable="true" tabindex="-1"></div>
                                        <div class="ql-tooltip ql-hidden">
                                            <a class="ql-preview" target="_blank" href="about:blank"></a>
                                            <input type="text" data-formula="e=mc^2" data-link="https://quilljs.com" data-video="Embed URL">
                                            <a class="ql-action"></a>
                                            <a class="ql-remove"></a>
                                        </div>
                                    </div>
                                    <div class="comment-quill-toolbar ql-toolbar ql-snow">
                                      <span class="ql-formats mr-0">
                                        <button class="ql-bold" type="button"><svg viewBox="0 0 18 18"> <path class="ql-stroke" d="M5,4H9.5A2.5,2.5,0,0,1,12,6.5v0A2.5,2.5,0,0,1,9.5,9H5A0,0,0,0,1,5,9V4A0,0,0,0,1,5,4Z"></path> <path class="ql-stroke" d="M5,9h5.5A2.5,2.5,0,0,1,13,11.5v0A2.5,2.5,0,0,1,10.5,14H5a0,0,0,0,1,0,0V9A0,0,0,0,1,5,9Z"></path> </svg></button>
                                        <button class="ql-italic" type="button"><svg viewBox="0 0 18 18"> <line class="ql-stroke" x1="7" x2="13" y1="4" y2="4"></line> <line class="ql-stroke" x1="5" x2="11" y1="14" y2="14"></line> <line class="ql-stroke" x1="8" x2="10" y1="14" y2="4"></line> </svg></button>
                                        <button class="ql-underline" type="button"><svg viewBox="0 0 18 18"> <path class="ql-stroke" d="M5,3V9a4.012,4.012,0,0,0,4,4H9a4.012,4.012,0,0,0,4-4V3"></path> <rect class="ql-fill" height="1" rx="0.5" ry="0.5" width="12" x="3" y="15"></rect> </svg></button>
                                        <button class="ql-link" type="button"><svg viewBox="0 0 18 18"> <line class="ql-stroke" x1="7" x2="11" y1="7" y2="11"></line> <path class="ql-even ql-stroke" d="M8.9,4.577a3.476,3.476,0,0,1,.36,4.679A3.476,3.476,0,0,1,4.577,8.9C3.185,7.5,2.035,6.4,4.217,4.217S7.5,3.185,8.9,4.577Z"></path> <path class="ql-even ql-stroke" d="M13.423,9.1a3.476,3.476,0,0,0-4.679-.36,3.476,3.476,0,0,0,.36,4.679c1.392,1.392,2.5,2.542,4.679.36S14.815,10.5,13.423,9.1Z"></path> </svg></button>
                                        <button class="ql-image" type="button"><svg viewBox="0 0 18 18"> <rect class="ql-stroke" height="10" width="12" x="3" y="4"></rect> <circle class="ql-fill" cx="6" cy="7" r="1"></circle> <polyline class="ql-even ql-fill" points="5 12 5 11 7 9 8 10 11 7 13 9 13 12 5 12"></polyline> </svg></button>
                                      </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @endif
                        <div class="card-action pl-0 pr-0 right-align">
                            <button class="btn-small waves-effect waves-light add-todo">
                                <span>Προσθήκη Υπενθύμισης</span>
                            </button>
                            <button class="btn-small waves-effect waves-light update-todo display-none">
                                <span>Αποθήκευση Αλλαγών</span>
                            </button>
                        </div>
                        <!-- form start end-->
                    </div>
                </div>
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 938px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 929px;"></div></div></div><!-- START RIGHT SIDEBAR NAV -->
            <aside id="right-sidebar-nav">
                <div id="slide-out-right" class="slide-out-right-sidenav sidenav rightside-navigation right-aligned">
                    <div class="row">
                        <div class="slide-out-right-title">
                            <div class="col s12 border-bottom-1 pb-0 pt-1">
                                <div class="row">
                                    <div class="col s2 pr-0 center">
                                        <i class="material-icons vertical-text-middle"><a href="#" class="sidenav-close">clear</a></i>
                                    </div>
                                    <div class="col s10 pl-0">
                                        <ul class="tabs">

                                            <li class="tab col s4 p-0">
                                                <a href="#settings">
                                                    <span>Settings</span>
                                                </a>
                                            </li>
                                            <li class="tab col s4 p-0">
                                                <a href="#activity">
                                                    <span>Activity</span>
                                                </a>
                                            </li>
                                            <li class="indicator" style="left: 0px; right: 188px;"></li></ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </aside>
            <!-- END RIGHT SIDEBAR NAV -->
        </div>
        <div class="content-overlay"></div>
    </div>
    @endsection
@section('page-script')
    <script src="{{asset('js/scripts/jquery-sortable-min.js')}}"></script>
    <script src="{{asset('js/scripts/select2.full.min.js')}}"></script>
    <script src="{{asset('js/scripts/quill.min.js')}}"></script>
    <script src="{{asset('js/scripts/app-todo.js')}}"></script>
    <script>
        $t = jQuery.noConflict();
        $t(document).ready(function(){
           $t('input.change-status').on('change', function() {
               $t(this).parent().parent('form').submit();
           });
            $t('.collection-item').on('click', function(){
                let description = $t(this).find('.list-desc').html();
                $t('.snow-container .ql-editor p').each(function(){
                    var str = $t(this).html();
                    var regex = /((http|https|ftp):\/\/[\w?=&.\/-;#~%-]+(?![\w\s?&.\/;#~%"=-]*>))/g;
                    var replaced_text = description.replace(regex, "<a href='$1' target='_blank'>$1</a>");

                    $t(this).html(replaced_text);
                });
            });
            let companies = [];
            $t('.company.badge').each(function() {
                let company = $t(this).data('company');
                let found = $t.inArray(company, companies);
                if(found < 0) {
                    companies.push(company);
                }
            });
            $t.each(companies, function(index, value){
                $t('.clients-list').append('<li><a href="#!" title="'+value+'" class="client-filter text-sub"><i class="purple-text material-icons small-icons mr-2">fiber_manual_record </i> '+value.substr(0, 21)+'... '+'</a></li>')
            });
        });
        $t(document).on('click', '.client-filter', function(){
            let companyName = $t(this).attr('title');

            $t('.collection-item').hide()
            $t('.collection-item[data-client="'+companyName+'"]').show()
        });
    </script>

@endsection
