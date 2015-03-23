<?php
/**
 * Created by PhpStorm.
 * User: SSL
 * Date: 2/27/2015
 * Time: 11:48 AM
 */

class ServicesController extends BaseController{

    public function index()
    {
        $items = ServiceGroup::all();
        return View::make('services.index',['entities'=>$items]);
    }

    public function searchLand()
    {
        #TODO: when search yields no results
        #var_dump(Input::get('search'));
        $lr_num = Input::get('search');
        $sid = FormData::where('Value', $lr_num)->where('FormColumnID', 12)->pluck('ServiceHeaderID');
        $res = FormData::where('ServiceHeaderID', $sid)->get();
        $oid = ServiceHeader::where('ServiceHeaderID', $sid)->pluck('CustomerID');
        $owner = Customer::where('CustomerID', $oid)->first();

        $details = (array) $owner;
        foreach($res as $entry) {
          if(is_array($entry->Value)) { return; }
          $detail = FormColumns::where('FormColumnID', $entry->FormColumnID)->first();
          $pair = [$detail->FormColumnName => $entry->Value ];
          array_merge($details, $pair);
        }
#        var_dump((array)$owner);
        return View::make('services.search', ['owner' => $owner]);
    }

    public function getServices($id)
    {
        $dep = ServiceGroup::findOrFail($id);

        $groups = Category::where('ServiceGroupID',$dep->id())->get();

        #return Response::json($groups);
        $service = $groups->toArray()[0]['CategoryName'];
       return View::make('services.list',['entities'=> $groups, 'service' => $service ]);
    }

    public function getApplyForm()
    {
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

    public function postApplyForm()
    {
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
