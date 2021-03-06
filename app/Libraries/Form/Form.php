<?php
namespace App\Libraries\Form;

use Illuminate\Support\HtmlString;

class Form
{

    /**
     * Usage
    {{ Form::input([
        'ref' => 'name',
        'label' => 'translate.name',
        'required' => true,
        'icon' => 'user',
        'value' => !empty(old('item.name')) ? old('item.name') : ( isset($item) ? $item->name : '' ),
    ]) }}
     */
    public function input($config = [])
    {
        $type = isset($config['type']) ? $config['type'] : 'text';
        $model = isset($config['model']) ? $config['model'] : 'item';
        $ref = isset($config['ref']) ? $config['ref'] : '';
        $id = isset($config['id']) ? $config['id'] : ($ref ?? null);
        $name = isset($config['name']) ? $config['name'] : ($ref ? "{$$model}[{$ref}]" : null);
        $required = (bool) isset($config['required']) ? $config['required'] : false;
        $icon = isset($config['icon']) ? $config['icon'] : false;
        $label = isset($config['label']) ? trans($config['label']) : '';
        $value = isset($config['value']) ? $config['value'] : '';
        $class = isset($config['class']) ? ' '.$config['class'] : '';
        $attributes = isset($config['attributes']) ? $config['attributes'] : [];

        $attributesString = '';
        foreach($attributes as $k => $v)
            $attributesString .= ' '.$k.'="'.$v.'"';

        return new HtmlString('
            <div class="form-group">
                <label '.($id ? 'for="'.$id.'"' : '').'>'.$label.' '.($required ? '*' : '').'</label>
                <div class="input-group">
                    '.($icon ?
                    '<div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-'.$icon.'"></i></span>
                    </div>' : ''
                    ).'
                    <input type="'.$type.'" '.($id ? 'id="'.$id.'"' : '').' name="'.$name.'" '.($required ? 'required' : '').' class="form-control'.$class.'" value="'.$value.'" '.$attributesString.'>
                    <div class="invalid-feedback">'.trans('crud.invalid-field', [$label]).'</div>
                </div>
            </div>
        ');
    }

    /**
     * Usage
    {{ Form::number([
        'ref' => 'number',
        'label' => 'translate.number',
        'required' => true,
        'icon' => 'sort-numeric-up-alt',
        'value' => !empty(old('item.number')) ? old('item.number') : ( isset($item) ? $item->number : '' ),
    ]) }}
     */
    public function number($config)
    {
        if(!isset($config['attributes'])) $config['attributes'] = [];
        $config['type'] = 'number';

        if(isset($config['step'])) $config['attributes']['step'] = $config['step'];
        if(isset($config['min'])) $config['attributes']['min'] = $config['min'];
        if(isset($config['max'])) $config['attributes']['max'] = $config['max'];
        
        return $this->input($config);
    }
    
    /**
     * Usage
    {{ Form::date([
        'ref' => 'date',
        'label' => 'translate.date',
        'required' => true,
        'value' => !empty(old('item.date')) ? old('item.date') : ( isset($item) ? $item->date : '' ),
    ]) }}
     */
    public function date($config)
    {
        if(!isset($config['attributes'])) $config['attributes'] = [];
        $config['icon'] = 'calendar-alt';
        $config['class'] = trim(($config['class'] ?? '') . ' date date-picker');

        return $this->input($config);
    }

    /**
     * Usage
    {{ Form::time([
        'ref' => 'time',
        'label' => 'translate.time',
        'required' => true,
        'value' => !empty(old('item.time')) ? old('item.time') : ( isset($item) ? $item->time : '' ),
    ]) }}
     */
    public function time($config)
    {
        if(!isset($config['attributes'])) $config['attributes'] = [];
        $config['icon'] = 'clock';
        $config['class'] = trim(($config['class'] ?? '') . ' time time-picker');

        return $this->input($config);
    }
    
    /**
     * Usage
    {{ Form::password([
        'ref' => 'password',
        'label' => 'translate.password',
        'required' => true,
        'icon' => 'key',
        'value' => !empty(old('item.password')) ? old('item.password') : ( isset($item) ? $item->password : '' ),
    ]) }}
     */
    public function password($config)
    {
        $config['type'] = 'password';
        return $this->input($config);
    }
    
