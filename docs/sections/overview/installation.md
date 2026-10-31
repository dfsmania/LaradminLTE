# Package Resources & Installation

LaradminLTE provides the `ladmin:install` Artisan command to install, publish, and update the package resources in your Laravel application.

This guide describes the available resources, installation options, and recommended procedures for updating previously published files.

For a quick initial setup, see the [Getting Started](./getting-started.md) guide.

## Available Resources

LaradminLTE provides next publishable resources, divided into **required** and **optional** resources.

| Resource        | Key            | Type         | Destination            |
|-----------------|----------------|--------------|------------------------|
| AdminLTE Assets | `assets`       | **Required** | `public/vendor/ladmin` |
| Configuration   | `config`       | **Required** | `config/ladmin`        |
| Translations    | `translations` | Optional     | `lang/vendor/ladmin`   |
| Migrations      | `migrations`   | Optional     | `database/migrations`  |

### Assets

The `assets` resource publishes the AdminLTE v4 distribution files, including CSS, JavaScript, and images.

These files are required to render the admin panel correctly.

```bash
php artisan ladmin:install --resource=assets
```

**Destination:** `public/vendor/ladmin`

### Configuration

The `config` resource publishes the LaradminLTE configuration files.

These files allow you to customize the admin panel's appearance, navigation menus, authentication scaffolding, and plugins.

```bash
php artisan ladmin:install --resource=config
```

**Destination:** `config/ladmin`

### Translations

The `translations` resource publishes the package translation files, allowing you to customize existing translations or add support for additional languages.

```bash
php artisan ladmin:install --resource=translations
```

**Destination:** `lang/vendor/ladmin`

### Migrations

The `migrations` resource publishes the database migrations required to support user profile images when using the built-in authentication scaffolding.

```bash
php artisan ladmin:install --resource=migrations
```

**Destination:** `database/migrations`

After publishing the migrations, apply them using:

```bash
php artisan migrate
```

::: info NOTE
The installer only publishes migration files. It does not execute database migrations automatically.
:::

## Installing Resources

### Standard Installation

To perform a standard installation, run:

```bash
php artisan ladmin:install
```

The installer automatically processes the required resources (`assets` and `config`).

In interactive environments, it then displays a selection prompt for optional resources (`translations` and `migrations`).

Use the **Space** key to select or deselect optional resources, then press **Enter** to continue. You can leave the selection empty to skip all optional resources.

Once installation is complete, a summary displays the status and destination of each resource.

### Installing Specific Resources

Use the `--resource` option to install or republish individual resources without running the standard installation workflow.

For example, to install only the translation files:

```bash
php artisan ladmin:install --resource=translations
```

You can also install multiple resources by repeating the option:

```bash
php artisan ladmin:install --resource=config --resource=translations
```

When using `--resource`:

- Only the specified resources are processed.
- Required resources are not automatically included.
- The optional resource selection prompt is skipped.
- Duplicate resource keys are ignored.

::: info NOTE
If an unknown resource key is provided, the installer displays an error and the available resource keys. No resources are installed until all specified keys have been validated.
:::

### Non-Interactive Installation

For automated deployments, CI/CD pipelines, or environments without interactive input, use:

```bash
php artisan ladmin:install --no-interaction
```

Without explicit resource selection, this installs the required resources and skips all optional resources.

To install optional resources non-interactively, specify them explicitly:

```bash
php artisan ladmin:install --resource=translations --resource=migrations --no-interaction
```

Existing files are preserved unless `--force` is specified.

## Managing Existing Resources

### Overwriting Existing Files

Before publishing a resource, the installer checks whether its destination files already exist.

If existing files are detected during interactive installation, the installer asks whether they should be overwritten.

Declining the confirmation preserves existing files while allowing missing files to be published.

To overwrite existing files without confirmation, use `--force`:

```bash
php artisan ladmin:install --resource=assets --force
```

The `--force` option can also be used with multiple resources:

```bash
php artisan ladmin:install --resource=assets --resource=config --force
```

::: danger CAUTION: Overwriting Customizations
Using `--force` overwrites previously published files and may replace your customizations.
Before overwriting configuration files or translations, make sure you have backed up any changes you want to preserve.
:::

### Installation Results

After processing the resources, the installer displays a summary table containing the resource name, installation status, and destination.

The following statuses may appear:

| Status      | Description                                                          |
|-------------|----------------------------------------------------------------------|
| `Installed` | The resource was successfully published.                             |
| `Updated`   | Existing resource files were overwritten successfully.               |
| `Unchanged` | All destination files already exist, and no overwrite was performed. |
| `Skipped`   | An optional resource was not selected during standard installation.  |
| `Failed`    | The resource could not be published successfully.                    |

If any resource fails, the command returns a failure exit status.

## Updating Package Resources

After updating LaradminLTE through Composer, some published resources may need to be refreshed to include the latest changes.

### Updating AdminLTE Assets

If a new LaradminLTE version includes updated AdminLTE v4 assets, republish them using:

```bash
php artisan ladmin:install --resource=assets --force
```

This replaces the previously published assets with the versions included in the installed package.

### Updating Configuration Files

New LaradminLTE versions may introduce additional configuration options or change existing defaults.

To republish the configuration files, run:

```bash
php artisan ladmin:install --resource=config --force
```

::: danger CAUTION: Losing Configuration Changes
This command overwrites existing configuration files, including any customizations you have made.
It is recommended to back up your configuration files before updating and review the differences before applying the new configuration.
:::

### Comparing Configuration Changes

Instead of overwriting your existing configuration, you can compare it against the version included in the updated package.

The package configuration files are located in:

```text
vendor/dfsmania/laradminlte/config/ladmin
```

Your published configuration files are located in:

```text
config/ladmin
```

For example, use the `diff` command to compare the main configuration file:

```bash
diff -u vendor/dfsmania/laradminlte/config/ladmin/main.php config/ladmin/main.php
```

You can then manually merge any new or modified configuration options while preserving your existing customizations.

#### Graphical Diff Tools

You can also use graphical comparison tools such as [Meld](https://meldmerge.org/) or [Beyond Compare](https://www.scootersoftware.com/).

For example, with Meld, you can compare the entire configuration directory:

```bash
meld vendor/dfsmania/laradminlte/config/ladmin config/ladmin
```

This allows you to review changes across multiple configuration files and merge them selectively.
