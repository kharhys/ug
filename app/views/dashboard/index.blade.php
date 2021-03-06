@extends('portal')

@section('content')
<div class="ui centered grid">
  <div class="column">

    <div id="dashboard-header" class="ui basic teal segment">

      <h5 class="ui left floated header">
        County Revenue Management System
        <div class="sub header">Public User Portal</div>
      </h5>

      <h6 class="ui right floated header">
        <div class="ui  relaxed horizontal divided list">

          <div class="item">
            <i class="ui user icon"></i>
            <div class="content">
              <a href="" class="header">{{Auth::User()}}</a>
            </div>
          </div>

          <div class="item">
            <i class="ui sign out icon"></i>
            <div class="content">
              <a href="{{route('portal.logout')}}" class="header">Sign Out</a>
            </div>
          </div>

        </div>
      </h6>

    </div>

    <div class="ui fitted divider"></div>

  </div>
</div>

<div id="dashboard-menu" class="ui centered grid">
  <div class="column">

    <div class="ui secondary pointing menu">
      <a class="green item" id="home" href="{{route('portal.home')}}">
        <i class="home icon"></i> Home
      </a>
      <a class="blue item" id="services" href="{{route('portal.services')}}">
        <i class="tasks icon"></i> Services
      </a>
      <a class="orange item" id="settings" href="{{route('portal.settings')}}">
        <i class="settings icon"></i> Settings
      </a>
      <a class="purple item" id="support" href="{{route('portal.support')}}">
        <i class="help icon"></i> Support
      </a>
      <div class="right menu" id="account-type">
        <a class="item">Account Type</a>
      </div>
    </div>

  </div>
</div>

<div id="dahboard" class="ui grid">
    <div class="four wide column">
      @yield('dashboard-aside')
    </div>
    <div class="twelve wide column">
      @include('partials.notification')
      @yield('dashboard-content')
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
  $('.ui.menu')
   .on('click', '.item', function() {
     if(!$(this).hasClass('dropdown')) {
       $(this)
         .addClass('active')
         .siblings('.item')
           .removeClass('active');
     }
   });

   var filterSelect = function(id, target){
     $.post('{{route('filter.select')}}',{FilterColumnID: target, SelectedID: id },function(data){
      var targetEl = "[name='ColumnID[" + target + "]']";
       var toAppend = '';
         if (data.code == 200){
           $.each(data.options,function(id,name){
            toAppend += '<option value="'+id+'" selected>'+name+'</option>';
          });
         }
         $(targetEl).html(toAppend);
         $(targetEl).parent().dropdown('set text', 'select');
     });
   }
</script>
@endsection
