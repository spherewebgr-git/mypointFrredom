<div id="permissions">
    <div class="card-panel">
        <div class="row">
            <form action="{{route('settings.permissions')}}" method="post">
            @csrf
                <h4 style="font-size: 16px;font-weight: 400;margin: 45px 0 10px 25px;">Χρήστες</h4>
                <div class="divider"></div>
                <div class="col s12 input-field">

                </div>
                <h4 style="font-size: 16px;font-weight: 400;margin: 45px 0 10px 25px;">Δικαιώματα ανά Ρόλο Χρήστη</h4>
                <div class="divider"></div>
            </form>
        </div>
    </div>
</div>
