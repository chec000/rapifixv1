<?php

namespace Modules\Admin\Http\Controllers;

use App\Helpers\RestWrapper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Modules\Admin\Entities\ACL\User;
use Modules\Admin\Entities\Country;
use Modules\Admin\Entities\DistributorsPool;
use Modules\Admin\Http\Controllers\AdminController as Controller;

use Modules\Admin\Http\Requests\SaveDistributorInPoolRequest;
use View;
use Auth;
use Validator;

class DistributorsPoolController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $pool = DistributorsPool::whereIn('country_id', User::userCountriesPermission())->get();

        $this->layoutData['modals']  = View::make('admin::shopping.pool.modals.confirm').View::make('admin::shopping.pool.modals.load_csv', ['countries' => Auth::user()->countries]);
        $this->layoutData['content'] = View::make('admin::shopping.pool.index', compact('pool'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function add() {
        $countries = Auth::user()->countries;

        $this->layoutData['content'] = View::make('admin::shopping.pool.add', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  SaveDistributorInPoolRequest $request
     * @return Response
     */
    public function save(SaveDistributorInPoolRequest $request) {
        $input       = $request->all();

        $distributor = new DistributorsPool();
        $distributor->country_id        = $input['country'];
        $distributor->distributor_code  = $input['code'];
        $distributor->distributor_name  = $input['name'];
        $distributor->distributor_email = $input['email'];
        $distributor->used              = 0;
        $distributor->last_modifier_id  = Auth::user()->id;

        DB::transaction(function () use ($distributor) {
            $distributor->save();
        });

        $request->session()->flash('success', trans('admin::distributorsPool.add.success_save'));

        return redirect()->route('admin.pool.index');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($code, $country) {
        $distributor = DistributorsPool::where('distributor_code', $code)->where('country_id', $country)->firstOrFail();
        $countries   = Auth::user()->countries;

        $this->layoutData['content'] = View::make('admin::shopping.pool.edit', compact('distributor', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     * @param  SaveDistributorInPoolRequest $request
     * @return Response
     */
    public function update(SaveDistributorInPoolRequest $request, $code, $country) {
        $input    = $request->all();
        $hasError = false;

        DB::transaction(function () use ($code, $input, $country, &$hasError) {
            try {
                DistributorsPool::where('distributor_code', $code)
                    ->where('country_id', $country)
                    ->update([
                        'distributor_code'  => $input['code'],
                        'distributor_name'  => $input['name'],
                        'distributor_email' => $input['email'],
                        'last_modifier_id'  => Auth::user()->id,
                    ]);
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->errorInfo[1] == 1062) {
                    $hasError = true;

                }
            }
        });

        if ($hasError) {
            $request->session()->flash('error', [trans('admin::distributorsPool.validation.code_uniq'),]);
            return redirect()->route('admin.pool.edit', [$code, $country]);
        } else {
            $request->session()->flash('success', trans('admin::distributorsPool.add.success_update'));
            return redirect()->route('admin.pool.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function delete(Request $request, $code, $country) {
        DB::transaction(function () use ($code, $country) {
            DistributorsPool::where('distributor_code', $code)->where('country_id', $country)->delete();
        });

        $request->session()->flash('success', trans('admin::distributorsPool.add.success_delete'));

        return redirect()->route('admin.pool.index');
    }

    public function uploadFile(Request $request) {
        $response = ['status' => false];

        $rules = [
            'country'  => 'required',
            'file_csv' => 'required',
        ];
        $messages = [
            'country.required'  => trans('admin::distributorsPool.validation.country'),
            'file_csv.required' => trans('admin::distributorsPool.validation.file'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $field) {
                foreach ($field as $i => $error) {
                    $response['errors'][] = $error;
                }
            }
        } else {
            $csvContent         = $this->readCSV($request->file('file_csv')->path());
            $response['data']   = $this->saveAllPool($request->input('country'), $csvContent);
            $response['status'] = true;
        }

        return $response;
    }

    public function validateSponsor(Request $request) {
        $response = [];

        if ($request->has('code') && $request->has('country')) {
            $sponsor    = $request->input('code');
            $countryKey = $request->input('country');

            if (empty($countryKey)) {
                $response = [
                    'status'   => false,
                    'data'     => [],
                    'messages' => [trans('admin::distributorsPool.validation.country_2'),],
                ];
            } else {
                if (is_numeric($countryKey)) {
                    $country = Country::find($countryKey);
                } else {
                    $country = Country::where('corbiz_key', $countryKey)->first();
                }

                $response = $this->validateSponsorFromCorbiz($country->webservice, $country->corbiz_key, $sponsor, Session::get('adminLocaleCorbiz'));
            }
        }

        return json_encode($response);
    }

    private function readCSV($file, $header = true) {
        ini_set('auto_detect_line_endings', true);

        $csv    = [];
        $handle = fopen($file, 'r');

        while ($line = fgetcsv($handle, 500, ",")) {
            if ($header) {
                $header = false;
            } else {
                $csv[] = [
                    'code'  => !empty($line[0]) ? $line[0] : null,
                    'name'  => !empty($line[1]) ? $line[1] : null,
                    'email' => !empty($line[2]) ? $line[2] : null,
                ];
            }
        }
        ini_set('auto_detect_line_endings', false);

        return $csv;
    }

    private function isAdmirableCustomer($param) {
        return (!empty($param) && strlen($param) > 1 && strtoupper($param[0]) == 'C');
    }

    private function saveAllPool($countryId, $csvContent) {
        $results = [];

        if (sizeof($csvContent) > 0) {
            DB::transaction(function () use ($countryId) {
                DistributorsPool::where('country_id', $countryId)->delete();
            });

            $country = Country::find($countryId);

            foreach ($csvContent as $i => $distributor) {
                if (!empty($distributor['code']) && !empty($distributor['name']) && !empty($distributor['email'])) {

                    if (!$this->isAdmirableCustomer($distributor['code'])) {

                        DB::transaction(function () use ($countryId, $distributor, $i, &$results, $country) {
                            try {
                                if (strlen($distributor['name']) > 200 || strlen($distributor['email']) > 200) {
                                    $results[$i] = ['line' => $i+1, 'message' => trans('admin::distributorsPool.validation.limit_chars'), 'class' => 'danger'];
                                } else {

                                    $response = $this->validateSponsorFromCorbiz($country->webservice, $country->corbiz_key, $distributor['code'], Session::get('adminLocaleCorbiz'));
                                    if ($response['status']) {
                                        $distributor = DistributorsPool::create([
                                            'country_id'        => $countryId,
                                            'distributor_code'  => $distributor['code'],
                                            'distributor_name'  => $distributor['name'],
                                            'distributor_email' => $distributor['email'],
                                            'used'              => 0,
                                            'last_modifier_id'  => Auth::user()->id,
                                        ]);
                                    } else {
                                        $results[$i] = ['line' => $i+1, 'message' => trans('admin::distributorsPool.validation.code_valid'), 'class' => 'danger'];
                                    }
                                }
                            } catch (\Illuminate\Database\QueryException $e) {
                                if ($e->errorInfo[1] == 1062) {
                                    $results[$i] = ['line' => $i+1, 'message' => trans('admin::distributorsPool.validation.code_uniq'), 'class' => 'danger'];
                                }
                            }
                        });

                        if (!isset($results[$i])) {
                            $results[$i] = ['line' => $i+1, 'message' => trans('admin::distributorsPool.add.success_save'), 'class' => 'success'];
                        }
                    } else {
                        $results[$i] = ['line' => $i+1, 'message' => trans('admin::distributorsPool.validation.client_adm'), 'class' => 'danger'];
                    }
                } else {
                    $results[$i] = ['line' => $i+1, 'message' => trans('admin::distributorsPool.validation.incomplete'), 'class' => 'danger'];
                }
            }
        }

        return $results;
    }

    private function validateSponsorFromCorbiz($ws, $countryKey, $sponsor, $lang) {
        $response    = ['status' => false, 'data' => [], 'messages' => []];
        $restWrapper = new RestWrapper("{$ws}validateSponsor?CountryKey={$countryKey}&Lang={$lang}&SponsorId={$sponsor}");
        $responseWS  = $restWrapper->call('GET', [], 'json', ['http_errors' => false]);

        if ($responseWS['success'] == true && isset($responseWS['responseWS']['response']['Sponsor']['dsSponsor']['ttSponsor'])) {
            $response['status'] = true;
            $response['data']   = [
                'dist_id' => trim($responseWS['responseWS']['response']['Sponsor']['dsSponsor']['ttSponsor'][0]['dist_id']),
                'name_1'  => trim($responseWS['responseWS']['response']['Sponsor']['dsSponsor']['ttSponsor'][0]['name1']),
                'name_2'  => trim($responseWS['responseWS']['response']['Sponsor']['dsSponsor']['ttSponsor'][0]['name2']),
                'email'   => trim($responseWS['responseWS']['response']['Sponsor']['dsSponsor']['ttSponsor'][0]['email']),
            ];
        } else {
            if (isset($responseWS['responseWS']['response']['Error']['dsError']['ttError'])) {
                $response['messages'] = [
                    trim($responseWS['responseWS']['response']['Error']['dsError']['ttError'][0]['messUser']),
                    '<i>'.trim($responseWS['responseWS']['response']['Error']['dsError']['ttError'][0]['messTech']).'</i>'
                ];
            } else {
                if (isset($responseWS['message'])) {
                    $response['messages'] = [$responseWS['message']];
                } else {
                    $response['messages'] = [trans('cms::cedis.errors.404')];
                }
            }
        }

        return $response;
    }
}
