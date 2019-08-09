<?php
/**
 * Created by PhpStorm.
 * User: Vicente Gutiérrez <vicente.gutierrez@omnilife.com>
 * Date: 11/07/18
 * Time: 11:07
 */

namespace App\Helpers;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Modules\Shopping\Entities\CountryProduct;
use Modules\Shopping\Entities\Product;
use Modules\Shopping\Entities\ProductRestriction;
use Modules\Shopping\Entities\PromoProd;

class ShoppingCart {

    /**
     * productsToJson
     * Convierte una colección de productos de una categoría (GroupProducts) a un string JSON
     *
     * @param Collection $groupProducts Colección de objetos GroupProducts
     * @return string
     */
    public static function productsToJson(Collection $groupProducts) : string {

        $products         = [];

        if(count($groupProducts)>0){
            foreach ($groupProducts as $groupProduct) {

                //*ashajsh
                    $product = new \stdClass();
                    if($groupProduct->countryProduct!=null){
                        $product->id          = $groupProduct->countryProduct->id;
                        $product->sku         = $groupProduct->countryProduct->product->sku;
                        $product->name        = $groupProduct->countryProduct->name;
                        $product->description = $groupProduct->countryProduct->description;
                        $product->image       = asset($groupProduct->countryProduct->image);
                        $product->price       = $groupProduct->countryProduct->price;
                        $product->points      = $groupProduct->countryProduct->points;
                        $product->quantity    = 1;
                        $products[$product->id] = $product;
                    }

                
            }
        }

        return json_encode($products);
    }


    /**
     * relatedProductsToJson
     * Convierte una colección de productos relacionados (ComplementaryProducts) a un string JSON
     *
     * @param Collection $relatedProducts Colección de objetos ComplementaryProducts
     * @return string
     */
    public static function relatedProductsToJson(Collection $relatedProducts) : string {
        $products         = [];
        $config           = country_config(SessionHdl::getCorbizCountryKey());
        $isShoppingActive = $config['shopping_active'];
        $isWSActive       = $config['webservices_active'];
        $warehouse        = SessionHdl::getWarehouse();

        foreach ($relatedProducts as $relatedProduct) {
            if ( ($isShoppingActive and $relatedProduct->relatedProduct->belongsToWarehouse($warehouse) and $isWSActive) xor (!$isShoppingActive or !$isWSActive) ) {
                $product = new \stdClass();
                $product->id          = $relatedProduct->relatedProduct->id;
                $product->sku         = $relatedProduct->relatedProduct->product->sku;
                $product->name        = $relatedProduct->relatedProduct->name;
                $product->description = $relatedProduct->relatedProduct->description;
                $product->image       = asset($relatedProduct->relatedProduct->image);
                $product->price       = $relatedProduct->relatedProduct->price;
                $product->points      = $relatedProduct->relatedProduct->points;
                $product->quantity    = 1;

                $products[$product->id] = $product;
            }
        }

        return json_encode($products);
    }


    /**
     * sessionToJson
     * Convierte el listado de productos de la sesión a un string JSON
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @return string
     */
    public static function sessionToJson(string $countryKey) : string {
        $products = [];

        if (Session::has("portal.cart.items") && sizeof(Session::get("portal.cart.items")) > 0) {
            foreach (self::getItems($countryKey) as $sessionProduct) {
                $product = new \stdClass();
                $product->id          = $sessionProduct['id'];
                $product->sku         = $sessionProduct['sku'];
                $product->name        = $sessionProduct['name'];
                $product->description = $sessionProduct['description'];
                $product->image       = $sessionProduct['image'];
                $product->price       = $sessionProduct['price'];
                $product->points      = $sessionProduct['points'];
                $product->quantity    = $sessionProduct['quantity'];

                $products[$product->id] = $product;
            }
        }

        return json_encode($products);
    }


    /**
     * createSession
     * Crea la sesión del carrito de compras si no existe
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @return bool
     */
    public static function createSession() : bool {
        \session()->put('portal.main.currency_key','DOP');
        if (!Session::has("portal.cart")) {
            Session::put("portal.cart", [
                'items'    => [],
                'subtotal' => 0.0,
                'points'   => 0
            ]);

        }

            return true;
    }


