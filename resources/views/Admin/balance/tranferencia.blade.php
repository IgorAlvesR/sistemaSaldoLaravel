@extends('adminlte::page')

@section('title', 'Transferencia')

@section('content_header')
    <h1>Transferencia</h1>

    <ol class="breadcrumb">
    	<li><a href="">Dashboard></a></li>
    	<li><a href="">Saldo></a></li>
        <li><a href="">Transferencia</a></li>
    </ol>
@stop

@section('content')
    <div class="box">
    	<div class="box-header">
    		<h3>Fazer Transferir Saldo (Informe o Recebedor)</h3>
    	</div>

    	<div class="box-body">
            @include('admin.includes.alerts')

    		<form method="POST" action="{{route('transferencia.confirmacao')}}">
    			{!! csrf_field() !!}

    			<div class="form-group">
    				<input type="text" name="sender" placeholder="Informação de quem vai receber o valor" class="form-control">
    			</div>
    			<div class="form-group">
    				<button type="submit" class="btn btn-success">Proxima Etapa</button>
    			</div>
    		</form>


    	</div>


    </div>
@stop