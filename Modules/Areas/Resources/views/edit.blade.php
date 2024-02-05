@extends('layouts.template')
@section('title')
Areas
@endsection
@section('content')
<section class="section">
  <div class="section-body">
    <form action="{{url('areas/update/'.$areas->id)}}" method="post">
      @csrf
      <div class="row">
        <div class="col-12 col-md-12">
          <div class="card card-primary">
            <div class="card-header bg-white">
              <h4>Areas</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">States</label>
                    <select id="state-dropdown" class="form-control" name="state_id">
                      <option value="">-- Select states --</option>
                      @foreach($states as $state)
                      <option value="{{$state->id}}"{{ $state->id == $areas->state_id ? 'selected' : ''}} >{{$state->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">City</label>
                    <select id="city-dropdown" class="form-control" name="city_id">
                    <option value="">-- Select City --</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" value="{{$areas->name}}" name="name" placeholder="Enter Name">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Nearest Place</label>
                    <input type="text" class="form-control" value="{{$areas->nearest_place}}" name="nearest_place" placeholder="Enter Nearest Place">
                  </div>
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
}, 50);
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
                           var sel='';
                           if(value.id=='{{$areas->city_id}}'){
                            sel='selected';
                           }
                            $("#city-dropdown").append('<option value="' + value
                                .id + '" '+sel+'>' + value.name + '</option>');
                        });

                        $('#city-dropdown').trigger('change');
                    },
                    error:function(err) {
                    error(err.statusText);
                    }
                });

            });
    
});
</script>
@endsection