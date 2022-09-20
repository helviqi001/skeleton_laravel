@if(!empty($responsive))
    @php($responsive = 'table-responsive')
@else
    @php($responsive = '')
@endif


<div class="box box-primary @if(!empty($collapsed)) collapsed-box @endif">
    <div class="box-header with-border">
        <h3 class ="box-title"> {{ $title }} </h3>
        @if(!empty($boxTool))
            <div class="box-tools">
                {{ $boxTool }}
            </div>
        @endif
    </div>
    <div class="box-body {{$padding ?? 'no-padding'}} table-responsive">
        {{ $body }}
    </div>
    @if (strlen($footer) >= 1)
        <div class="box-footer">
            {{ $footer }}
        </div>
    @endif
    @if(!empty($loading))
        <div class="overlay centers">
            <i class="glyphicon glyphicon-refresh fa-spin"></i>
        </div>
    @endif
</div>
