# Layout Configuration

These settings allow you to customize the layout, branding, and appearance of your admin panel.

The layout settings are managed in the `config/ladmin.php` file. If this file does not exist, you can publish it by running the following command in the `root` folder of your Laravel application:

```bash
php artisan vendor:publish --provider="DFSmania\LaradminLte\LaradminLteServiceProvider" --tag="config"
```

## Basic Information

The `basic` section allows you to define essential metadata for your admin panel. This information is primarily used in the footer (by default) and potentially in other components such as "About" modals or system metadata sections.

::: details Quick Example {open}
```php
'basic' => [
    'company' => 'Acme Inc.',
    'company_url' => 'https://acme.example',
    'start_year' => 2024,
    'version' => '2.1.0',
]
```
:::

### *company*:

- Type: `string`
- Example: `'company' => 'Acme Inc.'`

The name of the company or organization that owns and develops the Laravel admin panel. Displayed in the footer or anywhere a company reference is needed.

### *company_url*:

- Type: `string (URL)`
- Example: `'company_url' => 'https://acme.example'`

The link to the company website. It is typically shown next to or below the company name. Useful for users to quickly navigate to the company's homepage from the panel UI.

### *start_year*:

- Type: `int | string`
- Example: `'start_year' => 2024`

The year your admin panel or application was launched or started development. Allows the footer to show a date range like `© 2024 - 2025 Company Name`.

### *version*:

- Type: `string`
- Example: `'version' => '2.1.0'`

The current version number of your admin panel. Displayed in the footer or a custom "About" section. It helps administrators know what version is deployed.

## Favicons

This configuration block defines how your application declares and serves favicon assets (those small icons displayed in browser tabs, bookmarks, home screen shortcuts, and other interfaces). Note that this configuration does not generate favicon files; it only helps produce the appropriate `HTML` markup to reference the favicon files you’ve already prepared.

::: details Example 1: Setup Minimal Favicon Support {open}
::: code-group

```php [Favicons Config]
'favicons' => [
    'full_support' => false,
    'brand_logo_color' => '#6f42c1', // Still present, but ignored
    'brand_background_color' => '#ffffff', // Ignored too
    'png_sizes' => ['16x16', '32x32', '96x96'], // Ignored too
],
```

```html [Generated HTML]
<!-- Standard favicon (fallback for older browsers) -->
<link rel="icon" type="image/x-icon" href="{asset_url}/favicons/favicon.ico">
```
:::

::: details Example 2: Setup Full Favicon Support
::: code-group

```php [Favivons Config]
'favicons' => [
    'full_support' => true,
    'brand_logo_color' => '#6f42c1',
    'brand_background_color' => '#ffffff',
    'png_sizes' => ['16x16', '32x32', '96x96'],
],
```

