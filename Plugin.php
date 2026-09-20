<?php

/*
 * PWA Simple Creator - Plugin for Kanboard
 *
 * CONFIGURATION
 * =============
 * Configured in Kanboard Settings > PWA Settings.
 */

namespace Kanboard\Plugin\PWASimpleCreator;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use Kanboard\Core\Security\Role;

class Plugin extends Base
{
    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function initialize()
    {
        // Add public route for manifest
        $this->applicationAccessMap->add('PwaManifestController', 'manifest', Role::APP_PUBLIC);
        $this->route->addRoute('/pwa/manifest', 'PwaManifestController', 'manifest', 'PWASimpleCreator');

        // Inject PWA meta-tags into the <head> of every Kanboard page
        $this->template->hook->attachCallable('template:layout:head', 'PWASimpleCreator:pwa/head', function() {
            return [
                'pwa_theme_color' => $this->configModel->get('pwa_theme_color', '#ffffff'),
                'pwa_short_name' => $this->configModel->get('pwa_short_name', 'Kanboard'),
            ];
        });

        // Add settings sidebar menu
        $this->template->hook->attach('template:config:sidebar', 'PWASimpleCreator:config/sidebar');
    }

    public function getPluginName()
    {
        return 'PWA Simple Creator';
    }

    public function getPluginDescription()
    {
        return 'Makes Kanboard installable as a native app on Windows 11 and Android.';
    }

    public function getPluginAuthor()
    {
        return 'jburg3333';
    }

    public function getPluginVersion()
    {
        return '1.3.0';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/jburg3333/PWASimpleCreator';
    }

    public function getCompatibleVersion()
    {
        return '>=1.2.0';
    }
}
