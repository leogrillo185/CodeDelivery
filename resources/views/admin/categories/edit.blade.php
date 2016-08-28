@extends('app')

@section('content')
    <div class="container">
        <h3>Editando Categoria: {{ $category->name }}</h3>

        @if($errors->any())
            @foreach($errors->all() as $error)
                <ul class="alert alert-danger">
                    <li style="margin-left:15px;">{{ $error }}</li>
                </ul>
            @endforeach
        @endif

        {!! Form::model($category, ['route' => ['admin.categories.update', $category->id]]) !!}

        <div class="form-group">
            {!! Form::label('name', 'Nome:') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'id' => 'name']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Salvar categoria', ['class'=>'btn btn-primary', 'id' => 'bt-criar']) !!}
        </div>

        {!! Form::close() !!}


    </div>
@endsection