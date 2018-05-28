<?php

namespace Plugin\Hooks;

class Plugin
{
    /**
     * [$name description]
     * @var string
     */
    public $name = 'Plugin Test';

    /**
     * The plugins unique slug
     * @var string
     */
    public $slug = 'jjgrainger-plugin';

    /**
     * Plugins current version
     * @var float
     */
    public $version = 1.0;

    /**
     * Register plugin hooks
     */
    public function register()
    {
        add_filter('plugins_api', [$this, 'getInfo'], 20, 3);

        add_filter('site_transient_update_plugins', [$this, 'checkForUpdates']);
    }

    public function getInfo($result, $action, $args)
    {
        // do nothing if this is not about getting plugin information
        if ($action !== 'plugin_information') {
            return false;
        }

        // do nothing if it is not our plugin
        if ($this->slug !== $args->slug) {
            return $result;
        }

        // get from remote
        return (object) $this->details();
    }

    public function details()
    {
        return [
            'name' => 'Plugin Test',
            'slug' => $this->slug,
            'version' => '1.0',
            'tested' => '4.9.6',
            'requires' => '3.0',
            'author' => '<a href="https://jjgrainger.co.uk">jjgrainger</a>',
            'author_profile' => 'https://profiles.wordpress.org/jjgrainger',
            'download_link' => 'https://plugins.jjgrainger.co.uk/test-plugin/1.0.zip',
            'last_updated' => '2018-05-27 09:00:00',
            "sections" => [
                "description" => "This is the plugin to test your updater script",
            ],
            'banners' => [
                'low' => 'http://placehold.it/772x250/3d9ddd?text= ',
                'high' => 'http://placehold.it/1544x500/3d9ddd?text= '
            ]
        ];
    }

    public function checkForUpdates($transient)
    {
        if (empty($transient->checked)) {
            return $transient;
        }

        $res = new \stdClass();
        $res->slug = "{$this->slug}";
        $res->plugin = "{$this->slug}/{$this->slug}.php"; // it could be just YOUR_PLUGIN_SLUG.php if your plugin doesn't have its own directory
        $res->new_version = '1.1';
        $res->tested = '4.9.6';
        $res->package = 'https://plugins.jjgrainger.co.uk/test-plugin/test-plugin-1.1.zip';
        $res->url = 'https://jjgrainger.co.uk';

        $transient->response[$res->plugin] = $res;
        //$transient->checked[$res->plugin] = $remote->version;

        return $transient;
    }

    public function toJson()
    {
        return json_encode($this);
    }
}
