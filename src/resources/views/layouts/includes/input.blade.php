<div class="form-group">
    <div class="input-group {!! count($errors->get($attribute)) > 0 ? "is-invalid" : "" !!}">
        <div class="input-group-prepend">
            <label class="input-group-text" for="{{ $attribute }}" style="min-width: 170px;">{{ $label }}</label>
        </div>
        <input class="form-control {!! count($errors->get($attribute)) > 0 ? "is-invalid" : "" !!}" type="{{ $type ?? 'text' }}" name="{{ $attribute }}" placeholder="{{ $label }}"
                @if(isset($type)){
                   @if($type == "date")
                   value="{!! old($attribute) == NULL ? !isset($model) ? '' : $model->$attribute != NULL ? $model->$attribute->toDateString() : \Carbon\Carbon::now()->toDateString() : old($attribute) !!}"
                   @else
                   value="{!! old($attribute) == NULL ? !isset($model) ? '' : $model->$attribute : old($attribute) !!}"
                   @endif
                @else
                value="{!! old($attribute) == NULL ? !isset($model) ? '' : $model->$attribute : old($attribute) !!}"
                @endif
        >
    </div>
    <div class="invalid-feedback">
        @foreach($errors->get($attribute) as $message)
            {{ $message }}<br>
        @endforeach
    </div>
</div>