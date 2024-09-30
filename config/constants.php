<?php

return [
    /*Site Settings*/
    'SITE_NAME' => 'Naklank',

    /*Paths*/
    'CATEGORY_IMAGE_PATH' => 'assets/uploads/categories/',
    'PRODUCT_IMAGE_PATH' => 'assets/uploads/products/',
    'TEMP_PATH' => 'assets/temp/',

    /*Messages*/
    'STATUS_UPDATE' => 'Status Updated Successfully.',

    /*Users*/
    'USER_ADDED' => 'User Added Successfully.',
    'USER_UPDATED' => 'User Updated Successfully.',
    'USER_DELETE' => 'User Deleted Successfully.',

    /*Products*/
    'PRODUCT_ADDED' => 'Product Added Successfully.',
    'PRODUCT_UPDATED' => 'Product Updated Successfully.',
    'PRODUCT_DELETE' => 'Product Deleted Successfully.',

    /*Categories*/
    'CATEGORY_ADDED' => 'Category Added Successfully.',
    'CATEGORY_UPDATED' => 'Category Updated Successfully.',
    'CATEGORY_DELETE' => 'Category Deleted Successfully.',

    /*Error*/
    'ERROR_MESSAGE' => 'Something Went Wrong!',

    /*Profile*/
    'PROFILE_UPDATED' => 'Profile Updated Successfully',

    /*Inquiry*/
    'INQUIRY_DELETED' => 'Inquiry Deleted Successfully.',

    /*Status*/
    'STATUS' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ],

    /*Pagination Value*/
    'CATEGORY_COUNT' => 10,
    'PRODUCT_COUNT' => 10,

    /*Email*/
    'FROM_EMAIL' => env('MAIL_USERNAME') ?? 'info@zzonemicrogoldjewellery.com',
    'FROM_NAME' => env('MAIL_FROM_NAME') ?? 'Z-Zone'
];
