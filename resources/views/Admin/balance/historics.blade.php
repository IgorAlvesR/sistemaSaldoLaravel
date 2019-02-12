@extends('adminlte::page')

@section('title', 'Histórico de Movimentações')

@section('content_header')
    <h1>Histórico de Movimentações</h1>

    <ol class="breadcrumb">
    	<li><a href="">Dashboard></a></li>
    	<li><a href="">Histórico></a></li>
    </ol>
@stop

@section('content')
    <div class="box">
    	<div class="box-header">
        <form action="{{route('historic.search')}}" method="POST" class="form form-inline">
            {!!  csrf_field() !!}
                <input type="text" name="id" placeholder="Id" class="form form-control">
                <input type="date" name="date" class="form form-control">

                <select name="type" class="form form-control">
                    <option value=""> --Selecione-- </option>
                    @foreach ($types as $key => $type)

                    <option value="{{ $key }}">{{ $type }}</option>
                    
                    @endforeach
                    
                </select>

               

                <input type="submit" class="btn btn-primary" value="Pesquisar"> 
        </form>        
    </div>

    	<div class="box-body">
           
           <table class="table table-bordered table-hover">
               <thead>
                   <tr>
                        <th>#</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                        <th>Sender</th> 
                   </tr>

                <tbody>
                    @forelse($historic as $h)
                    <tr>
                        <th>{{$h->id}}</th>
                        <th>{{number_format($h->amount,2,'.','')}}</th>
                        <th>{{$h->type($h->type)}}</th>
                        <th>
                            @if($h->user_id_transaction)
                                {{$h->userSender->name }}
                            @else
                                -
                            @endif
                        </th> 
                        <th>{{$h->date}}</th>
                    </tr> 
                    @empty
                    @endforelse
                </tbody>
               </thead>

           </table> 

            @if(isset($dataForm))
    	        {!! $historic->appends($dataForm)->links() !!}

            @else
                {!! $historic->links() !!}

            @endif                
        
    	</div>
    </div>
@stop