<html>
<head>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>

  <script type="text/javascript">
    google.load("visualization", '1', {packages:['corechart']});
    google.setOnLoadCallback(drawChart);
    function drawChart() {

      var data = google.visualization.arrayToDataTable([
        ['Element', 'Density', { role: 'style' }],
        ['Copper', 8.94, '#600600', ],
        ['Silver', 10.49, '#600600'],
        ['Gold', 19.30, '#600600'],
        ['Platinum', 21.45, '#600600' ]
      ]);

      var options = {
        title: "Density of Precious Metals, in g/cm^3",
        bar: {groupWidth: '95%'},
        legend: 'none',
      };

      var chart_div = document.getElementById('chart_div');
      var chart = new google.visualization.ColumnChart(chart_div);

      // Wait for the chart to finish drawing before calling the getImageURI() method.
      google.visualization.events.addListener(chart, 'ready', function () {
        chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
        console.log(chart_div.innerHTML);
      });

      chart.draw(data, options);

  }
  </script>

<div id='chart_div'></div>
