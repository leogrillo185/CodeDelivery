@extends('app')

@section('content')
    <div class="container">
        <h3>Pedidos</h3>
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Data</th>
                <th>Total</th>
                <th>Itens</th>
                <th>Entregador</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <th>#{{ $order->id }}</th>
                    <th>{{ $order->created_at }}</th>
                    <th>R$ {{ $order->total }}</th>
                    <th>
                        <ul>
                        @foreach($order->items as $item)
                            <li>{{ $item->product->name }}</li>
                        @endforeach
                        </ul>
                    </th>
                    <th>
                        @if($order->deliveryman)
                            {{ $order->deliveryman->name }}
                        @else
                            --
                        @endif
                    </th>
                    <th>{{ $order->status }}</th>
                    <th>
                        <a href="{{ route('admin.orders.edit', ['id' => $order->id]) }}" class="btn btn-default btn-sm">Editar</a>

                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $orders->render() !!}
    </div>
@endsection