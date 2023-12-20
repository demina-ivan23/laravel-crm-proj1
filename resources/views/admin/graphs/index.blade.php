@extends('layouts.app')

@section('content')
<div class="container">

  <div class="card mt-4">
<div class="card-body">
  <div class="d-flex">
    <h2>Prospects <small class="text-muted">Showing Graphs</small></h2>
  </div>
</div>
  </div>
  
  @if ($timeTakenArray)
  <canvas id="orderChart" width="400" height="200"></canvas>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var ctx = document.getElementById('orderChart').getContext('2d');

      var orderData = {!! json_encode($timeTakenArray) !!};

      // Sort the orderData array based on created_at
      orderData.sort((a, b) => (a.created_at > b.created_at) ? 1 : -1);

      var orderIds = orderData.map(order => order.order_id);
      var timeTaken = orderData.map(order => order.time_taken);

      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: orderIds,
          datasets: [{
            label: 'Time Taken (ms)',
            data: timeTaken,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    });
  </script>
@endif


</div>
@endsection