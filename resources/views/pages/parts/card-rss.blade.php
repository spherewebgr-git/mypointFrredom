<div class="col s12 m6">
    <div class="card">
        <div class="card-content taxheaven-calendar">
            <h5 class="card-title mb-3">Φορολογικές Υποχρεώσεις - {{\Carbon\Carbon::now()->locale('el_GR')->timezone('Europe/Athens')->getTranslatedMonthName('M')}} {{date('Y')}}</h5>

            <div class="taxheaven-calendar--inner">
                @foreach($feed->channel->item as $item)
                    <div class="taxheaven-calendar-item">
                        <div class="col s2">
                            <div class="date">{{\Carbon\Carbon::createFromTimestamp(strtotime($item->pubDate))->format('d/m')}}</div>
                            <div class="year">{{\Carbon\Carbon::createFromTimestamp(strtotime($item->pubDate))->format('Y')}}</div>
                        </div>
                        <div class="col s10">
                            <a href="{{$item->link}}" target="_blank">{{$item->title}}</a>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>

