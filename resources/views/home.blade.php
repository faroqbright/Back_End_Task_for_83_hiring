@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Advertising Compaigns</span>
                    <a href="{{url('add_compaign_page')}}" class="btn btn-success btn-sm">Add Compaign</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- {{ __('You are logged in!') }} --}}
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Daily Budget</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($compaigns as $compaign)
                                <tr>
                                    <td>
                                        {{$compaign->name}}
                                    </td>
                                    <td>
                                        {{$compaign->start_date}}
                                    </td>
                                    <td>
                                        {{$compaign->end_date}}
                                    </td>
                                    <td>
                                        {{$compaign->daily_budget}}
                                    </td>
                                    <td>
                                        {{$compaign->total}}
                                    </td>
                                    <td>
                                        <a href="{{url('compaign_edit_page').'/'. $compaign->id}}" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="javascript:;" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewCompaign{{$compaign->id}}">View</a>
                                        <a href="{{url('delete_compaign'). '/' .$compaign->id}}" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>


                                <!-- Modal -->
<div class="modal fade" id="viewCompaign{{$compaign->id}}">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{$compaign->name}}'s Compaign images</h5></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-0">
            <div id="carouselControls{{$compaign->id}}" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                  @foreach ($compaign->images as $image)
                  <div class="carousel-item active">
                    <img src="{{asset('compaign-images/'.$image->file)}}" style="height:400px;" class="w-100">
                  </div>
                  @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselControls{{$compaign->id}}" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselControls{{$compaign->id}}" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
        </div>
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> --}}
      </div>
    </div>
  </div>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
