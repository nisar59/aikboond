@extends('layouts.template')
@section('title')
Dashboard
@endsection
@section('content')
<section class="section">
  <div class="section-body">
    <div class="row ">
      <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-6">
        <div class="card" style="height: 130px;">
          <div class="card-statistic-4">
            <div class="align-items-center justify-content-between">
              <div class="row ">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3 m-auto">
                  <div class="card-content">
                    <h5 class="font-15">Doctors</h5>
                    <h2 class="mb-3 font-18">0</h2>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 m-auto">
                  <div class="banner-img">
                    <img src="{{asset('public/icons/maki_doctor.svg')}}" alt="" class="w-50">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-6">
        <div class="card" style="height: 130px;">
          <div class="card-statistic-4">
            <div class="align-items-center justify-content-between">
              <div class="row ">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3 m-auto">
                  <div class="card-content">
                    <h5 class="font-15"> Blood Donors</h5>
                    <h2 class="mb-3 font-18">0</h2>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 m-auto">
                  <div class="banner-img">
                    <img src="{{asset('public/icons/homepagedonate.svg')}}" alt=""  class="w-50">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="card" style="height: 130px;">
          <div class="card-statistic-4">
            <div class="align-items-center justify-content-between">
              <div class="row ">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3 m-auto">
                  <div class="card-content">
                    <h5 class="font-15">Register People</h5>
                    <h2 class="mb-3 font-18">0</h2>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 m-auto">
                  <div class="banner-img">
                    <img src="{{asset('public/icons/homepageaboutus.svg')}}" alt=""  class="w-50">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-md-6 col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4>Statistics</h4>
        </div>
        <div class="card-body">
          <canvas id="statistics"></canvas>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('js')
<script>
$(document).ready(function() {
var ctx = document.getElementById("statistics").getContext('2d');
var myChart = new Chart(ctx, {
type: 'pie',
data: {
labels: [
'Doctors',
'Blood Donors',
'Registered People',
],
},
options: {
responsive: true,
legend: {
position: 'bottom',
},
}
});
});
</script>
@endsection