@php
if(old($attribute) == NULL){
    if(isset($model)){
        $selected_value = $model->$attribute;
    }else{
        $selected_value = "";
    }
}else{
    $selected_value = old($attribute);
}
@endphp

<div class="form-group {!! count($errors->get($attribute)) > 0 ? "label-floating has-danger" : "" !!}">
    <div class="input-group {!! count($errors->get($attribute)) > 0 ? "is-invalid" : "" !!}">
        <div class="input-group-prepend">
            <label class="input-group-text" for="{{ $attribute }}" style="min-width: 170px;">{{ $label }}</label>
        </div>
        <select class="form-control" type="{{ $type ?? 'text' }}" name="{{ $attribute }}" placeholder="{{ $label }}">
            @foreach($options as $key => $value)
                @if($value  == $selected_value)
                    <option value="{{ $key }}" selected>{{ $value }}</option>
                @else
                    <option value="{{ $key }}">{{ $value }}</option>
                @endif
            @endforeach
        </select>
    </div>

    <p class="help-block">
        @foreach($errors->get($attribute) as $message)
            {{ $message }}<br>
        @endforeach
    </p>
</div>