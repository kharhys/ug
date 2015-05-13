@extends('hire.services')

@section('service')
  <form class="ui form" action="{{ route('hire.article') }}" method="post" enctype="multipart/form-data">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <h4 class=" ui orange dividing header"> Application Details</h4>

    <div class="required field">
      <label>Equipment</label>
      <select name="article" id="article" class="ui dropdown">
        <option value="">Equipment</option>
        @foreach($equipment as $key => $equip)
          <option value={{$key}}> {{$equip}} </option>
        @endforeach
      </select>
    </div>

    <div class="two fields">
      <div class="required field">
        <label>Start Date</label>
        <input name="start" id="start" placeholder="Start Date" type="text">
      </div>
      <div class="required field">
        <label>End Date</label>
        <input name="end" id="end" placeholder="Start Date" type="text">
      </div>
    </div>

    <div class="ui section divider"></div>

    <div class="ui buttons">
      <button class="ui button">Save</button>
      <div class="or"></div>
      <button class="ui positive button">Submit</button>
    </div>

  </form>
@endsection

@section('script')
  @parent
  <script type="text/javascript">
     $( document ).ready(function() {
       $('#hire-menu #equipment').trigger('click');
       $('select.dropdown').dropdown();
       $('#start, #end').dateDropper();
     });
  </script>
@endsection
