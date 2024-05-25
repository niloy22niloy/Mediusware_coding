<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />

    <style>
      body {
        background-color: #f8f9fa;
      }
      #myTable tr th{
        text-align:center;
       
    }
    #myTable tr td{
        text-align:center;
    }
      table.dataTable {
        width: 100%;
        background-color: #fff;
        border-collapse: separate;
        border-spacing: 0;
      }
      table.dataTable thead th {
        background-color: #007bff;
        color: white;
      }
      table.dataTable tbody tr {
        background-color: #e9ecef;
      }
      table.dataTable tbody tr:nth-child(odd) {
        background-color: #f8f9fa;
      }
      table.dataTable tbody tr:hover {
        background-color: #dee2e6;
      }
    </style>

    <title>Beautiful DataTable</title>
  </head>
  <body>

    <div class="container mt-5">
        @yield('content')
    
    </div>

    <!-- jQuery first, then Bootstrap JS, then DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>

    <script>
      $(document).ready(function() {
        $('#myTable').DataTable();
      });
    </script>
  </body>
</html>
