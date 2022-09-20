<div class="modal fade" id="{{$id}}" role="dialog" aria-labelledby="label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="label">{{$tittle}}</h4>
            </div>
            <div class="modal-body">{{$body}}</div>
            @if (!empty($footer) >=1)
                <div class="modal-footer">{{$footer}}</div>
            @endif
        </div>
    </div>
</div>