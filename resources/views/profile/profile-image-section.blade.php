{{-- Profile image section --}}
<x-ladmin-profile-section title="{{ __('ladmin::auth.profile.profile_image.title') }}"
    description="{{ __('ladmin::auth.profile.profile_image.description') }}">

    {{-- Update image form --}}
    <form method="POST" action="{{ route(config('ladmin.main.routes.as', 'ladmin.') . 'user-profile-image.update') }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        {{-- Image selection and preview --}}
        {{-- TODO: Create a component (ImageInput) for the image preview/selection? --}}
        {{-- TODO: Add tools for image cropping, resizing, or rotating? --}}
        <div class="d-flex align-items-center gap-3">

            {{-- Profile image preview --}}
            <img id="image_preview" src="{{ $user->profileImageUrl() }}"
                alt="{{ __('ladmin::auth.profile.profile_image.title') }}"
                class="rounded-circle shadow border border-2 border-secondary-subtle"
                style="width:128px;height:128px;">

            {{-- Image selection button --}}
            <x-ladmin-button type="button" theme="light" icon="bi bi-file-image fs-5"
                label="{{ __('ladmin::auth.profile.buttons.select_new_image') }}"
                onclick="document.querySelector('input[name=photo]').click();"
                class="d-flex align-items-center border-secondary-subtle"/>

            {{-- Image input file (hidden) --}}
            <x-ladmin-input-group for="photo" errors-bag="updateProfileImage">
                <x-ladmin-input name="photo" type="file" accept="image/*" class="d-none" no-validation-feedback/>
            </x-ladmin-input-group>

        </div>

        {{-- Save image button --}}
        <x-ladmin-button type="submit" theme="secondary" icon="bi bi-save fs-5"
            label="{{ __('ladmin::auth.profile.buttons.save') }}"
            class="mt-2 float-end d-flex align-items-center bg-gradient"/>
    </form>

    {{-- Delete image form --}}
    <form method="POST" action="{{ route(config('ladmin.main.routes.as', 'ladmin.') . 'user-profile-image.delete') }}">
        @method('DELETE')
        @csrf

        <x-ladmin-button type="submit" theme="outline-danger" icon="bi bi-trash fs-5"
            label="{{ __('ladmin::auth.profile.buttons.delete_image') }}"
            class="mt-2 me-3 float-end d-flex align-items-center"/>
    </form>

</x-ladmin-profile-section>

{{-- Extra JS --}}
@push('js')
<script>

    document.addEventListener('DOMContentLoaded', function () {
        const imageInput = document.querySelector('input[name=photo]');

        // Listen for changes on the file input to update the image preview.

        imageInput?.addEventListener('change', function (e) {
            // Get the selected file.

            const [file] = e.target.files;

            if (! file) {
                return;
            }

            // Create a FileReader to read the file and set the preview image
            // source. Note we use readAsDataURL() to get a base64 encoded
            // string with data:URL format that can be used as image src.

            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('image_preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    });

</script>
@endpush
