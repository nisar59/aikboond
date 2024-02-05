@extends('layouts.template')
@section('title')
Registered Peoples
@endsection
@section('content')
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="col-md-6">Registered Peoples</h4>
                    <div class="col-md-6 text-right">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" id="users" style="width:100%;">
                        <thead>
                          <tr>
                            <th>Phone</th>
                            <th>OTP</th>
                            <!-- <th>Action</th> -->
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
  var roles_table = $('#users').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{url('registered-people')}}",
              buttons:[],
              columns: [
                {data: 'phone', name: 'phone'},
                {data: 'otp', name: 'otp'},
               /* {data: 'action', name: 'action', orderable: false, searchable: false},*/
            ]
          });
      });
</script>
@endsection
