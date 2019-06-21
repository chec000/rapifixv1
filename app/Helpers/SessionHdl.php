<?php
/**
 * Created by PhpStorm.
 * User: vicente.gutierrez
 * Date: 27/07/18
 * Time: 12:59
 */

namespace App\Helpers;


use Illuminate\Support\Facades\Session;

class SessionHdl {

    public static function getCorbizCountryKey() {
        return Session::get('portal.main.country_corbiz');
    }

    public static function getCorbizLanguage() {
        return Session::get('portal.main.language_corbiz');
    }

    public static function getWarehouse() {
        return Session::get('portal.main.corbiz_warehouse') != null ? Session::get('portal.main.corbiz_warehouse') : '';
    }

    public static function getTypeWarehouse() {
        return Session::get('portal.main.type_warehouse') != null ? Session::get('portal.main.type_warehouse') : '';
    }

    public static function getLocale() {
        return Session::get('portal.main.app_locale');
    }

    public static function getTimeZone() {
        return Session::get('portal.main.time_zone');
    }

    public static function getCurrencyKey() {
        return Session::get('portal.main.currency_key');
    }

    public static function getCountryID() {
        return Session::get('portal.main.country_id');
    }

    public static function getParentBrandID() {
        return Session::get('portal.main.brand.parent_brand_id');
    }

    public static function getParentBrands() {
        return Session::get('portal.main.varsMenu.parentBrands');
    }

    public static function getBrandID() {
        return Session::get('portal.main.brand.id');
    }

    public static function getBrandName() {
        return Session::get('portal.main.brand.name');
    }

    public static function hasParentBrands() {
        return Session::get('portal.main.varsMenu.parentBrands') != null;
    }

    public static function isInscriptionActive() {
        return ((int) Session::get('portal.main.inscription_active')) == 1;
    }

    public static function isShoppingActive() {
        return ((int) Session::get('portal.main.shopping_active')) == 1;
    }

    public static function isCustomerActive() {
        return ((int) Session::get('portal.main.customer_active')) == 1;
    }

    public static function hasShippingAddress() {
        return Session::get('portal.checkout.'.self::getCorbizCountryKey().'.shippingAddress.selected') != null;
    }

    public static function getShippingAddress() {
        return Session::get('portal.checkout.'.self::getCorbizCountryKey().'.shippingAddress.selected');
    }

    public static function hasTransaction() {
        return Session::get('portal.checkout.'.self::getCorbizCountryKey().'.transaction') != null;
    }

    public static function getTransaction() {
        return Session::get('portal.checkout.'.self::getCorbizCountryKey().'.transaction');
    }

    public static function hasEo() {
        return Session::get('portal.eo') != null;
    }

    public static function getEo() {
        return Session::get('portal.eo');
    }

    public static function hasQuotation() {
        return Session::get('portal.checkout.'.self::getCorbizCountryKey().'.quotation') != null;
    }

    public static function getQuotation() {
        return Session::get('portal.checkout.'.self::getCorbizCountryKey().'.quotation');
    }

    public static function getDistributorId() {
        return Session::get('portal.eo.distId');
    }

    public static function hasPaymentMethod() {
        return Session::get('portal.checkout.'.self::getCorbizCountryKey().'.paymentMethod') != null;
    }

    public static function getPaymentMethod() {
        return Session::get('portal.checkout.'.self::getCorbizCountryKey().'.paymentMethod');
    }

    public static function getRouteWS() {
        return Session::get('portal.main.webservice');
    }

    public static function getBrandUrl() {
        return Session::get('portal.main.brand.domain');
    }

    public static function hasChoosePer() {
        return Session::has('portal.checkout.'.self::getCorbizCountryKey().'.quotation.choose_per');
    }

    public static function getChoosePer() {
        return Session::get('portal.checkout.'.self::getCorbizCountryKey().'.quotation.choose_per');
    }

    public static function hasPeriodChange() {
        return Session::has('portal.checkout.'.self::getCorbizCountryKey().'.quotation.period_change');
    }

    public static function getPeriodChange() {
        return Session::get('portal.checkout.'.self::getCorbizCountryKey().'.quotation.period_change');
    }

    public static function hasPromotionItems($process = "checkout") {

        return Session::has("portal.{$process}.".self::getCorbizCountryKey().".promotionsItemsTemp");
    }

    public static function getPromotionItems($process = "checkout") {
        if (Session::has("portal.{$process}.".self::getCorbizCountryKey().".promotionsItemsTemp")) {
            return Session::get("portal.{$process}.".self::getCorbizCountryKey().".promotionsItemsTemp");
        }

        return [];
    }

    public static function forgetPromotionItems($process = "checkout") {
        return Session::forget("portal.{$process}.".self::getCorbizCountryKey().".promotionsItemsTemp");
    }

    // Config data
    public static function isDistributorAreaActive() {
        return ((int) config('settings::frontend.distributorarea_active')) == 1;
    }
}