    /**
     * deleteSession
     * Elimina la sesión del carrito de compras de un país
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @return bool
     */
    public static function deleteSession() : bool {
        if (Session::has("portal.cart")) {
           // Session::forget("portal.cart");
            return true;
        }

        return false;
    }


    /**
     * deleteAllSessions
     * Elimina las sesiones del carrito de compras de todos los paises
     *
     * @return bool
     */
    public static function deleteAllSessions() : bool {
        if (Session::has("portal.cart")) {
            //Session::forget("portal.cart");
            return true;
        }

        return false;
    }


    /**
     * hasItem
     * Verifica si existe un item o producto en la sesión de un país en específico
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @param string $sku           SKU del producto a buscar
     * @return bool
     */
    public static function hasItem(string $sku) : bool {
        if (!is_null(Session::get("portal.cart.items"))) {
            foreach (Session::get("portal.cart.items") as $sessionItem) {
                if ($sessionItem['sku'] == $sku) {
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * addItem
     * Agrega un item nuevo a la sesión o suma $q elementos al item si este ya se encuentra en sesión
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @param array $item           Item o producto para agregar al carrito
     * @return array
     */
    public static function addItem(array $item) : array {
        $items = Session::get("portal.cart.items");

        if (self::hasItem( $item['sku'])) {
            for ($i = 0; $i < sizeof($items); $i++) {
                if ($item['sku'] == $items[$i]['sku']) {
                    $items[$i]['quantity'] += $item['quantity'];

                    Session::put("portal.cart.items", $items);

                    self::calculatePoints();
                    self::calculateSubtotal();

                    return $items[$i];
                }
            }
        } else {
            $items            = Session::get("portal.cart.items");
            $item['price']    = (float) $item['price'];
            $item['points']   = (int) $item['points'];
            $items[]          = $item;

            Session::put("portal.cart.items", $items);

            self::calculatePoints();
            self::calculateSubtotal();

            return $item;
        }

        return [];
    }


    /**
     * removeItem
     * Elimina uno o todos los elementos de un item del carrito
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @param string $sku           SKU del producto
     * @param bool $removeAll       Bandera para eliminar todos los elementos del item
     * @return bool
     */
    public static function removeItem(string $sku, bool $removeAll = false) : bool {
     
        $items = Session::get("portal.cart.items");
        for ($i = 0; $i < sizeof($items); $i++) {
            if ($sku == $items[$i]['sku']) {

                if ($removeAll) {
                    array_splice($items, $i, 1);
                } else {
                    if ($items[$i]['quantity'] > 1) {
                        $items[$i]['quantity'] -= 1;
                    } else {
                        array_splice($items, $i, 1);
                    }
                }

                Session::put("portal.cart.items", $items);

                self::calculatePoints();
                self::calculateSubtotal();

                return true;
            }
        }

        return false;
    }


    /**
     * updateItem
     * Actualiza la información en sesión de un producto
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @param string $sku           SKU del producto
     * @param array $item           Array con los nuevos datos del producto
     * @return array
     */
    public static function updateItem(string $sku, array $item = []) : array {
        $items = Session::get("portal.cart.items");

        if (self::hasItem($sku)) {
            for ($i = 0; $i < sizeof($items); $i++) {
                if ($sku == $items[$i]['sku']) {

                    foreach ($item as $key => $value) {
                        $items[$i][$key] = $value;
                    }

                    Session::put("portal.cart.items", $items);

                    self::calculatePoints();
                    self::calculateSubtotal();

                    return $items[$i];
                }
            }
        }

        return [];
    }


    /**
     * getItems
     * Regresa todos los items del carrito de un país
     *
     * @param string $countryKey Llave de corbiz del país a crear la sesión
     * @return array
     */
    public static function getItems() : array {
        if (Session::has("portal.cart.items")) {
            return Session::get("portal.cart.items");
        }

        return [];
    }


    /**
     * calculatePoints
     * Calcula el total de puntos de los productos que se encuentran en el carrito
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @return int
     */
    public static function calculatePoints() : int {
        $points = 0;

        if (Session::has("portal.cart.items") && sizeof(Session::get("portal.cart.items")) > 0) {
            foreach (Session::get("portal.cart.items") as $item) {
                $points += $item['points'] * $item['quantity'];
            };
        }

        Session::put("portal.cart.points", $points);

        return $points;
    }


    /**
     * calculateSubtotal
     * Calcula el el monto subtotal de los productos que se encuentran en el carrito
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @return float
     */
    public static function calculateSubtotal() : float {
        $subtotal = 0.0;

        if (Session::has("portal.cart.items") && sizeof(Session::get("portal.cart.items")) > 0) {
            foreach (Session::get("portal.cart.items") as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            };
        }

        Session::put("portal.cart.subtotal", $subtotal);

        return $subtotal;
    }


    /**
     * getPoints
     * Obtiene los puntos de los productos en el carrito
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @return int
     */
    public static function getPoints() : int {
        return Session::has("portal.cart.points") ? Session::get("portal.cart.points") : 0;
    }


    /**
     * getSubtotal
     * Obtiene el subtotal de los productos en el carrito
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @return float
     */
    public static function getSubtotal() : float {
        return Session::has("portal.cart.subtotal") ? Session::get("portal.cart.subtotal") : 0.0;
    }


    /**
     * Llave de corbiz del país a crear la sesión
     * Obtiene el subtotal de los productos en el carrito formateados para una moneda
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @param string $currencyKey   Clave de la moneda
     * @return string
     */
    public static function getSubtotalFormatted(string $currencyKey) : string {
        return Session::has("portal.cart.subtotal") ? currency_format(Session::get("portal.cart.subtotal"), $currencyKey)  : currency_format(0, $currencyKey);
    }


    /**
     * getProductTranslations
     * Obtiene las traducciones relacionadas con los productos
     *
     * @param $locale               Idioma de las traducciones
     * @return array
     */
    public static function getProductTranslations($locale) : array {
        return [
            'code'     => trans('cms::cart_aside.code', [], $locale),
            'pts'      => trans('cms::cart_aside.pts', [], $locale),
            'points'   => trans('cms::cart_aside.points', [], $locale),
            'subtotal' => trans('cms::cart_aside.subtotal', [], $locale),
            'total'    => trans('cms::cart_aside.total', [], $locale),
            'no_items' => trans('cms::cart_aside.no_items', [], $locale),
        ];
    }


    /**
     * getPriceFormatted
     * Obtiene el precio de un producto formateado
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @param string $sku           SKU del producto
     * @param string $currencyKey   Clave de la moneda
     * @return string
     */
    public static function getPriceFormatted(string $sku, string $currencyKey) : string {
        $price = currency_format(0, $currencyKey);

        if (Session::has("portal.cart.items") && sizeof(Session::get("portal.cart.items")) > 0) {
            foreach (Session::get("portal.cart.items") as $item) {
                if ($item['sku'] == $sku) {
                    $price = currency_format($item['price'], $currencyKey);
                }
            };
        }

        return $price;
    }


    /**
     * validateProductWarehouse
     * Valida que los productos de la sesión pertenezcan al almacén
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @param string $warehouse     Clave del almacén
     */
    public static function validateProductWarehouse(string $warehouse) {
        $items       = self::getItems();
        $deleteItems = false;
        $strDeleteItems = "";
        foreach ($items as $i => $item) {
            $countryProduct = CountryProduct::find($item['id']);
            //print_r($item['id']);
            if (!$countryProduct->belongsToWarehouse($warehouse)) {
                $strDeleteItems .= $items[$i]['sku'].', ';
                unset($items[$i]);
                $deleteItems = true;
            }
        }

        $items = array_values($items);

        if (sizeof($items) == 0) {
            self::deleteSession();
        } else {
            Session::put("portal.cart.items", $items);

            self::calculatePoints();
            self::calculateSubtotal();

            if ($deleteItems) {

                if(session()->has('delete-items')) {
                    $msgItemsRemove = session()->get('delete-items'). " error_pw:".(substr($strDeleteItems,0,-2).'.');
                    session()->flash('delete-items', $msgItemsRemove);
                } else {
                    session()->flash('delete-items', trans('cms::cart_aside.delete_items')." error_pw:".(substr($strDeleteItems,0,-2).'.'));
                }
            }
        }
    }


    /**
     * validateProductRestrictionState
     * Valida que los productos de la sesión no se encuentren restringidos por pais-estado
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @param string $stateKey     Clave del estado de la dirección a validar
     */
    public static function validateProductRestrictionState(string $stateKey) {
        $items       = self::getItems();
        $deleteItems = false;

        $countryProduct = ProductRestriction::from('shop_product_restrictions as pr')
            ->select('pr.country_product_id')
            ->join('shop_country_products as scp', 'scp.id', '=', 'pr.country_product_id' )
            ->where('scp.country_id', '=', SessionHdl::getCountryID())
            ->where('pr.state', '=', $stateKey)
            ->where('pr.active', '=', 1)
            ->get();
        $arrayCP = array();
        foreach($countryProduct as $cp){
            $arrayCP[] = (int)$cp->country_product_id;
        }

        $strDeleteItems = "";
        if(!empty($arrayCP)) {
            foreach ($items as $i => $item) {
                if (in_array((int)$item['id'], $arrayCP, true)) {
                    $strDeleteItems .= $items[$i]['sku'].', ';
                    unset($items[$i]);
                    $deleteItems = true;
                }
            }
        }

        $items = array_values($items);

        if (sizeof($items) == 0) {
            self::deleteSession();
        } else {
            Session::put("portal.cart..items", $items);

            self::calculatePoints();
            self::calculateSubtotal();

            if ($deleteItems) {
                if(session()->has('delete-items')) {
                    $msgItemsRemove = session()->get('delete-items'). ", error_pr:".(substr($strDeleteItems,0,-2).'.');
                    session()->flash('delete-items', $msgItemsRemove);
                } else {
                    session()->flash('delete-items', trans('cms::cart_aside.delete_items').", error_pr:".(substr($strDeleteItems,0,-2).'.'));
                }
            }
        }
    }

    /**
     * getSession
     * Regresa la sesión del carrito con los precios formateados con la moneda de la sesión actual
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @return array
     */
    public static function getSession() {
        $session = [];

        if (Session::has("portal.cart")) {
            $session = Session::get("portal.cart");

            for ($i = 0; $i < sizeof($session['items']); $i++) {
                $session['items'][$i]['price'] = self::getPriceFormatted($session['items'][$i]['sku'], Session::get('portal.main.currency_key'));
            }

            $session['subtotal'] = self::getSubtotalFormatted(Session::get('portal.main.currency_key'));
        }

        return $session;
    }

    public static function setSessionCartAddSalesWeb($arrayData){
        $items = array();

        //Prearmado de la cotizacion para guardar en session
        $sessionCheckout = [
                'subtotal' => $arrayData['Subtotal'],
                'handling' => $arrayData['Handling'],
                'taxes' => $arrayData['Taxes'],
                'total' => $arrayData['Total'],
                'points' => $arrayData['Points'],
                'choose_per' => $arrayData['ChoosePer'] == "true" ? true : false,
                'period_change' => 0,
                'items' => []
            ];

        //Obtiene los items del carrito en session
        $session = Session::get("portal.cart.".SessionHdl::getCorbizCountryKey());
        //FORs para obtener los datos id,description e image del carrito en session y agregarlos a los items en la cotizacion
        foreach ($arrayData['SalesWebItems']['dsSalesWebItems']['ttSalesWebItems'] as $it) {
            $itemCart = [];
            $itemCart['is_special'] = false;
            if($it['promo']){
                $dataItemPromo = PromoProd::where('clv_producto','=',$it['item'])->first();
                //dd($dataItemPromo);
                $itemCart['image'] = ""; //Por definir imagen DEFAULT
                if($dataItemPromo != null){
                    //dd($dataItemPromo);
                    $itemCart['id'] = $dataItemPromo->id;
                    $itemCart['name'] = $dataItemPromo->name;
                    $itemCart['description'] = $dataItemPromo->description;
                } else {
                    $itemCart['id'] = 0;
                    $itemCart['name'] = $it['itemName'];
                    $itemCart['description'] = $it['itemName'];
                }

            }

            else {
                $findProductSupport = Product::where('sku', '=', $it['item'])->first();
                if ($findProductSupport != null){
                    for ($i = 0; $i < sizeof($session['items']); $i++) {
                        if ($session['items'][$i]['sku'] == $it['item']) {
                            $itemCart['id'] = $session['items'][$i]['id'];
                            $itemCart['name'] = $session['items'][$i]['name'];
                            $itemCart['description'] = $session['items'][$i]['description'];
                            $itemCart['image'] = $session['items'][$i]['image'];
                            break;
                        }
                    }
                } else {
                    $itemCart['id'] = 0;
                    $itemCart['name'] = $it['itemName'];
                    $itemCart['description'] = $it['itemName'];
                    $itemCart['image'] = ""; //Por definir imagen DEFAULT
                    $itemCart['is_special'] = true;
                }
            }
            $items[] = [
                'id' => $itemCart['id'],
                'sku' => $it['item'],
                'name' => $itemCart['name'],
                'description' => $itemCart['description'],
                'image' => $itemCart['image'],
                'listPrice' => $it['listPrice'],
                'discPrice' => $it['discPrice'],
                'points' => $it['points'],
                'promo' => $it['promo'],
                'quantity' => $it['quantity'],
                'unit_tax' => $it['unit_tx'],
                'tot_tax' => $it['tot_tax'],
                'is_special' => $itemCart['is_special']

            ];
        }

        //Funcion para editar el carrito con los productos devueltos en el WS addSalesWeb
        self::editShopingCartAddSalesWebWS($items);

        //Se guarda la cotizacion en session
        $sessionCheckout['items'] = $items;

        Session::put('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.quotation', $sessionCheckout);
        //dd(Session::get("portal.checkout"));

        return true;

    }

    /**
     * editShopingCartAddSalesWebWS
     * Valida que los productos de la sesión contra los obtenidos del WS addSalesWeb
     *
     * @param array $arrayItemsQuot   array de items devuelto por el WS addSalesWeb
     */
    public static function editShopingCartAddSalesWebWS($arrayItemsQuot){
        $countryKey = SessionHdl::getCorbizCountryKey();
        $items       = self::getItems($countryKey);
        $deleteItems = false;

        foreach ($items as $i => $item) {
            $itemExist = false;
            foreach($arrayItemsQuot as $aiq){
                if($item['sku'] == $aiq['sku']){
                    $itemExist = true;
                    break;
                }
            }
            //print_r($item['id']);
            if (!$itemExist) {
                unset($items[$i]);
                $deleteItems = true;
            }
        }

        $items = array_values($items);

        if (sizeof($items) == 0) {
            self::deleteSession();
        } else {
            Session::put("portal.cart.items", $items);

            self::calculatePoints();
            self::calculateSubtotal();

            if ($deleteItems) {
                session()->flash('delete-items', trans('cms::cart_aside.delete_items'));
            }
        }
    }

    /**
     * removeItemsCartAddSalesWebWS
     * Valida que los productos de la sesión contra los obtenidos del WS addSalesWeb
     *
     * @param array $arrayItemsQuot   array de items no existentes devuelto por el WS addSalesWeb
     */
    public static function removeItemsCartAddSalesWebWS($arrayItemsQuot){
        $countryKey = SessionHdl::getCorbizCountryKey();
        $items       = self::getItems($countryKey);
        $deleteItems = false;
        $strDeleteItems = "";
        foreach ($items as $i => $item) {
            foreach($arrayItemsQuot as $aiq){
                //if($aiq['idError'] == config('shopping.codes_error_ws.add_sales_web.item_not_available')){*/

                    $contains = str_contains($aiq['messTech'], (string)$item['sku']);
                    if($contains){
                        $strDeleteItems .= $item['sku'].', ';
                        unset($items[$i]);
                        $deleteItems = true;
                        break;
                    }
                    /*list($message, $sku) = explode(":", $aiq['messShortTech']);
                    if((int)$item['sku'] == (int)trim($sku)){
                        $strDeleteItems .= $item['sku'].', ';
                        unset($items[$i]);
                        $deleteItems = true;
                        break;
                    }*/
                //}
            }
        }

        $items = array_values($items);

        if (sizeof($items) == 0) {
            self::deleteSession($countryKey);
        } else {
            Session::put("portal.cart.{$countryKey}.items", $items);

            self::calculatePoints($countryKey);
            self::calculateSubtotal($countryKey);

            if ($deleteItems) {
                if(session()->has('delete-items')) {
                    $msgItemsRemove = session()->get('delete-items'). ", error_pq:".(substr($strDeleteItems,0,-2).'.');
                    session()->flash('delete-items', $msgItemsRemove);
                } else {
                    session()->flash('delete-items', trans('cms::cart_aside.delete_items').", error_pq:".(substr($strDeleteItems,0,-2).'.'));
                }
            }
        }

        return $deleteItems;
    }

    /**
     * getSessionDemo
     * Regresa datos de pruebas simulando una sesión del carrito
     *
     * @return array
     */
    public static function getSessionDemo() {
        return [
            'items' => [
                [
                    'id'          => '87',
                    'sku'         => '9518032',
                    'name'        => 'Tinte castaño claro',
                    'description' => 'Da color a tu cabello sin remordimiento. El Tinte Semi-Permanente sin Amoníaco Seytu resiste 10 a 15 lavadas',
                    'image'       => 'http://seytulocal.omnilife.com/uploads/images/products/detail/mex/es/9518032.png',
                    'price'       => 5,
                    'points'      => 100,
                    'quantity'    => 1
                ],
                [
                    'id'          => '88',
                    'sku'         => '9518033',
                    'name'        => 'Tinte negro natural',
                    'description' => 'Da color a tu cabello sin remordimiento. El Tinte Semi-Permanente sin Amoníaco Seytu resiste 10 a 15 lavadas',
                    'image'       => 'http://seytulocal.omnilife.com/uploads/images/products/detail/mex/es/9518033.png',
                    'price'       => 5,
                    'points'      => 100,
                    'quantity'    => 2
                ],
                [
                    'id'          => '89',
                    'sku'         => '9518034',
                    'name'        => 'Tinte moka',
                    'description' => 'Da color a tu cabello sin remordimiento. El Tinte Semi-Permanente sin Amoníaco Seytu resiste 10 a 15 lavadas',
                    'image'       => 'http://seytulocal.omnilife.com/uploads/images/products/detail/mex/es/9518034.png',
                    'price'       => 5,
                    'points'      => 100,
                    'quantity'    => 1
                ],
                [
                    'id'          => '84',
                    'sku'         => '9504034',
                    'name'        => 'Complejo multivitamínico capilar',
                    'description' => 'Complejo Multivitamínico Capilar',
                    'image'       => 'http://seytulocal.omnilife.com/uploads/images/products/detail/mex/es/9504034.png',
                    'price'       => 5,
                    'points'      => 100,
                    'quantity'    => 1
                ],
                [
                    'id'          => '90',
                    'sku'         => '9518035',
                    'name'        => 'Tinte rojo intenso',
                    'description' => 'Da color a tu cabello sin remordimiento. El Tinte Semi-Permanente sin Amoníaco Seytu resiste 10 a 15 lavadas',
                    'image'       => 'http://seytulocal.omnilife.com/uploads/images/products/detail/mex/es/9518035.png',
                    'price'       => 5,
                    'points'      => 100,
                    'quantity'    => 1
                ],
                [
                    'id'          => '91',
                    'sku'         => '9518036',
                    'name'        => 'Tinte rubio oscuro',
                    'description' => 'Da color a tu cabello sin remordimiento. El Tinte Semi-Permanente sin Amoníaco Seytu resiste 10 a 15 lavadas',
                    'image'       => 'http://seytulocal.omnilife.com/uploads/images/products/detail/mex/es/9518036.png',
                    'price'       => 5,
                    'points'      => 100,
                    'quantity'    => 1
                ],
                [
                    'id'          => '92',
                    'sku'         => '9518037',
                    'name'        => 'Tinte rubio claro',
                    'description' => 'Da color a tu cabello sin remordimiento. El Tinte Semi-Permanente sin Amoníaco Seytu resiste 10 a 15 lavadas',
                    'image'       => 'http://seytulocal.omnilife.com/uploads/images/products/detail/mex/es/9518037.png',
                    'price'       => 5,
                    'points'      => 100,
                    'quantity'    => 1
                ],
            ],
            'subtotal' => '$40.00',
            'points'   => '800'
        ];
    }

    public static function getItemsQuotation(string $countryKey) : array {
        if (Session::has("portal.checkout.{$countryKey}.quotation.items")) {
            return Session::get("portal.checkout.{$countryKey}.quotation.items");
        }
        return [];
    }

    /**
     * getPointsAfterQuotation
     * Obtiene los puntos de los productos en el carrito desde la cotizacion
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @return int
     */
    public static function getPointsQuotation(string $countryKey) : int {
        return Session::has("portal.checkout.{$countryKey}.quotation.points") ? Session::get("portal.checkout.{$countryKey}.quotation.points") : 0;
    }

    /**
     * Obtiene el subtotal de los productos en el carrito formateados para una moneda desde la cotizacion
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @param string $currencyKey   Clave de la moneda
     * @return string
     */
    public static function getSubtotalFormattedQuotation(string $countryKey, string $currencyKey) : string {
        return Session::has("portal.checkout.{$countryKey}.quotation.subtotal") ? currency_format(Session::get("portal.checkout.{$countryKey}.quotation.subtotal"), $currencyKey)  : currency_format(0, $currencyKey);
    }

    /**
     * Obtiene el manejo de los productos en el carrito formateados para una moneda desde la cotizacion
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @param string $currencyKey   Clave de la moneda
     * @return string
     */
    public static function getHandlingFormattedQuotation(string $countryKey, string $currencyKey) : string {
        return Session::has("portal.checkout.{$countryKey}.quotation.handling") ? currency_format(Session::get("portal.checkout.{$countryKey}.quotation.handling"), $currencyKey)  : currency_format(0, $currencyKey);
    }

    /**
     * Obtiene los impuestos de los productos en el carrito formateados para una moneda desde la cotizacion
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @param string $currencyKey   Clave de la moneda
     * @return string
     */
    public static function getTaxesFormattedQuotation(string $countryKey, string $currencyKey) : string {
        return Session::has("portal.checkout.{$countryKey}.quotation.taxes") ? currency_format(Session::get("portal.checkout.{$countryKey}.quotation.taxes"), $currencyKey)  : currency_format(0, $currencyKey);
    }

    /**
     * Obtiene el total de los productos en el carrito formateados para una moneda desde la cotizacion
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @param string $currencyKey   Clave de la moneda
     * @return string
     */
    public static function getTotalFormattedQuotation(string $countryKey, string $currencyKey) : string {
        return Session::has("portal.checkout.{$countryKey}.quotation.total") ? currency_format(Session::get("portal.checkout.{$countryKey}.quotation.total"), $currencyKey)  : currency_format(0, $currencyKey);
    }

    /**
     * deleteSession
     * Elimina la sesión del carrito de compras y la cotizacion de un país
     *
     * @param string $countryKey    Llave de corbiz del país a crear la sesión
     * @return bool
     */
    public static function deleteSessionResumeCart() : bool {
        if (Session::has("portal.cart")) {
            //Session::forget("portal.cart");
            Session::forget("portal.checkout.quotation");
            return true;
        }

        return false;
    }

    /**
     * getPromotionItems
     * Regresa todos los items de promocion de un país
     *
     * @param string $countryKey Llave de corbiz del país a crear la sesión
     * @return array
     */
    public static function getPromotionItems(string $countryKey, string $process = "checkout") : array {

        if (Session::has("portal.{$process}.{$countryKey}.promotionsItemsTemp")) {
            return Session::get("portal.{$process}.{$countryKey}.promotionsItemsTemp");
        }

        return [];
    }
}