@extends('app')

@section('content')
    <div class="container">
        <h3>Cupons</h3>
        <a href="{{ route('admin.cupoms.create') }}" class="btn btn-default" style="margin-bottom: 20px;">Novo
            cupom</a>
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Código</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cupoms as $cupom)
                <tr>
                    <th>{{ $cupom->id }}</th>
                    <th>{{ $cupom->code }}</th>
                    <th>{{ $cupom->value }}</th>
                    <th>
                        <a href="{{ route('admin.cupoms.edit', $cupom->id) }}" class="btn btn-default btn-sm">Editar</a>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $cupoms->render() !!}
    </div>
@endsection