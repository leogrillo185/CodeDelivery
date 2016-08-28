@extends('app')

@section('content')
    <div class="container">
        <h3>Nova Categoria</h3>
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <ul class="alert alert-danger">
                        <li style="margin-left:15px;">{{ $error }}</li>
                    </ul>
                @endforeach
            @endif

        {!! Form::open(['route' => 'admin.categories.store']) !!}

        <div class="form-group">
            {!! Form::label('name', 'Nome:') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'id' => 'name']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('criar categoria', ['class'=>'btn btn-primary', 'id' => 'bt-criar']) !!}
        </div>

        {!! Form::close() !!}


    </div>
@endsection