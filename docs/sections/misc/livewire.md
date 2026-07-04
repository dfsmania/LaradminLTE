# Livewire Support

## Introduction to Livewire

[Livewire](https://livewire.laravel.com/) is a full-stack framework for *Laravel* that allows you to build dynamic, interactive interfaces using only *PHP*. It eliminates the need to write separate frontend *JavaScript* frameworks (like *React* or *Vue*), automatically handling *AJAX* requests and *DOM* updates behind the scenes.

**Livewire** adds to *Laravel* the ability to create reactive components that can be used in your *Blade* templates. This allows you to build modern, dynamic web applications without leaving the comfort of your *Laravel* backend.

Starting from version 3.0, **Livewire**  introduced automatic asset injection, which means that you no longer need to manually include the *Livewire* scripts and styles in your templates. The framework will automatically handle the inclusion of necessary assets, making it easier to integrate **Livewire** into your *Laravel* applications. However, if you still need to manually handle the inclusion of *Livewire* assets, refer to the [Livewire Support Configuration](/sections/config/general#livewire-support) section of *LaradminLTE* documentation for guidance.

**LaradminLTE** provides seamless integration with **Livewire**, allowing you to easily use **Livewire** components within your *Blade* views using the main `<x-ladmin-panel>` component. In the next sections, we will explore how to use **Livewire** components with **LaradminLTE**, by showing some basic, but practical, examples.

## Inline Components

Inline components are the most common type of **Livewire** components. They are defined in a single file and can be used directly in your *Blade* templates. These components are ideal for small, reusable pieces of functionality that don't require a lot of complexity.

To show how to use **Livewire** components with **LaradminLTE**, we will create a simple counter component that allows users to increment and decrement a count value. Start by executing the next command in your terminal to create a new **Livewire** component:

```bash
php artisan make:livewire counter
```

On the most recent versions of **Livewire** (v4.0 or later), a single file will be created at `resources/views/components/⚡counter.blade.php`. This is known as *Single File Component (SFC)*, which allows you to write both your *PHP* backend logic and your *Blade HTML* template inside a single `.blade.php` file. On older versions of **Livewire** (v3.0 or earlier), two separate files will be created: `app/Http/Livewire/Counter.php` for the backend logic and `resources/views/livewire/counter.blade.php` for the frontend template. We will continue assuming *SFC* is being used, but the same logic applies to the older versions of **Livewire**.

So, next edit the `resources/views/components/⚡counter.blade.php` file to look like this:

```blade
<?php

use Livewire\Component;

new class extends Component
{
    public int $count = 0;

    public function increment(): void
    {
        $this->count++;
    }

    public function decrement(): void
    {
        $this->count--;
    }
};

?>

<div>
    <h1>Counter: {{ $count }}</h1>

    <x-ladmin-button wire:click="decrement" theme="danger" label="-"/>
    <x-ladmin-button wire:click="increment" theme="success" label="+"/>
</div>
```

That's it! Now you can use the `<livewire:counter/>` component inside the provided *LaradminLTE* main layout component (`<x-ladmin-panel>`), and it will automatically handle the increment and decrement functionality without requiring any additional *JavaScript* code. For example, we can define a view file at `resources/views/livewire-counter-example.blade.php` with the following content:

```blade
<x-ladmin-panel title="A Livewire Inline Component">

    {{-- Setup the content header --}}
    <x-slot name="contentHeader">
        <div class="row">
            <div class="col-12">
                <h3 class="fw-bold">
                    <i class="bi bi-lightning-charge-fill text-warning"></i>
                    Livewire Counter Component Test
                </h3>
            </div>
        </div>
    </x-slot>

    {{-- Setup the content body --}}
    <div class="row">

        {{-- Use the Livewire Counter component --}}
    	<div class="col-12">
            <livewire:counter/>
        </div>

    </div>

</x-ladmin-panel>
```

Then, as usual, you can define a route in your `routes/web.php` file to access this view, and configure a menu entry in the `config/ladmin/menu.php` file to make it accessible from the *LaradminLTE* sidebar menu.

## Full Page Components

Full page components are **Livewire** components that are designed to take up an entire page. They are typically used for more complex functionality that requires a dedicated view and backend logic. Full page components can be created using the same `php artisan make:livewire` command, but adding the `page::` prefix to the component name.

Full page components require a layout for them to be rendered inside. In **LaradminLTE**, the main layout component is `<x-ladmin-panel>`, which provides a consistent look and feel for your application, so first let's use it to create a layout for our full page component.

### A LaradminLTE Layout for Full Page Components

At next we create a basic, but functional, layout for our full page components. Create a new file at `resources/views/layouts/ladmin.blade.php` with the following content:

```blade
{{-- Full Page Components Layout --}}
<x-ladmin-panel title="{{ $title ?? 'LaradminLTE Layout' }}">

    {{-- Setup a content header definition --}}
    <x-slot name="contentHeader">
        <div class="row">
            <div class="col-12">
                <h3 class="fw-bold">
                    {{ $contentHeader ?? 'LaradminLTE Layout Header' }}
                </h3>
            </div>
        </div>
    </x-slot>

    {{-- Slot for Livewire full page components --}}
    {{ $slot }}

</x-ladmin-panel>
```

The `$slot` directive is used to define a placeholder for the content of the full page component that will be rendered inside this layout. The `$title` and `$contentHeader` variables are optional and can be passed to the layout when rendering a full page component.

### A Full Page Component Example

Now, let's create a full page component that uses the layout we just created. Execute the following command in your terminal to create a new **Livewire** full page component:

```bash
php artisan make:livewire pages::post.create
```

This command will create a new **Livewire** component in the next *SFC (Single File Component)* file: `resources/views/pages/post/⚡create.blade.php`. Now, edit this file to look like this:

```blade
<?php

use Livewire\Component;

new class extends Component {

    /*
     * Properties for the post title and content.
     */
    public string $title = '';
    public string $content = '';

    /*
     * Property to hold the success message after saving.
     */
    public string $successMessage = '';

    /*
     * Save the post data.
     */
    public function save()
    {
        // Validate the input data.

        $validated = $this->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        // Here you would typically save the post to the database or perform
        // other actions. For example:
        //
        // Post::create($validated);

        // Set a success message to display after saving.

        $data = json_encode($validated, JSON_PRETTY_PRINT);
        $this->successMessage = "Post created successfully! Data: {$data}";
    }

    /*
     * Render the Livewire component view, specifying the layout to use.
     */
    public function render()
    {
        // Render the view for this Livewire component and specify the layout
        // to use. Note we are using the 'layouts::ladmin' we defined
        // previously and passing the title and contentHeader to it.

        return $this->view()
            ->layout('layouts::ladmin', [
                'title' => 'Create Post',
                'contentHeader' => 'Create New Post'
            ]);
    }
};

?>

{{-- Blade view for the Livewire component --}}

<div class="row">
    <div class="col-12 col-lg-6">

        <form wire:submit="save">
            <x-ladmin-input-group for="title" label="Title" label-classes="fw-bold">
                <x-ladmin-input name="title" wire:model="title" />

                <x-slot name="prepend">
                    <span class="input-group-text bg-body-tertiary">
                        <i class="bi bi-tag-fill fs-5 text-primary"></i>
                    </span>
                </x-slot>
            </x-ladmin-input-group>

            <x-ladmin-input-group for="content" label="Content" label-classes="fw-bold">
                <x-ladmin-textarea name="content" wire:model="content" />

                <x-slot name="prepend">
                    <span class="input-group-text bg-body-tertiary">
                        <i class="bi bi-card-text fs-5 text-primary"></i>
                    </span>
                </x-slot>
            </x-ladmin-input-group>

            <x-ladmin-button type="submit" theme="primary" label="Create Post"/>
        </form>

        @if($successMessage)
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ $successMessage }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

    </div>
</div>
```

This component allows users to create a new post by entering a title and content. When the form is submitted, the `save` method is called, which validates the input data and sets a success message. The component uses the `layouts::ladmin` layout we defined earlier, passing the title and content header to it. Note the component uses some other components from **LaradminLTE**, such as `<x-ladmin-input-group>`, `<x-ladmin-input>`, `<x-ladmin-textarea>`, and `<x-ladmin-button>`, to create a consistent and styled form. This is on purpose, to show how **Livewire** components can be seamlessly integrated with **LaradminLTE** components.

Also, you should pay special attention to the `render()` method, which specifies the layout to use for this full page component. The `layout` method is used to specify the layout view and pass any necessary data to it. In this case, we are passing the title and content header to the layout.

### Using the Livewire Configuration for Layouts

If you will be using the same layout for your entire *Laravel* application, you can consider setting the `component_layout` entry in the *Livewire* configuration file (`config/livewire.php`) instead of specifying it in each full page component you create. Under this situation, the render method of the full page component would look like this:

```php
public function render()
{
    // Render the view for this Livewire component. The layout will be
    // automatically set to the value defined in the Livewire configuration.

    return $this->view()->layoutData([
        'title' => 'Create Post',
        'contentHeader' => 'Create New Post'
    ]);
}
```

### Final Notes

Finnally, you can define a route in your `routes/web.php` file to access this full page component, and configure a menu entry in the `config/ladmin/menu.php` file to make it accessible from the *LaradminLTE* sidebar menu. This way, you can easily navigate to the full page component and test its functionality. A menu entry for the full page component we examined before could look like this:

```php
[
    'type' => MenuItemType::LINK,
    'label' => 'Create Post',
    'icon' => 'bi bi-pencil-square',
    'url' => '/url/to/full-page-component',
],
```
