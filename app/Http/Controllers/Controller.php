<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function isDuplicate($model, array $where, $id = null)
    {
        if($id){
            $model = $model->where($where)->first();
            if ($model) {
                return $id == $model->id ? 'true' : 'false';
            } else {
                return 'true';
            }
        }else{
            return $model->where($where)->exists() ? 'false' : 'true';
        }
    }
}
