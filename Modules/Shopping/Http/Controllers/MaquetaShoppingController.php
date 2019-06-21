<?php

namespace Modules\Shopping\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use View;

class MaquetaShoppingController extends Controller
{
  public $brand;

  public function __construct()
  {
    $this->brand = 'omnilife';
  }

  public function categories()
  {
    return View::make('shopping::frontend.categories', ['brand' => $this->brand]);
  }

  public function products()
  {
    return View::make('shopping::frontend.products', ['brand' => $this->brand]);
  }

  public function productDetail()
  {
    $categories = array();
    $selectedCategory = '';
    if ($this->brand == 'omnilife') {
      $categories[] = 'Vive Balanceado';
      $categories[] = 'Vive Activo';
      $categories[] = 'Vive Fortalecido';
      $categories[] = 'Sistemas';
      $selectedCategory = 'Vive Balanceado';
    }
    if ($this->brand == 'seytu') {
      $categories[] = 'Kenya Vergara';
      $categories[] = 'Cuidado capilar';
      $categories[] = 'Cuidado  de la piel';
      $categories[] = 'Complementos';
      $categories[] = 'Caballeros';
      $categories[] = 'Fragancias';
      $selectedCategory = 'Kenya Vergara';
    }
    return View::make('shopping::frontend.product_detail', ['brand' => $this->brand, 'categories' => $categories, 'selectedCategory' => $selectedCategory]);
  }

  public function shoppingCart()
  {
    return View::make('shopping::frontend.shopping_cart', ['brand' => $this->brand]);
  }

  public function register()
  {
    return View::make('shopping::frontend.register', ['brand' => $this->brand]);
  }

}
