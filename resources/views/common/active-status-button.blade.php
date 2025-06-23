<div class="form-check form-switch">
    <input type="checkbox"
           name="{{$name}}"
           id="{{$name}}"
           class="form-check-input changeDataStatus"
           data-id="{{$id}}"
           data-model="{{$model}}"
           @if (isset($active) && $active == 1) checked @endif
    />
</div>
