<div id="permissions">
    <div class="card-panel">
        <div class="row">
            <form action="{{route('settings.permissions')}}" method="post">
            @csrf
                <h4 style="font-size: 16px;font-weight: 400;margin: 45px 0 10px 25px;">Χρήστες</h4>
                <div class="divider"></div>
                <div class="col s12 input-field">
                    <table class="striped">
                        <tr>
                            <th>Όνομα</th>
                            <th>E-mail</th>
                            <th>Ρόλος Χρήστη</th>
                        </tr>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>admin?</td>
                            </tr>
                        @endforeach
                    </table>

                </div>
                <h4 style="font-size: 16px;font-weight: 400;margin: 145px 0 10px 25px;">Δικαιώματα ανά Ρόλο Χρήστη</h4>
                <div class="divider"></div>
            </form>
        </div>
    </div>
</div>
