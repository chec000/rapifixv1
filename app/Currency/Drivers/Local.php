<?php

namespace App\Currency\Drivers;

use DateTime;
use Illuminate\Support\Arr;
use Torann\Currency\Drivers\AbstractDriver;

class Local extends AbstractDriver
{
    /**
     * {@inheritdoc}
     */
    public function create(array $params)
    {
        // Get blacklist path
        $path =  base_path('currencies.json');

        // Get all as an array
        $currencies = $this->all();

        // Created at stamp
        $created = new DateTime('now');

        $currencies[$params['code']] = array_merge([
            'name' => '',
            'code' => '',
            'symbol' => '',
            'format' => '',
            'exchange_rate' => 1,
            'active' => 0,
            'created_at' => $created->format('Y-m-d H:i:s'),
            'updated_at' => $created->format('Y-m-d H:i:s'),
        ], $params);

        return file_put_contents($path, json_encode($currencies));
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        $path =  base_path('currencies.json');

        return json_decode(file_get_contents($path), true);
    }

    /**
     * {@inheritdoc}
     */
    public function find($code, $active = 1)
    {
        return Arr::get($this->all(), $code);
    }

    /**
     * {@inheritdoc}
     */
    public function update($code, array $value, DateTime $timestamp = null)
    {
        $path =  base_path('currencies.json');

        $currencies = json_decode(file_get_contents($path), true);

        // Update given code
        if (isset($currencies[$code])) {
            $currencies[$code]['exchange_rate'] = $value;
            $currencies[$code]['updated_at'] = new DateTime('now');

            return file_put_contents($path, json_encode($currencies));
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($code)
    {
        // Get blacklist path
        $path =  base_path('currencies.json');

        // Get all as an array
        $currencies = $this->all();

        if (isset($currencies[$code])) {
            unset($currencies[$code]);

            return file_put_contents($path, json_encode($currencies));
        }

        return false;
    }


}