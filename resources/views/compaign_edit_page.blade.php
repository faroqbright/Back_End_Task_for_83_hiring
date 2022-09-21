@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Advertising Compaigns</span>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{url('edit_compaign')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" value="{{$compaign->name}}" class="form-control" id="name">
                                    <input type="hidden" name="id" value="{{$compaign->id}}" class="form-control" id="id">
                                    @error('name')
                                        <div class="form-text text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" onfocus="this.showPicker()" name="start_date" id="start_date" value="{{$compaign->start_date}}">
                                    @error('start_date')
                                        <div class="form-text text-danger">{{$message}}</div>
                                    @enderror
                                  </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control" onfocus="this.showPicker()" name="end_date" id="end_date" value="{{$compaign->end_date}}">
                                    @error('end_date')
                                        <div class="form-text text-danger">{{$message}}</div>
                                    @enderror
                                  </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="daily_budget" class="form-label">Daily Budget</label>
                                    <input type="number" class="form-control" name="daily_budget" id="daily_budget" value="{{$compaign->daily_budget}}">
                                    @error('daily_budget')
                                        <div class="form-text text-danger">{{$message}}</div>
                                    @enderror
                                  </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="total" class="form-label">Total</label>
                                    <input type="number" class="form-control" name="total" id="total" value="{{$compaign->total}}">
                                    @error('total')
                                        <div class="form-text text-danger">{{$message}}</div>
                                    @enderror
                                  </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="images" class="form-label">Upload images</label>
                                    <input type="file" class="form-control" name="images[]" multiple id="images">
                                    @error('images')
                                        <div class="form-text text-danger">{{$message}}</div>
                                    @enderror
                                  </div>
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{url('home')}}" class="btn btn-success">Back To List</a>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