```html [Generated HTML]
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

::: info INFO: About `{asset_url}` Placeholder
The `{asset_url}` placeholder in the examples represents the base URL used for serving assets in your Laravel application. It corresponds to the value returned by Laravel’s `asset()` helper, which uses the `ASSET_URL` environment variable if defined, or falls back to `APP_URL` by default. All asset paths typically resolve to files stored in the **public** directory.
:::

::: warning WARNING: Favicons Storing Folder
To ensure this configuration works correctly, all favicon files must be placed in the `public/favicons` directory (or in the `favicons` folder of the corresponding path resolved by your `ASSET_URL` setting). Additionally, make sure each file follows the expected naming convention, such as `favicon-32x32.png`, to match the declared sizes in the configuration.
:::

### *full_support*:

- Type: `bool`
- Example: `'full_support' => true`

Determines whether your application should output a full set of `<link>` and `<meta>` tags to maximize favicon and branding support across multiple platforms (iOS, Android Chrome, Windows tiles, Safari pinned tabs, etc.).

When set to `true`, the configuration will generate all recommended tags for broad compatibility, leveraging the other favicon options you configure. When set to `false`, only a minimal favicon declaration will be included:

```html
<link rel="icon" type="image/x-icon" href="{asset_url}/favicons/favicon.ico">
```

Use `true` for best cross-platform appearance, or `false` if you only need basic favicon support.

### *brand_logo_color*:

- Type: `string (any HTML color)`
- Example: `'brand_logo_color' => '#6f42c1'`

Defines the foreground color of your app's logo. Used in some environments like Android's maskable icons or Safari pinned tabs. Use a color that provides strong contrast with the background and is visually consistent with your branding.

### *brand_background_color*:

- Type: `string (any HTML color)`
- Example: `'brand_background_color' => '#ffffff'`

Specifies the background color used in various contexts, including:

- Windows 10 live tiles (`msapplication-TileColor`)
- Android Chrome theme color (`theme-color`)
- iOS launch screen backgrounds

Choose a color that complements your logo and maintains readability.

### *png_sizes*:

- Type: `array<string>`
- Example: `'png_sizes' => ['16x16', '32x32', '96x96']`

An array listing the favicon image sizes (in pixels) that you have included in the `favicons` directory. These will be automatically referenced in the markup like:

```html
<link rel="icon" type="image/png" sizes="32x32" href="{asset_url}/favicons/favicon-32x32.png">
```

These sizes ensure compatibility with various browser requirements.

::: tip TIP: Favicons Generator Tools
To easily generate a complete set of favicon files from your brand logo, use online tools such as [favicon.io](https://favicon.io/) or [RealFaviconGenerator](https://realfavicongenerator.net/). These services create all the recommended favicon formats and sizes for modern browsers and platforms. After generating the files, download and place them in your `public/favicons` directory as described above.
:::

## Brand Logo

The `logo` section allows you to configure the brand logo displayed in the admin panel. The logo appears in the top-left corner of the layout and helps visually identify your panel or application.

::: details Quick Example {open}
```php
'logo' => [
    'image' => 'vendor/ladmin/img/LaradminLTE.png',
    'image_alt' => 'LaradminLTE Logo',
    'image_classes' => ['rounded-circle', 'shadow'],
    'text' => 'LaradminLTE',
    'text_classes' => ['fw-bold'],
]
```
:::

### *image*:

- Type: `string (path | URL)`
- Example: `'image' => 'vendor/ladmin/img/LaradminLTE.png'`

The path or URL to the logo image file. You can use a relative path (from the `public/` directory) or an absolute URL. This image is used as the main brand icon in the admin panel header.

### *image_alt*:

- Type: `string`
- Example: `'image_alt' => 'LaradminLTE Logo'`

Alternative text for the logo image, which improves accessibility and SEO (*Search Engine Optimization*). It's displayed when the image cannot be loaded and is also used by screen readers.

### *image_classes*:

- Type: `array<string>`
- Example: `'image_classes' => ['rounded-circle', 'shadow']`

An array of `CSS` utility classes (e.g., from `Bootstrap` or custom styles) that are applied to the logo image element. These allow you to visually style the image with effects such as borders, shadows, or rounded corners.

### *text*:

- Type: `string`
- Example: `'text' => 'LaradminLTE'`

The textual portion of the brand logo, displayed next to the image. This is helpful for adding your application name or a short label to the header.

### *text_classes*:

- Type: `array<string>`
- Example: `'text_classes' => ['fw-bold']`

An array of `CSS` utility classes applied to the logo text. This lets you control its typography and visual presentation, such as font weight, color, spacing, etc.

## Layout

The `layout` section lets you customize the overall structure and appearance of your admin panel. These options affect the positioning of interface components like the `header`, `sidebar`, and `footer`, and support both light and dark themes.

::: details Quick Example {open}
```php
'layout' => [
    'bootstrap_theme' => 'light',
    'fixed_footer' => false,
    'fixed_navbar' => true,
    'fixed_sidebar' => true,
    'rtl' => false,
]
```
:::

### *bootstrap_theme*:

- Type: `string ('light' | 'dark')`
- Example: `'bootstrap_theme' => 'light'`

Defines the visual theme used by `Bootstrap` across the panel. Choose between `'light'` for a bright interface or `'dark'` for a darker appearance, depending on your brand or user preference.

### *fixed_footer*:

- Type: `bool`
- Example: `'fixed_footer' => false`

Controls whether the footer stays fixed at the bottom of the viewport as the user scrolls. Useful for keeping persistent actions or status indicators visible.

### *fixed_navbar*:

- Type: `bool`
- Example: `'fixed_navbar' => true`

Determines if the top navigation bar remains fixed at the top while scrolling. This helps maintain access to navigation or user actions at all times.

### *fixed_sidebar*:

- Type: `bool`
- Example: `'fixed_sidebar' => true`

Enables a fixed sidebar that stays in place while the main content scrolls. A fixed sidebar is useful for dashboards or admin panels with extensive navigation.

### *rtl*:

- Type: `bool`
- Example: `'rtl' => false`

Enables support for `right-to-left` (RTL) layouts. Useful for languages like *Arabic*, *Hebrew*, or *Persian*. When set to `true`, the layout direction is reversed to suit RTL writing systems.

## Navbar

The `navbar` section allows you to customize the appearance of the top navigation bar in your admin panel. You can use this to control its styling using `Bootstrap` utility classes or your own custom classes.

::: details Quick Example {open}
```php
'navbar' => [
    'classes' => ['bg-body'],
]
```
:::

### *classes*:

- Type: `array<string>`
- Example: `'classes' => ['bg-body']`

An array of `CSS` classes applied to the `<nav>` element of the top navbar. These classes typically define background color, text color, borders, spacing, or other visual properties. For example, you might use `bg-primary-subtle` and `navbar-light` to get a light blue navbar.

::: tip TIP: Try AdminLTE v4 Theme Tool
You can experiment with different navbar styles using the [AdminLTE v4 Theme Tool](https://adminlte-v4.netlify.app/dist/pages/generate/theme). This interactive tool lets you preview and select `Bootstrap` classes for your navbar, making it easy to customize the appearance before applying the classes to your configuration.
:::

## Sidebar

The `sidebar` section provides full control over the behavior and appearance of the sidebar navigation in your admin panel. You can configure visual styles, layout responsiveness, collapsibility, and interactive features like accordion menus and mini-sidebar mode.

::: details Quick Example {open}
```php
'sidebar' => [
    'accordion' => false,
    'bootstrap_theme' => 'dark',
    'classes' => ['bg-body-secondary', 'shadow'],
    'default_collapsed' => false,
    'expand_breakpoint' => 'lg',
    'mini_sidebar' => true,
    'treeview_animation_speed' => 300,
]
```
:::

### *accordion*:

- Type: `bool`
- Example: `'accordion' => false`

When enabled (`true`), opening one sidebar submenu will automatically collapse any other open submenus. Useful for reducing clutter in navigation-heavy panels.

### *bootstrap_theme*:

- Type: `string ('light' | 'dark') | null`
- Example: `'bootstrap_theme' => 'dark'`

Sets the visual theme of the sidebar independently from the global layout. Use `'light'` or `'dark'` to apply a specific `Bootstrap` theme, or `null` to inherit from the layout’s theme setting.

### *classes*:

- Type: `array<string>`
- Example: `'classes' => ['bg-body-secondary', 'shadow']`

An array of `CSS` classes applied to the sidebar container. These control visual styling such as background color and shadows using `Bootstrap` utility classes or custom styles.

::: tip TIP: Try AdminLTE v4 Theme Tool
You can experiment with different sidebar styles using the [AdminLTE v4 Theme Tool](https://adminlte-v4.netlify.app/dist/pages/generate/theme). This interactive tool lets you preview and select `Bootstrap` classes for your sidebar, making it easy to customize the appearance before applying the classes to your configuration.
:::

### *default_collapsed*:

- Type: `bool`
- Example: `'default_collapsed' => false`

If set to `true`, the sidebar will be collapsed by default when the page loads. This is useful for saving screen space, especially on smaller devices or in minimalist UIs.

### *expand_breakpoint*:

- Type: `string ('sm' | 'md' | 'lg' | 'xl' | 'xxl')`
- Example: `'expand_breakpoint' => 'lg'`

Determines the `Bootstrap` breakpoint at which the sidebar automatically expands or collapses. Below the specified size, the sidebar may be hidden or minimized for responsive behavior.

### *mini_sidebar*:

- Type: `bool`
- Example: `'mini_sidebar' => true`

Enables a compact **"mini sidebar"** mode when the sidebar is manually collapsed. Instead of hiding completely, the sidebar shrinks to show only icons — a useful feature for experienced users familiar with the menu structure.

### *treeview_animation_speed*:

- Type: `int (> 0)`
- Example: `'treeview_animation_speed' => 300`

Specifies the duration (in milliseconds) of the expand/collapse animation for sidebar **treeview menus**. Adjust this value to control how quickly submenu items appear or disappear when toggling treeview sections. Higher values result in slower, smoother transitions, while lower values make the animation faster.

## Footer

The `footer` section allows you to customize the appearance of the bottom footer in your admin panel. This typically includes background styling, shadows, or spacing using `Bootstrap` utility classes.

::: details Quick Example {open}
```php
'footer' => [
    'classes' => ['bg-body'],
]
```
:::

### *classes*:

- Type: `array<string>`
- Example: `'classes' => ['bg-body']`

An array of `CSS` classes applied to the `<footer>` element. You can use `Bootstrap` utility classes or custom styles to define background color, borders, or other visual features of the footer.

::: tip TIP: Try AdminLTE v4 Theme Tool
You can experiment with different footer styles using the [AdminLTE v4 Theme Tool](https://adminlte-v4.netlify.app/dist/pages/generate/theme). This interactive tool lets you preview and select `Bootstrap` classes for your footer, making it easy to customize the appearance before applying the classes to your configuration.
:::

## Main Content

The `main_content` section controls the styling of the central content area where most pages, widgets, and dashboards are rendered.

::: details Quick Example {open}
```php
'main_content' => [
    'classes' => ['bg-body-tertiary'],
]
```
:::

### *classes*:

- Type: `array<string>`
- Example: `'classes' => ['bg-body-tertiary']`

A list of `CSS` classes applied to the main content container. These classes affect the background color and general styling of the page body. Useful for aligning your content area with your overall design theme.
