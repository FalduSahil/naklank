<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;

class Inquiry extends Model
{
    use HasFactory;

    public static function getDataTable()
    {
        $data = self::all();
        return DataTables::of($data)
            ->addColumn('actions', function ($record) {
                return '<div class="btn-group btn-group-sm">
                        <a href="'.route('inquiries.show', $record->id).'" class="btn btn-success"><i class="fas fa-eye"></i></a>
                        <a data-id="'.$record->id.'" href="javascript:void(0)" class="btn btn-danger delete"><i class="far fa-trash-alt"></i></a>
                      </div>';
            })
            ->addColumn('name', function ($record) {
                return ucfirst($record->first_name . ' ' . $record->last_name);
            })
            ->rawColumns(['actions', 'name'])
            ->addIndexColumn()->make(true);
    }
}
