<?php
/*
 * PWASimpleCreator - Template: head injection
 *
 * Called by the hook 'template:layout:head' on every Kanboard page.
 */

$baseUrl = $this->url->dir();

$manifestUrl = $this->url->href('PwaManifestController', 'manifest', ['plugin' => 'PWASimpleCreator']);
$swUrl       = $baseUrl . 'plugins/PWASimpleCreator/sw.php';
$icon192Url  = $baseUrl . 'plugins/PWASimpleCreator/Asset/icons/icon-192.png';

$themeColor = isset($pwa_theme_color) ? $pwa_theme_color : '#ffffff';
$shortName = isset($pwa_short_name) ? $pwa_short_name : 'Kanboard';
?>

<!-- PWA Simple Creator plugin -->
<link rel="manifest" href="<?= htmlspecialchars($manifestUrl, ENT_QUOTES, 'UTF-8') ?>">
<meta name="theme-color" content="<?= htmlspecialchars($themeColor, ENT_QUOTES, 'UTF-8') ?>">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="<?= htmlspecialchars($shortName, ENT_QUOTES, 'UTF-8') ?>">
<link rel="apple-touch-icon" href="<?= htmlspecialchars($icon192Url, ENT_QUOTES, 'UTF-8') ?>">
<script>
(function () {
    if (!('serviceWorker' in navigator)) return;
    window.addEventListener('load', function () {
        navigator.serviceWorker
            .register(
                <?= json_encode($swUrl, JSON_UNESCAPED_SLASHES) ?>,
                { scope: <?= json_encode($baseUrl, JSON_UNESCAPED_SLASHES) ?> }
            )
            .catch(function (err) {
                console.warn('[PWA] SW registration failed:', err.message);
            });
    });
}());
</script>
<!-- /PWA Simple Creator plugin -->
