@extends('layouts.template')
@section('title')
Addresses And Towns
@endsection
@section('content')
<section class="section">
  <div class="section-body">
    
    <form action="{{url('addresses-and-towns/update/'.$addresses_and_towns->id)}}" method="post">
      @csrf
      <div class="row">
        <div class="col-12 col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>Addresses And Towns</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="">States</label>
                  <select name="state_id" id="state-dropdown" class="form-control select2">
                    <option value="">-- Select State --</option>
                    @foreach($states as $state)
                    <option value="{{$state->id}}"{{ $state->id == $addresses_and_towns->state_id ? 'selected' : ''}}>{{$state->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">City</label>
                    <select id="city-dropdown" class="form-control select2" name="city_id">
                      <option value="">-- Select City --</option>
                      @foreach($cities as $city)
                      <option value="{{$city->id}}"{{ $city->id == $addresses_and_towns->city_id ? 'selected' : ''}}>{{$city->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Area Name</label>
                    <select id="area-dropdown" class="form-control select2" name="area_id">
                      <option value="">-- Select Area --</option>
                      @foreach($areas as $area)
                      <option value="{{$area->id}}"{{ $area->id == $addresses_and_towns->area_id ? 'selected' : ''}}>{{$area->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label>Name</label>
                  <input type="text" class="form-control" name="name" value="{{$addresses_and_towns->name}}" placeholder="Enter Name">
                </div>
              </div>
              <div class="card-footer text-right">
                <button class="btn btn-primary mr-1" type="submit">Submit</button>
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
        }
        });
        });
});
</script>
@endsection