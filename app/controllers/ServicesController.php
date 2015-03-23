<?php
/**
 * Created by PhpStorm.
 * User: SSL
 * Date: 2/27/2015
 * Time: 11:48 AM
 */

class ServicesController extends BaseController{

    public function index() {
        $items = ServiceGroup::all();
        return View::make('services.index',['entities'=>$items]);
    }

    public function searchLand() {
        #var_dump(Input::get('search'));
        $lrnqs = Input::get('search');

        function find($qs) {
          $sid = FormData::where('Value', $qs)->where('FormColumnID', 12)->pluck('ServiceHeaderID');
          $lrn = FormData::where('ServiceHeaderID', $sid)->where('FormColumnID', 12)->pluck('Value');

          $oid = ServiceHeader::where('ServiceHeaderID', $sid)->pluck('CustomerID');
          $cid = Customer::where('CustomerID', $oid)->pluck('CustomerID');
          $own = Customer::where('CustomerID', $oid)->first();

          $ihi = Invoice::where('CustomerID', $cid)->where('Paid', false)->pluck('InvoiceHeaderID');
          $invd = InvoiceLine::where('InvoiceHeaderID', $ihi)->pluck('Amount');
          $paid = Receipt::where('InvoiceHeaderID', $ihi)->pluck('Amount');
          $bal = (float)$invd - (float)$paid;

          $inv = InvoiceView::where('ServiceGroupID', 3)->where('CustomerID', Auth::id())->pluck('InvoiceHeaderID');

          return [ 'owner' => $own, 'due' => $bal, 'lrnumber' => $lrn, 'invoice' => $inv ];
        }

        $land = find($lrnqs);

        return View::make('services.search_land', ['land' => $land, 'owner' => $land['owner'], 'due' => $land['due'], 'inv' => $land['invoice'] ]);
    }

    public function searchHousing() {
        //dd(Input::all());
        $eqs = Input::get('estate');
        $hqs = Input::get('house');

        $info = InvoiceView::select(['CustomerName', 'Balance', 'InvoiceHeaderID'])->where('ServiceID', $eqs)->first();
        if(isset($info)) {
          $info = $info->toArray();
          $invd = true;
        } else {
          $info = [ 'warning' => 'No invoice has been issued' ];
          $invd = false;
        }

        return View::make('services.search_housing', [ 'house' => $info, 'invoiced' => $invd ]);
    }

    public function getServices($id) {
        $dep = ServiceGroup::findOrFail($id);

        $groups = Category::where('ServiceGroupID',$dep->id())->get();
        return View::make('services.list',['entities'=> $groups ]);
    }

    public function getHouserent() {
      $estates = Service::where('ServiceCategoryID', 50)->lists('ServiceName','ServiceID');
      //dd($estates);
      //$estates = Estate::lists('EstateName');
      $houses = House::where('ServiceID', 389)->lists('HouseNo','HouseID');
      return View::make('houserent',['estates'=> $estates, 'houses' => $houses ]);
    }

    public function getLandRates() {
      $land = House::where('ServiceID', 389)->lists('HouseNo','HouseID');
      return View::make('landrates', [ 'land'=> $land ]);
    }

    public function fetchEstateHouses() {
      //dd(Input::all());
      $rules = ['ServiceID'=>"required|exists:Services,ServiceID"];
      $valid = Validator::make(Input::all(),$rules);
      if ($valid->fails()){
        $response =['code'=>404,'message'=>'Estate not found'];
      }else{
        $id = Input::get('ServiceID');
        $houses = House::select(['HouseID','HouseNo'])->FromEstate($id)->get();#->toJson();
        $response =['code'=>200,'message'=>'Estate found','houses'=>$houses];
      }


      return Response::json($response);
    }

    public function getApplyForm() {
        $rules = [
            'form'=>'required:exits:Form,FormID',
            'ServiceNo'=>'required|exists:Services,ServiceID'
        ];
        $valid = Validator::make(Input::all(),$rules);
        if ($valid->fails()){
            return Redirect::route('list.departments');
        }
        $id = Input::get('form');


        $form = ServiceForm::findOrFail(intval($id));
        $myBusiness = Business::MyBusinesses(Auth::user()->CustomerProfileID)->lists('CustomerName','CustomerID');

        return View::make('services.apply',['form'=>$form,'businesses'=>$myBusiness,'formID'=>$id,'ServiceNo'=>Input::get('ServiceNo')]);
    }

    public function postApplyForm() {
        #$input = Input::all();
        #return Response::json($input);

        $rules = [
            'form'=>'required:exits:Form,FormID',
            'ServiceNo'=>'required|exists:Services,ServiceID',
            'CustomerID'=>'required|exists:Customer,CustomerID'
        ];
        $valid = Validator::make(Input::all(),$rules);
        if ($valid->fails()){
            return Redirect::route('list.departments');
        }

        $app = new Application();
        $app->CustomerID = Input::get('CustomerID');
        $app->ServiceID = Input::get('ServiceNo');
        $app->FormID = Input::get('form');
        $app->SubmissionDate = date('Y-m-d H:i:s');
        $app->ServiceStatusID = 1;
        $app->save();

        $columns = Input::get('ColumnID');

        foreach($columns as $key => $value)
        {
            $params['ServiceHeaderID'] = $app->id();
            $params['ColumnID'] = $key;
            $params['Value'] = $value;

            Api::AddFormData($params);

        }

        if (Input::hasFile('ServiceDocument')){
            $files = Input::file('ServiceDocument');
            foreach ($files as $key=> $value){
                $path =false;
                $doc = FormDocument::find($key);
                $params['file'] = $value;
                $params['path'] = Application::$url;
                $params['name'] = $doc->type;
                $path = Api::upload($value,$params);

                if ($path){
                    $upload = new ServiceDocument();
                    $upload->ServiceDocumentName = $doc->type;
                    $upload->ServiceHeaderID = $app->id();
                    $upload->FileName = $path;
                    $upload->CreatedDate = date('Y-m-d H:i:s');
                    $upload->CreatedBy = Auth::id();
                    $upload->save();
                }
            }
        }

        Session::flash('success_msg','Application sent successfully');
        return Redirect::route('list.departments');


    }
}
