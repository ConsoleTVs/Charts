let {{ $chart->id }}_rendered = false;
let {{ $chart->id }}_load = function () {
    if (document.getElementById("{{ $chart->id }}") && !{{ $chart->id }}_rendered) {
        @if ($chart->api_url)
            jQuery.ajax("{{ $chart->api_url }}", {
                    method: '{{ $chart->api_type }}',
                    @if (!empty($chart->api_var) )
                        data: {{ $chart->api_var }},
                    @endif
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
            .done(function (response) {
                var data = jQuery.parseJSON(response);
                {{ $chart->id }}_create(data);
            });
        @else
            {{ $chart->id }}_create({!! $chart->formatDatasets() !!})
        @endif
    }
};
window.addEventListener("load", {{ $chart->id }}_load);
document.addEventListener("turbolinks:load", {{ $chart->id }}_load);