    /**
     * Usage
    {{ Form::textarea([
        'ref' => 'observation',
        'label' => 'translate.observation',
        'icon' => 'align-left',
        'value' => !empty(old('item.observation')) ? old('item.observation') : ( isset($item) ? $item->observation : '' ),
    ]) }}
     */
    public function textarea($config = [])
    {
        $model = isset($config['model']) ? $config['model'] : 'item';
        $ref = isset($config['ref']) ? $config['ref'] : '';
        $id = isset($config['id']) ? $config['id'] : ($ref ?? null);
        $name = isset($config['name']) ? $config['name'] : ($ref ? "{$model}[{$ref}]" : null);
        $required = (bool) isset($config['required']) ? $config['required'] : false;
        $icon = isset($config['icon']) ? $config['icon'] : false;
        $label = isset($config['label']) ? trans($config['label']) : '';
        $value = isset($config['value']) ? $config['value'] : '';
        $class = isset($config['class']) ? ' '.$config['class'] : '';
        $rows = isset($config['rows']) ? $config['rows'] : 3;
        $attributes = isset($config['attributes']) ? $config['attributes'] : [];

        $attributesString = '';
        foreach($attributes as $k => $v)
            $attributesString .= ' '.$k.'="'.$v.'"';

        return new HtmlString('
            <div class="form-group">
                <label '.($id ? 'for="'.$id.'"' : '').'>'.$label.' '.($required ? '*' : '').'</label>
                <div class="input-group">
                    '.($icon ?
                    '<div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-'.$icon.'"></i></span>
                    </div>' : ''
                    ).'
                    <textarea '.($id ? 'id="'.$id.'"' : '').' rows="'.$rows.'" name="'.$name.'" '.($required ? 'required' : '').' class="form-control'.$class.'" '.$attributesString.'>'.$value.'</textarea>
                    <div class="invalid-feedback">'.trans('crud.invalid-field', [$label]).'</div>
                </div>
            </div>
        ');
    }

    /**
     * Usage
    {{ Form::wysiwyg([
        'ref' => 'observation',
        'label' => 'translate.observation',
        'value' => !empty(old('item.observation')) ? old('item.observation') : ( isset($item) ? $item->observation : '' ),
    ]) }}
     */
    public function wysiwyg($config = [])
    {
        unset($config['icon']);
        $config['class'] = trim(($config['class'] ?? '') . ' wysiwyg');
        if(isset($config['rows']))$config['attributes'] = [ 'data-height' => 20+(23*$config['rows']) ];
        return $this->textarea($config);
    }

    /**
     * Usage
    {{ Form::select([
        'ref' => 'name',
        'label' => 'translate.name',
        'required' => true,
        'icon' => 'user',
        'options' => [1 => 'Fulano', 2 => 'Sicrano'],
        'value' => !empty(old('item.name')) ? old('item.name') : ( isset($item) ? $item->name : '' ),
    ]) }}
     */
    public function select($config = [])
    {
        $model = isset($config['model']) ? $config['model'] : 'item';
        $ref = isset($config['ref']) ? $config['ref'] : '';
        $id = isset($config['id']) ? $config['id'] : ($ref ?? null);
        $name = isset($config['name']) ? $config['name'] : ($ref ? "{$model}[{$ref}]" : null);
        $required = (bool) isset($config['required']) ? $config['required'] : false;
        $icon = isset($config['icon']) ? $config['icon'] : false;
        $label = isset($config['label']) ? trans($config['label']) : '';
        $chooseOption = trans(isset($config['chooseOption']) ? $config['chooseOption'] : 'crud.choose-a-option');
        $options = isset($config['options']) ? $config['options'] : [];
        $class = isset($config['class']) ? ' '.$config['class'] : '';
        $selected = isset($config['value']) ? ' '.$config['value'] : '';
        $optionsString = '<option value="">'.$chooseOption.'</option>';
        $attributes = isset($config['attributes']) ? $config['attributes'] : [];

        $attributesString = '';
        foreach($attributes as $k => $v)
            $attributesString .= ' '.$k.'="'.$v.'"';
        
        foreach($options as $k => $v)
            $optionsString .= '<option value="'.$k.'" '.(trim($selected) == trim($k) ? 'selected' : '').'>'.trans($v).'</option>';

        return new HtmlString('
            <div class="form-group">
                <label '.($id ? 'for="'.$id.'"' : '').'>'.$label.' '.($required ? '*' : '').'</label>
                <div class="input-group">
                    '.($icon ?
                    '<div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-'.$icon.'"></i></span>
                    </div>' : ''
                    ).'
                    <select '.($id ? 'id="'.$id.'"' : '').' name="'.$name.'" class="form-control'.$class.'" '.($required ? 'required' : '').' '.$attributesString.'>
                        '.$optionsString.'
                    </select>
                    <div class="invalid-feedback">'.trans('crud.invalid-field', [$label]).'</div>
                </div>
            </div>
        ');
    }

