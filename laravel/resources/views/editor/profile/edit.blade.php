@extends('layouts.editor.template')
@section('content')

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Profil</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                  <ol class="breadcrumb">
                    <li><a href="{{url('/')}}/editor"><i class="fa fa-dashboard"></i> Halaman Depan</a></li>
                    <li class="active">Profil</li>
                  </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
             <div class="col-sm-12">
                <div class="white-box">
                 <hr>
                   <div class="box-body">
                     <div class="table-responsive" >
						 <div class="x_panel">

		            	{!! session()->get('msg') !!}
			            @include('errors.error')
			            {!! Form::open(array('route' => 'editor.profile.update', 'method' => 'PUT', 'files' => 'true'))!!}
	                    {{ csrf_field() }}
	                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
	                        <label for="username">Username</label>
	                        <p id="username">{{Auth::user()->username}}</p>

	                        <label for="password">Sandi</label>
	                        <p><a href="{{ URL::route('editor.profile.edit_password') }}">Ganti Sandi</a></p>

	                        <label for="email">E-mail</label>
	                        <input type="email" class="form-control" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" placeholder="E-mail address*" required><br>

	                        <label for="full_name">Nama</label>
	                        <div id="full_name">
		                        <div class="col-md-6 col-sm-6 col-xs-6 form-group">
			                        <input type="first_name" class="form-control" name="first_name" id="first_name" value="{{ old('first_name', Auth::user()->first_name) }}" placeholder="First name*" required><br>
		                        </div>
		                        <div class="col-md-6 col-sm-6 col-xs-6 form-group">
			                        <input type="last_name" class="form-control" name="last_name" id="last_name" value="{{ old('last_name', Auth::user()->last_name) }}" placeholder="Last name" required><br>
		                        </div>
	                        </div>

	                        <label for="image">Upload Foto Profil</label>
	                        <input type="file" name="image" id="image">
	                        
                            <button type="submit" class="btn btn-success pull-right btn-lg btn-flat"><i class="fa fa-check"></i> Simpan</button>
                    	</div>
                        {!! Form::close() !!}
						</div>
                   </div>
                </div>
             </div>
          </div>
      </div>
    </div>
</div>

@stop