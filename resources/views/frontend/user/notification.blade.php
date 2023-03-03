@forelse($loginLogs as $log)
    <tr id="{{$loop->index}}">
        <td>{{$loop->iteration}}</td>
        <td class="tb-col-os">{{$log->browser}} on {{$log->os}}</td>
        <td class="tb-col-ip"><span class="sub-text">{{$log->ip}}</span></td>
        <td class="tb-col-time"><span class="sub-text">{{formatDateTime($log->created_at)}}</span></td>
        <td class="tb-col-action">
            <a 
                data-act="modal-form" 
                data-action="{{route('profile.destroy.login-logs', $log->id)}}" 
                data-method="DELETE" href="javascript:void(0)" 
                data-tr="#{{$loop->index}}"
                data-div-id="#notification_tbody"
                class="link-cross mr-sm-n1">
                <em class="icon ni ni-cross"></em>
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="text-center">No data found</td>
    </tr>
@endforelse