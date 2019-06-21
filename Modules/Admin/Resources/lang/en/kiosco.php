<?php
/**
 * Created by PhpStorm.
 * User: mario.avila
 * Date: 09/08/2018
 * Time: 04:52 PM
 */

return [
    'disclaimer' => [
        'index' => [
            'title' => 'Kiosco disclaimer',
            'form-add-button' => 'Add disclaimer',
            'thead-legals-countries' => 'Country',
            'thead-legals-activecontract' => 'Contract Active',
            'thead-legals-activedisclaimer' => 'Disclaimer Active',
            'thead-legals-activepolicies' => 'Policies Active',
            'thead-legals-active' => 'Active',
            'legal_active' => 'Active',
            'legal_inactive' => 'Inactive',
            'thead-legals-actions' => 'Actions',
            'btn_return' => 'Return',
            'disable' => 'Disable',
            'enable' => 'Enable',
            'delete' => 'Delete',
            'edit' => 'Edit',
        ],
        'add' => [
            'view' => [
                'form-countries' => 'Choose the countries where you want to add legal documents',
                'title-add' => 'Add legal documents',
                'form-country' => 'Countries selected',
                'form-save-button' => 'Save',
                'form-active' => 'Active',
                'form-error' => 'It\'s neccesary complete the required fields',
                'form-error-pdf' => 'The contract and policies must be a pdf file',
                'title-edit' => 'Edit legal document',
            ],
            'input' => [
                'contract' => 'Legal Contract',
                'contractvars' => 'Contract data',
                'disclaimer' => 'Disclaimer',
                'yes' => 'Yes',
                'no' => 'No',
                'activecontract' => 'Activate Contract',
                'activedisclaimer' => 'Active Disclaimer',
                'activepolicies' => 'Active Policies',
                'see_example' => 'preview example',
                'btn-pdf' => 'Select PDF',
                'contract-pdf' => 'Contract pdf',
                'examplecontract' => 'Example contract',
                'terms-pdf' => 'Policies and Cookies pdf',
                'instructions' => 'It\'s need it to use the following structure of the contracts for a correct creation when the contract be generated automacally after the inscritption'
            ],
            'error' => [
                'controller-success' => 'Legal document added succesfully',
                'controller-pdfextension' => 'The contract must be a PDF',
            ]
        ],
        'edit' => [
            'error' => [
                'controller-success' => 'Legal document updated successfully',
                'controller-pdfextension' => 'The contract must be a PDF',
            ]
        ],
    ],
    'banners' => [
        'index' => [
            'title' => 'Kiosco Banners',
            'form-add-button' => 'Add Kiosco banner'
        ],
    ]
];