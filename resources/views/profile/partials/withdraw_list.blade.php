@extends('layouts.frontend.app')
@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{url('/profile')}}" class="btn btn-primary me-2">Profile</a>
    <a href= "{{url('/deposit')}}"class="btn btn-success">Deposit</a>
  </div>

  <div class="col-lg-8  col-xl-8 col-md-8 mx-auto">
    <div class="card">
        <div class="card-header">
            <h3>Withdraw List [{{Auth::user()->account_type}}] </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table id="myTable" class="display table table-striped table-bordered">
                <thead>
                  <tr >
                    <th>Serial</th>
                    <th>Withdraw Money</th>
                    <th>Withdraw Fee</th>
                    <th>Withdraw time</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse($withdraw_list as $key=>$withdraw)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$withdraw->amount}}</td>
                        <td>{{$withdraw->fee}}</td>
                        <td>{{$withdraw->created_at->format('d-m-Y')}}</td>
                      </tr>
                      @empty
                      Sorry No Data
                    @endforelse
                 
                 
                </tbody>
              </table>
            </div>
        </div>
    </div>
  </div>


@endsection
