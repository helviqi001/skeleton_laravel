<div class="form-group has-feedback">
    @if (!empty($label))
        <label for="{{$name}}">{{$label}}</label>
    @endif
    <select name="{{$name}}" class="form-control @if(!empty($select2)){{$select2}}@endif" @if(!empty($multiple)) multiple="multiple" @endif @if (!empty($attrib)){{$attrib}}@endif style="width: 100%;">
        @if(empty($select2))
            <option value="">@if(!empty($placeholder)) --{{$placeholder}}-- @else -- Select One -- @endif </option>
            @if(!empty($enum))
                @foreach($enum as $data)
                    <option value="{{$data}}" @if(!empty($selected) && $data==$selected) selected @endif> {{$data}} </option>
                @endforeach
            @else
                @foreach($datas as $data)
                    <option value="{{$data->$datavalue}}" @if(!empty($selected) && $data->$datavalue==$selected) selected @endif> {{$data->$dataname}} </option>
                @endforeach
            @endif
        @else
            @if(!empty($multiple))
                @foreach($selected as $select)
                    <option value="{{$select->$datavalue}}" selected > {{$select->$dataname}} </option>
                @endforeach
            @else
                @if(!empty($selected))
                    <option value="{{$selected[0]}}" text="{{$selected[1]}}" selected>{{$selected[1]}}</option>
                @endif
            @endif
        @endif
    </select>
</div>