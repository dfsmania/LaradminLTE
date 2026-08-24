{{-- Sidebar search widget --}}
<div class="sidebar-search mt-2" role="search">

    {{-- Label (visually hidden, but accessible to screen readers) --}}
    <label for="sidebar-search-input" class="visually-hidden">
        {{ __('ladmin::layout.sidebar_search.search') }}
    </label>

    {{-- Search input --}}
    <input id="sidebar-search-input" type="search" class="form-control fs-6" autocomplete="off"
        placeholder="{{ __('ladmin::layout.sidebar_search.search') }}"
        data-lte-toggle="sidebar-search" data-lte-target="{{ $target }}">

    {{-- Empty search results element --}}
    <p class="fs-6 text-secondary mt-2 mb-0" role="status" data-lte-search-empty hidden>
        {{ __('ladmin::layout.sidebar_search.no_results') }}
    </p>

</div>
