@extends('layouts.stats')

@section('content')
  <h1>{{ $title }}</h1>
  <div class="row">
    <div class="col-md-12">
      <div id="graph" style="width: 100%, height: 500px"></div>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-md-6">
      <h2>Running Total, up to {{ $lastDate }}</h2>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Category</th>
            <th scope="col">{{ $current }}</th>
            <th scope="col">{{ $previous }}</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($counts as $category => $count)
          <tr>
            <td>{{ $category }}</td>
            <td>{{ $count['current'] }}</td>
            <td>{{ $count['previous'] }}</td>
          </tr>
        @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>Totals</th>
            <th>{{ $totals['current'] }}</th>
            <th>{{ $totals['previous'] }}</th>
          </tr>
        </tfoot>
      </table>
    </div>
  <div class="row">

@endsection

@section('graph-data')

var chartOptions = {
  chart: {
    type: 'column',
    zoomType: 'x'
  },

  title: {
    text: 'Incidents by hour'
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