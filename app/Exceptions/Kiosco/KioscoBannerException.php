<?php
/**
 * Created by PhpStorm.
 * User: mario.avila
 * Date: 07/08/2018
 * Time: 12:04 PM
 */

namespace App\Exceptions\Kiosco;


class KioscoBannerException extends \Exception
{
    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Exception $previous = null) {

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @createdBy Mario Avila
     */
    public function renderException() {

    }
}