@extends('app')

@section('content')
    <div class="container">
        <h2>Pedido: #{{ $order->id }} - R$ {{ $order->total }}</h2>
        <p>Data: {{ $order->created_at }}</p>
        <h3>Cliente: {{ $order->client->user->name }}</h3>
        <h4><strong>Endereço:</strong> <br>{{ $order->client->address }} - {{ $order->client->city }}
            - {{ $order->client->state }} - CEP: {{ $order->client->zip_code }}
        </h4>

        @include('errors.error_msg')

        {!! Form::model($order, ['route' => ['admin.orders.update', $order->id]]) !!}

        <div class="form-group">
            {!! Form::label('status', 'Status:') !!}
            {!! Form::select('status', $list_status, null, ['class'=>'form-control', 'id' => 'status']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('Entregador', 'Entregador:') !!}
            {!! Form::select('user_deliveryman_id', $deliveryman, null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Salvar', ['class'=>'btn btn-primary', 'id' => 'bt-salvar']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection