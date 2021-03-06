@extends('admin.layouts.template-resource-form')

@section('fields')

    {{ Form::input([
        'ref' => 'title',
        'label' => 'crud.title',
        'required' => true,
        'icon' => $icon,
        'value' => !empty(old('item.title')) ? old('item.title') : ( isset($item) ? $item->title : '' ),
    ]) }}

    {{ Form::input([
        'ref' => 'name',
        'label' => 'crud.name',
        'required' => true,
        'icon' => 'tag',
        'value' => !empty(old('item.name')) ? old('item.name') : ( isset($item) ? $item->name : '' ),
    ]) }}

    {{ Form::input([
        'ref' => 'level',
        'label' => 'admin.level',
        'icon' => 'sitemap',
        'value' => !empty(old('item.level')) ? old('item.level') : ( isset($item) ? $item->level : '' ),
        'attributes' => [
            'data-mask' => '00',
            'data-mask-reverse' => 'true'
        ],
    ]) }}

    {{ Form::switch([
        'ref' => 'default',
        'label' => 'admin.default',
        'checked' => (bool) (!empty(old('item.default')) ? old('item.default') : ( isset($item) ? $item->default : false ) ),
    ]) }}

@endsection

@section('col')
    <div class="col col-md-6">
        <sub-items name="permissions"
            options="{{ json_encode($permissions->map(function($item){ return (object)['key' => $item->id, 'value' => $item->title]; })) }}"
            label="@lang('admin.permissions')"
            added-items="{{ json_encode(old('permissions') ? old('permissions') : (isset($item) ? $item->permissions->pluck('id') : [])) }}"
        >
        </sub-items>
    </div>
@endsection
