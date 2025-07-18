# What is LaradminLTE?

**LaradminLTE** is a Laravel package that seamlessly integrates the powerful [AdminLTE v4](https://adminlte-v4.netlify.app/dist) dashboard template into [Laravel](https://laravel.com/) (v10 or higher). Designed for modern web applications, this package provides a fast and flexible way to build responsive, maintainable, and feature-rich admin panels by using a Laravel [Blade component](https://laravel.com/docs/blade#components) to quick access the layout and configuration files to customize it.

::: danger CAUTION: Active Development
**LaradminLTE** is currently under active development. Features, configuration options, and behavior are subject to change until the first stable release.
:::

## Key Features

**LaradminLTE** key features are:

- **Responsive Admin Dashboard**: Built on the modern **AdminLTE v4** template and powered by **Bootstrap 5**, offers a mobile-first administration panel with responsive design that works seamlessly across all devices.

- **Powerful Menu System**: Config-driven and extensible menu system with support for: *nested items*, *links*, *section headers* and *dividers*.
  - Support to permission-based visibility that integrates well with **Laravel's Gate/Policies** or other authorization tool.
  - Automatic active state detection based on the current route, with support for custom logics.
  - Support to localizations by using Laravel's built-in translation tools, making it easy to create multilingual admin panels.

- **Advanced Configuration Options**: Provides deep customization for: panel layout, branding, navbar and sidebar behavior. All options are centralized in a single config file for simplicity and maintainability.

- **Built-in Authentication Scaffolding**: Out-of-the-box authentication UI powered by **Laravel Fortify**. Includes: *login*, *registration* and *password reset views*.

## Who is it for?

**LaradminLTE** is ideal for:

- Laravel Developers who want to quickly build modern, fully-featured admin panels without starting from scratch.

- Teams and Agencies building custom dashboards, CRMs, or internal tools that require flexibility, modularity, and fast setup.

- Anyone who prefers config-driven development and clean, maintainable code for backend interfaces.

Whether you're building a simple CMS or a complex enterprise dashboard, LaradminLTE offers the tools and structure to help you move faster while keeping control over customization and layout.
