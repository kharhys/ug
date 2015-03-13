@extends('app')

@section('content')
    <label><h2> Land Details</h2></label>
    <table class="table stripped hovered">
        <thead>
        <tr>
            <th>Land Details</th>
            <th></th>
        </tr>
        </thead>
        @if($land['owner'])
          <tbody>
            <tr>
                <td>Land Owner </td>
                <td>{{$land['owner']->CustomerName}}</td>
            </tr>
            @if($land['lrnumber'])
              <tr>
                  <td>Land Registration Number </td>
                  <td>{{$land['lrnumber']}}</td>
              </tr>
            @endif
            @if($land['due'])
              <tr>
                  <td>Amount Due </td>
                  <td>KSh. {{$land['due']}}</td>
              </tr>
            @endif
            <tr>
                <td>Contact Person Name </td>
                <td>{{$land['owner']->ContactPerson}} </td>
            </tr>
            <tr>
                <td>Contact Person Designation </td>
                <td>{{$land['owner']->Designation}} </td>
            </tr>
            <tr>
                <td>Contact Postal Address </td>
                <td>P.O Box {{$land['owner']->PostalCode}}, {{$land['owner']->Town}} </td>
            </tr>
            <tr>
                <td>Contact Telephone </td>
                <td>{{$land['owner']->Telephone1}}, {{$land['owner']->Telephone2}} </td>
            </tr>
            <tr>
                <td>Contact Email </td>
                <td>{{$land['owner']->Email}} </td>
            </tr>
            <tr>
                <td>Contact Url </td>
                <td>{{$land['owner']->Url}} </td>
            </tr>
          </tbody>
        @else
          <h3> Not Found </h3>
        @endif
    </table>
@endsection
