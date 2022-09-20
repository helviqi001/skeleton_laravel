<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
    <div class="small-box {{$color}}">
        <div class="inner">
            <h3>{{ $count }}</h3>
            <p>{{ $name }}</p>
        </div>
        <div class="icon">
            <span class="{{$icon}}"></span>
        </div>
        @if (!empty($url))
            <a href="{{ $url }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        @endif
    </div>
</div>
