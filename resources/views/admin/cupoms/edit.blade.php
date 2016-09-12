@extends('app')

@section('content')
    <div class="container">
        <h3>Editando cupom: {{ $cupom->code }}</h3>

        @include('errors.error_msg')

        {!! Form::model($cupom, ['route' => ['admin.cupoms.update', $cupom->id]]) !!}

        <div class="form-group">
            {!! Form::label('value', 'Valor:') !!}
            {!! Form::text('value', null, ['class'=>'form-control', 'id' => 'value']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Salvar', ['class'=>'btn btn-primary', 'id' => 'bt-criar']) !!}
        </div>

        {!! Form::close() !!}


    </div>
@endsection