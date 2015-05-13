@extends('dashboard.index')

@section('script')
  @parent
  <script type="text/javascript">
     $( document ).ready(function() {
       $('#dashboard-menu #home').trigger('click');
     });
  </script>
@endsection
