@extends('adminlte::page')

@section('title', 'Transferencia Confirmação')

@section('content_header')
    <h1>Transferencia Confirmação</h1>

    <ol class="breadcrumb">
    	<li><a href="">Dashboard></a></li>
    	<li><a href="">Saldo></a></li>
        <li><a href="">Transferencia</a></li>
        <li><a href="">Confirmação</a></li>
        
    </ol>
@stop

@section('content')
    <div class="box">
    	<div class="box-header">
    		<h3>Confirmar transferencia de saldo</h3>
    	</div>

    	<div class="box-body">
            @include('admin.includes.alerts')

            
            
            <p><strong>Recebedor: </strong>{{$sender->name}}</p>
            <p><strong>Seu Saldo: </strong>{{$balance->amount}}</p>
            

    		<form method="POST" action="{{route('transferencia.store')}}">
    			{!! csrf_field() !!}

                <input type="hidden" name="sender_id" value="{{$sender->id}}">
    			<div class="form-groups">
    				<input type="text" name="value" placeholder="Valor" class="form-control">
    			</div>
                <br>
    			<div class="form-group">
    				<button type="submit" class="btn btn-success">Transferir</button>
    			</div>
    		</form>


    	</div>


    </div>
@stop