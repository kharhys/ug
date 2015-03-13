@if (Auth::id())
<header class="bg-dark"></header>

<table width="100%">
  <tr>
    <td width="50%"> <h1> <a href="/">  <img src="../images/logo.png" width="15%"/> </a><small>County Revenue Management System</small></h1> </td>
    <td align="right">
      <div id="logout">
        <span class="icon-user on-left fg-darkBlue"></span><a href="{{route('my.profile')}}">{{Auth::user()}}</a>
        &nbsp;&nbsp;&nbsp;<span class="icon-exit on-left fg-darkBlue"></span><a href="{{route('logout')}}">Logout</a>
      </div>
    </td>
  </tr>
</table>

<div class="fluent-menu" data-role="fluentmenu">

    <ul class="tabs-holder">
        <li class="special"><a href="{{route('home')}}"> Home </a></li>
        <li class="active"><a href="#tab_manage"> Manage </a></li>
        <li class=""><a href="#tab_settings">Settings</a></li>
        <li class=""><a href="#tab_support">Support</a></li>
        <!--
        <li class=""><a href="#tab_account">My Account</a></li>
        <li class=""><a href="#tab_support">Support</a></li>
        -->
    </ul>

    <div class="tabs-content">
        <div class="tab-panel" id="tab_manage" style="display: none;">
            <div class="tab-panel-group">
                <div class="tab-group-content">
                    <a class="fluent-big-button" href="{{route('list.businesses')}}"><i style="display:block" class="fa fa-2x fa-list"> </i> <br/> Businesses</a>
                    <a class="fluent-big-button" href="{{route('get.add.business')}}"><i style="display:block" class="fa fa-2x fa-plus-circle"> </i> <br/> New <br/> Business</a>
                    <!--
                    <div class="tab-content-segment">
                        <button class="fluent-big-button dropdown-toggle">
                            <span class="icon-pictures"></span>
                            <span class="button-label">Create<br>element</span>
                        </button>
                        <ul class="dropdown-menu" data-role="dropdown">
                            <li><a href="{{route('get.add.user')}}">User Account</a></li>
                            <li><a href="{{route('get.add.business')}}">Business</a></li>
                        </ul>
                    </div>
                    <div class="tab-content-segment">
                        <button class="fluent-big-button">
                            <span class="icon-cancel"></span>
                            <span class="button-label">Delete</span>
                        </button>
                    </div>
                  -->

                </div>
                <div class="tab-group-caption">Business</div>
            </div>
            <div class="tab-panel-group">
                <div class="tab-group-content">
                    <a class="fluent-big-button" href="{{route('list.departments')}}"><i style="display:block" class="fa fa-2x fa-list"> </i> <br/> Services</a>
                    <a class="fluent-big-button" href="{{route('my.applications')}}"><i style="display:block" class="fa fa-2x fa-list-ul"> </i> <br/> Applications</a>
                    <a class="fluent-big-button" href="{{route('my.applications')}}"><i style="display:block" class="fa fa-2x fa-plus-circle"> </i> <br/> New <br/> Application</a>
                </div>
                <div class="tab-group-caption">Services</div>
            </div>
            <div class="tab-panel-group">
                <div class="tab-group-content">
                    <a class="fluent-big-button" href="{{route('my.bills')}}"><i style="display:block" class="fa fa-2x fa-fax"> </i> <br/> Invoices </a>
                    <a class="fluent-big-button" href="{{route('my.applications')}}"><i style="display:block" class="fa fa-2x fa-bank"> </i> <br/> Payments </a>
                    <a class="fluent-big-button" href="{{route('my.applications')}}"><i style="display:block" class="fa fa-2x fa-file-text-o"> </i> <br/> Permits </a>
                </div>
                <div class="tab-group-caption">Reports</div>
            </div>
        </div>

        <div class="tab-panel" id="tab_settings" style="display: none;">
          <div class="tab-panel-group">
              <div class="tab-group-content">
                  <a class="fluent-big-button" href="{{route('my.profile')}}"><i style="display:block" class="fa fa-2x fa-list"> </i> <br/> Profile </a>
                  <a class="fluent-big-button" href="{{route('list.users')}}"><i style="display:block" class="fa fa-2x fa-users"> </i> <br/> Users </a>
                  <a class="fluent-big-button" href="{{route('get.add.user')}}"><i style="display:block" class="fa fa-2x fa-user-plus"> </i> <br/> Add User </a>
              </div>
              <div class="tab-group-caption">Settings</div>
          </div>
        </div>

        <div class="tab-panel" id="tab_support" style="display: none;">
          <div class="tab-panel-group">
              <div class="tab-group-content">
                  <a class="fluent-big-button" href="{{route('my.profile')}}"><i style="display:block" class="fa fa-2x fa-list"> </i> <br/> Help </a>
                  <a class="fluent-big-button" href="{{route('list.users')}}"><i style="display:block" class="fa fa-2x fa-users"> </i> <br/> About </a>
              </div>
              <div class="tab-group-caption">Settings</div>
          </div>
        </div>

    </div>
</div>
@else
    <div class="fluent-menu" data-role="fluentmenu">
        <ul class="tabs-holder">
            <li class="special"><a href="{{route('home')}}">Home</a></li>
            <li class="active"><a href="#tab_manage">User Area</a> </li>
        </ul>

        <div class="tabs-content">
            <div class="tab-panel" id="tab_manage" style="display: none;">
                <div class="tab-panel-group">
                    <div class="tab-group-content">
                        <a class="fluent-big-button" href="{{route('get.login')}}"><span class="icon-key"></span>Login</a>
                        <a class="fluent-big-button" href="{{route('get.register')}}"><span class="icon-user"></span>Register</a>
                    </div>
                    <div class="tab-group-caption">Clipboard</div>
                </div>

            </div>
        </div>
    </div>
@endif