<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'slug', 'name', 'main_image', 'description', 'product_code', 'quantity', 'price', 'status', 'desktop_id', 'label_id', 'product_for', 'per_box_quantity'];

    protected $guarded = ['id'];

    public function getCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getProductImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public static function getDataTable()
    {
        $data = self::with(['getCategory'])->get();
        return DataTables::of($data)
            ->editColumn('category', function ($record) {
                return $record->getCategory->name ?? '-';
            })
            ->addColumn('actions', function ($record) {
                return '<div class="btn-group btn-group-sm">
                        <a href="'.route('products.show', $record->id).'" class="btn btn-success mx-1"><i class="fas fa-eye"></i></a>
                        <a href="'.route('products.edit', $record->id).'" class="btn btn-info mx-1"><i class="fas fa-edit"></i></a>
                        <a data-id="'.$record->id.'" href="javascript:void(0)" class="btn btn-danger mx-1 delete"><i class="far fa-trash-alt"></i></a>
                      </div>';
            })
            ->editColumn('status', function ($record) {
                if ($record->status == 'active') {
                    return '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success"><input data-id="'.$record->id.'" data-status="inactive" type="checkbox" class="custom-control-input change-status" name="checkbox_'.$record->id.'" checked id="productStatus_'.$record->id.'"><label class="custom-control-label" for="productStatus_'.$record->id.'">'.ucfirst('Active').'</label></div>';
                } else {
                    return '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success"><input data-id="'.$record->id.'" data-status="active" type="checkbox" class="custom-control-input change-status" name="checkbox_'.$record->id.'" id="productStatus_'.$record->id.'"><label class="custom-control-label" for="productStatus_'.$record->id.'">'.ucfirst('Inactive').'</label></div>';
                }
            })
            ->rawColumns(['actions', 'status', 'category'])
            ->addIndexColumn()->make(true);
    }
}
