<?php
namespace Modules\Admin\Http\Controllers;

use App\Exceptions\Kiosco\KioscoBannerException;
use Modules\Admin\Entities\Language;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\Shopping\Entities\ConfirmationBanner;
use Illuminate\Http\Request;

class KioscoController extends Controller {

    const KIOSCO_PURPOSE = 4;
    const SUCCESS_BANNER = 1;
    const WARNING_BANNER = 3;
    const   ERROR_BANNER = 2;

    public function index() {
        $kiosco_banners = ConfirmationBanner::getBannersByPurpose(self::KIOSCO_PURPOSE);
        $this->layoutData['content'] = \View::make('admin::kiosco.showBanners', compact('kiosco_banners'));
    }

    /**
     * Show the form for creating a new kiosco banner
     * @createdBy Mario Avila
     */
    public function createBanner() {
        $countriesUser = \Auth::user()->countries;

        $title    = trans('admin::shopping.confirmationbanners.add.view.form-countries');
        $locale   = \Auth::user()->language->locale_key;

        $this->layoutData['modals']  = \View::make('admin::kiosco.modals.country', compact('countriesUser', 'title'));
        $this->layoutData['content'] = \View::make('admin::kiosco.createBanner', compact('locale', 'countriesUser'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @createdBy Mario Avila
     */
    public function storeBanners(Request $request) {
        $is_process_ok = true;
        $msg_response  = trans('admin::shopping.confirmationbanners.add.error.controller-success');

        \DB::beginTransaction();
        try {
            ConfirmationBanner::saveKioscoBanner($request->get('id_country'), self::SUCCESS_BANNER, self::KIOSCO_PURPOSE, $request);
            \DB::commit();
        } catch (KioscoBannerException $exception) {
            $msg_response = $exception->getMessage();
            $is_process_ok = false;
            \DB::rollback();
        }

        return $is_process_ok ? redirect()->route('admin.kiosco.index')->with('msg', $msg_response)
                              : back()->withInput()->withErrors(array('msg' => $msg_response));
    }

    /**
     * @param $id_banner
     * @createdBy Mario Avila
     */
    public function editBanner($id_banner) {
        $banner = ConfirmationBanner::find($id_banner);
        $this->layoutData['content'] = \View::make('admin::kiosco.editBanner', array('banner' => $banner));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @createdBy Mario Avila
     */
    public function updateBanner(Request $request) {
              $locale_key = Language::getLocaleKeyById((int)$request->get('id_language'));
            $msg_response = trans('admin::shopping.confirmationbanners.add.error.controller-success');
        $banner_to_update = ConfirmationBanner::find($request->get('id_banner'))->translate($locale_key);

        $banner_to_update->image  = $request->get('image');
        $banner_to_update->active = $request->get('active');

        return $banner_to_update->save() ? redirect()->route('admin.kiosco.index')->with('msg', $msg_response)
                                         : back()->withErrors(array('msg' => trans('admin::shopping.confirmationbanners.edit.error.controller-country'))) ;
    }

    /**
     * @createdBy Mario Avila
     * @version 09/08/2018
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyBanner(Request $request) {
        ConfirmationBanner::destroy($request->get('id_banner'));
        return back();
    }

    /**
     * @createdBy Mario Avila
     * @version 09/08/2018
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatusBanner(Request $request)  {
        ConfirmationBanner::where('id', $request->get('id_banner'))->update(['active' => $request->get('new-status')]);
        return back();
    }
}