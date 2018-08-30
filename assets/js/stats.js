$(document).ready(function() {
	$('.datepicker').datetimepicker();

	if (typeof chartOptions != "undefined") {
		Highcharts.chart('graph', chartOptions);
	}
});