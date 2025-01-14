@stack('add_new_button_start')
@php
    $route ='general.title.new';
    if($textPage == 'general.invoices' || $textPage  == 'general.bills')
        $route.='_femine';
@endphp

@if (! $hideCreate)
    @can($permissionCreate)
        <x-link href="{{ route($createRoute) }}" kind="primary">
            {{ trans($route, ['type' => trans_choice($textPage, 1)]) }}
        </x-link>
    @endcan
@endif

@stack('edit_button_start')

@if (! in_array($document->status, $hideButtonStatuses))
    @if (! $hideEdit)
        @can($permissionUpdate)
            <x-link href="{{ route($editRoute, $document->id) }}">
                {{ trans('general.edit') }}
            </x-link>
        @endcan
    @endif
@endif

@stack('edit_button_end')
