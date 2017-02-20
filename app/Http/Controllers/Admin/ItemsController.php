<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Items;
use Illuminate\Support\Facades\Storage;
use Mockery\CountValidator\Exception;

class ItemsController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Items::get();
        return view('admin/items/index', ['items' => $items]);
    }

    public function getItemsObj($limit = 9999999)
    {
        $input = \Request::all();

        if(isset($input['check'])){
            $type = $input['check'];
        }else{
            $type = '';
        }

        if($type == 'published'){
            $items = Items::where('published', '=', 1)->orderBy('id', 'desc')->take($limit)->get()->toArray();
        }else{
            $items = Items::orderBy('id', 'desc')->take($limit)->get()->toArray();
        }

        $arr = [];

        foreach($items as $value){
            if(($type=='published' && $value['published']) || $type!='published'){
                if($value['obj']!=''){
                    $obj = json_decode($value['obj'], true);
                    unset($value['obj']);
                }else{
                    $obj = [];
                }
                if($value['promo'] != ''){
                    $promo = json_decode($value['promo'], true);
                    unset($value['promo']);
                }else{
                    $promo = [];
                }
                $obj['item'] = $value;
                $obj['price'] = $value['price'];
                $obj['promo'] = $promo;
                $arr[] = $obj;
            }
        }

     return $arr;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $item = '';
        return view('admin/items/item', ['item' => $item]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($id != '') {
            $item = Items::find($id);

            if ($item['obj']){
                $obj = json_decode($item['obj'], true);
                if (!isset($obj['images'])){
                    $item->images = json_encode([]);
                } else {
                    $item->images = json_encode($obj['images']);
                }
            }
            if($item['promo']){
                $item['promo'] = json_decode($item['promo'], true);
            }
        } else {
            $item = '';
        }

        return view('admin/items/item', ['item' => $item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $input = \Request::all();
        $input = Items::modifiedData($input);

        if (isset($input['id']) && isset($input['obj'])) {
            $k = json_decode($input['obj'],true);
            if (isset($k['images'])){
                $item = Items::find($input['id']);
                $obj = json_decode($item->obj, true);
                $k['images'] = $obj['images'];
            }

            $input['obj'] = json_encode($k);
        }

        if($input['id']){
            Items::find($input['id'])->update($input);
        }else{
            $input['id'] = Items::create($input);
        }

        return \Redirect::action('Admin\ItemsController@show', ['id' => $input['id'], $input['tab']]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateImages()
    {
        $input = \Request::all();

        if(!isset($input['images'])){
            $input['images'] = [];
        }
        if ($input['id'] && is_array($input['images'])) {
            $item = Items::find($input['id']);
            $arr = json_decode($item->obj, true);
            $arr['images'] = $input['images'];
            $item->obj = json_encode($arr);
            $item->save();
        }
        return 'images updated';
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $disk = Storage::disk('my_images');
        if ($disk->exists('items/' . (string)$id)) {

            $is_valid_dir = is_dir($disk->getAdapter()->getPathPrefix() . 'items/' . (string)$id);
            if ($is_valid_dir) {
                try {
                    $disk->deleteDirectory('items/' . $id);
                } catch (Exception $e) {
                    dd('Возникла непредвиденная ошибка: ' . $e->getMessage(), '\n');
                }
            }
        }

        $item = Items::find($id);
        $item->delete();

        return \Redirect::action('Admin\ItemsController@index');
    }
}
