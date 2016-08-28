@extends('app')

@section('content')
    <div class="container">
        <h3>Clientes</h3>
        <a href="{{ route('admin.clients.create') }}" class="btn btn-default" style="margin-bottom: 20px;">Novo
            Cliente</a>
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clients as $client)
                <tr>
                    <th>{{ $client->id }}</th>
                    <th>{{ $client->user->name }}</th>
                    <th>
                        <a href="{{ route('admin.clients.edit', $client->id) }}" class="btn btn-default btn-sm">Editar</a>
                        <!--<a href="{{ route('admin.clients.destroy', $client->id) }}" class="btn btn-default btn-sm">Remover</a>-->
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $clients->render() !!}
    </div>
@endsection