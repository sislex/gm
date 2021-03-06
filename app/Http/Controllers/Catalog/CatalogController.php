<?php

namespace App\Http\Controllers\Catalog;

use App\Content;
use App\UIComponents;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Items;
use App\Calculator;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $catalog_banner = UIComponents::where('name','=','catalog-banner')->get()->first();
        $catalog_banner_arr = [];

        if(isset($catalog_banner) && isset($catalog_banner->obj)){
            $obj = json_decode($catalog_banner->obj);
            if(isset($obj->images)){
                $catalog_banner_arr['images'] = $obj->images;
            }
            if(isset($obj->html)){
                $catalog_banner_arr['html'] = $obj->html;
            }
        }
        $itemsNames = [];
        $items = Items::where('published', '=', '1')->get();

        if($items->count()){
            $items = $items->toArray();
            foreach($items as $value){
                if(isset($value['obj'])){
                    $obj = json_decode($value['obj'], true);

                    $mark = '';
                    $model = '';
                    $modification = '';
                    $year = '';

                    if(isset($obj['type_auto'][0]['children'][0]['text'])){
                        $mark = $obj['type_auto'][0]['children'][0]['text'];
                    }

                    if(isset($obj['type_auto'][0]['children'][0]['children'][0]['text'])){
                        $model = $obj['type_auto'][0]['children'][0]['children'][0]['text'];
                    }

                    if(isset($obj['Версия/Модификация'])){
                        $modification = $obj['Версия/Модификация'];
                    }

                    if(isset($obj['God_vypuska'][0]['text'])){
                        $year = $obj['God_vypuska'][0]['text'];
                    }

                    if ($modification != ''){
                        $name = "{$mark} {$model} {$modification} {$year}";
                    } else {
                        $name = "{$mark} {$model} {$year}";
                    }

                    // adding or updating 'name' field containing full name of the item
                    $obj['name'] = trim($name);
                    $item = Items::where('id','=',$value['id'])->get()->first();
                    if (isset($item->obj) && $item->obj != $obj){
                        $item->obj = json_encode($obj);
                        $item->save();
                    }

                    $itemsNames[] = ['id' => $value['id'], 'name' => $name];
                }
            }
        }
        
        return view('catalog/catalog/index', [
            'catalog_banner' => $catalog_banner_arr,
            'itemsNames' => $itemsNames
        ]);
    }

    public function item($id = 0)
    {
        if ($id) {
            $item = Items::find($id);
            if ($item) {
                Items::updateViewsCounter($id);

                if ($item['obj']){
                    $obj = json_decode($item['obj'], true);
                    $item['obj'] = $obj;

                    if (!isset($obj['views_count'])){
                        $item['views_count'] = 1;
                    } else {
                        $item['views_count'] = $obj['views_count'];
                    }

                    if (!isset($obj['images'])){
                        $item->images = [];
                    } else {
                        $item->images = $obj['images'];
                    }
                }

                $catalog_banner = UIComponents::where('name','=','catalog-banner')->get()->first();
                $catalog_banner_arr = [];

                if(isset($catalog_banner) && isset($catalog_banner->obj)){
                    $obj = json_decode($catalog_banner->obj);
                    if(isset($obj->images)){
                        $catalog_banner_arr['images'] = $obj->images;
                    }
                    if(isset($obj->html)){
                        $catalog_banner_arr['html'] = $obj->html;
                    }
                }

                if(isset($item['obj']['Версия/Модификация']) && trim($item['obj']['Версия/Модификация']) != ''){
                    $item['name'] = "{$item['obj']['type_auto'][0]['children'][0]['text']}"
                        ." {$item['obj']['type_auto'][0]['children'][0]['children'][0]['text']}"
                        ." {$item['obj']['Версия/Модификация']}"
                        ." {$item['obj']['God_vypuska'][0]['text']}";
                } else {
                    $item['name'] = "{$item['obj']['type_auto'][0]['children'][0]['text']}"
                        ." {$item['obj']['type_auto'][0]['children'][0]['children'][0]['text']}"
                        ." {$item['obj']['God_vypuska'][0]['text']}";
                }

                $percent = Calculator::where('name', '=', 'Процент')->first();

                return view('catalog/catalog/item', ['item' => $item, 'catalog_banner' => $catalog_banner_arr, 'percent' => $percent['value']]);
            } else {
                // Go To 404 page if $id is not valid (not found in database)
                abort(404);
            }

        } else {
            // Go To 404 page if $id is not set or zero
            abort(404);
        }
    }

    public function menu($pseudo_url = ''){
        if ($pseudo_url) {
            $content = Content::where('pseudo_url','=',$pseudo_url)->get()->first();
            if ($content) {
                return view('catalog/content/menu', ['content' => $content]);
            } else {
                // Go To 404 page if $pseudo_url is not valid (not found in database)
                abort(404);
            }
        } else {
            // Go To 404 page if $pseudo_url is not set or empty string
            abort(404);
        }
    }

    public function news($pseudo_url = ''){
        if ($pseudo_url) {
            $content = Content::where('pseudo_url','=',$pseudo_url)->get()->first();
            if ($content) {
                $categories = Content::getCategories('news');

                return view('catalog/content/news/news', ['content' => $content, 'categories' => $categories]);
            } else {
                // Go To 404 page if $pseudo_url is not valid (not found in database)
                abort(404);
            }
        } else {
            // Go To 404 page if $pseudo_url is not set or empty string
            abort(404);
        }
    }

    public function news_index(){
        $content = Content::where('type','=','news')->where('parent_id','=',0)->get()->first();

        $news_pages = Content::getCategoriesContent('news',$content->id);
        $categories = Content::getCategories('news');

        return view('catalog/content/news/index', ['content' => $content, 'news_pages' => $news_pages, 'categories' => $categories]);
    }

    public function news_category($pseudo_url){
        if ($pseudo_url) {
            $content = Content::where('pseudo_url','=',$pseudo_url)->get()->first();
            if ($content) {
                $news_pages = Content::getContent('news',$content->id);
                $categories = Content::getCategories('news');

                return view('catalog/content/news/index', ['content' => $content, 'news_pages' => $news_pages, 'categories' => $categories, 'active_category_id' => $content->id]);
            } else {
                // Go To 404 page if $pseudo_url is not valid (not found in database)
                abort(404);
            }
        } else {
            // Go To 404 page if $pseudo_url is not set
            abort(404);
        }
    }

    public function blog($pseudo_url = ''){
        if ($pseudo_url) {
            $content = Content::where('pseudo_url','=',$pseudo_url)->get()->first();
            if ($content) {
                $categories = Content::getCategories('blog');

                return view('catalog/content/blog/blog', ['content' => $content, 'categories' => $categories]);
            } else {
                // Go To 404 page if $pseudo_url is not valid (not found in database)
                abort(404);
            }
        } else {
            // Go To 404 page if $pseudo_url is not set
            abort(404);
        }
    }

    public function blog_index(){
        $content = Content::where('parent_id','=',0)->where('type','=','blog')->get()->first();

        $blog_pages = Content::getCategoriesContent('blog',$content->id);
        $categories = Content::getCategories('blog');

        return view('catalog/content/blog/index', ['content' => $content, 'blog_pages' => $blog_pages, 'categories' => $categories]);
    }

    public function blog_category($pseudo_url){
        if ($pseudo_url) {
            $content = Content::where('pseudo_url','=',$pseudo_url)->get()->first();
            if ($content) {
                $blog_pages = Content::getContent('blog',$content->id);
                $categories = Content::getCategories('blog');

                return view('catalog/content/blog/index', ['content' => $content, 'blog_pages' => $blog_pages, 'categories' => $categories, 'active_category_id' => $content->id]);
            } else {
                // Go To 404 page if $pseudo_url is not valid (not found in database)
                abort(404);
            }
        } else {
            // Go To 404 page if $pseudo_url is not set
            abort(404);
        }
    }

    public function getLastContent()
    {
        $input = \Request::all();

        $content_arr = [];
        if(isset($input['type']) && isset($input['limit']))
        {
            $type = $input['type'];
            $limit = $input['limit'];
            $content_arr = Content::getLastContent($type, $limit);
        }

        return $content_arr;
    }
}
