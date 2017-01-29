<script type="text/javascript">
    $(function () {
        var {{ $model->id }} = new Highcharts.Chart({
            chart: {
                type: 'area',
                renderTo:  "{{ $model->id }}",
                @include('charts::_partials.dimension.js2')
            },
            @if($model->title)
			title: {
                text:  "{{ $model->title }}",
            	x: -20 //center
            },
            @endif
            @if(!$model->credits)
            credits: {
            	enabled: false
            },
            @endif    
            xAxis: {                
            	@if($model->xTickInterval)
            	tickInterval: {{ $model->xTickInterval }},
            	@endif            	
            	labels: {
                    formatter: function () {
                        return this.value;
                    }
                },
                plotLines: [{
                    value: 0,
                    height: 0.5,
                    width: 1,
                    color: '#808080'
                }]
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [
                @for ($i = 0; $i < count($model->datasets); $i++)
                    {
                        name:  "{{ $model->datasets[$i]['label'] }}",
                        @if($model->colors && count($model->colors) > $i)
                            color: "{{ $model->colors[$i] }}",
                        @endif
 		                	@if(!$model->datasets[$i]['fillColor'])
 		            			fillColor: {},
 		            		@endif
						data: [
                        	@foreach($model->datasets[$i]['values'] as $dta)
                            	{{ $dta }},
                            @endforeach
                       ]
                    },
                @endfor
            ]
        })
    });
</script>

@if(!$model->customId)
    @include('charts::_partials.container.div')
@endif
