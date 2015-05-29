@extends('dashboard.index')

@section('dashboard-aside')
<div id="department-menu" class="ui vertical accordion menu">
  <div class="header item">Services</div>

  <div class="item"> </div>

  <div class="item">
    <a class="active title">
      <i class="dropdown icon"></i>
      Land
    </a>
    <div class="active content">
      <div class="menu">
        <a class="active item" href="{{route('land.registration')}}">Register Land</a>
        <a class="item" href="{{route('land.pay')}}">Registration Applications</a>
        <a class="item" href="{{route('land.plots')}}">Registered Plots</a>
      </div>
    </div>
  </div>

  <div class="item" id="permits">
    <a class="title">
      <i class="dropdown icon"></i>
      Permits
    </a>
    <div class="content">
      <div class="menu">
        <a class="item" href="{{route('permits.apply')}}">Register for Permit</a>
        <a class="item" href="{{route('permits.index')}}">View Applications</a>
        <a class="item" href="{{route('permits.renew')}}">Renew Permit</a>
      </div>
    </div>
  </div>

  <div class="item">
    <a class="title">
      <i class="dropdown icon"></i>
      Tenancy
    </a>
    <div class="content">
      <div class="menu">
        <a id="house" class="item" href="{{route('housing.stall')}}">Hire County Stall </a>
        <a id="stall" class="item" href="{{route('housing.home')}}">Hire County House </a>
        <a id="tenancy" class="item" href="{{route('housing.applications')}}">Registration Applications</a>
      </div>
    </div>
  </div>

  <div class="item">
    <a class="title">
      <i class="dropdown icon"></i>
      Hire
    </a>
    <div class="content">
      <div class="menu">
        <a class="item" href="{{route('hire.stadia')}}">Hire Stadium</a>
        <a class="item" href="{{route('hire.premises')}}">Hire Premise</a>
        <a class="item" href="{{route('hire.equipment')}}">Hire Equipment</a>
        <a class="item" href="{{route('hire.applications')}}">View Applications</a>
      </div>
    </div>
  </div>

  <div class="item">
    <a class="title">
      <i class="dropdown icon"></i>
      Signage
    </a>
    <div class="content">
      <div class="menu">
        <a class="item" href="{{route('signage.apply')}}">Apply </a>
        <a class="item" href="{{route('signage.charges')}}">View Service Charges</a>
        <a class="item" href="{{route('signage.applications')}}">View Applications</a>
      </div>
    </div>
  </div>

</div>

@endsection

@section('dashboard-content')

@endsection

@section('script')
  @parent
  <script type="text/javascript">
     $( document ).ready(function() {
       $('#dashboard-menu #services').trigger('click');
       $('.ui.accordion').accordion();
     });
  </script>
@endsection
