@extends('layouts.template')
@section('title')
Addresses And Towns
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
                  <div class="col-md-6 form-group">
                    <label for="">State</label>
                    <select class="form-control filters" name="state_id">
                      <option value="">-- Select State --</option>
                      @foreach($states as $state)
                      <option value="{{$state->id}}">{{$state->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="">City</label>
                    <select class="form-control filters" name="city_id">
                      <option value="">-- Select City --</option>
                      @foreach($cities as $city)
                      <option value="{{$city->id}}">{{$city->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="">Area</label>
                    <select class="form-control filters" name="area_id">
                      <option value="">-- Select Area --</option>
                      @foreach($areas as $area)
                      <option value="{{$area->id}}">{{$area->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control filters" name="name" placeholder="Name">
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
            <h4 class="col-md-6">Addresses And Towns</h4>
            <div class="col-md-6 text-right">
              <a href="{{url('addresses-and-towns/create')}}" class="btn btn-success">+</a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover table-sm" id="addresses_and_towns" style="width:100%;">
                <thead>
                  <tr>
                    <th>Country Name</th>
                    <th>State Name</th>
                    <th>City Name</th>
                    <th>Area</th>
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
  data_table = $('#addresses_and_towns').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url:"{{url('addresses-and-towns')}}",
        data:data,
        },
      buttons:[],
      buttons:[],
              columns: [
                {data: 'country_id', name: 'country_id',class:'text-center'},
                {data: 'state_id', name: 'state_id',class:'text-center'},
                {data: 'city_id', name: 'city_id',class:'text-center'},
                {data: 'area_id', name: 'area_id',class:'text-center'},
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action', orderable: false, searchable: false,class:'text-center'},
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
