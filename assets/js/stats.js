$(document).ready(function() {
	$('.datepicker').datetimepicker();

	Highcharts.chart('graph', chartOptions);
});