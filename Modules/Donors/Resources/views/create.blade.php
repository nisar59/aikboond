@extends('layouts.template')
@section('title')
Blood Donor
@endsection
@section('content')
<section class="section">
  <div class="section-body">
    
    <form action="{{url('/donors/store')}}" method="post">
      @csrf
      <div class="row">
        <div class="col-12 col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>Blood Donor</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="form-group col-md-6">
                  <label>Name</label>
                  <input type="text" class="form-control" name="name" placeholder="Enter Name">
                </div>
                <div class="form-group col-md-6">
                  <label>Age</label>
                  <input type="number" class="form-control" min="0" name="age" placeholder="Enter Age">
                </div>

                <div class="form-group col-md-6">
                  <label>Contact No</label>
                  <input type="number" class="form-control" min="0" name="contact_no"  placeholder="Enter Contact No">
                </div>

                <div class="form-group col-md-2">
                  <label for="">Get Code</label><br>
                  <button type="button" class="btn btn-primary">Get Code</button>                  
                </div>

                <div class="form-group col-md-4">
                  <label>Verification Code</label>
                  <input type="number" class="form-control" min="0" name="contact_no"  placeholder="Enter Verification Code">
                </div>

                <input type="text" hidden name="country_id" value="167">
                <div class="form-group col-md-6">
                  <label for="">States</label>
                  <select name="state_id" id="state-dropdown" class="form-control select2">
                    <option value="">-- Select State --</option>
                    @foreach($states as $state)
                    <option value="{{$state->id}}">{{$state->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">City</label>
                    <select id="city-dropdown" class="form-control select2" name="city_id">
                      <option value="">-- Select City --</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Area Name</label>
                    <select id="area-dropdown" class="form-control select2" name="area_id">
                      <option value="">-- Select Area --</option>
                    </select>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label>Address</label>
                  <select id="address-dropdown" class="form-control select2" name="address_id">
                    <option value="">-- Select Address --</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>Blood Group</label>
                  <select name="blood_group" class="form-control">
                    <option value="">-- Select Blood Group --</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label>Last Donate Date</label>
                  <input type="date" class="form-control" name="last_donate_date" placeholder="Enter Last Donate Date">
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
  @section('js')
  <script type="text/javascript">
  $(document).ready(function() {
  $('#country-dropdown').on('change', function () {
  var idCountry = this.value;
  $("#state-dropdown").html('');
  $.ajax({
  url: "{{url('states')}}",
  type: "POST",
  data: {
  country_id: idCountry,
  _token: '{{csrf_token()}}'
  },
  dataType: 'json',
  success: function (result) {
  console.log(result);
  $('#state-dropdown').html('<option value="">-- Select State --</option>');
  $.each(result.states, function (key, value) {
  $("#state-dropdown").append('<option value="' + value
  .id + '">' + value.name + '</option>');
  });
  $('#city-dropdown').html('<option value="">-- Select City --</option>');
  },
  error:function(err) {
  error(err.statusText);
  }
  });
  });
  /*------------------city listing----------------*/
  $('#state-dropdown').on('change', function () {
  var idState = this.value;
  $("#city-dropdown").html('');
  $.ajax({
  url: "{{url('cities')}}",
  type: "POST",
  data: {
  state_id: idState,
  _token: '{{csrf_token()}}'
  },
  dataType: 'json',
  success: function (res) {
  $('#city-dropdown').html('<option value="">-- Select City --</option>');
  $.each(res.cities, function (key, value) {
  $("#city-dropdown").append('<option value="' + value
  .id + '">' + value.name + '</option>');
  });
  },
  error:function(err) {
  error(err.statusText);
  }
  });
  $('#area-dropdown').html('<option value="">-- Select Area --</option>');
  });
  /*-----------------area listing-----------*/
  $('#city-dropdown').on('change', function() {
  var city_id = this.value;
  $("#area-dropdown").html('');
  $.ajax({
  url:"{{url('areas')}}",
  type: "POST",
  data: {
  city_id: city_id,
  _token: '{{csrf_token()}}'
  },
  dataType : 'json',
  success: function(result){
  $('#area-dropdown').html('<option value="">Select Area</option>');
  $.each(result.areas,function(key,value){
  $("#area-dropdown").append('<option value="'+value.id+'">'+value.name+'</option>');
  });
  },
  error:function(err) {
  error(err.statusText);
  }
  });
  $('#address-dropdown').html('<option value="">-- Select Area --</option>');
  });
  /*Address*/
  $('#area-dropdown').on('change', function() {
  var area_id = this.value;
  $("#address-dropdown").html('');
  $.ajax({
  url:"{{url('address')}}",
  type: "POST",
  data: {
  area_id: area_id,
  _token: '{{csrf_token()}}'
  },
  dataType : 'json',
  success: function(result){
  $('#address-dropdown').html('<option value="">Select Address</option>');
  $.each(result.address,function(key,value){
  $("#address-dropdown").append('<option value="'+value.id+'">'+value.name+'</option>');
  });
  },
  error:function(err) {
  error(err.statusText);
  }
  });
  });
  });
  </script>
  @endsection