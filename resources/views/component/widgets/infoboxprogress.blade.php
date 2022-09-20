<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
    <div class="info-box {{$color}}">
        <span class="info-box-icon"><i class="fas fa-clock"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">{{ $name }}</span>
            <span class="info-box-number">{{ $count }}</span>
            <div class="progress">
                <div class="progress-bar" style="width: {{ $progress }}%"></div>
            </div>
            <span class="progress-description"> {{$description}} </span>
        </div>
    </div>
</div>