    /**
     * Usage
    {{ Form::select2([
        'ref' => 'name',
        'label' => 'translate.name',
        'required' => true,
        'icon' => 'user',
        'options' => [1 => 'Fulano', 2 => 'Sicrano'],
        'value' => !empty(old('item.name')) ? old('item.name') : ( isset($item) ? $item->name : '' ),
    ]) }}
     */
    public function select2($config = [])
    {
        $config['class'] = 'select2' . (isset($config['class']) ? ' '.$config['class'] : '');
        return $this->select($config);
    }

    /**
     * Usage
    {{ Form::switch([
        'ref' => 'is_true',
        'label' => 'translate.is_true',
        'checked' => (bool) (!empty(old('item.is_true')) ? old('item.is_true') : ( isset($item) && isset($item->is_true) ? $item->is_true : false ) ),
    ]) }}
     */
    public function switch($config = [])
    {
        $model = isset($config['model']) ? $config['model'] : 'item';
        $ref = isset($config['ref']) ? $config['ref'] : '';
        $id = isset($config['id']) ? $config['id'] : ($ref ?? null);
        $name = isset($config['name']) ? $config['name'] : ($ref ? "{$model}[{$ref}]" : null);
        $required = (bool) isset($config['required']) ? $config['required'] : false;
        $label = isset($config['label']) ? trans($config['label']) : '';
        $class = isset($config['class']) ? ' '.$config['class'] : '';
        $checked = isset($config['checked']) ? (bool) $config['checked'] : false;

        return new HtmlString('
            <div class="form-group">
                <label '.($id ? 'for="'.$id.'"' : '').'>'.$label.' '.($required ? '*' : '').'</label>
                <div class="custom-control custom-switch">
                    <input type="checkbox" '.($id ? 'id="'.$id.'"' : '').' name="'.$name.'" '.($required ? 'required' : '').' class="custom-control-input'.$class.'" '. ($checked ? 'checked' : '') .'>
                    <label class="custom-control-label" '.($id ? 'for="'.$id.'"' : '').'></label>
                    <div class="invalid-feedback">'.trans('crud.invalid-field', [$label]).'</div>
                </div>
            </div>
        ');
    }

    /**
     * Usage
    {{ Form::file([
        'ref' => 'image',
        'label' => 'translate.image',
        'icon' => 'image',
        'image' => !empty(old('item.image')) ? old('item.image') : ( isset($item) ? $item->image : '' ),
    ]) }}    
     */
    public function file($config = [])
    {
        $model = isset($config['model']) ? $config['model'] : 'item';
        $ref = isset($config['ref']) ? $config['ref'] : '';
        $id = isset($config['id']) ? $config['id'] : ($ref ?? null);
        $name = isset($config['name']) ? $config['name'] : ($ref ? "{$model}[{$ref}]" : null);
        $required = (bool) isset($config['required']) ? $config['required'] : false;
        $icon = isset($config['icon']) ? $config['icon'] : false;
        $label = isset($config['label']) ? trans($config['label']) : '';
        $class = isset($config['class']) ? ' '.$config['class'] : '';
        $image = filePath($config['image'], true);
        
        return new HtmlString('
            <div class="form-group">
                <label '.($id ? 'for="'.$id.'"' : '').'>'.$label.' '.($required ? '*' : '').'</label>
                <div class="input-group">
                    '.($icon ?
                    '<div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-'.$icon.'"></i></span>
                    </div>' : ''
                    ).'
                    <input type="text" class="form-control selected-file'.$class.'" readonly placeholder="'.trans('crud.choose-file').'">
                    <div class="input-group-append">
                        <label class="btn btn-primary m-0" '.($id ? 'for="'.$id.'"' : '').'>
                            <input '.($id ? 'id="'.$id.'"' : '').' name="'.$name.'" type="file" '.($required ? 'required' : '').' class="d-none file'.$class.'">
                            <i class="fas fa-search"></i>
                        </label>
                    </div>
                    <div class="invalid-feedback">'.trans('crud.invalid-field', [$label]).'</div>
                </div>
            </div>
            <div class="text-center">
            '.(isset($image) ? '<img class="img-thumbnail img-fluid" src="'.$image.'" alt="">' : '' ).'
            </div>
        ');
    }
}
