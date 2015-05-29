@extends('permits.services')

@section('service')
  <form class="ui form" action="{{ route('permits.submit.application') }}" method="post" enctype="multipart/form-data">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

      @foreach ($form->sections() as $section )
        @if ($section->Show)
          @if ( count($section->columns()) > 0 )
            <h4 class=" ui teal dividing header">{{$section}} </h4>
            @foreach($section->columns() as $col)
              {{Api::CustomFormField($col->id())}}
            @endforeach
          @endif
        @endif
      @endforeach

      <div class="ui section divider"></div>

      <button class="fluid ui positive button">Submit</button>
  </form>
@endsection

@section('script')
  @parent
  <script type="text/javascript">
     $( document ).ready(function() {
       $('#department-menu #permits').trigger('click');
       $('.ui.dropdown').dropdown();
     });
  </script>
@endsection
