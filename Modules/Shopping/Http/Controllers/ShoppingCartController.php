<?php

namespace Modules\Shopping\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use PageBuilder;
use Response;
use View;
use App\Helpers\ShoppingCart;

class ShoppingCartController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function addOneItem(Request $request) {
        $corbizKey = Session::get('portal.main.country_corbiz');
        ShoppingCart::createSession($corbizKey);

        $item    = $request->all();
        $newItem = ShoppingCart::addItem($corbizKey, $item);

        return response()->json([
            'status'      => !empty($newItem),
            'cart_resume' => $this->getCartResume(),
            'translates'  => ShoppingCart::getProductTranslations(Session::get('portal.main.app_locale')),
            'price'       => ShoppingCart::getPriceFormatted($corbizKey, $newItem['sku'], Session::get('portal.main.currency_key')),
        ], 200);
    }

    public function removeOneItem(Request $request) {
        $corbizKey = Session::get('portal.main.country_corbiz');
        $item      = $request->all();

        $removed = ShoppingCart::removeItem($corbizKey, $item['sku']);

        return response()->json([
            'status'      => $removed,
            'cart_resume' => $this->getCartResume(),
            'translates'  => ShoppingCart::getProductTranslations(Session::get('portal.main.app_locale'))
        ], 200);
    }

    public function removeAllFromItem(Request $request) {
        $corbizKey = Session::get('portal.main.country_corbiz');
        $item      = $request->all();

        $removed = ShoppingCart::removeItem($corbizKey, $item['sku'], true);

        return response()->json([
            'status'      => $removed,
            'cart_resume' => $this->getCartResume(),
            'translates'  => ShoppingCart::getProductTranslations(Session::get('portal.main.app_locale'))
        ], 200);
    }

    public function removeAll(Request $request) {
        $corbizKey = Session::get('portal.main.country_corbiz');
        $removed   = ShoppingCart::deleteSession($corbizKey);

        return response()->json([
            'status'     => $removed,
            'translates' => ShoppingCart::getProductTranslations(Session::get('portal.main.app_locale'))
        ], 200);
    }

    public function addManyItems(Request $request) {
        $corbizKey = Session::get('portal.main.country_corbiz');
        ShoppingCart::createSession($corbizKey);

        $items  = $request->all();
        $prices = [];

        if (sizeof($items) > 0) {
            foreach ($items as $item) {
                $newItem = ShoppingCart::addItem($corbizKey, $item);
                $prices[$newItem['sku']] = ShoppingCart::getPriceFormatted($corbizKey, $newItem['sku'], Session::get('portal.main.currency_key'));
            }
        }

        return response()->json([
            'status'      => !empty($newItem),
            'cart_resume' => $this->getCartResume(),
            'translates'  => ShoppingCart::getProductTranslations(Session::get('portal.main.app_locale')),
            'prices'      => $prices,
        ], 200);

    }

    public function changeItemQuantity(Request $request) {
        $corbizKey = Session::get('portal.main.country_corbiz');
        ShoppingCart::createSession($corbizKey);

        $item        = $request->all();
        $updatedItem = ShoppingCart::updateItem($corbizKey, $item['sku'], $item);

        return response()->json([
            'status'      => !empty($updatedItem),
            'cart_resume' => $this->getCartResume(),
            'translates'  => ShoppingCart::getProductTranslations(Session::get('portal.main.app_locale'))
        ], 200);
    }

    public function getCartResume() {
        $corbizKey = Session::get('portal.main.country_corbiz');
        $currency  = Session::get('portal.main.currency_key');

        return [
            'subtotal'            => ShoppingCart::getSubtotal($corbizKey),
            'subtotal_formatted'  => ShoppingCart::getSubtotalFormatted($corbizKey, $currency),
            'points'              => ShoppingCart::getPoints($corbizKey)
        ];
    }

    public function removeAllResumeCart(Request $request) {
        $corbizKey = Session::get('portal.main.country_corbiz');
        $removed   = ShoppingCart::deleteSessionResumeCart($corbizKey);

        return response()->json([
            'status'     => $removed,
            'translates' => ShoppingCart::getProductTranslations(Session::get('portal.main.app_locale'))
        ], 200);
    }

}
