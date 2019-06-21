<?php
/**
 * Created by PhpStorm.
 * User: vicente.gutierrez
 * Date: 27/07/18
 * Time: 12:59
 */

namespace App\Helpers;


use Illuminate\Support\Facades\Session;

class SessionRegisterHdl {

    public static function getCorbizCountryKey() {
        return Session::get('portal.register.country_corbiz');
    }

    public static function getCorbizLanguage() {
        return Session::get('portal.register.language_corbiz');
    }

    public static function getLocale() {
        return Session::get('portal.main.app_locale');
    }

    public static function hasTransaction() {
        return Session::get('portal.register.checkout.'.self::getCorbizCountryKey().'.transaction') != null;
    }

    public static function forgetTransaction() {
        return Session::get('portal.register.checkout.'.self::getCorbizCountryKey().'.transaction') != null;
    }

    public static function getTransaction() {
        return Session::get('portal.register.checkout.'.self::getCorbizCountryKey().'.transaction');
    }

    public static function getTimeZone() {
        return Session::get('portal.register.time_zone');
    }

    public static function getCurrencyKey() {
        return Session::get('portal.register.currency_key');
    }

    public static function getCountryID() {
        return Session::get('portal.register.country_id');
    }

    public static function isInscriptionActive() {
        return ((int) Session::get('portal.main.inscription_active')) == 1;
    }


    public static function hasSteps() {
        return Session::get('portal.register.steps') != null;
    }

    public static function getSteps() {
        return Session::get('portal.register.steps');
    }

    public static function hasRegisterQuotation() {
        return Session::get('portal.register.checkout.'.SessionRegisterHdl::getCorbizCountryKey().'.quotation') != null;
    }

    public static function getRegisterQuotation() {
        return Session::get('portal.register.checkout.'.SessionRegisterHdl::getCorbizCountryKey().'.quotation');
    }

    public static function hasPromotionItems($process = "register") {

        return Session::has("portal.register.".self::getCorbizCountryKey().".promotionsItemsTemp");
    }


    public static function hasPaymentMethod() {
        return Session::get('portal.checkout.paymentMethod') != null;
    }

    public static function getRouteWS() {
        return Session::get('portal.register.webservice');
    }

    public static function getPaymentMethod() {
        return Session::get('portal.register.checkout.'.self::getCorbizCountryKey().'.paymentMethod');
    }

    public static function getKitInfo(){
        return Session::get('portal.register.cart.'.self::getCorbizCountryKey().'.items');
    }

    public static function forgetPromotionItems($process = "register") {
        return Session::forget("portal.{$process}.".self::getCorbizCountryKey().".promotionsItemsTemp");
    }

    // Config data
    public static function isDistributorAreaActive() {
        return ((int) config('settings::frontend.distributorarea_active')) == 1;
    }
}