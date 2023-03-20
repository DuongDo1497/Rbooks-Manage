<script type="text/javascript">
  var data =  @json($performance_efficiency);

  var x_axis = ['x', ];
  var y_axis = ['Doanh thu thực tế', ];

  // tạo data cho biểu đồ theo mẫu dưới đây
  // var data_chart = [
  //       ['x', '2014-01-01', '2014-01-02', '2014-01-03', '2014-01-04', '2014-01-05', '2014-01-6', '2014-01-7', '2014-01-8', '2014-01-9', '2014-01-10'],
  //       ['Doanh thu thực tế', 16, 13, 15, 22, 33, 20, 15, 18, 19, 10]
  // ];
  var max_cost = 0;
  for(var item of data.days) {
    x_axis.push(item);
    var value = 0;
    if(data.data[item]) {
      value = data.data[item];
    }
    y_axis.push(value);
    max_cost = value > max_cost ? value : max_cost;
  }

  var data_chart = [x_axis, y_axis];

  var chart = c3.generate({
    bindto: '#chart',
    data: {
      type: 'bar',
      x: 'x',
      y: 'y',
      columns: data_chart
    },
    bar: {
        width: {
            ratio: 0.2
        }
    },
    legend: {
      hide: true
    },
    axis: {
      x: {
        type: 'timeseries',
        tick: {
          format: "%d/%m"
        }
      },
      y: {
        max: max_cost,
        label: 'đồng',
        tick: {
          format: function (d) {
            return d.toLocaleString();
          }
        }
      }
    },
  });
</script>
