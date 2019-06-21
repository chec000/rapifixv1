<?php

namespace Modules\Shopping\Entities;

use Auth;
use Mockery\Exception;
use Modules\Admin\Entities\CountryLanguage;
use Session;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\ACL\User;
use Modules\Admin\Entities\CountryTranslation;
use DB;

class ComplementaryProducts extends Model
{
    /**
     * The table associated with the model. ksjfkjdshf
     *
     * @var string
     */
    protected $table = 'shop_complementary_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['country_id','product_id','product_related_id','active','last_modifier_id','created_at','updated_at'];


    /**
     * Crea o edita la information del product
     * @param  int $id
     * @param  int $sku
     * @param  boolean $is_kit
     * @param  boolean $active
     * @return int $product
     */
     static function saveInfo($relateds, $product_id,$active,$country)
    {


         if (!empty($product_id))
        {

            DB::table('shop_complementary_products')->where('product_id','=',$product_id)->where('country_id','=',$country)->delete();
             foreach ($relateds as $rl){

                    /* $existeregistro = ComplementaryProducts::where('product_id','=',$product_id)->
                                                             where('country_id','=',$rl['country'])
                                                             ->get();

                    //dd($existeregistro);

                    if(!empty($existeregistro)){
                        DB::table('shop_complementary_products')->where('product_id','=',$product_id)->where('country_id','=',$rl['country'])->delete();
                    } */




                   //logica para almacenar los productos relacionados

                       $productcomplementary = ComplementaryProducts::updateOrCreate(
                           ['country_id' => $rl['country'],'product_id' => $product_id,'product_related_id' => $rl['id_related']],
                           ['country_id' => $rl['country'],'product_id' => $product_id,'product_related_id' => $rl['id_related'],'active' => $active, 'last_modifier_id' => Auth::user()->id]
                       );

                }
             }

        return false;
    }


    /**
     * Regresa los productos filtrados por marca y por país para obtener unicamente los complementarios de dicha combinación
     * @param  int $pais,$lenguaje,$idproducto
     * @return array $product
     */
    static function obtainComplementaryProducts($pais,$lenguaje,$idproducto)
    {

        //Se optiene la informaicon de la marca del producto
        try{
            $brandProduct = BrandProduct::join('glob_brand_translations', 'shop_brand_products.brand_id', '=', 'glob_brand_translations.brand_id')
                ->where('product_id',$idproducto)->where('glob_brand_translations.locale',Session::get('adminLocale'))->first();

            $product = Product::join('shop_brand_products','shop_brand_products.product_id','=','shop_products.id')
                ->join('shop_country_products','shop_country_products.product_id','=','shop_products.id')
                ->join('shop_product_translations','shop_product_translations.country_product_id','=','shop_country_products.id')
                ->where('shop_brand_products.brand_id','=',$brandProduct->brand_id)
                ->where('shop_country_products.country_id','=',$pais)
                ->where('shop_product_translations.locale','=',Session::get('adminLocale'))
                ->get();



            return $product;

        }catch(\Exception $e){
            $product = "";
            return $product;
        }

    }


    static function selectedComplementary($id,$country_id){

             $selected = ComplementaryProducts::join('shop_country_products','shop_country_products.product_id','=','shop_complementary_products.product_related_id')
                                               ->join('shop_product_translations','shop_product_translations.country_product_id','=','shop_country_products.id')
                                               ->join('shop_products','shop_products.id','=','shop_country_products.id')
                                               ->where('shop_complementary_products.country_id','=',$country_id)
                                               ->where('shop_complementary_products.product_id','=',$id)
                                               ->where('shop_complementary_products.active','=',1)
                                               ->select('shop_complementary_products.id as idcomplementary','shop_complementary_products.country_id as country_complementary','shop_complementary_products.product_id as productcomplementary','shop_complementary_products.product_related_id as productrelated','shop_complementary_products.active as active','shop_product_translations.name as name','shop_product_translations.image as image','shop_products.sku as sku')
                                                ->get();


            return $selected;

    }

    public function relatedProduct() {
        return $this->hasOne('Modules\Shopping\Entities\CountryProduct', 'id', 'product_related_id');
    }

}