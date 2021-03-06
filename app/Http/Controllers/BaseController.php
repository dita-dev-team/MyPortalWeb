<?php

namespace App\Http\Controllers;


use App\File;
use App\Type;
use App\Utilities\FunctionsUtilities;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Schema;


class BaseController extends Controller
{
    protected $response = array();


    //<editor-fold desc="Issue Get Request">
    //
    public function issueGetRequest(Request $request, $table, $id = null, $q = null)
    {

        $pageSize = $request->query('pageSize');
        $offSet = $request->query('offSet');
        $all = $request->query('all');
        $q = $request->query('q');
        $where = false;
        $filters = array();
        if (!isset($all)) {
            $where = true;
            $units = explode(',', $request->query('names'));
            $shift = $request->query('shift');
            $filters['shift'] = $shift;
            $filters['name'] = $units;
        }


        if (Schema::hasTable($table)) {
            if ($id != null) {
                $data = self::fetchOne($table, $id);
                if (isset($data['error'])) {
                    $this->response['errors'] = $data;
                } else {

                    $this->response['resource'] = $data;
                }
            } else {
                $this->response = FunctionsUtilities::fetchList($table, $pageSize, $offSet, $all, $q, $where, $filters);

            }
            return $this->response;
            //
        } else {
            $this->response['errors'] = ['status_code' => 404, "error" => "resource $table does not exist"];
        }

        return $this->response;

    }

    public static function fetchOne($resource, $id)
    {
        $models = [
            'type' => Type::class,
            'files' => File::class,

        ];

        try {
            $data = $models[$resource]::findOrFail($id);
        } catch (ModelNotFoundException $e) {

            $data = ["status_code" => 404, 'error' => "$resource not found"];
        }

        return $data;

    }

    //</editor-fold>



}
