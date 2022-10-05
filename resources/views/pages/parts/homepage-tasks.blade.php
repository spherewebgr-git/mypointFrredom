<div class="col s12 m6">
    <ul id="task-card" class="collection with-header animate fadeLeft card">
        <li class="collection-header cyan">
            <h5 class="task-card-title mb-3">Υπενθυμίσεις</h5>
            <p class="task-card-date">{{$today}}</p>
            <a class="btn-floating activator btn-move-up waves-effect waves-light red accent-2 z-depth-4 right" style="top: -2px;" title="Προθήκη νέας υπενθύμισης">
                <i class="material-icons">add</i>
            </a>
        </li>
        @foreach(getTasks() as $task)
        <li class="collection-item dismissable">
            <form class="change-task-state" method="post" action="{{route('tasks.state', ['task' => $task])}}">
                @csrf
                <label>
                    <input type="checkbox" class="change-status" name="taskstatus" @if($task->completed == 1) checked @endif>
                    <span class="width-100"@if($task->completed == 1) style="text-decoration: line-through;" @endif>{{$task->taskName}} </span>
                    <span class="secondary-content"><span class="ultra-small">{{ Carbon\Carbon::parse($task->task_date)->format('d/m/Y') }}</span></span>
                    <span class="task-cat teal accent-4">{{\Illuminate\Support\Str::limit(getClient($task->client_id)['company'], 50, $end='...')}}</span>
                </label>
            </form>

        </li>
        @endforeach
        <div class="card-reveal">
                            <span class="card-title grey-text text-darken-4">
                                Νέα Υπενθύμιση <i class="material-icons right">close</i>
                            </span>
            <div class="row">
                <form action="{{route('tasks.store')}}" class="col-12 mt-5" style="overflow-x: hidden">
                    @csrf
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="task_title" id="task_title" type="text" class="validate">
                            <label for="task_title">Τίτλος Υπενθύμισης</label>
                        </div>
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
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="task_date" id="task_date" type="text" class="datepicker">
                            <label for="task_date">Ημ/νία Υπενθύμισης</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea name="description" id="description" class="materialize-textarea"></textarea>
                            <label for="description">Περιγραφή</label>
                        </div>
                    </div>
                    <div class="input-field col s12" >
                        <select id="taskClient" name="taskClient" class="browser-default" style="position: relative">
                            <option value="" disabled selected>Επιλέξτε πελάτη</option>
                            @foreach(clientsNames() as $key => $clientName)
                                <option value="{{$key}}">{{$clientName}}</option>
                            @endforeach
                        </select>
                        <label for="taskClient" style="top: -30px;">Αφορά τον πελάτη (μη υποχρεωτικό)</label>
                    </div>
                    <div class="row">
                        <button class="btn waves-effect waves-light" type="submit">Καταχώρηση
                            <i class="material-icons right">save</i>
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </ul>
</div>
@section('last-script')
    <script>
        $t = jQuery.noConflict();
        $t(document).ready(function(){
            $t('input.change-status').on('change', function() {
                $t(this).parent().parent('form').submit();
            })
        });
    </script>
@endsection
