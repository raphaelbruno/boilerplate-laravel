<?php
    $nameString = isset($name) ? $name : 'subitems';
?>
<div id="{{ sha1($nameString) }}" class="subitem">
    <div class="form-group">
        <label>@lang(isset($label) ? $label : '&nbsp;')</label>
        <div class="card card-outline card-secondary">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover m-0 subitems">
                        <thead>
                            <tr>
                                <th>@lang('crud.title')</th>
                                <th class="text-center">@lang('crud.delete')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="no-subitems">
                                <td class="align-middle" colspan="2">@lang('admin.no-items')</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="javascript:void(0);" onclick="addSubitem('{{ sha1($nameString) }}', '{{ $nameString }}');" title="Novo" class="btn btn-sm btn-success float-left">
                    <i class="fas fa-plus"></i> @lang('crud.new')
                </a>
                <div class="float-right">
                    @lang('crud.total'): <span class="total">0</span>
                </div>
            </div>
        </div>
    </div>
    
    <table class="d-none">
        <tbody class="model">
            <tr>
                <td class="align-middle">
                    <select class="form-control" style="width: 100%;">
                        @foreach($subitems as $subitem)
                        <option value="{{ $subitem->{isset($key) ? $key : 'id'} }}">{{ $subitem->{isset($value) ? $value : 'title'} }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="align-middle text-center">
                    <a href="javascript:void(0);" onclick="deleteSubitem(this);" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    window.addEventListener('load', function(){
        @foreach($addedItems as $addedItem)
            @if(is_numeric($addedItem))
                addSubitem('{{ sha1($nameString) }}', '{{ $nameString }}', {{ $addedItem }});
            @else
                addSubitem('{{ sha1($nameString) }}', '{{ $nameString }}', {{ $addedItem->{isset($key) ? $key : 'id'} }});
            @endif
        @endforeach
    });
</script>