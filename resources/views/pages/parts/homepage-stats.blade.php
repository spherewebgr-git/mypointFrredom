<!-- card stats start -->
<div id="card-stats" class="pt-0">
    <div class="row">
{{--        <div class="col s12 m6 l3">--}}
{{--            <div class="card animate fadeLeft">--}}
{{--                <div class="card-content cyan white-text">--}}
{{--                    <p class="card-stats-title"><i class="material-icons">person_outline</i> Σύνολο Πελατών</p>--}}
{{--                    <h4 class="card-stats-number white-text">{{countClients()}}</h4>--}}
{{--                    <p class="card-stats-compare">--}}
{{--                        <i class="material-icons">keyboard_arrow_down</i>--}}
{{--                        <a href="{{route('client.list')}}" class="green-text text-lighten-5">Προβολή Λίστας Πελατών</a>--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--                <div class="card-action cyan darken-1">--}}
{{--                    <div id="clients-bar" class="center-align"></div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="col s12 m6 l3">
            <div class="card animate fadeLeft card-incomes-retails">
                <div class="card-content red accent-2 white-text">
                    <p class="card-stats-title"><i class="material-icons">euro_symbol</i> Σύνολο Εσόδων {{date('Y')}}<br /> <small>(Αποδείξεις Λιανικής)</small></p>
                    <h4 class="card-stats-number white-text">&euro; {{ getIncomesRetails()  }}</h4>
                    <p class="card-stats-compare">
                        <i class="material-icons">keyboard_arrow_down</i>
                        <a href="{{route('retail-receipts.list')}}" class="green-text text-lighten-5">Προβολή Αποδείξεων Λιανικής</a>
                    </p>
                </div>
                <div class="card-action red">
                    <div id="invoices-compositebar" class="center-align"></div>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l3">
            <div class="card animate fadeLeft card-incomes-invoices">
                <div class="card-content red accent-2 white-text">
                    <p class="card-stats-title"><i class="material-icons">euro_symbol</i> Σύνολο Εσόδων {{date('Y')}}<br /> <small>(Τιμολόγια)</small></p>
                    <h4 class="card-stats-number white-text">&euro; {{ getIncomes()  }}</h4>
                    <p class="card-stats-compare">
                        <i class="material-icons">keyboard_arrow_down</i>
                        <a href="{{route('invoice.list')}}" class="green-text text-lighten-5">Προβολή Λίστας Τιμολογίων</a>
                    </p>
                </div>
                <div class="card-action red">
                    <div id="retails-compositebar" class="center-align"></div>
                </div>
            </div>
        </div>

        <div class="col s12 m6 l3">
            <div class="card animate fadeLeft card-incomes-total">
                <div class="card-content red accent-2 white-text">
                    <p class="card-stats-title"><i class="material-icons">euro_symbol</i> Σύνολο Εσόδων {{date('Y')}}<br /> <small>(Τιμολόγια + Αποδείξεις)</small></p>
                    <h4 class="card-stats-number white-text">&euro; {{ getAllIncomes() }}</h4>
                    <p class="card-stats-compare">

                    </p>
                </div>
                <div class="card-action red">
                    <div id="retails-compositebar" class="center-align"></div>
                </div>
            </div>
        </div>

        <div class="col s12 m6 l3">
            <div class="card animate fadeRight card-outcomes">
                <div class="card-content orange lighten-1 white-text">
                    <p class="card-stats-title"><i class="material-icons">trending_up</i> Σύνολο Εξόδων</p>
                    <h4 class="card-stats-number white-text">&euro; {{ getOutcomes()  }}</h4>
                    <p class="card-stats-compare">
                        <i class="material-icons">keyboard_arrow_down</i>
                        <a href="{{route('outcome.list')}}" class="green-text text-lighten-5">Προβολή Παραστατικών Εξόδων</a>
                    </p>
                </div>
                <div class="card-action orange">
                    <div id="profit-tristate" class="center-align"></div>
                </div>
            </div>
        </div>
{{--        <div class="col s12 m6 l3">--}}
{{--            <div class="card animate fadeRight">--}}
{{--                <div class="card-content green lighten-1 white-text">--}}
{{--                    <p class="card-stats-title"><i class="material-icons">content_copy</i> Φ.Π.Α. {{  getFpa()['trimino'].'ου'  }} Τριμήνου</p>--}}
{{--                    <h4 class="card-stats-number white-text">&euro; {{  getFpa()['fpa']  }}</h4>--}}
{{--                    <p class="card-stats-compare">--}}
{{--                        <span class="green-text text-lighten-5">Συνυπολογίζεται ΦΠΑ εξόδων</span>--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--                <div class="card-action green">--}}
{{--                    <div id="invoice-line" class="center-align"></div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
</div>
<!--card stats end-->

@section('page-script')
<script>
    $s = jQuery.noConflict();
    $s(document).ready(function(){
        $s("#invoices-compositebar").sparkline([4, 6, 7, 7, 4, 3, 2, 3, 1, 4, 6, 5, 9, 4, 6, 7, 7, 4, 6, 5, 9,2,2,2,2,2,2,2,2,2], {
            type: "line",
            barColor: "#F6CAFD",
            height: "25",
            width: "100%",
            barWidth: "7",
            barSpacing: 4
        });

        $s("#retails-compositebar").sparkline([4, 6, 7, 7, 4, 3, 2, 3, 1, 4, 6, 5, 9, 4, 6, 7, 7, 4, 6, 5, 9,2,2,2,2,2,2,2,2,2], {
            type: "line",
            barColor: "#F6CAFD",
            height: "25",
            width: "100%",
            barWidth: "7",
            barSpacing: 4
        });

        $s("#profit-tristate").sparkline([4, 6, 7, 7, 4, 3, 2, 3, 1, 4, 6, 5, 9, 4, 6, 7, 7, 4, 6, 5, 9,2,2,2,2,2,2,2,2,2], {
            type: "tristate",
            posBarColor: "#ffecb3",
            negBarColor: "#fff8e1",
            height: "25",
            width: "100%",
            barWidth: "7",
            barSpacing: 4
        });
    })
</script>
@endsection
