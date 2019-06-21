<?php

namespace Modules\Admin\Http\Controllers\Kiosco;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Shopping\Entities\Legal;
use Modules\Admin\Http\Controllers\AdminController;

class DisclaimerController extends AdminController
{
    const KIOSCO_PURPOSE = 4;
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $legals = Legal::where(['delete' => 0])->where('purpose_id', self::KIOSCO_PURPOSE)->get();
        $this->layoutData['content'] = \View::make('admin::kiosco.disclaimer.index', compact('legals'));
    }

    /**
     * Show the form for creating a new resource.
     * @return void
     */
    public function create() {
                $title = trans('admin::shopping.legals.add.view.form-countries');
               $locale = \Auth::user()->language->locale_key;
        $countriesUser = \Auth::user()->countries;

        $this->layoutData['modals']  = \View::make('admin::kiosco.disclaimer.modals.country', compact('countriesUser', 'title'));
        $this->layoutData['content'] = \View::make('admin::kiosco.disclaimer.create', compact('locale', 'countriesUser'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     * @throws \Exception
     */
    public function store(Request $request) {
        $msg_response = trans('admin::shopping.legals.add.error.empty-params');

        try {
            \DB::beginTransaction();
            foreach (\Auth::user()->countries as $uC) {
                $active           = "active_".$uC->id;
                if ($request->$active != null) {

                    $was_saved = Legal::saveKioscoLegalsCountry($uC->id, $request);
                    if (!$was_saved) {
                        throw new \Exception('Error al guardar');
                    }
                    $msg_response = trans('admin::shopping.legals.add.error.controller-success');
                } else {
                    $msg_response = trans('admin::shopping.legals.add.error.controller-country');
                }
            }
        } catch (Exception $e) {
            \DB::rollback();
            $was_saved = false;
            $msg_response = trans('admin::shopping.legals.add.error.controller-country');
        }
        \DB::commit();

        return $was_saved ? redirect()->route('admin.kiosco.disclaimer.index')->with('msg', $msg_response)
                          : back()->withErrors(array('msg' => $msg_response));
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return void
     */
    public function edit($id) {
        $legalsByCountry = Legal::where('id',$id)->first();
        $identifier = $id;
        $this->layoutData['content'] = \View::make('admin::kiosco.disclaimer.edit', compact('legalsByCountry','identifier'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request) {
        try {
            \DB::beginTransaction();
            foreach (\Auth::user()->countries as $uC) {
                $active   = "active_".$uC->id;
                $infoLegal = Legal::where(['id' => $request->id,'country_id' => $uC->id])->first();

                if (isset($infoLegal)) {
                    Legal::where('id', $infoLegal->id)->update([ 'active' => $request->$active]);
                    foreach ($uC->languages as $countryLang) {
                        $contract    = 'contract_'.$uC->id.'_'.$countryLang->language->id;

                        if (!empty($request->$contract) ) {
                            $infoLegal->translateOrNew($countryLang->language->locale_key)->active = $active;
                            $infoLegal->translateOrNew($countryLang->language->locale_key)->contract_html = $request->$contract;
                        }
                    }
                    $infoLegal->update();
                }
            }
            \DB::commit();
            return redirect()->route('admin.kiosco.disclaimer.index')
                   ->with('msg', trans('admin::shopping.legals.edit.error.controller-success'));
        }catch(\Exception $e) {
            \DB::rollback();
            return back()->withInput()->withErrors(array('msg' => trans('admin::shopping.legals.add.error.controller-country')));
        }
        //return back()->withInput()->withErrors(array('msg' => trans('admin::shopping.legals.add.error.empty-params')));
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request) {
        $legal = Legal::where('id',$request->id)->first();
        if ($legal->id > 0) {
            $legal->last_modifier_id = \Auth::user()->id;
            $legal->active = 0;
            $legal->delete = 1;
            $legal->save();
        }

        return redirect()->route('admin.kiosco.disclaimer.index')->with('msg', trans('admin::shopping.legals.edit.error.controller-success'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @createdBy
     */
    public function changeStatus(Request $request): \Illuminate\Http\RedirectResponse
    {
        $msg_response = trans('admin::shopping.legals.add.error.empty-params');
        if ($request->has('new-status')) {
            $legal     = Legal::where('id',$request->id)->first();
            $newStatus = 0;
            if ($request->input('new-status') == 'activate') { $newStatus = 1; }

            if ($legal->id > 0) {
                $legal->last_modifier_id = \Auth::user()->id;
                $legal->active = $newStatus;
                $legal->save();
            }
            return redirect()->route('admin.kiosco.disclaimer.index')->with('msg', trans('admin::shopping.legals.edit.error.controller-success'));
        }
        return back()->withErrors($msg_response);
    }
}