@extends('layouts.frontend.app')
@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{url('/profile')}}" class="btn btn-primary me-2">Profile</a>
    <a href= "{{url('/withdraw')}}"class="btn btn-success">Withdraw</a>
  </div>

  <div class="col-lg-8  col-xl-8 col-md-8 mx-auto">
    <div class="card">
        <div class="card-header">
            <h3>Deposit List [{{Auth::user()->account_type}}] </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table id="myTable" class="display table table-striped table-bordered">
                <thead>
                  <tr >
                    <th>Serial</th>
                    <th>Deposit Money</th>
                    <th>Deposit time</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse($deposit_list as $key=>$deposit)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$deposit->amount}}</td>
                        <td>{{$deposit->created_at->format('d-m-y')}}</td>
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
