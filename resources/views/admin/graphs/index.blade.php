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
          
          var orderDataFormatted = orderData.map(order => ({
              id: order.id,
              timeTaken: order.time_taken,
              createdAt: order.created_at
          }));

          var orderIds = orderDataFormatted.map(order => order.id);
          var createdAt = orderDataFormatted.map(order => order.createdAt);
          var timeTaken = orderDataFormatted.map(order => order.timeTaken);

          var myChart = new Chart(ctx, {
              type: 'bar',
              data: {
                  labels: createdAt,
                  datasets: [{
                      label: 'Order ID',
                      data: orderIds,
                      backgroundColor: 'rgba(255, 99, 132, 0.2)',
                      borderColor: 'rgba(255, 99, 132, 1)',
                      borderWidth: 1
                  }, {
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