<?php
/**
 * Restful interface
 */

class RestController extends Controller {

    //groups
    public function servicegroups() {
      $data = ServiceGroup::get(['ServiceGroupID', 'Label', 'DepartmentID']);
      return Response::json($data);
    }

    //services in group with id {gid}
    public function groupedservices($gid) {
      $data = Service::where('ServiceGroupID', $gid)->get(['ServiceID', 'ServiceName', 'ServiceCategoryID', 'ServiceGroupID']);
      return Response::json($data);
    }

    //categories in group with id {gid}
    public function groupedcategories($gid) {
      $data = Category::where('ServiceGroupID', $gid)->get(['ServiceCategoryID', 'CategoryName', 'ServiceGroupID', 'FormID', 'Label']);
      return Response::json($data);
    }

    //services in category with id {cid}
    public function categorizedservices($cid) {
      $data = Service::where('ServiceCategoryID', $cid)->get(['ServiceID', 'ServiceName', 'ServiceCategoryID', 'ServiceGroupID']);
      return Response::json($data);
    }

    //form sections for services in category with id {cid}
    public function categorizedserviceformsections($cid) {
      $fid = Category::where('ServiceCategoryID', $cid)->pluck('FormID');
      //note form may not exist in db
      $data = FormSection::where('FormID', $fid)->where('Show', true)->get(['FormSectionID', 'FormSectionName', 'FormID', 'Priority']);
      return Response::json($data);
    }

    //formcolumns for services in category with id {cid}
    public function categorizedserviceformcolumns($cid) {
      $fid = Category::where('ServiceCategoryID', $cid)->pluck('FormID');
      //note form may not exist in db
      $data = FormColumns::where('FormID', $fid)
        ->join('ColumnDataType', 'ColumnDataType.ColumnDataTypeID', '=', 'FormColumns.FormColumnID')
        ->get([
          'FormColumns.FormColumnID as id',
          'ColumnDataType.ColumnDataTypeName as type',
          'FormColumns.FormColumnName as name',
          'FormColumns.Priority as priority',
          'FormColumns.Mandatory as required'
          #'ServiceRequiredDocuments.DocumentTypeID'
        ]);
      return Response::json($data);
    }

    //form for services in category with id {cid}
    public function categorizedserviceform($cid) {
      var_dump(
        FormSection::join('FormColumns', 'FormColumns.FormSectionID', '=', 'FormSections.FormSectionID' )
        ->get(['FormSections.FormSectionName', 'FormColumns.FormColumnName'])
        ->toJson()
      );
    }

    //service with id {sid}
    public function service($sid) {
      $data = Service::where('ServiceID', $sid)->get(['ServiceID', 'ServiceName', 'ServiceCategoryID', 'ServiceGroupID']);
      return Response::json($data);
    }

    public function businesses(){
        $profile = Auth::user()->CustomerProfileID;
        $items = Business::MyBusinesses($profile)->get();

        return View::make('business.index',['entities'=>$items]);
    }

    public function updateEstates() {
      $base = 1530;
      for($x = 1; $x < 14; $x++){
        //var_dump();
        DB::table('Houses')->where('EstateID', $x)->update(['ServiceID' => $base]);
        $base = $base + 1;
      }
      /* $dat = DB::table('Estates')->lists('EstateName'); ->update(['ServiceID' => 1531])
      function make($name) {
        return(['ServiceName' => $name, 'ServiceCategoryID' => 50, 'ServiceGroupID' => 9, 'DepartmentID' => 7 ]);
      }
      $data = array_map('make', $dat);
      DB::table('Services')->insert($data);
      dd($data); */
    }
}
