<?php

namespace App\Helpers;
use Modules\CMS\Entities\Share;

class ShareSession {

    public static function getShareEncoded($isProduct = 0) {
        $data = session()->get('portal.main');
        $share = Share::where('url', url()->current())->where('brand_id', $data['brand']['id'])
            ->where('country_id', $data['country_id'])->where('language_id', $data['language_id'])->first();
        if ($share !== null) {
            return 'share=' . $share->share_id;
        }
        $idFound = true;
        $share_id = '';
        while ($idFound) {
            $share_id = self::generateRandomString();
            $idFound = Share::where('share_id', $share_id)->exists();
        }
        $share = Share::create([
            'share_id' => $share_id,
            'url' => url()->current(),
            'brand_id' => $data['brand']['id'],
            'country_id' => $data['country_id'],
            'language_id' => $data['language_id'],
            'data' => base64_encode(serialize($data)),
            'is_product' => $isProduct
        ]);
        return 'share=' . $share->share_id;
    }

    static function generateRandomString() {
        $length = 12;
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
