@extends('layouts.template')
@section('title')
Blood Donor
@endsection
@section('content')
<section class="section">
  <div class="section-body">
    <form action="{{url('/union-councils/update', $union_councils->id)}}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-12 col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>Blood Donor</h4>
            </div>
            <div class="card-body pt-1">
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="">States</label>
                  <select name="state_id" id="state-dropdown" class="form-control select2">
                    <option value="">-- Select State --</option>
                    @foreach($states as $state)
                    <option @if(old('state_id' , $union_councils->state_id)==$state->id) selected @endif value="{{$state->id}}">{{$state->name}}</option>
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
                <div class="form-group col-md-12">
                  <label>Name</label>
                  <input type="text" value="{{old('name', $union_councils->name)}}" class="form-control" name="name" placeholder="Enter Address">
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
    setTimeout(function() {
        $("#state-dropdown").trigger('change');
    }, 500);
    // $(document).on('change','#country-dropdown', function() {
    //     var idCountry = this.value;
    //     $("#state-dropdown").html('');
    //     $.ajax({
    //         url: "{{url('states')}}",
    //         type: "POST",
    //         data: {
    //             country_id: idCountry,
    //             _token: '{{csrf_token()}}'
    //         },
    //         dataType: 'json',
    //         success: function(result) {
    //             console.log(result);
    //             $('#state-dropdown').html('<option value="">-- Select State --</option>');
    //             $.each(result.states, function(key, value) {
    //                 var selected=("{{old('state_id')}}"==value.id) ? 'selected' : '';

    //                 $("#state-dropdown").append('<option '+selected+' value="' + value
    //                     .id + '">' + value.name + '</option>');
    //             });
    //             $('#city-dropdown').html('<option value="">-- Select City --</option>');
    //         },
    //         error: function(err) {
    //             error(err.statusText);
    //         }
    //     });
    // });
    /*------------------city listing----------------*/
    $(document).on('change','#state-dropdown', function() {
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
            success: function(res) {
                $('#city-dropdown').html('<option value="">-- Select City --</option>');
                $.each(res.cities, function(key, value) {
                    var selected='';
                    if(value.id=="{{old('city_id', $union_councils->city_id)}}"){
                        selected='selected';
                    }
                    $("#city-dropdown").append('<option '+selected+' value="' + value
                        .id + '">' + value.name + '</option>');
                });
                setTimeout(function () {
                 $("#city-dropdown").trigger('change');
                }, 500)
            },
            error: function(err) {
                error(err.statusText);
            }
        });
        $('#area-dropdown').html('<option value="">-- Select Area --</option>');
    });
    /*-----------------area listing-----------*/
    $(document).on('change','#city-dropdown', function() {
        var city_id = this.value;
        $("#area-dropdown").html('');
        $.ajax({
            url: "{{url('areas')}}",
            type: "POST",
            data: {
                city_id: city_id,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result) {
                $('#area-dropdown').html('<option value="">Select Area</option>');
                $.each(result.areas, function(key, value) {
                    var selected='';
                    if(value.id=="{{old('area_id',$union_councils->area_id)}}"){
                        selected='selected';
                    }
                    $("#area-dropdown").append('<option '+selected+' value="' + value.id + '">' + value.name + '</option>');
                });

                setTimeout(function () {
                    $("#area-dropdown").trigger('change');
                },500)
            },
            error: function(err) {
                error(err.statusText);
            }
        });
        $('#address-dropdown').html('<option value="">-- Select Area --</option>');
    });
    /*Address*/
    $(document).on('change','#area-dropdown', function() {
        var area_id = this.value;
        $("#address-dropdown").html('');
        $.ajax({
            url: "{{url('address')}}",
            type: "POST",
            data: {
                area_id: area_id,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result) {
                $('#address-dropdown').html('<option value="">Select Address</option>');

                $.each(result.address, function(key, value) {                
                    var selected='';
                    if(value.id=="{{old('town_id', $union_councils->town_id)}}"){
                        selected='selected';
                    }
                    $("#address-dropdown").append('<option '+selected+' value="' + value.id + '">' + value.name + '</option>');
                });
            },
            error: function(err) {
                error(err.statusText);
            }
        });
    });





  });
  </script>
  @endsection