@extends('permits.services')

@section('dashboard-content')

<div class="ui center aligned segment">
  <div class="ui two item fluid labeled icon menu">
    <a id="application" href="{{route('permits.apply')}}" class="item">
      <i class="plus square outline icon"></i>
      Apply for Business Permit
    </a>
    <a id="renewal" href="{{route('permits.renew')}}" class="item">
      <i class="wait icon"></i>
      Renew Business Permit
    </a>
  </div>
</div>

@endsection

@section('script')
  @parent
  <script type="text/javascript">
     $( document ).ready(function() {
       $('#land-menu #search').trigger('click');
     });
  </script>
@endsection
