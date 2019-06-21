<?php namespace Modules\Admin\Http\Controllers;

use Auth;
use Modules\Admin\Events\LoadResponse;
use Modules\Admin\Helpers\Routes;
use Modules\Admin\Helpers\View\AdminMenu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Request;
use Response;
use View;


class AdminController extends Controller
{
    /**
     * @var string
     */
    protected $layout;

    /**
     * @var array
     */
    protected $layoutData;

    /**
     * @var int
     */
    protected $responseCode;

    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        View::make('admin::asset_builder.main')->render();
        $this->responseCode = 200;
        $this->layout = 'admin::template.main';      
        $this->layoutData = [
            'site_name' => config('cms.site.name'),
            'title' =>ucwords(Request::segment(2)),
            'modals' => '',
            'content' => '',
            'alerts' => []
        ];
    }

    /**
     * @param string $class
     * @param string $content
     */
    public function addAlert($class, $content = '')
    {
        $alert = new \stdClass;
        $alert->class = $class;
        $alert->content = $content;
        $this->layoutData['alerts'][] = $alert;
    }

    /**
     * @return RedirectResponse
     */
    public function catchAll()
    {
        return \redirect()->route('admin.home');
    }

    /**
     * @param string $method
     * @param array $parameters
     * @return \Illuminate\Contracts\View\View
     */
    public function callAction($method, $parameters)
    {
        $altResponseContent = parent::callAction($method, $parameters);

        if (is_null($altResponseContent)) {
            $this->layoutData = array_merge([
                'system_menu' => AdminMenu::getSystemMenu(),
                'sections_menu' => Auth::admin() ? AdminMenu::getSectionsMenu() : '',
                'coaster_routes' => Routes::jsonRoutes()
            ], $this->layoutData);
        }

        event(new LoadResponse($this->layout, $this->layoutData, $altResponseContent, $this->responseCode));

        if (is_a($altResponseContent, \Symfony\Component\HttpFoundation\Response::class)) {
            return $altResponseContent;
        } else {
            $responseContent = is_null($altResponseContent) ? View::make($this->layout, $this->layoutData) : $altResponseContent;
        }

        return Response::make($responseContent, $this->responseCode);
    }
}