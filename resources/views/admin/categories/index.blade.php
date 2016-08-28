@extends('app')

@section('content')
    <div class="container">
        <h3>Categorias</h3>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-default" style="margin-bottom: 20px;">Nova
            Categoria</a>
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="width: 10%;">ID</th>
                <th style="width: 70%%;">Nome</th>
                <th style="width: 20%;">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <th>{{ $category->id }}</th>
                    <th>{{ $category->name }}</th>
                    <th>
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-default btn-sm">Editar</a>

                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $categories->render() !!}
    </div>
@endsection