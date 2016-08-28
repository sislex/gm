<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $fillable = [
        'name',
        'title',
        'description',
        'keywords',
        'short_text',
        'text',
        'published',
        'price',
        'promo',
        'obj',
        'specifications'
    ];

    static function modifiedData($input){
        $item = Items::where('id', '=', $input['id'])->get()->first();
        $text = '';
        if($item){$text = $item->text;}
        if($input && isset($input['obj']) && $input['obj']){
            $obj = json_decode($input['obj'], true);

            $mark = isset($obj['type_auto'][0]['children'][0]['text'])
                ? $obj['type_auto'][0]['children'][0]['text'] : '';
            $model = isset($obj['type_auto'][0]['children'][0]['children'][0]['text'])
                ? $obj['type_auto'][0]['children'][0]['children'][0]['text'] : '';
            $god = isset($obj['God_vypuska'][0]['text'])
                ? $obj['God_vypuska'][0]['text'] : ''. 'г.';
            $toplivo = isset($obj['Тип двигателя'][0]['text'])
                ? $obj['Тип двигателя'][0]['text'] : '';

            if(isset($input['price'])){
                $input['price'] = intval($input['price']);
                $price = "Цена {$input['price']}$";
            }else{
                $price = '';
            }

            $price = isset($input['price'])
                ? "Цена {$input['price']}$" : '';

            if(isset($input['title']) && $input['title']==''){
                $input['title'] = "Купить {$mark} {$model} {$god} {$toplivo} {$price} в Минске Голден Моторс";
            }
            if(isset($input['description']) && $input['description']==''){
                $input['description'] = "Продажа в РБ {$mark} {$model} {$text}";
                $input['description'] = mb_substr($input['description'], 0, 180);
            }
            if(isset($input['keywords']) && $input['keywords']==''){
                $input['keywords'] = "{$mark} {$model}";
            }
        }
        
        if(isset($input['promo_new']) && isset($input['promo_hot'])){
            $promo['new'] = $input['promo_new'];
            $promo['hot'] = $input['promo_hot'];
            $promo['reserved'] = $input['promo_reserved'];
            $input['promo'] = json_encode($promo);
        }

        return $input;
    }
}