# Layout Configuration

These settings allow you to customize the layout, branding, and appearance of your admin panel.

The layout settings are managed in the `config/ladmin.php` file. If this file does not exist, you can publish it by running the following command in the `root` folder of your Laravel application:

```bash
php artisan vendor:publish --provider="DFSmania\LaradminLte\LaradminLteServiceProvider" --tag="config"
```

## Basic Information

The `basic` section allows you to define essential metadata for your admin panel. This information is primarily used in the footer (by default) and potentially in other components such as "About" modals or system metadata sections.

::: details Example {open}
```php
'basic' => [
    'company' => 'Acme Inc.',
    'company_url' => 'https://acme.example',
    'start_year' => 2024,
    'version' => '2.1.0',
]
```
:::

### `company`:

- Type: `string`
- Example: `'company' => 'Acme Inc.'`

The name of the company or organization that owns and develops the Laravel admin panel. Displayed in the footer or anywhere a company reference is needed.

### `company_url`:

- Type: `string (URL)`
- Example: `'company_url' => 'https://acme.example'`

The link to the company website. It is typically shown next to or below the company name. Useful for users to quickly navigate to the company's homepage from the panel UI.

### `start_year`:

- Type: `int | string`
- Example: `'start_year' => 2024`

The year your admin panel or application was launched or started development. Allows the footer to show a date range like `© 2024 - 2025 Company Name`.

### `version`:

- Type: `string`
- Example: `'version' => '2.1.0'`

The current version number of your admin panel. Displayed in the footer or a custom "About" section. It helps administrators know what version is deployed.

## Favicons

This configuration block defines how your application declares and serves favicon assets (those small icons displayed in browser tabs, bookmarks, home screen shortcuts, and other interfaces). Note that this configuration does not generate favicon files; it only helps produce the appropriate `HTML` markup to reference the favicon files you’ve already prepared.

::: details Example 1: Setup Minimal Favicon Support {open}
**Configuration:**
```php
'favicons' => [
    'full_support' => false,
    'brand_logo_color' => '#6f42c1', // Still present, but ignored
    'brand_background_color' => '#ffffff', // Ignored too
    'png_sizes' => ['16x16', '32x32', '96x96'], // Ignored too
],
```

**Generated HTML:**
```html
<!-- Standard favicon (fallback for older browsers) -->
<link rel="icon" type="image/x-icon" href="{asset_url}/favicons/favicon.ico">
```
:::

::: details Example 2: Setup Full Favicon Support
**Configuration:**
```php
'favicons' => [
    'full_support' => true,
    'brand_logo_color' => '#6f42c1',
    'brand_background_color' => '#ffffff',
    'png_sizes' => ['16x16', '32x32', '96x96'],
],
```

**Generated HTML:**
```html
<!-- Standard favicon (fallback for older browsers) -->
<link rel="icon" type="image/x-icon" href="{asset_url}/favicons/favicon.ico">

<!-- PNG icons (most modern browsers) -->
<link rel="icon" type="image/png" sizes="16x16" href="{asset_url}/favicons/favicon-16x16.png">
<link rel="icon" type="image/png" sizes="32x32" href="{asset_url}/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="{asset_url}/favicons/favicon-96x96.png">

<!-- Apple Touch Icon (iOS, Safari) -->
<link rel="apple-touch-icon" sizes="180x180" href="{asset_url}/favicons/apple-touch-icon.png">

<!-- Web App Manifest -->
<link rel="manifest" href="{asset_url}/favicons/site.webmanifest">

<!-- Safari pinned tab icon (macOS) -->
<link rel="mask-icon" href="{asset_url}/favicons/safari-pinned-tab.svg" color="#6f42c1">

<!-- Windows tiles -->
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="{asset_url}/favicons/mstile-144x144.png">

<!-- Mobile browser address bar color -->
<meta name="theme-color" content="#ffffff">
```
:::

::: info
The `{asset_url}` placeholder in the examples represents the base URL used for serving assets in your Laravel application. It corresponds to the value returned by Laravel’s `asset()` helper, which uses the `ASSET_URL` environment variable if defined, or falls back to `APP_URL` by default. All asset paths typically resolve to files stored in the **public** directory.
:::

::: warning
To ensure this configuration works correctly, all favicon files must be placed in the `public/favicons` directory (or in the `favicons` folder of the corresponding path resolved by your `ASSET_URL` setting). Additionally, make sure each file follows the expected naming convention, such as `favicon-32x32.png`, to match the declared sizes in the configuration.
:::

### `full_support`:

- Type: `bool`
- Example: `'full_support' => true`

Determines whether your application should output a full set of `<link>` and `<meta>` tags to maximize favicon and branding support across multiple platforms (iOS, Android Chrome, Windows tiles, Safari pinned tabs, etc.).

When set to `true`, the configuration will generate all recommended tags for broad compatibility, leveraging the other favicon options you configure. When set to `false`, only a minimal favicon declaration will be included:

```html
<link rel="icon" type="image/x-icon" href="{asset_url}/favicons/favicon.ico">
```

Use `true` for best cross-platform appearance, or `false` if you only need basic favicon support.

### `brand_logo_color`:

- Type: `string (any HTML color)`
- Example: `'brand_logo_color' => '#6f42c1'`

Defines the foreground color of your app's logo. Used in some environments like Android's maskable icons or Safari pinned tabs. Use a color that provides strong contrast with the background and is visually consistent with your branding.

### `brand_background_color`:

- Type: `string (any HTML color)`
- Example: `'brand_background_color' => '#ffffff'`

Specifies the background color used in various contexts, including:

- Windows 10 live tiles (`msapplication-TileColor`)
- Android Chrome theme color (`theme-color`)
- iOS launch screen backgrounds

Choose a color that complements your logo and maintains readability.

### `png_sizes`:

- Type: `array<string>`
- Example: `'png_sizes' => ['16x16', '32x32', '96x96']`

An array listing the favicon image sizes (in pixels) that you have included in the `favicons` directory. These will be automatically referenced in the markup like:

```html
<link rel="icon" type="image/png" sizes="32x32" href="{asset_url}/favicons/favicon-32x32.png">
```

These sizes ensure compatibility with various browser requirements.
