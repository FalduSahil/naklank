<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Yajra\DataTables\Facades\DataTables;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $rememberTokenName = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'number',
        'address',
        'user_type',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public static function getDataTable()
    {
        $data = self::whereNot('user_type', 'admin')->get();
        return DataTables::of($data)
            ->addColumn('actions', function ($record) {
                return '<div class="btn-group btn-group-sm">
                        <a href="'.route('users.edit', $record->id).'" class="btn btn-info mx-1"><i class="fas fa-edit"></i></a>
                        <a data-id="'.$record->id.'" href="javascript:void(0)" class="btn btn-danger delete mx-1"><i class="far fa-trash-alt"></i></a>
                      </div>';
            })
            ->editColumn('status', function ($record) {
                if ($record->status == 'active') {
                    return '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success"><input data-id="'.$record->id.'" data-status="inactive" type="checkbox" class="custom-control-input change-status" name="checkbox_'.$record->id.'" checked id="userStatus_'.$record->id.'"><label class="custom-control-label" for="userStatus_'.$record->id.'">'.ucfirst('Active').'</label></div>';
                } else {
                    return '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success"><input data-id="'.$record->id.'" data-status="active" type="checkbox" class="custom-control-input change-status" name="checkbox_'.$record->id.'" id="userStatus_'.$record->id.'"><label class="custom-control-label" for="userStatus_'.$record->id.'">'.ucfirst('Inactive').'</label></div>';
                }
            })
            ->rawColumns(['actions', 'status'])
            ->addIndexColumn()->make(true);
    }
}
