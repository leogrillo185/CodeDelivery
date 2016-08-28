@extends('app')

@section('content')
    <div class="container">
        <h3>Novo Cliente</h3>
        @include('errors.error_msg')

        {!! Form::open(['route' => 'admin.clients.store']) !!}

        <div class="form-group">
            {!! Form::label('name', 'Nome:') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'id' => 'name']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('email', 'E-mail:') !!}
            {!! Form::text('email', null, ['class'=>'form-control', 'id' => 'email']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('phone', 'Telefone:') !!}
            {!! Form::text('phone', null, ['class'=>'form-control', 'id' => 'phone']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('address', 'Endereço:') !!}
            {!! Form::text('address', null, ['class'=>'form-control', 'id' => 'address']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('city', 'Cidade:') !!}
            {!! Form::text('city', null, ['class'=>'form-control', 'id' => 'city']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('state', 'Estado:') !!}
            {!! Form::text('state', null, ['class'=>'form-control', 'id' => 'state']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('zip_code', 'CEP:') !!}
            {!! Form::text('zip_code', null, ['class'=>'form-control', 'id' => 'zip_code']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Salvar', ['class'=>'btn btn-primary', 'id' => 'bt-criar']) !!}
        </div>

        {!! Form::close() !!}


    </div>
@endsection