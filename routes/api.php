<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Tags;
use App\Models\Categories;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/json', function (){
//    $tags = DB::select('select * from tags'); //Return array of objects
//    $categories = DB::select('select * from categories'); //Return array of objects
    $tags = DB::connection()->getPdo()->query("select * from tags")->fetchAll(\PDO::FETCH_ASSOC); //Return array of arrays
    $categories = DB::connection()->getPdo()->query("select * from categories")->fetchAll(\PDO::FETCH_ASSOC); //Return array of arrays

    $data = [
        'tags' => [],
        'categories' => [],
    ];
    if (!empty($tags)){
        foreach ($tags AS $tag){
            $data['tags'][] = ['id' => $tag['id'], 'title' => $tag['title']];
        }
    }
    if (!empty($categories)){
        foreach ($categories AS $category){
            $data['categories'][] = ['id' => $category['id'], 'title' => $category['title']];
        }
    }

    return [
        'data' => $data
    ];

    //Best solution:
//    return [
//        'data' => [
//            'tags' => Tags::select('id', 'title')->get(),
//            'categories' => Categories::select('id', 'title')->get(),
//        ]
//    ];
});
