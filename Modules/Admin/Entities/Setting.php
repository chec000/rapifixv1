<?php namespace Modules\Admin\Entities;

use Cache;
use Config;
use DB;
use Eloquent;
use File;
use \GuzzleHttp\Client;

Class Setting extends Eloquent
{
    protected $table = 'glob_settings';
    public static $settings = array();
    protected $fillable = ['name', 'value', 'label', 'hidden', 'editable', 'active'];
public $timestamps = true;
    private static $_blogConn;

    public static function loadAll($configFolder = null, $namespace, $db = true)
    {
        if($configFolder){
            $files = File::files($configFolder);

            foreach ($files as $file) {
                $config = File::getRequire($file);
                Config::set($namespace . '::' . pathinfo($file, PATHINFO_FILENAME), $config);
            }
        }

        if ($db) {
            $settings = self::all();
            foreach ($settings as $setting) {
                if ($setting->value != '' || strpos($setting->name, 'key') !== 0) {
                    Config::set($namespace . '::' . $setting->name, $setting->value);
                }
            }
        }

    }

    /**
     * Latest tag (version)
     * @return string
     */
    public static function latestTag()
    {
      if (!Cache::has('admin::site.version')) {
          try {
              $gitHub = new Client(
                  [
                      'base_uri' => 'https://api.github.com/repos/'
                  ]
              );
              $latestRelease = json_decode($gitHub->request('GET', 'Web-Feet/coasterframework/releases/latest')->getBody());
              Cache::put('admin::site.version', $latestRelease->tag_name, 30);
          } catch (\Exception $e) {
              return 'not-found';
          }
      }
      return Cache::get('admin::site.version');
    }

    public static function blogConnection()
    {
        if (!isset(self::$_blogConn)) {
            if (config('cms.blog.connection')) {
                self::$_blogConn = new \PDO(config('cms.blog.connection'), config('cms.blog.username'), config('cms.blog.password'));
            } else {
                self::$_blogConn = DB::connection()->getPdo();
            }
        }
        return self::$_blogConn;
    }

}
