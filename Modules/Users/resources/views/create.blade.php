@extends('layouts.template')
@section('title')
Users
@endsection
@section('content')
        <section class="section">
          <div class="section-body">
            
            <form action="{{url('/users/store')}}" method="post" enctype="multipart/form-data">
              @csrf  
            <div class="row">  
              <div class="col-12 col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Add Users</h4>
                  </div>
                  <div class="card-body">

                  <div class="row">
                    <input type="file"  hidden class="form-control" name="image" id="image" onchange="document.getElementById('image-display').src = window.URL.createObjectURL(this.files[0])">

                    <label for="image" class="form-group col-md-12 text-center">
                      <img src="{{url('/img/images.png')}}" class="image-display rounded-circle" id="image-display" width="100" height="100">
                    </label>
                  </div>


                    <div class="row">
                    <div class="form-group col-md-4">
                      <label>Name</label>
                      <input type="text" class="form-control" name="name" placeholder="Name">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Email</label>
                      <input type="email" class="form-control" name="email" placeholder="Email">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Phone No</label>
                      <input type="phone" class="form-control" name="phone" placeholder="Phone No">
                    </div>

                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>Password</label>
                      <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <div class="form-group col-md-6">
                      <label>Role</label>
                      <select class="form-control" name="role">
                        @foreach($data['role'] as $role)
                        <option value="{{$role->name}}">{{$role->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="row">
      
                <div class="form-group col-md-6">
                  <input type="text" hidden name="country_id" value="167">
                  <label for="">States</label>
                  <select name="state_id" id="state-dropdown" class="form-control select2">
                    <option value="">-- Select State --</option>
                    @foreach($data['states'] as $state)
                    <option @if(old('state_id')==$state->id) selected @endif value="{{$state->id}}">{{$state->name}}</option>
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
                    <label for="">Union Councils Name</label>
                    <select id="union-dropdown" class="form-control select2" name="ucouncil_id">
                      <option value="">-- Select Council Name --</option>
                    </select>
                  </div>
                </div>
                
                <div class="form-group col-md-6">
                  <label>Address</label>
                  <input type="text" value="{{old('address')}}" class="form-control" name="address" placeholder="Enter Address">
                </div>

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
  if(value.id=="{{old('city_id')}}"){
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


    $('#union-dropdown').html('<option value="">-- Select Council Name --</option>');
    });
    /*-----------------area listing-----------*/
    $(document).on('change','#city-dropdown', function() {
    var city_id = this.value;
    $("#union-dropdown").html('');
    $.ajax({
    url: "{{url('union-council')}}",
    type: "POST",
    data: {
    city_id: city_id,
    _token: '{{csrf_token()}}'
    },
    dataType: 'json',
    success: function(result) {
    $('#union-dropdown').html('<option value="">Select Council Name</option>');
    $.each(result.unioncouncil, function(key, value) {
    var selected='';
    if(value.id=="{{old('city_id')}}"){
    selected='selected';
    }
    $("#union-dropdown").append('<option '+selected+' value="' + value.id + '">' + value.name + '</option>');
    });
    setTimeout(function () {
    $("#union-dropdown").trigger('change');
    },500)
    },
    error: function(err) {
    error(err.statusText);
    }
    });
   
    });
  
  });
  </script>
  @endsection
