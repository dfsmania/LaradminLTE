# Form Components

**LaradminLTE** provides some [Blade Components](https://laravel.com/docs/blade#components) that can help you build formularies UIs with a consistent Bootstrap theme and built-in support for common patterns like old input value restoration and validation feedback.

Most of these components are already used by the package's authentication scaffolding, so you can refer to the [authentication views](https://github.com/dfsmania/LaradminLTE/tree/main/resources/views/auth) for a fast overview or impression of how these components can be used in practice.

## Available Form Components

At the moment, the following form-related components are available to be used in your Blade views. Since *AdminLTE* is built on top of *Bootstrap*, these components are designed with Bootstrap's form styles and classes, while also providing some extra features to make your life easier when building forms in Laravel.

| Component                   | Description                                                                          |
| --------------------------- | ------------------------------------------------------------------------------------ |
| [Button](#button)           | Renders a button with support for icon, label, and custom content.                     |
| [Checkbox](#checkbox)       | Renders a checkbox (or switch) with support for label and theme styling.             |
| [Input](#input)             | Renders a text-like input with old-input and validation-state support.               |
| [Input Group](#input-group) | Wraps inputs with label, prepend/append content, help text, and validation messages. |
| [Select](#select)           | Renders a select element with options and old-input selection support.               |
| [Textarea](#textarea)       | Renders a textarea with old-input and validation-state support.                      |

### Component Themes

Some of these components allows setting a `theme` property that is directly related to the [Bootstrap color themes](https://getbootstrap.com/docs/5.3/customize/color/#theme-colors) (like `primary`, `secondary`, `success`, `danger`, etc.). The actual effect of the theme depends on the component, but generally it applies a color from the Bootstrap palette to the component's background, or text. At next we share a common list of the Bootstrap themes that you can use in these components:

| Theme Name  | Description                                                    |
| ----------- | -------------------------------------------------------------- |
| `primary`   | The primary theme color, usually a strong blue.                |
| `secondary` | The secondary theme color, usually a muted gray.               |
| `success`   | The success theme color, usually a strong green.               |
| `danger`    | The danger theme color, usually a strong red.                  |
| `warning`   | The warning theme color, usually a strong yellow or orange.	   |
| `info`      | The info theme color, usually a strong cyan.                   |

## Shared Behavior and Properties

Most of the form control components (like `x-ladmin-input`, `x-ladmin-select`, `x-ladmin-textarea`, and `x-ladmin-checkbox`) share a base behavior for validation and old input handling. Here we describe the common properties and behavior that these components share, so you can understand how to use them effectively across different form controls.

### Shared Properties

The next table lists the common properties that are available on all base form controls.

| Name                   | Type               | Default Value | Required | Description                                                          |
| ---------------------- | ------------------ | ------------- | -------- | -------------------------------------------------------------------- |
| `name`                 | `string`           | -             | Yes      | Form control `name` attribute and validation key source.             |
| `id`                   | `string` or `null` | `name`        | No       | Form control `id` attribute.                                         |
| `sizing`               | `string` or `null` | `null`        | No       | Form control size modifier. Valid values are `sm` and `lg`.          |
| `noOldInput`           | `bool`             | `false`       | No       | Disables old-input value restoration.                                |
| `noValidationFeedback` | `bool`             | `false`       | No       | Disables validation visual feedback styling.                         |
| `errorsBag`            | `string` or `null` | `null`        | No       | The errors bag name to use when looking up validation messages.      |

### Shared Behavior

In the next sections, we describe the common behavior related to old input and validation feedback.

#### About Old Input

Old input is enabled by default and can be disabled with the `no-old-input` attribute. When disabled, the component will not attempt to restore previous input values after validation errors, and will rely solely on the provided `value` attribute or slot content. This can be useful in cases where you want to have more control over the rendered value or when old input restoration is not desired.

#### About Validation Feedback

Validation feedback is enabled by default and can be disabled with the `no-validation-feedback` attribute. When enabled, the component will apply Bootstrap's `is-invalid` class when there are validation errors for this field, and `is-valid` when there are validation errors in the bag but not for this field. Disabling this will prevent the automatic application of these classes, which can be useful if you want to handle validation feedback styling manually or if you don't want any visual feedback for validation states.

#### About Error Bags

Named error bags are supported through the `errors-bag` attribute. You can specify which error bag to use when looking up validation messages. This is particularly useful when you have multiple forms on the same page or when you want to separate validation errors into different contexts. By default, it will use the default Laravel's error bag.

#### About Validation Key Resolution

Validation key resolution supports array-style names. So you can use a name like `files[]` in your form control, and the component will correctly resolve the validation key to `files` when looking up errors in the error bag. This allows you to work with complex form structures and nested data without losing validation support. As examples:
  - `files[]` becomes `files`
  - `person[2][name]` becomes `person.2.name`
  - `addresses[][street]` becomes `addresses.*.street`

## Button

Use the `x-ladmin-button` component to render action buttons with a consistent Bootstrap theme, and support for icon, label, and optional custom slot content.

### Properties

| Name     | Type               | Default Value | Required | Description                                                                         |
| -------- | ------------------ | ------------- | -------- | ----------------------------------------------------------------------------------- |
| `label`  | `string` or `null` | `null`        | No       | Text content rendered inside the button. HTML entities are decoded.                 |
| `theme`  | `string` or `null` | `'secondary'` | No       | Bootstrap button theme, you can use any valid [Bootstrap theme](#component-themes). |
| `icon`   | `string` or `null` | `null`        | No       | Icon CSS classes (for example Bootstrap Icons or FontAwesome classes).              |
| `sizing` | `string` or `null` | `null`        | No       | Size modifier. Valid values are `sm` and `lg`.                                      |

Any additional attributes you define will be merged into the underlying `<button>` element via the Laravel's `$attributes->merge(...)` method. So, you can safely use attributes like `type`, `class`, `id`, `disabled`, `data-*`, `aria-*` or `onclick` on the component and they will be applied to the rendered button.

### Slots

| Slot    | Description                                                                     |
| ------- | ------------------------------------------------------------------------------- |
| Default | Extra content rendered inside the `<button>` after the optional icon and label. |

The `default` slot (i.e. anything you put between the opening and closing tags of the component) is rendered inside the button after the optional icon and label. This allows you to add extra markup or content to the button, such as badges, counters, or any other inline elements that should be part of the button's content. Even more, it allows you to completely customize the button's content if you choose to ignore the `label` and `icon` props.

### Examples

#### A Button with Icon and Label

At next, we define a login button with icon and label. Note that attributtes like `type` and `class` (that are not part of the component props) are merged into the underlying `<button>` element:

```blade
<x-ladmin-button
	type="submit"
	theme="primary"
	icon="bi bi-box-arrow-in-right fs-5"
	label="Sign In"
	class="d-flex align-items-center bg-gradient"
/>
```

#### A Button with Custom Slot Content

At next, we define a button with an icon and custom slot content (instead of using the `label` prop). This allows us to include extra content inside the button (like the `badge`) and also to have more control over the structure of the button's content.

```blade
<x-ladmin-button type="button" theme="primary" icon="bi bi-download">
	Export
	<span class="badge bg-light text-dark ms-2">CSV</span>
</x-ladmin-button>
```

## Checkbox

Use the `x-ladmin-checkbox` for checkbox inputs with optional label, theme color, old-input aware checked state, and support for [Bootstrap's switch](https://getbootstrap.com/docs/5.3/forms/checks-radios/#switches) style.

### Properties

Besides the properties listed below, this component also supports the [shared form control properties](#shared-properties).

| Name           | Type               | Default Value | Required | Description                                                          |
| -------------- | ------------------ | ------------- | -------- | -------------------------------------------------------------------- |
| `theme`        | `string`           | `'primary'`   | No       | [Theme color](#component-themes) applied to checked state.           |
| `label`        | `string` or `null` | `null`        | No       | Label text rendered next to the checkbox. HTML entities are decoded. |
| `labelClasses` | `string` or `null` | `null`        | No       | Extra classes for styling the label.                                 |
| `switchMode`   | `bool`             | `false`       | No       | Renders the checkbox as Bootstrap switch style (`form-switch`).      |

Additional attributes you define will be merged into the underlying `<input type="checkbox">` element via the Laravel's method:
```php
$attributes->except('checked')->merge(...)
```

The `checked` state is computed by the component logic, so `checked` is intentionally excluded from normal merge handling.

Checkbox labels are handled directly by the component (`label` prop). So, you should use this component as a standalone control instead of wrapping it with [x-ladmin-input-group](#input-group) for label rendering.

#### About Checked State Behavior:

- If there are validation errors in the selected error bag, the component uses old input to determine checked state.
- Otherwise, it falls back to whether the `checked` attribute was provided.

### Examples

#### A Checkbox with Label and Theme

At next, we define a "remember me" checkbox that follows the package authentication views style. Note that the `class` attribute is merged into the underlying `<input>` element, so we can use it to remove the default checkbox shadow:

```blade
<x-ladmin-checkbox
	name="remember_me"
	theme="primary"
	label="Remember Me"
	class="shadow-none"
	sizing="lg"
	no-validation-feedback
/>
```

Note we disable validation feedback in this example, since the "remember me" checkbox is not required and will not have any validation rules associated with it.

#### A Checkbox with Switch Mode

At next, we define a checkbox rendered as a Bootstrap switch.

```blade
<x-ladmin-checkbox
	name="notifications"
	label="Enable notifications"
	theme="success"
	switch-mode
/>
```

## Input

Use the `x-ladmin-input` for standard input fields such as text, email, password, number, and other input types supported by *HTML*.

### Properties

This component supports the [shared form control properties](#shared-properties) that are common to all base form controls, such as `name`, `id`, `sizing`, `noOldInput`, `noValidationFeedback`, and `errorsBag`. But, it does not define additional properties specific to the input component, since it is designed to be flexible and work with any input type and attributes you may need.

So, instead, you can pass any additional attributes directly to the component, and they will be applied (merged) to the underlying `<input>` element via the Laravel's `$attributes->merge(...)` method. This allows you to use standard *HTML* input attributes like `type`, `value`, `placeholder`, `required`, `readonly`, `autocomplete`, `min`, `max`, `step`, and any custom `data-*` or `aria-*` attributes without needing specific props for each of them.

### Examples

#### An Email Input Wrapped in an Input Group

At next, we define an [input group](#input-group) wrapping an email input with a floating label and an appended icon, as used in this package's authentication scaffolding.

```blade
<x-ladmin-input-group for="email" label="Email" floating-label>
	<x-ladmin-input name="email" type="email" placeholder="" required/>

	<x-slot name="append">
		<span class="input-group-text bg-body-tertiary">
			<i class="bi bi-envelope-fill fs-5 text-primary"></i>
		</span>
	</x-slot>
</x-ladmin-input-group>
```

#### A Standalone Numeric Input

At next, we define a standalone numeric input with custom attributes.

```blade
<x-ladmin-input
	name="price"
	type="number"
	min="0"
	step="0.01"
	class="text-primary"
	value="9.99"
/>
```

Note that attributes like `type`, `min`, `step`, `class`, and `value` are not defined as specific properties on the component, but they are still applied to the rendered `<input>` element thanks to the `$attributes->merge(...)` handling provided by the component.

## Input Group

Use the `x-ladmin-input-group` as a wrapper around form controls to add labels, prepend/append content, contextual help, and validation messages.

### Properties

| Name                  | Type               | Default Value | Required | Description                                                              |
| --------------------- | ------------------ | ------------- | -------- | ------------------------------------------------------------------------ |
| `for`                 | `string`           | -             | Yes      | Reference to the wrapped input name used by label and validation lookup. |
| `label`               | `string` or `null` | `null`        | No       | Label text. HTML entities are encoded.                                   |
| `sizing`              | `string` or `null` | `null`        | No       | Input group size. Valid values are `sm` and `lg`.                        |
| `labelClasses`        | `string` or `null` | `null`        | No       | Extra classes for styling the label.                                     |
| `fgroupClasses`       | `string` or `null` | `null`        | No       | Extra classes for the outer `form-group` wrapper.                        |
| `igroupClasses`       | `string` or `null` | `null`        | No       | Extra classes for the inner `input-group` wrapper.                       |
| `validFeedbackMessage`| `string` or `null` | `null`        | No       | Message displayed when the form has errors but this field is valid.      |
| `noValidationFeedback`| `bool`             | `false`       | No       | Disables invalid/valid feedback message blocks.                          |
| `floatingLabel`       | `bool`             | `false`       | No       | Enables the floating label mode (`form-floating`).                       |
| `errorsBag`           | `string` or `null` | `null`        | No       | Specifies the named validation error bag where to look for errors.       |

#### About Validation Feedback Behavior

- When there are validation errors for the wrapped form control (i.e., the one referenced by the `for` property), the component shows the first error message inside an `invalid-feedback` block.
- When there are validation errors in the bag but not for the wrapped form control, and `validFeedbackMessage` is set, the component shows the `validFeedbackMessage` inside a `valid-feedback` block.

### Slots

| Slot      | Description                                                                                                      |
| --------- | ---------------------------------------------------------------------------------------------------------------- |
| Default   | Used for the wrapped form control itself (for example `x-ladmin-input`, `x-ladmin-select`, `x-ladmin-textarea`). |
| `prepend` | Allows to add content before the wrapped form control inside.                                                    |
| `append`  | Allows to add content after the wrapped form control inside.                                                     |
| `help`    | Allows to add content below the group as `<div class="form-text">...</div>`.                                     |

### Examples

#### An Input Group with Floating Label and Append Icon

At next, we define an input group with floating label and appended icon following the auth pages style.

```blade
<x-ladmin-input-group for="password" label="Password" floating-label>
	<x-ladmin-input name="password" type="password" placeholder="" required/>

	<x-slot name="append">
		<span class="input-group-text bg-body-tertiary">
			<i class="bi bi-lock-fill fs-5 text-dark"></i>
		</span>
	</x-slot>
</x-ladmin-input-group>
```

#### An Input Group with Prepend, Append, and Help Slots

At next, we define an input group using all available content slots.

```blade
<x-ladmin-input-group for="username" label="Username" valid-feedback-message="Looks good">
	<x-slot name="prepend">
		<span class="input-group-text">@</span>
	</x-slot>

	<x-ladmin-input name="username" required/>

	<x-slot name="append">
		<span class="input-group-text">.admin</span>
	</x-slot>

	<x-slot name="help">
		<span class="text-primary">
            This will be visible to other users.
        </span>
	</x-slot>
</x-ladmin-input-group>
```

## Select

Use the `x-ladmin-select` component to render select fields with normalized options, old-input selection recovery, and standard validation-state support.

### Properties

Besides the properties listed below, this component also supports the [shared form control properties](#shared-form-control-properties).

| Name      | Type                               | Default Value | Required | Description                |
| --------- | ---------------------------------- | ------------- | -------- | -------------------------- |
| `options` | `array<int, array<string, mixed>>` | `[]`          | No       | Predefined set of options. |

Additional attributes you pass will be merged into the underlying `<select>` element via the Laravel's `$attributes->merge(...)` method.


#### The `options` Property

The `options` property allows you to define a list of options to be rendered inside the select. Each option is an associative array that should contain at least a `value` key, and can optionally include `label`, `disabled`, and `selected` keys. For example:

```php
[
	['value' => 'draft', 'label' => 'Draft'],
	['value' => 'published', 'label' => 'Published', 'selected' => true],
	['value' => 'archived', 'label' => 'Archived', 'disabled' => true],
]
```

The `options` prop is always normalized before rendering, following these rules:

- Invalid options (without a string `value`) will be ignored.
- The `label` key defaults to `value` when omitted.
- The `disabled` key defaults to `false`.
- During validation errors, the selected state is driven by old input values.
- Without validation errors, the selected state follows each option's `selected` key.

### Slots

| Slot    | Description                                                       |
| ------- | ----------------------------------------------------------------- |
| Default | Allows adding extra options, or entirely define the options list. |

The default slot can be used to add extra options or to completely define the options list using standard `<option>` elements. When using the default slot, the `options` property is still processed and rendered before the slot content, so you can combine both approaches if needed.

### Examples

#### A Select with Predefined Options

At next, we define a select with options passed through the `options` property.

```blade
@php
	$options = [
		['value' => 'draft', 'label' => 'Draft'],
		['value' => 'published', 'label' => 'Published', 'selected' => true],
		['value' => 'archived', 'label' => 'Archived', 'disabled' => true],
	];
@endphp

<x-ladmin-select name="status" :options="$options"/>
```

#### A Select with Extra Slot Options

At next, we define a select using predefined options plus extra options via the default slot.

```blade
<x-ladmin-select name="country" :options="[['value' => 'us', 'label' => 'United States']]">
	<option value="ca">Canada</option>
	<option value="mx">Mexico</option>
</x-ladmin-select>
```

## Textarea

Use the `x-ladmin-textarea` for multi-line content inputs with the same old-input and validation-state behavior as other base form controls.

### Properties

This component supports the [shared form control properties](#shared-properties) that are common to all base form controls, such as `name`, `id`, `sizing`, `noOldInput`, `noValidationFeedback`, and `errorsBag`. But, it does not define additional properties specific to the component, since it is designed to be flexible and work with any attributes you may need.

So, instead, you can pass any additional attributes directly to the component, and they will be applied (merged) to the underlying `<textarea>` element via the Laravel's `$attributes->merge(...)` method. This allows you to use standard *HTML* textarea attributes like `rows`, `cols`, `placeholder`, `required`, `readonly`, `maxlength`, and any custom `data-*` or `aria-*` attributes without needing specific props for each of them.

#### About Content Resolution Behavior

- If old input exists (and old-input support is enabled), the old input will be rendered. This is the case when the form was submitted and there were validation errors, so we want to restore the user's previous input.
- Otherwise, the default slot content is rendered. This allows you to provide default content for the textarea that will only be shown when there is no old input value to restore. If the default slot is empty, the textarea will simply render with no content in this case.

### Slots

| Slot    | Description                                  |
| ------- | -------------------------------------------- |
| Default | Used as textarea initial or default content. |

The default slot is used as the initial content of the textarea when there is no old input value to restore. This allows you to provide a default value or placeholder content for the textarea that will be shown on the first render or when the form is reset, while still allowing old input restoration to take precedence when applicable.

### Examples

#### A Basic Textarea

At next, we define a basic textarea with explicit `rows` and `placeholder` attributes. Note that these attributes are not defined as specific properties on the component, but they are still applied to the rendered `<textarea>` element thanks to the `$attributes->merge(...)` handling provided by the component.

```blade
<x-ladmin-textarea name="notes" rows="4" placeholder="Type here..."></x-ladmin-textarea>
```

#### A Textarea with Slot Fallback

At next, we define a textarea with default slot content used only on initial render or when there is no old input value.

```blade
<x-ladmin-textarea name="bio" rows="5">
	Default bio text shown initially or only when there is no old input.
</x-ladmin-textarea>
```
