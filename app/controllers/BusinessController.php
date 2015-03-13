<?php
class BusinessController extends BaseController{

    public function index(){
        $profile = Auth::user()->CustomerProfileID;
        $items = Business::MyBusinesses($profile)->get();

        return View::make('business.index',['entities'=>$items]);
    }

    public function getAddBusiness()
    {
        $types = BusinessType::all()->lists('BusinessTypeName','BusinessTypeID');
        $counties = County::all()->lists('CountyName','CountyID');

        return View::make('business.new',['types'=>$types,'counties'=>$counties]);
    }

    public function postAddBusiness()
    {
        $profile = Auth::user()->CustomerProfileID;
        $rules = array(
            'CustomerName'=>'required|min:4',
            'ContactPerson'=>'required',
            'Designation'=>'required',
            'RegistrationNumber'=>'required',
            'PIN'=>'required',
            'VATNumber'=>'required',
            'BusinessTypeID'=>'required|exists:BusinessType',
            'PostalAddress'=>'required',
            'PostalCode'=>'required',
            'Town'=>'required',
            'CountyID'=>'required|exists:CountyDetails',
            'Mobile1'=>'required',
            'Telephone1'=>'required',
            'Email' => 'email'
        );
        $valid = Validator::make(Input::all(),$rules);

        if ($valid->passes()){
            $input = Input::all();
            $biz = new Business();
            $biz->CustomerProfileID = $profile;
            $biz->CustomerName = $input['CustomerName'];
            $biz->ContactPerson = $input['ContactPerson'];
            $biz->Designation = $input['Designation'];
            $biz->RegistrationNumber = $input['RegistrationNumber'];
            $biz->PIN = $input['PIN'];
            $biz->VATNumber = $input['VATNumber'];
            $biz->BusinessTypeID = $input['BusinessTypeID'];
            $biz->PostalAddress = $input['PostalAddress'];
            $biz->PostalCode = $input['PostalCode'];
            $biz->Town = $input['Town'];
            $biz->CountyID = $input['CountyID'];
            $biz->Telephone1 = $input['Telephone1'];
            $biz->Telephone2 = $input['Telephone2'];
            $biz->Mobile1 = $input['Mobile1'];
            $biz->Mobile2 = $input['Mobile2'];
            $biz->Email = $input['Email'];
            $biz->Url = $input['Url'];
            $biz->CreatedDate = date('Y-m-d H:i:s');
            $biz->CreatedBy = Auth::id();
            $biz->save();

            Session::flash('success_msg','Business registered successfully');
            return Redirect::route('list.businesses');
        }

        return Redirect::route('get.add.business')
            ->withErrors($valid)
            ->withInput(Input::all());
    }
}