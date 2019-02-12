@extends('site.layouts.app')


@section('title', 'Meu Perfil')

@section('content')


<h1>Meu Perfil</h1>

@include('admin.includes.alerts')

<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
	{!! csrf_field() !!}
			
	<div class="form-group" >
		<label for="name">Nome</label>
		<input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}">
	</div>

	<div class="form-group">
		<label for="email">Email</label>
		<input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}">
	</div>

	<div class="form-group">
		<label for="password">Senha</label>
		<input type="password" class="form-control" name="senha" placeholder="Senha">
	</div>

	<div class="form-group">

		@if(auth()->user()->image != null)

			<img src="{{ url('storage/users/'.auth()->user()->image) }}" alt="{{ auth()->user()->name }}" style="max-width: 50px;">

		
		@endif


		<label for="image">Imagem: </label>
		<input class="form-control" type="file" name="image">

	</div>

	<div class="form-group">
		<input class="btn btn-info" type="submit" value="Atualizar Perfil">
	</div>
		

	
</form>

@endsection