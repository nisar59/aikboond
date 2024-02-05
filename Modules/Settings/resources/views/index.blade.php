@extends('layouts.template')
@section('title')
Settings
@endsection
@section('content')
        <section class="section">
          <div class="section-body">
            
            @php
            $sett=$data['settings'];

            $logo=url('/img/images.png');
            $favicon=url('/img/images.png');
            $footer_logo=url('/img/images.png');

            if($sett->portal_logo!='' AND file_exists(public_path('img/settings/'.$sett->portal_logo))){
              $logo=url('/img/settings/'.$sett->portal_logo);
            }

            if($sett->portal_favicon!='' AND file_exists(public_path('img/settings/'.$sett->portal_favicon))){
              $favicon=url('/img/settings/'.$sett->portal_favicon);
            }

            if($sett->footer_logo!='' AND file_exists(public_path('img/settings/'.$sett->footer_logo))){
              $footer_logo=url('/img/settings/'.$sett->footer_logo);
            }
            @endphp


            <form action="{{url('/settings/store')}}" method="post" enctype="multipart/form-data">
              @csrf  
            <div class="row">  
              <div class="col-12 col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Panel Settings</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                    <div class="form-group col-md-12">
                      <label>Panel Name</label>
                      <input type="text" class="form-control" name="panel_name" value="{{$sett->portal_name}}" placeholder="Panel Name">
                    </div>
                    <div class="form-group col-md-12">
                      <label>Panel Email</label>
                      <input type="email" class="form-control" name="panel_email" value="{{$sett->portal_email}}" placeholder="Panel Email">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-10">
                      <label>Panel Logo</label>
                      <input type="file" class="form-control" name="panel_logo" id="panel_logo" width="100%" height="100%" onchange="document.getElementById('logo-display').src = window.URL.createObjectURL(this.files[0])">
                    </div>
                    <div class="form-group col-md-2">
                      <img src="{{$logo}}" class="image-display" id="logo-display" width="100" height="100">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-10">
                      <label>Panel Favicon</label>
                      <input type="file" class="form-control" name="panel_favicon" id="panel_favicon" onchange="document.getElementById('favicon-display').src = window.URL.createObjectURL(this.files[0])">
                    </div>
                    <div class="form-group col-md-2">
                      <img src="{{$favicon}}" class="image-display" id="favicon-display" width="100" height="100">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-10">
                      <label>Footer Logo</label>
                      <input type="file" value="{{$footer_logo}}" class="form-control" name="footer_logo" onchange="document.getElementById('footer-display').src = window.URL.createObjectURL(this.files[0])">
                    </div>
                      <div class="form-group col-md-2">
                      <img src="{{$footer_logo}}" class="image-display" id="footer-display" width="100" height="100">
                    </div>
                  </div>
                    <div class="row">
                    <div class="form-group col-md-12">
                      <label>Footer Text</label>
                      <input type="text" class="form-control" name="footer_text" value="{{$sett->footer_text}}" placeholder="Footer Text">
                    </div>
                    <div class="form-group col-md-12">
                      <label>SMS API</label>
                      <input type="text" class="form-control" name="sms_api" value="{{$sett->sms_api}}" placeholder="SMS API">
                    </div>
                    <div class="form-group col-md-12">
                      <label>SMS API Secret</label>
                      <input type="text" class="form-control" name="sms_api_secret" value="{{$sett->sms_api_secret}}" placeholder="SMS API Secret">
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

@endsection
