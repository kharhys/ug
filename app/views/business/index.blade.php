@extends('app')

@section('content')
<label><h2>My Businesses</h2></label>

    <table class="table striped hovered dataTable" id="data-table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Reg. No.</th>
            <th>PIN</th>
            <th>VAT No.</th>
            <th>Telephone (Line 1)</th>
            <th>Mobile No.</th>
            <th>Country</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        </tbody>

    </table>
@endsection

@section('page_js')

    <script>
        $(function(){
            $('#data-table').dataTable( {
                "bProcessing": true,
                "sAjaxSource": "{{route('list.businesses.ajax')}}",
                "aoColumns": [
                    { "aaData": "CustomerName" },
                    { "aaData": "type" },
                    { "aaData": "RegistrationNumber" },
                    { "aaData": "PIN" },
                    { "aaData": "VATNumber" },
                    { "aaData": "Telephone1" },
                    { "aaData": "Mobile1" },
                    { "aaData": "country" },
                    { "aaData": "view" }
                ]
            } );
        });
    </script>

@endsection