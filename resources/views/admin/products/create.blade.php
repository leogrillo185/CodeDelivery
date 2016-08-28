@extends('app')

@section('content')
    <div class="container">
        <h3>Novo Produto</h3>
        @include('errors.error_msg')

        {!! Form::open(['route' => 'admin.products.store']) !!}

        <div class="form-group">
            {!! Form::label('category', 'Categoria:') !!}
            {!! Form::select('category_id', $categories, null, ['class'=>'form-control', 'id' => 'category']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('name', 'Nome:') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'id' => 'name']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('description', 'Descrição:') !!}
            {!! Form::textarea('description', null, ['class'=>'form-control', 'id' => 'description']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('price', 'Preço:') !!}
            {!! Form::text('price', null, ['class'=>'form-control', 'id' => 'price']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Criar', ['class'=>'btn btn-primary', 'id' => 'bt-criar']) !!}
        </div>

        {!! Form::close() !!}


    </div>
@endsection