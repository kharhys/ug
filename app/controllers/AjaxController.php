<?php

class AjaxController extends BaseController {

    public function getUsers()
    {
        $users = User::select([
            'UserProfileID as id',
            'FirstName',
            'MiddleName',
            'LastName',
            'Email',
            'IDNumber',
            'Mobile'
        ])
        ->where('CustomerProfileID',Auth::user()->CustomerProfileID);

        return Datatables::of($users)
            ->remove_column('id')
            ->add_column('view','<a href="{{route(\'view.profile\',$id)}}" >Show</a>')
            ->make();
    }


    public function getBusinesses()
    {
        $biz = Business::select([
            'CustomerID as id',
            'CustomerName',
            'BusinessTypeName as type',
            'RegistrationNumber',
            'PIN',
            'VATNumber',
            'Customer.Telephone1',
            'Customer.Mobile1',
            'CountyName as country'
        ])
            ->where('CustomerProfileID',Auth::user()->CustomerProfileID)
        ->join('CountyDetails','CountyDetails.CountyID','=','Customer.CountyID')
        ->join('BusinessType','BusinessType.BusinessTypeID','=','Customer.BusinessTypeID');

        return Datatables::of($biz)
            ->remove_column('id')
            ->add_column('view','<a href="{{route(\'view.biz\',$id)}}" >Show</a>')
            ->make();
    }

    public function getApplications()
    {
        $apps = Application::select([
            'ServiceHeader.ServiceHeaderID as ID',
            'Customer.CustomerName',
            'Services.ServiceName',
            'ServiceHeader.CreatedDate as Date',
            'ServiceStatus.ServiceStatusDisplay as Status'
        ])
            ->where('Customer.CustomerProfileID',Auth::user()->CustomerProfileID)
            ->join('Customer','Customer.CustomerID','=','ServiceHeader.CustomerID')
            ->join('Services','Services.ServiceID','=','ServiceHeader.ServiceID')
            ->join('ServiceStatus','ServiceStatus.ServiceStatusID','=','ServiceHeader.ServiceStatusID');

        return Datatables::of($apps)
            ->remove_column('ID')
            ->add_column('view','<a href="{{route(\'view.biz\',$ID)}}" >Show</a>')
            ->make();
    }

    public function getInvoices()
    {
        $items = Invoice::select([
            'InvoiceHeader.InvoiceHeaderID as ID',
            'Customer.CustomerName as Customer',
            'InvoiceHeader.InvoiceDate as Date',
            DB::raw('sum(Amount) as Total')
        ])


            ->join('Customer','Customer.CustomerID','=','InvoiceHeader.CustomerID')
            ->join('InvoiceLines','InvoiceLines.InvoiceHeaderID','=','InvoiceHeader.InvoiceHeaderID')
            ->where('Customer.CustomerProfileID','=',Auth::user()->CustomerProfileID)
            ->groupBy('CustomerName')
            ->groupBy('InvoiceHeader.InvoiceHeaderID')
            ->groupBy('InvoiceDate');

        return Datatables::of($items)
            ->add_column('view','<a href="{{route(\'my.invoice\',$ID)}}" >Show</a>')
            ->make();
    }

    public function getDatatable()
    {
        return Datatable::collection(User::all(array('id','name')))
            ->showColumns('id', 'name')
            ->searchColumns('name')
            ->orderColumns('id','name')
            ->make();
    }
}