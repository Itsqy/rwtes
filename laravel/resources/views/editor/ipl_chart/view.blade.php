@extends('layouts.editor.template_chart')
@if(isset($data_header_ipl))
@section('title', 'Grafik Collection IPL') 
@else
@section('title', 'Grafik Collection IPL') 
@endif
@section('content')
<link href="https://canvasjs.com/assets/css/jquery-ui.1.11.2.min.css" rel="stylesheet" />


 <!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Grafik Collection IPL</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                  <li><a href="#">Chart</a></li>
                  <li class="active">Grafik Collection IPL</li> 
              </ol>
          </div>
          <!-- /.col-lg-12 -->
      </div>
      <div class="row">
       
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body"> 
                        {!! Form::open(array('route' => 'editor.ipl-chart.view', 'files' => 'true'))!!}
                            <div class="form-body"> 
                                <section>
                                <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                                <section> 
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>


<script>
window.onload = function () {

var options = {
	animationEnabled: true,
	title: {
		text: "Grafik Collection IPL Tahun 2016‐2019"
	},
	axisY: {
		title: "Growth Rate (in %)",
		suffix: "%",
		includeZero: false
	},
	axisX: {
		title: "Countries"
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.0#"%"",
		dataPoints: [
			{ label: "Januari", y: 10.09 },	
			{ label: "Februari", y: 9.40 },	
			{ label: "Maret", y: 8.50 },
			{ label: "April", y: 7.96 },	
			{ label: "Mei", y: 7.80 },
			{ label: "Juni", y: 7.56 },
			{ label: "Juli", y: 7.20 },
			{ label: "Agustus", y: 7.1 },
			{ label: "September", y: 7.20 },
			{ label: "Oktober", y: 7.20 },
			{ label: "November", y: 7.20 },
			{ label: "Desember", y: 7.20 },

			
		]
	}]
};
$("#chartContainer").CanvasJSChart(options);

}
</script>


@stop
