<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image' , 'slug', 'desktop_id'];

    public static function getDataTable()
    {
        $data = self::all();
        return DataTables::of($data)
            ->addColumn('actions', function ($record) {
                return '<div class="btn-group btn-group-sm">
                        <a href="'.route('categories.edit', $record->id).'" class="btn btn-info"><i class="fas fa-edit"></i></a>
                        <a data-id="'.$record->id.'" href="javascript:void(0)" class="btn btn-danger delete"><i class="far fa-trash-alt"></i></a>
                      </div>';
            })
            ->editColumn('status', function ($record) {
                if ($record->status == 'active') {
                    return '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success"><input data-id="'.$record->id.'" data-status="inactive" type="checkbox" class="custom-control-input change-status" name="checkbox_'.$record->id.'" checked id="categoryStatus_'.$record->id.'"><label class="custom-control-label" for="categoryStatus_'.$record->id.'">'.ucfirst('Active').'</label></div>';
                } else {
                    return '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success"><input data-id="'.$record->id.'" data-status="active" type="checkbox" class="custom-control-input change-status" name="checkbox_'.$record->id.'" id="categoryStatus_'.$record->id.'"><label class="custom-control-label" for="categoryStatus_'.$record->id.'">'.ucfirst('Inactive').'</label></div>';
                }
            })
            ->rawColumns(['actions', 'status', 'created_at'])
            ->addIndexColumn()->make(true);
    }

}
