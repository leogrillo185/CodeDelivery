@extends('app')

@section('content')
    <div class="container">
        <h3>Novo Cupom</h3>
        @include('errors.error_msg')

        {!! Form::open(['route' => 'admin.cupoms.store']) !!}

        <div class="form-group">
            {!! Form::label('code', 'Código:') !!}
            {!! Form::text('code', null, ['class'=>'form-control', 'id' => 'code']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('value', 'Valor:') !!}
            {!! Form::text('value', null, ['class'=>'form-control', 'id' => 'value']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Criar', ['class'=>'btn btn-primary', 'id' => 'bt-criar']) !!}
        </div>

        {!! Form::close() !!}
    </div>
@endsection