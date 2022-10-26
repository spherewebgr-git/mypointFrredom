{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Στατιστικά Κίνησης')

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div class="section">
        @include('pages.parts.homepage-stats')
{{--        @include('pages.parts.chart-dashboard')--}}
        <!--work collections start-->
        <div id="work-collections">
            <div class="row">
{{--                @include('pages.parts.projects-card')--}}
{{--                @include('pages.parts.issues-card')--}}
                @include('pages.parts.homepage-tasks')
                @include('pages.parts.unpaid-invoices-card')
            </div>
        </div>
        <!--work collections end-->
        <!--card widgets start-->
        <div id="card-widgets">
            <div class="row">

                @include('pages.parts.card-weather')
                @include('pages.parts.card-company')
            </div>
        </div>
        <!--card widgets end-->
    </div>
    <div class="tour-container"></div>
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/sparkline/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('vendors/chartjs/chart.min.js')}}"></script>

    <script src="{{asset('js/scripts/dashboard-analytics.js')}}"></script>
    <script>
        $c = jQuery.noConflict();
        $c(document).ready(function(){
            // Bar chart ( New Clients)
            $c("#clients-bar").sparkline([70, 80, 65, 78, 58, 80, 78, 80, 20, 50, 75, 65, 80, 70, 65, 90, 65, 80, 70, 65, 90], {
                type: "bar",
                height: "25",
                barWidth: 7,
                barSpacing: 4,
                barColor: "#b2ebf2",
                negBarColor: "#81d4fa",
                zeroColor: "#81d4fa"
            });
            $c('select').formSelect({
                'dropdown': 10
            });
        });
    </script>
    <script>
        $u = jQuery.noConflict();
        $u(document).ready(function(){
            let sum = 0;
            $u('.unpaid-invoice').each(function(){
                let price = $u(this).data('price');
                sum+=parseFloat(price) || 0;
            });
            $u('#unpaid .price').text(sum);

            displayTour();
            // tour initialize
            var tour = new Shepherd.Tour({
                defaultStepOptions: {
                    cancelIcon: {
                        enabled: true
                    },
                    classes: 'tour-container',
                    scrollTo: { behavior: 'smooth', block: 'center' }
                }
            });
            // step 1
            tour.addStep({
                title: 'Καλώς ήλθατε στον οδηγό χρήσης της εφαρμογής MyPoint',
                text: 'Κάντε κλικ στο "Επόμενο" για να ξεκινήσει η περιήγηση',
                attachTo: {
                    element: '#card-stats',
                    on: 'center'
                },
                buttons: [
                    {
                        action: function () {
                            return this.cancel();
                        },
                        classes: 'btn btn-light-indigo',
                        text: 'Τέλος'
                    },
                    {
                        action: function () {
                            return this.next();
                        },
                        classes: 'btn indigo',
                        text: 'Επόμενο'
                    }
                ],
                id: 'welcome'
            });
            // step 2
            tour.addStep({
                title: 'Σύνοψη Εσόδων τρέχοντος έτους.',
                text: 'Εδώ μπορείτε να βλέπεπε το σύνολο των εσόδων σας <strong>από αποδείξεις λιανικής</strong> για το τρέχων έτος.',
                attachTo: {
                    element: '.card-incomes-retails',
                    on: 'bottom'
                },
                buttons: [
                    {
                        action: function () {
                            return this.cancel();
                        },
                        classes: 'btn btn-light-indigo',
                        text: 'Έξοδος'
                    },
                    {
                        action: function () {
                            return this.back();
                        },
                        classes: 'card-incomes-retails',
                        text: 'Πίσω'
                    },
                    {
                        action: function () {
                            return this.next();
                        },
                        classes: 'btn indigo',
                        text: 'Επόμενο'
                    }
                ],
            });
            // step 3
            tour.addStep({
                title: 'Σύνοψη Εσόδων τρέχοντος έτους.',
                text: 'Εδώ μπορείτε να βλέπεπε το σύνολο των εσόδων σας <strong>από Τιμολόγια Παροχής Υπηρεσιών</strong> για το τρέχων έτος.',
                attachTo: {
                    element: '.card-incomes-invoices',
                    on: 'bottom'
                },
                buttons: [
                    {
                        action: function () {
                            return this.cancel();
                        },
                        classes: 'btn btn-light-indigo',
                        text: 'Έξοδος'
                    },
                    {
                        action: function () {
                            return this.back();
                        },
                        classes: 'card-incomes-retails',
                        text: 'Πίσω'
                    },
                    {
                        action: function () {
                            return this.next();
                        },
                        classes: 'btn indigo',
                        text: 'Επόμενο'
                    }
                ],
            });
            // step 4
            tour.addStep({
                title: 'Σύνοψη Εσόδων τρέχοντος έτους.',
                text: 'Εδώ μπορείτε να βλέπεπε το σύνολο των εσόδων σας <strong>από Τιμολόγια Παροχής Υπηρεσιών και Αποδείξεις Λιανικής</strong> για το τρέχων έτος.',
                attachTo: {
                    element: '.card-incomes-total',
                    on: 'bottom'
                },
                buttons: [
                    {
                        action: function () {
                            return this.cancel();
                        },
                        classes: 'btn btn-light-indigo',
                        text: 'Έξοδος'
                    },
                    {
                        action: function () {
                            return this.back();
                        },
                        classes: 'card-incomes-retails',
                        text: 'Πίσω'
                    },
                    {
                        action: function () {
                            return this.next();
                        },
                        classes: 'btn indigo',
                        text: 'Επόμενο'
                    }
                ],
            });
            // step 5
            tour.addStep({
                title: 'Σύνοψη Εσόδων τρέχοντος έτους.',
                text: 'Εδώ μπορείτε να βλέπεπε το σύνολο των εξόδων σας για το τρέχων έτος.',
                attachTo: {
                    element: '.card-outcomes',
                    on: 'bottom'
                },
                buttons: [
                    {
                        action: function () {
                            return this.cancel();
                        },
                        classes: 'btn btn-light-indigo',
                        text: 'Έξοδος'
                    },
                    {
                        action: function () {
                            return this.back();
                        },
                        classes: 'card-incomes-retails',
                        text: 'Πίσω'
                    }
                ],
            });
            // step 6
            tour.addStep({
                title: 'Υπενθυμίσεις',
                text: 'Εδώ μπορείτε να <strong>βλέπεπε</strong> και να <strong>προσθέτετε υπενθυμίσεις</strong> που μπορούν να αφορούν συγκεκριμένο πέλατη ή απλως μια γενική υπενθύμιση',
                attachTo: {
                    element: '#task-card',
                    on: 'right'
                },
                buttons: [
                    {
                        action: function () {
                            return this.cancel();
                        },
                        classes: 'btn btn-light-indigo',
                        text: 'Έξοδος'
                    },
                    {
                        action: function () {
                            return this.back();
                        },
                        classes: 'card-incomes-retails',
                        text: 'Πίσω'
                    },
                    {
                        action: function () {
                            return this.next();
                        },
                        classes: 'btn indigo',
                        text: 'Επόμενο'
                    }
                ],
            });
            // step 6
            tour.addStep({
                title: 'Υπενθυμίσεις',
                text: 'Εδώ μπορείτε να <strong>βλέπεπε</strong> τα τιμολόγια που δεν είναι σημειωμένα ώς πληρωμένα καθώς και το <strong>σύνολο των ανεξόφλητων τιμολογίων</strong>',
                attachTo: {
                    element: '.card-unpaid-invoices',
                    on: 'bottom'
                },
                buttons: [
                    {
                        action: function () {
                            return this.cancel();
                        },
                        classes: 'btn btn-light-indigo',
                        text: 'Έξοδος'
                    },
                    {
                        action: function () {
                            return this.back();
                        },
                        classes: 'card-incomes-retails',
                        text: 'Πίσω'
                    },
                    {
                        action: function () {
                            return this.next();
                        },
                        classes: 'btn indigo',
                        text: 'Επόμενο'
                    }
                ],
            });

            $u(window).resize(displayTour)
            // function to remove tour on small screen
            function displayTour() {
                window.resizeEvt;
                if ($u(window).width() > 576) {
                    $u('#tour').on("click", function () {
                        clearTimeout(window.resizeEvt);
                        $u('.content-overlay').addClass('active');
                        tour.start();
                    })
                }
                else {
                    $u('#tour').on("click", function () {
                        clearTimeout(window.resizeEvt);
                        tour.cancel()
                        window.resizeEvt = setTimeout(function () {
                            alert("Tour only works for large screens!");
                        }, 250);
                    })
                }
            }
        });
    </script>
@endsection
