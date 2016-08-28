@extends('app')

@section('content')
    <div class="container">
        <h3>Produtos</h3>
        <a href="{{ route('admin.products.create') }}" class="btn btn-default" style="margin-bottom: 20px;">Novo
            Produto</a>
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Produto</th>
                <th>Categoria</th>
                <th>Preço</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <th>{{ $product->id }}</th>
                    <th>{{ $product->name }}</th>
                    <th>{{ $product->category->name }}</th>
                    <th>{{ $product->price }}</th>
                    <th>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-default btn-sm">Editar</a>
                        <a href="{{ route('admin.products.destroy', $product->id) }}" class="btn btn-default btn-sm">Remover</a>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $products->render() !!}
    </div>
@endsection