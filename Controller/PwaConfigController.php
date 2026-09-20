<?php

namespace Kanboard\Plugin\PWASimpleCreator\Controller;

use Kanboard\Controller\BaseController;

class PwaConfigController extends BaseController
{
    private function getPwaConfig()
    {
        return [
            'app_name' => $this->configModel->get('pwa_app_name', 'Kanboard'),
            'short_name' => $this->configModel->get('pwa_short_name', 'Kanboard'),
            'description' => $this->configModel->get('pwa_description', 'Kanboard PWA'),
            'theme_mode' => $this->configModel->get('pwa_theme_mode', 'light'),
            'theme_color' => $this->configModel->get('pwa_theme_color', '#ffffff'),
            'background_color' => $this->configModel->get('pwa_background_color', '#ffffff'),
            'start_uri' => $this->configModel->get('pwa_start_uri', 'board/1')
        ];
    }

    public function show()
    {
        if (! $this->userSession->isAdmin()) {
            $this->response->redirect($this->helper->url->to('DashboardController', 'show'));
        }

        $projectsList = $this->projectModel->getList();
        $startUriOptions = [
            '' => t('Dashboard (Default)'),
            'projects' => t('My Projects'),
            'tasks' => t('My Tasks'),
            'activity' => t('My Activity'),
            'custom' => t('Custom URL (type below)')
        ];

        if (!empty($projectsList)) {
            $startUriOptions['---'] = '--------------------';
            foreach ($projectsList as $id => $name) {
                $startUriOptions['board/' . $id] = t('Board') . ': ' . $name;
            }
        }

        $values = $this->getPwaConfig();
        
        // Determine which option is selected
        $selectedValue = $values['start_uri'];
        $isCustom = true;
        
        if (isset($startUriOptions[$selectedValue]) && $selectedValue !== '---') {
            $isCustom = false;
        }

        if ($isCustom && $selectedValue !== '') {
            $values['start_uri_select'] = 'custom';
            $values['start_uri_custom'] = $selectedValue;
        } else {
            $values['start_uri_select'] = $selectedValue;
            $values['start_uri_custom'] = '';
        }

        $this->response->html($this->helper->layout->config('PWASimpleCreator:config/settings', [
            'title' => t('PWA Settings'),
            'values' => $values,
            'errors' => [],
            'startUriOptions' => $startUriOptions
        ]));
    }

    public function save()
    {
        if (! $this->userSession->isAdmin()) {
            $this->response->redirect($this->helper->url->to('DashboardController', 'show'));
        }

        $values = $this->request->getValues();
        
        $mode = isset($values['theme_mode']) ? $values['theme_mode'] : 'light';
        $themeColor = isset($values['theme_color']) ? $values['theme_color'] : '#ffffff';
        $bgColor = isset($values['background_color']) ? $values['background_color'] : '#ffffff';

        if ($mode === 'light') {
            $themeColor = '#ffffff';
            $bgColor = '#ffffff';
        } elseif ($mode === 'dark') {
            $themeColor = '#333333';
            $bgColor = '#333333';
        }

        $startUri = '';
        if (isset($values['start_uri_select'])) {
            if ($values['start_uri_select'] === 'custom') {
                $startUri = isset($values['start_uri_custom']) ? $values['start_uri_custom'] : '';
            } else {
                $startUri = $values['start_uri_select'];
            }
        } elseif (isset($values['start_uri'])) {
            $startUri = $values['start_uri'];
        }

        $config = [
            'pwa_app_name' => !empty($values['app_name']) ? $values['app_name'] : 'Kanboard',
            'pwa_short_name' => !empty($values['short_name']) ? $values['short_name'] : 'Kanboard',
            'pwa_description' => !empty($values['description']) ? $values['description'] : 'Kanboard PWA',
            'pwa_theme_mode' => $mode,
            'pwa_theme_color' => $themeColor,
            'pwa_background_color' => $bgColor,
            'pwa_start_uri' => ltrim($startUri, '/')
        ];

        if ($this->configModel->save($config)) {
            $this->flash->success(t('PWA settings saved successfully.'));
        } else {
            $this->flash->failure(t('Unable to save your settings.'));
        }

        $this->response->redirect($this->helper->url->to('PwaConfigController', 'show', ['plugin' => 'PWASimpleCreator']));
    }
}
