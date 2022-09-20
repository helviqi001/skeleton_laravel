@if(empty($checked))
    @php($checked = false)
@endif
@if(empty($disabled))
    @php($disabled = false )
@endif
<div class="form-group">
    <div class="checkbox">
        <label>
            <input type="checkbox" name="{{$name}}" value="1" @if ($checked == true) checked @endif @if ($disabled == true) disabled @endif>
            {{ $label }}
        </label>
    </div>
</div>