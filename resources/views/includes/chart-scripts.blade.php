@inject('accesscontroller', '\App\Http\Controllers\AccessController')

@if(isset($report) && $accesscontroller->checkAccess(Auth::user()->id, 'reports'))
{{-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> --}}
<script src="{{ asset('js/google.chart.loader.js') }}"></script>
<script>
  google.charts.load('current', {'packages':['bar']});

  function drawBarChart(ctitle, csubtitle, cdata) {
    var data = google.visualization.arrayToDataTable(cdata);

    var options = {
      chart: {
        title: ctitle,
        subtitle: csubtitle,
      },
      animation: {startup: true, duration: 5000, easing: 'linear',}
    };
    var chart = new google.charts.Bar(document.getElementById('barChart'));

    chart.draw(data, google.charts.Bar.convertOptions(options));
  }


  $(document).ready(function () {

    // load farm
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
      $('#report_sub_location').hide();
      
      $('#report_location_name').text('')
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
      var id = $(this).val();
      if(id == '') {
        $('#report_location_name').text('');
        return ;
      }
      else if (id != '') {
        if(has_sublocation == 1) {
          $('#report_sub_location').show();
        
          $('#report_location_name').text('')
          // load sublocation
          // /farm/sublocation/get/{id}
          $.ajax({
            url: "/farm/sublocation/get/" + id,
            dataType: "json",
            async: false,
            success: function(data) {
              // console.log(data);
              $('#report_sub_location option').remove();
              $('#report_sub_location').append('<option value="">Select Sub Location</option>');
              $.each(data, function(k, v) {
                $('#report_sub_location').append('<option value="'+ data[k]['id'] +'">'+ data[k]['sub_location_name'] +'</option>');
              });
            }
          }); 
          return false;
        }
        else {
          $('#report_sub_location').hide();
          // alert('load data in chart')
          var location_name = $("#report_location option:selected").text();
          var farm_name = $("#report_farm option:selected").text();
          // load data for location with id
          $.ajax({
            url: "/daily/loc/compliance/" + id,
            dataType: "json",
            async: false,
            success: function(data) {
              // console.log(data);
              google.charts.setOnLoadCallback(function() {
                var param1 = farm_name + ' - ' + location_name
                var param2 = '';
                // var cdata = [
                //   ['Location', 'Non-Compliant', 'Compliant'],
                //   ['2014', 1000, 400],
                //   ['2015', 1170, 460],
                //   ['2016', 660, 1120],
                //   ['2017', 1030, 540]
                // ];
                cdata = data;
                drawBarChart(param1, param2, cdata);
              });
            }
          }); 
          
          $('#report_location_name').text(farm_name + ' - ' + location_name)
          return ;

        }
      }
    });


    $('#report_sub_location').change(function () {
      var id = $(this).val();
      $('#report_location_name').text('');
      var location_name = $("#report_location option:selected").text();
      var farm_name = $("#report_farm option:selected").text();
      var sub_loc_name = $("#report_sub_location option:selected").text();
      
      if(id == '') {
        return ;
      }
      else if(id != '') {
        // load data
        google.charts.setOnLoadCallback(function() {
          var param1 = farm_name + ' - ' + location_name + ' - ' + sub_loc_name;
          var param2 = '';
          var cdata = [
            ['Location', 'Non-Compliant', 'Compliant'],
            ['2014', 1000, 400],
            ['2015', 1170, 460],
            ['2016', 660, 1120],
            ['2017', 1030, 540]
          ];
          drawBarChart(param1, param2, cdata);
        });

        $('#report_location_name').text(farm_name + ' - ' + location_name + ' - ' + sub_loc_name);
        return false;
      }
    });
  });
</script>

@endif