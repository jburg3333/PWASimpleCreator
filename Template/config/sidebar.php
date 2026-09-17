<li <?= $this->app->checkMenuSelection('PwaConfigController', 'show', 'PWASimpleCreator') ?>>
    <?= $this->url->link(t('PWA Settings'), 'PwaConfigController', 'show', ['plugin' => 'PWASimpleCreator']) ?>
</li>
