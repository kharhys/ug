@extends('app')

@section('content')
    <div class="row">
        <div class="span3" align="center">
          <img alt="User Pic" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=100" class="img-circle">
        </div>
        <!--<div class="col-xs-10 col-sm-10 hidden-md hidden-lg"> <br>
          <dl>
            <dt>DEPARTMENT:</dt>
            <dd>Administrator</dd>
            <dt>HIRE DATE</dt>
            <dd>11/12/2013</dd>
            <dt>DATE OF BIRTH</dt>
               <dd>11/12/2013</dd>
            <dt>GENDER</dt>
            <dd>Male</dd>
          </dl>
        </div> -->
        <div class="span9">
            <table class="table table-user-information">
                <tbody>
                <tr>
                    <td>First Name</td>
                    <td>{{$entity->FirstName}}</td>
                </tr>
                <tr>
                    <td>Middle Name</td>
                    <td>{{$entity->MiddleName}}</td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td>{{$entity->LastName}}</td>
                </tr>
                <tr>
                    <td>IDNumber</td>
                    <td>{{$entity->IDNumber}}</td>
                </tr>
                <tr>
                    <td>Phone Number</td>
                    <td>{{$entity->Mobile}}</td>
                </tr>

                <tr>
                    <td>Email Address</td>
                    <!-- <td><a href="mailto:{{$entity->Email}}">{{$entity->Email}}</a></td> -->
                    <td>{{$entity->Email}}</td>
                </tr>

                </tbody>
            </table>

            <hr/>
            <a href="#">Change Password </a>

        </div>
    </div>

@endsection
