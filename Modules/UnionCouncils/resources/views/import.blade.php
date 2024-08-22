@extends('layouts.template')
@section('title')
Union councils
@endsection
@section('content')
<section class="section">
  <div class="section-body">
    
    <form action="{{url('/union-councils/importUpload')}}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-12 col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>Import Excel</h4>
            </div>
            <div class="card-body pt-1">
              <div class="row">
                <div class="form-group col-md-12">
                  <label>Import Excel File</label>
                  <input type="file"class="form-control" name="file">
                </div>


              </div>
              <div class="card-footer text-right">
                <button class="btn btn-primary mr-1" type="submit">Submit</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
  @endsection
