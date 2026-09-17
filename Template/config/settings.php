<div class="page-header">
    <h2><?= t('PWA Settings (Progressive Web App)') ?></h2>
</div>

<form method="post" action="<?= $this->url->href('PwaConfigController', 'save', ['plugin' => 'PWASimpleCreator']) ?>" autocomplete="off">
    <?= $this->form->csrf() ?>

    <fieldset>
        <legend><?= t('Application Texts') ?></legend>
        
        <?= $this->form->label(t('App Name (e.g. Kanboard Company)'), 'app_name') ?>
        <?= $this->form->text('app_name', $values, $errors) ?>
        <p class="form-help"><?= t('Shown on the loading screen, app manager and install banner. Defaults to "Kanboard" if empty.') ?></p>

        <?= $this->form->label(t('Short Name (e.g. Kanboard)'), 'short_name') ?>
        <?= $this->form->text('short_name', $values, $errors, ['maxlength="15"']) ?>
        <p class="form-help"><?= t('Shown below the icon on the Desktop and home screen. Max 15 characters. Defaults to "Kanboard" if empty.') ?></p>
        
        <?= $this->form->label(t('Description'), 'description') ?>
        <?= $this->form->text('description', $values, $errors) ?>
        <p class="form-help"><?= t('Description for the installer. Defaults to "Kanboard PWA" if empty.') ?></p>
    </fieldset>

    <fieldset>
        <legend><?= t('Colors and Theme') ?></legend>

        <?= $this->form->label(t('Color Mode'), 'theme_mode') ?>
        <?= $this->form->radios('theme_mode', [
            'light' => t('Light Mode (White)'),
            'dark' => t('Dark Mode (Dark gray)'),
            'custom' => t('Custom Color')
        ], $values) ?>

        <div id="custom-color-container" style="display: <?= ($values['theme_mode'] ?? 'light') === 'custom' ? 'block' : 'none' ?>; margin-top: 15px; padding-left: 15px; border-left: 2px solid #ccc;">
            <?= $this->form->label(t('Title bar color (Theme Color)'), 'theme_color') ?>
            <input type="color" name="theme_color" id="theme_color" value="<?= htmlspecialchars($values['theme_color'] ?? '#ffffff', ENT_QUOTES, 'UTF-8') ?>" style="display: block; margin-bottom: 10px; width: 60px; height: 35px; cursor: pointer;">
            <p class="form-help"><?= t('Sets the color of the app window\'s top bar. (e.g. Classic Kanboard blue: #2f6291)') ?></p>

            <?= $this->form->label(t('Startup background color (Background Color)'), 'background_color') ?>
            <input type="color" name="background_color" id="background_color" value="<?= htmlspecialchars($values['background_color'] ?? '#ffffff', ENT_QUOTES, 'UTF-8') ?>" style="display: block; margin-bottom: 10px; width: 60px; height: 35px; cursor: pointer;">
            <p class="form-help"><?= t('The color that fills the screen while the PWA is loading.') ?></p>
        </div>
    </fieldset>

    <script>
        document.querySelectorAll('input[name="theme_mode"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                var container = document.getElementById('custom-color-container');
                if (this.value === 'custom') {
                    container.style.display = 'block';
                } else {
                    container.style.display = 'none';
                }
            });
        });
    </script>

    <fieldset>
        <legend><?= t('Start Path (Optional)') ?></legend>

        <?= $this->form->label(t('Start URI (e.g. board/1)'), 'start_uri') ?>
        <?= $this->form->text('start_uri', $values, $errors) ?>
        <p class="form-help"><?= t('Relative path to open when launching the app. Leave empty to go to the Dashboard.') ?></p>
    </fieldset>

    <div class="form-actions">
        <button type="submit" class="btn btn-blue"><?= t('Save Settings') ?></button>
    </div>
</form>

<div class="alert alert-info">
    <strong><?= t('Important!') ?></strong> <?= e('PWA icons must be replaced manually via FTP at: %s (keeping the names %s and %s).', '<code>plugins/PWASimpleCreator/Asset/icons/</code>', '<code>icon-192.png</code>', '<code>icon-512.png</code>') ?>
</div>
