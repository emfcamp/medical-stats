@extends('layouts.stats')

@section('content')
  <div class="row">
    
    <div class="col-md-12">
      <div id="graph" style="width: 100%, height: 500px"></div>
    </div>
  </div>
@endsection

@section('graph-data')

var chartOptions = {
  chart: {
    type: 'column',
    zoomType: 'x'
  },

  title: {
    text: '{{ $title }}'
  },

  xAxis: {
    dateTimeLabelFormats: {
      'day': '%a'
    },
    type: 'datetime',
    tickInterval: 3600 * 1000,
    min: {{ $start }},
    max: {{ $end }},
},

  yAxis: {
    allowDecimals: false,
    min: 0,
    title: {
      text: 'Incidents'
    }
  },

  tooltip: {
    formatter: function () {
      var label = '<b>' + moment(this.x).format("ddd HH:mm") + '</b><br/>' +
      this.series.name + ': ' + this.y + '<br/>';
      if (typeof this.point.stackTotal != "undefined") {
        label += 'Stack: ' + this.point.stackTotal;
      }
      return label
    }
  },

  plotOptions: {
    column: {
      stacking: 'normal'
    }
  },
  series: @json($series)
  };
@endsection