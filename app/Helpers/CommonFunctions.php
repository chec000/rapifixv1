<?php
/**
 * Created by PhpStorm.
 * User: vicente.gutierrez
 * Date: 18/07/18
 * Time: 09:46
 */

if (! function_exists('str_limit2')) {
    function str_limit2($value, $limit = 100, $end = '...') {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }

        $pos = strpos($value, ' ', $limit);
        if ($pos === false && strlen($value) > 0) {
            return $value;
        }

        $newValue = substr($value, 0, $pos);

        if (mb_strwidth($newValue, 'UTF-8') == 0) {
            $end = '';
        }


        return "{$newValue}{$end}";
    }
}

if (! function_exists('country_config')) {
    function country_config($countryCorbizKey=null) {
        $config = false;

        if ($countryCorbizKey != null || !empty($countryCorbizKey)) {
            $country = \Modules\Admin\Entities\Country::where('corbiz_key', $countryCorbizKey)->first();

            if ($country != null) {
                $config = [
                    'shopping_active'    => (int) $country->shopping_active == 1,
                    'inscription_active' => (int) $country->inscription_active == 1,
                    'customer_active'    => (int) $country->customer_active == 1,
                    'webservices_active' => (int) config('settings::frontend.webservices') == 1
                ];
            }
        }

        return $config;
    }
}

if (! function_exists( 'generate_random_number')) {
    function generate_random_number($len = 8, $toString = true) {
        $number = '';
        for ($i = 0; $i < $len; $i++) {
            $number .= "" . mt_rand(0, 9);
        }

        return $number;
    }
}

if (! function_exists('hide_price')) {
    function hide_price() {
        return (in_array(\App\Helpers\SessionHdl::getCorbizCountryKey(), config('shopping.hideShopping')) && !\App\Helpers\SessionHdl::hasEo());
    }
}

if (! function_exists('generate_contract_pdf')) {
    function generate_contract_pdf($countryId, $lang, $lines, $fileName, $filePath = '') {
        require('fpdf/fpdf.php');
        require('fpdi/fpdi.php');

        $country           = \Modules\Admin\Entities\Country::find($countryId);
        $finalContractPath = !empty($filePath) ? $filePath : public_path() . '/contracts/' . strtolower($country->corbiz_key);
        $legal             = \Modules\Shopping\Entities\Legal::where('country_id', $countryId)->whereTranslation('locale', $lang)->first();
        $baseContractPath  = public_path() . $legal->contract_pdf;

        # Create folder
        try {
            if (!file_exists($finalContractPath)) {
                mkdir($finalContractPath, 0777, true);
            }
        } catch (ErrorException $e) {
            \Illuminate\Support\Facades\Log::error('ERR (generate_contract_pdf): ' . $e->getMessage());
            return false;
        }

        $pdf = new fpdi();
        $pdf->setSourceFile($baseContractPath);
        $tplIdx = $pdf->importPage(1, '/MediaBox');

        $pdf->addPage();
        $pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);

        # Font
        $pdf->SetFont('Arial','',9);
        $pdf->SetTextColor(87, 35, 100);

        foreach ($lines as $line) {
            $pdf->SetXY($line['x'], $line['y']);
            $pdf->Write(1, $line['content']);
        }

        $tplIdx2 = $pdf->importPage(2, '/MediaBox');
        $pdf->addPage();
        $pdf->useTemplate($tplIdx2, 0, 0, 0, 0, true);

        # Save PDF
        try {
            $pdf->Output("{$finalContractPath}/{$fileName}",'F');
        } catch (ErrorException $e) {
            \Illuminate\Support\Facades\Log::error('ERR (generate_contract_pdf): ' . $e->getMessage());
            return false;
        }

        return [
            'publicPath' => '/contracts/' . strtolower($country->corbiz_key) .'/'. $fileName,
            'completePath' => "{$finalContractPath}/{$fileName}"
        ];
    }
}