<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_uuid',
        'user_id ',
        'name',
        'email',
        'phone',
        'address',
        'total',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderMeta()
    {
        return $this->hasMany(OrderMeta::class, 'order_id');
    }

    public static function getDataTable()
    {
        $data = self::all();
        return DataTables::of($data)
            ->addColumn('actions', function ($record) {
                return '<div class="btn-group btn-group-sm">
                        <a href="'.route('orders.edit', $record->id).'" class="btn btn-primary mx-1"><i class="fas fa-edit"></i></a>
                        <a href="'.route('orders.show', $record->id).'" class="btn btn-success mx-1"><i class="fas fa-eye"></i></a>
                        <a data-id="'.$record->id.'" href="javascript:void(0)" class="btn btn-danger delete mx-1"><i class="far fa-trash-alt"></i></a>
                      </div>';
            })
            ->editColumn('status', function ($record) {
                $statusIcons = [
                    'accepted' => 'fa-check-circle text-success',
                    'pending' => 'fa-hourglass-half text-warning',
                    'rejected' => 'fa-times-circle text-danger',
                    'packaging' => 'fa-box text-info',
                    'completed' => 'fa-check-double text-success',
                ];

                $iconClass = $statusIcons[$record->status] ?? 'fa-question-circle text-info';

                return '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" id="statusDropdown_' . $record->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa ' . $iconClass . '"></i> ' . ucfirst($record->status) . '</button><div class="dropdown-menu" aria-labelledby="statusDropdown_' . $record->id . '"><a class="dropdown-item change-status" data-status="accepted" data-id="'.$record->id.'" href="javascript:void(0)">Accepted <i class="fa fa-check-circle text-success"></i></a><a class="dropdown-item change-status" data-status="pending" data-id="'.$record->id.'" href="javascript:void(0)">Pending <i class="fa fa-hourglass-half text-warning"></i></a><a class="dropdown-item change-status" data-status="rejected" data-id="'.$record->id.'" href="javascript:void(0)">Rejected <i class="fa fa-times-circle text-danger"></i></a></div></div>';
            })
            ->editColumn('total', function ($record) {
                return '₹'.formatNumber($record->total);
            })
            ->addColumn('client', function ($record){
                return $record->user->name;
            })
            ->rawColumns(['actions', 'status', 'client'])
            ->addIndexColumn()->make(true);
    }
}
