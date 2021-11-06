@inject('accesscontroller', '\App\Http\Controllers\AccessController')

@if(isset($report) && $accesscontroller->checkAccess(Auth::user()->id, 'reports'))
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.1.1/Chart.min.js"></script> --}}
<script src="{{ asset('js/chart.js') }}"></script>
<script>

  // load farm
  $(document).ready(function () {
    $.ajax({
      url: "{{ route('report.get.farms') }}",
      dataType: "json",
      async: false,
      success: function(data) {
        $.each(data, function(k, v) {
          $('#report_farm').append('<option value="'+ data[k]['id'] +'">'+ data[k]['code'] +'</option>');
        });
      }
    });

    $('#report_farm').change(function () {
      var id = $(this).val();
      $.ajax({
        url: "/farm/location/get/" + id,
        dataType: "json",
        async: false,
        success: function(data) {
          // console.log(data);
          $('#report_location option').remove();
          $('#report_location').append('<option value="">Select Location</option>');
          $.each(data, function(k, v) {
            $('#report_location').append('<option value="'+ data[k]['id'] +'" data-id="'+ data[k]['has_sublocation'] +'">'+ data[k]['location_name'] +'</option>');
          });
        }
      });      
    });

    $('#report_location').change(function() {
      var has_sublocation = $(this).find(':selected').data('id');
      if(has_sublocation == 1) {
        $('#report_sub_location').show();
      }
      else {
        alert('load data in chart')
      }
    });
  });

  // after selecting farm-load location-lock farm field

  // after selecting locaton-load data if no sublocation - if it has sublocation, load sublocation-lock location
  
  // optional load 

  var jsonData1 = $.ajax({
      url: "{{ route('report.all.non.compliant') }}",
      dataType: "json",
      async: false
      }).responseJSON;

  var jsonData2 = $.ajax({
      url: "{{ route('report.all.compliant') }}",
      dataType: "json",
      async: false
      }).responseJSON;

  var areaChartData = {
    labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
    datasets: [
      {
        label               : 'Non-Compliance',
        fillColor           : 'rgba(221, 75, 57, 1)',
        strokeColor         : 'rgba(221, 75, 57, 1)',
        pointColor          : 'rgba(221, 75, 57, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        data                : jsonData1
      },
      {
        label               : 'Compliance',
        fillColor           : 'rgba(57,229,75,1)',
        strokeColor         : 'rgba(60,141,188,0.8)',
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : jsonData2
      }
    ]
  }

	//-------------
  //- BAR CHART -
  //-------------
  var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
  var barChart                         = new Chart(barChartCanvas)
  var barChartData                     = areaChartData
  barChartData.datasets[1].fillColor   = '#00a65a'
  barChartData.datasets[1].strokeColor = '#00a65a'
  barChartData.datasets[1].pointColor  = '#00a65a'
  var barChartOptions                  = {
    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
    scaleBeginAtZero        : true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines      : true,
    //String - Colour of the grid lines
    scaleGridLineColor      : 'rgba(0,0,0,.05)',
    //Number - Width of the grid lines
    scaleGridLineWidth      : 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines  : true,
    //Boolean - If there is a stroke on each bar
    barShowStroke           : true,
    //Number - Pixel width of the bar stroke
    barStrokeWidth          : 2,
    //Number - Spacing between each of the X value sets
    barValueSpacing         : 5,
    //Number - Spacing between data sets within X values
    barDatasetSpacing       : 1,
    //String - A legend template
    legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
    //Boolean - whether to make the chart responsive
    responsive              : true,
    maintainAspectRatio     : true
  }

  barChartOptions.datasetFill = false
  barChart.Bar(barChartData, barChartOptions)
</script>

@endif