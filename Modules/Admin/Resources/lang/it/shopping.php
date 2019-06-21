<?php

/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 16/04/2018
 * Time: 02:47 PM
 */
return [
    /*
      |--------------------------------------------------------------------------
      | Pagination Language Lines
      |--------------------------------------------------------------------------
      |
      | The following language lines are used by the paginator library to build
      | the simple pagination links. You are free to change them to anything
      | you want to customize your views to better match your application.
      |
     */

    'products' => [
        'add' => [
            'first_general_tab' => [
                'title'                     => 'Basic information',
                'form-sku-label'            => 'Product SKU',
                'form-is-kit-label'         => 'This product is a Kit for inscription',
                'select-country-label'      => 'Please select the countries in which the product will be active ',
                'select-brand-label'        => 'Please select the brands in which the product will be active ',
                'form-next-button'          => 'Next step ',
            ],
            'second_general_tab' => [
                'title'                                 => 'Country Detail information',
                'first-text'                            => 'Please enter the product information such as the price and specific points for each country.',
                'country-tab-title'                     => 'Edit information for: ',
                'country-form-price-label'              => 'Price:',
                'country-form-points-label'             => 'Points:',
                'country-form-category-label'           => 'Category:',
                'second-text'                           => 'Please enter the product information in the languages available for the country, keep in mind that if you do not fill all the fields the product information will not be seen correctly.',
                'country-language-title'                => 'Edit for language: ',
                'form-product-name-label'               => 'Product name:',
                'form-product-description-label'        => 'Product description:',
                'form-product-short-description-label'  => 'Product short description:',
                'form-product-benefits-label'           => 'Product benefits:',
                'form-product-ingredients-label'        => 'Product ingredients:',
                'form-product-image-label'              => 'Product ingredients:',
                'form-product-nutritional-info-label'   => 'Product ingredients:',
                'form-save-button'                      => 'Save',
                'form-cancell-button'                   => 'Cancell',
            ],
            'errors'=>[
                'empty-sku'                     => 'You must enter a valid sku',
                'empty-brand'                   => 'You must select the brand',
                'empty-country'                 => 'You must select at least one country',
                'empty-country-price'           => 'You must enter a valid price for the country:',
                'empty-country-points'          => 'You must enter a valid points for the country:',
                'empty-country-category'        => 'You must select at least one product category for the country',
                'empty-country-language-item'   => 'Missing information in a country field, country: $country, language: $lang',
            ],
        ]
    ],
];
