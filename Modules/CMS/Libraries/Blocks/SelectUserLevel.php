<?php namespace Modules\CMS\Libraries\Blocks;

use Modules\Admin\Entities\Language;
use Modules\Admin\Entities\Country;
use Modules\CMS\Entities\Page;
use Modules\CMS\Entities\BlockSelectOption;
use App\Helpers\RestWrapper;

class SelectUserLevel extends String_
{
    /**
     * @var array
     */
    public static $blockSettings = ['Manage block select options' => 'themes/selects'];

    /**
     * Add return all option to the data function
     * @param string $content
     * @param array $options
     * @return array|string
     */
    public function data($content, $options = [])
    {
        if (isset($options['returnAll']) && $options['returnAll']) {
            return BlockSelectOption::getOptionsArray($this->_block->id);
        }
        return parent::data($content);
    }

    /**
     * Display select options
     * @param string $content
     * @return string
     */
    public function edit($content)
    {
        $selectOptions = ['-' => trans('admin::blocks.selectuserlevel.default_option')];

        if (config('settings::frontend.webservices')) {
            $page = Page::find($this->_block->getPageId());
            $country = Country::find($page->country_id);
            $url = $country->webservice;
            $corbizCountryKey = $country->corbiz_key;
            $corbizLangKey = Language::currentCorbiz();
            $restWrapper = new RestWrapper($url.'getCarrerTitle?CountryKey='.$corbizCountryKey.'&Lang='.$corbizLangKey);
            $resultCarrerTitle = $restWrapper->call('GET', [], 'json', ['http_errors' => false]);
            if ($resultCarrerTitle['success'] && isset($resultCarrerTitle['responseWS']['response']['Title']['dsTitle']['ttTitulo'])) {
                $options = $resultCarrerTitle['responseWS']['response']['Title']['dsTitle']['ttTitulo'];
                foreach ($options as $option) {
                    $selectOptions[$option['clavetitulo']] = $option['descripcion']." (".$option['abrevtitulo'].")";
                }
            } else if (isset($resultCarrerTitle['responseWS']['response']['Error']['dsError']['ttError'])) {
                $this->_editViewData['errorWebService'] = $resultCarrerTitle['responseWS']['response']['Error']['dsError']['ttError'][0]['messUser'];
                $this->_editViewData['errorWebService'] .= '<br>';
                $this->_editViewData['errorWebService'] .= '<i>'.$resultCarrerTitle['responseWS']['response']['Error']['dsError']['ttError'][0]['messTech'].'</i>';
            } else {
                $this->_editViewData['errorWebService'] = $resultCarrerTitle['message'];
            }
        }

        $this->_editViewData['selectOptions'] = $selectOptions;
        return parent::edit($content);
    }

    /**
     * Save select option
     * @param array $postContent
     * @return static
     */
    public function submit($postContent)
    {
        return $this->save(isset($postContent['select']) ? $postContent['select'] : '');
    }

}
