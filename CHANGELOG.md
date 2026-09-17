# Changelog

All notable changes to the PWA Simple Creator plugin will be documented in this file.

## [1.2.0] - 2026-09-17

### Added
- **Editable Description**: Added a new field in the settings panel to customize the PWA installer description (defaults to "Kanboard PWA").

### Changed
- **Kanboard Database Integration**: Refactored the configuration storage to use Kanboard's native `ConfigModel` instead of `Data/config.json`.
- **Dynamic Manifest Controller**: Replaced the static `manifest.php` script with a native Kanboard public controller (`PwaManifestController`) for better security and performance.
- **Removed Directory Dependency**: The `Data` folder is no longer needed or included, eliminating folder permission issues (`chmod 777`) during installation.
- **Template Variables**: Switched to `attachCallable` for injecting Kanboard database settings securely into the `<head>` tag.

## [1.1.0] - 2026-09-17

### Added
- **Native Interface**: Custom configuration panel integrated directly into Kanboard's "Settings > PWA Settings".
- **Color Modes**: Theme selector with Light, Dark, and Custom color options. Custom mode dynamically displays color pickers.
- **Start URI**: You can now define a specific board or homepage to open by default when launching the App (e.g., `board/1`).
- **JSON Storage**: Preferences were saved natively and independently in `Data/config.json` to ensure an ultra-fast and secure `manifest.php`.

### Changed
- **Decoupled Configuration**: Removed the manual `Config.php` file.
- **Flexible Texts**: The short name and long app name are no longer mandatory in the form, falling back to "Kanboard" automatically if left blank.

## [1.0.0] - 2026-09-17

### Added
- **Base Plugin** (`Plugin.php`): Hook registration for `template:layout:head` to automatically inject PWA meta-tags on all Kanboard pages.
- **Centralized Configuration** (`Config.php`): PHP constants to customize the name, short name, description, colors, and icon names without touching any other files.
- **Web App Manifest** (`manifest.php`): Public PHP endpoint (without Kanboard authentication) generating the JSON manifest with automatic detection of the base URL, scheme (HTTP/HTTPS), and reverse proxy support (`X-Forwarded-Proto`).
- **Minimal Service Worker** (`sw.php`): PHP endpoint serving the SW with the `Service-Worker-Allowed` header to expand its scope to the entire Kanboard root. No offline caching: solely to meet browser installability requirements.
- **Injection Template** (`Template/pwa/head.php`): Injects `<link rel="manifest">`, `<meta name="theme-color">`, Apple tags (`apple-mobile-web-app-capable`, `apple-touch-icon`), and the Service Worker registration script into Kanboard's `<head>`.
- **Icon Support**: `Asset/icons/` folder to host 192×192 and 512×512 px icons.
- **Root/Subdirectory Compatibility**: Works whether Kanboard is installed in the root directory or a subdirectory.
- **Platform Support**: Installation support for **Windows 11** (Chrome, Edge) and **Android** (Chrome).
- **iOS / Safari Support**: Basic support via "Add to Home Screen".
- `README.md` with installation, configuration, and usage instructions.
