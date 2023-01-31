<div class="col s12 m6">
    <div id="flight-card" class="card animate fadeUp">
        <div class="card-header grey accent-2">
            <div class="card-title">
                <h5 class="task-card-title mb-3 mt-0 white-text">Καιρός Αθήνα</h5>
                <p class="flight-card-date">{{$todayTime}}</p>
            </div>
        </div>
        <div class="card-content-bg white-text">
            <div class="card-content">
                <div class="row flight-state-wrapper">
                    <div class="col s5 m5 l5 center-align">
                        <div class="flight-state">
                            <h4 class="margin white-text">{{ getWeather()['temperature'] }}<sup>o</sup>C</h4>
                            <p class="ultra-small">Αίσθηση σαν {{ getWeather()['feels_like'] }}<sup>o</sup>C</p>
                        </div>
                    </div>
                    <div class="col s2 m2 l2 center-align">
                    </div>
                    <div class="col s5 m5 l5 center-align">
                        <div class="flight-state">
                            <p class="ultra-small">{{ getWeather()['description'] }}</p>
                            <img src="https://openweathermap.org/img/wn/{{ getWeather()['icon'] }}@2x.png" alt="" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s6 m6 l6 center-align">
                        <div class="flight-info">
                            <p class="small"><span class="grey-text text-lighten-4">Ελάχιστη Θερμοκρασία:</span><br />{{ getWeather()['temp_min'] }}<sup>o</sup>C</p>
                        </div>
                    </div>
                    <div class="col s6 m6 l6 center-align flight-state-two">
                        <div class="flight-info">
                            <p class="small"><span class="grey-text text-lighten-4">Μέγιστη Θερμοκρασία:</span><br />{{ getWeather()['temp_max'] }}<sup>o</sup>C</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
