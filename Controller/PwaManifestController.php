<?php

namespace Kanboard\Plugin\PWASimpleCreator\Controller;

use Kanboard\Controller\BaseController;

class PwaManifestController extends BaseController
{
    public function manifest()
    {
        $appName = $this->configModel->get('pwa_app_name', 'Kanboard');
        $shortName = $this->configModel->get('pwa_short_name', 'Kanboard');
        $description = $this->configModel->get('pwa_description', 'Kanboard PWA');
        $themeColor = $this->configModel->get('pwa_theme_color', '#ffffff');
        $bgColor = $this->configModel->get('pwa_background_color', '#ffffff');
        $startUri = $this->configModel->get('pwa_start_uri', 'board/1');

        $basePath = $this->helper->url->dir();
        $pluginUrl = $this->helper->url->base() . 'plugins/PWASimpleCreator/';
        $startUrl = $basePath . ltrim($startUri, '/');

        $lang = $this->languageModel->getCurrentLanguage();
        $langCode = !empty($lang) ? substr($lang, 0, 2) : 'en';

        $manifest = [
            'name'             => $appName,
            'short_name'       => $shortName,
            'description'      => $description,
            'lang'             => $langCode,
            'start_url'        => $startUrl,
            'scope'            => $basePath,
            'display'          => 'standalone',
            'orientation'      => 'portrait-primary',
            'theme_color'      => $themeColor,
            'background_color' => $bgColor,
            'icons'            => [
                [
                    'src'     => $pluginUrl . 'Asset/icons/icon-192.png',
                    'sizes'   => '192x192',
                    'type'    => 'image/png',
                    'purpose' => 'any',
                ],
                [
                    'src'     => $pluginUrl . 'Asset/icons/icon-512.png',
                    'sizes'   => '512x512',
                    'type'    => 'image/png',
                    'purpose' => 'any maskable',
                ],
            ],
        ];

        $this->response->withHeader('Content-Type', 'application/manifest+json; charset=utf-8');
        $this->response->withHeader('Cache-Control', 'no-cache, must-revalidate');
        $this->response->withHeader('X-Content-Type-Options', 'nosniff');
        
        echo json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
