<div class="error-notice">
    @if(Session::has('error_msg'))
        <div class="oaerror danger">{{Session::get('error_msg')}}</div>
    @endif

    @if(Session::has('success_msg'))
        <div class="oaerror success">{{Session::get('success_msg')}}</div>
    @endif

    @if(Session::has('warning_msg'))
        <div class="oaerror warning">{{Session::get('warning_msg')}}</div>
    @endif

    @if(Session::has('info_msg'))
        <div class="oaerror info">{{Session::get('info_msg')}}</div>
    @endif

    @if (count($errors) > 0)
        <div class="oaerror danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
