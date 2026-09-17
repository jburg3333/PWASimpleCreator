<?php
/*
 * PWA Simple Creator - sw.php (Service Worker)
 *
 * Serves the minimal Service Worker JS with the special header
 * 'Service-Worker-Allowed' so it can control the full Kanboard
 * scope even though this file lives inside /plugins/PWASimpleCreator/.
 *
 * This SW does NOT cache anything offline.
 * It exists only to satisfy the browser's installability requirement.
 *
 * URL: <kanboard-root>/plugins/PWASimpleCreator/sw.php
 */

// Auto-detect Kanboard root path (same logic as manifest.php)
$scriptPath = $_SERVER['SCRIPT_NAME'];
$basePath   = rtrim(dirname(dirname(dirname($scriptPath))), '/') . '/';

header('Content-Type: application/javascript; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');
header('Service-Worker-Allowed: ' . $basePath);
?>
/* PWA Simple Creator - Minimal Service Worker */

self.addEventListener('install', function (e) {
    self.skipWaiting();
});

self.addEventListener('activate', function (e) {
    e.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', function (e) {
    /* Pass all requests straight to the network - no offline cache */
    e.respondWith(fetch(e.request));
});


