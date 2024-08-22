@extends('layouts.template')
@section('title')
Union councils
@endsection
@section('content')
<section class="section">
  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card card-primary" id="filters-container">
          <div class="card-header bg-white" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">
            <h4><i class="fas fa-filter"></i> Filters</h4>
          </div>
          <div class="card-body p-0">
            <div class="collapse multi-collapse" id="multiCollapseExample2" data-bs-parent="#filters-container">
              <div class="p-3 accordion-body">
                <div class="row">
                  
                  <div class="col-md-4 form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control filters" name="name" placeholder="Name">
                  </div>
                  <div class="col-md-4 form-group">
                    <label for="">State</label>
                    <select class="form-control filters" name="state_id">
                      <option value="">-- Select State --</option>
                      @foreach($states as $state)
                      <option value="{{$state->id}}">{{$state->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-4 form-group">
                    <label for="">City</label>
                    <select class="form-control filters" name="city_id">
                      <option value="">-- Select City --</option>
                      @foreach($cities as $city)
                      <option value="{{$city->id}}">{{$city->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="col-md-6">Union councils</h4>
            <div class="col-md-5 text-right">
              <a href="{{url('/union-councils/create')}}" class="btn btn-success">+</a>
            </div>
            <div class="col-md-1 text-right">
              <div class="col-md-3 text-right">
                <a class="btn btn-primary" href="{{url('/union-councils/import')}}"><i class="fas fa-cloud-upload-alt"></i></a>
              </div>            
            </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-sm table-bordered table-striped table-hover table-sm" id="union-councils" style="width:100%;">
                  <thead>
                    <tr>
                      <th>State</th>
                      <th>City Name</th>
                      <th>Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
@section('js')
<script type="text/javascript">
//Roles table
$(document).ready( function(){
  var data_table;
  function DataTableInit(data={}) {
  data_table = $('#union-councils').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url:"{{url('/union-councils')}}",
        data:data,
        },
      buttons:[],
      buttons:[],
              columns: [                
                {data: 'state_id', name: 'state_id'},
                {data: 'city_id', name: 'city_id'},
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
  });
}

DataTableInit();


$(document).on('change', '.filters', function () {
var data={};
$('.filters').each(function() {
data[$(this).attr('name')]=$(this).val();
});
data_table.destroy();
DataTableInit(data);
});


});
</script>
@endsection
