@if($model->responsive && $model->height)
    height: {{ $model->height }},
    width: 100%,
@elseif($model->responsive)
    height="100%" width="100%"
@else
    @if($model->height)
        height: {{ $model->height }},
    @endif

    @if($model->width)
        width: {{ $model->width }},
    @endif
@endif
