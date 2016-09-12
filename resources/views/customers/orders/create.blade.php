@extends('app')

@section('content')
    <div class="container">
        <h3>Novo Pedido</h3>
        @include('errors.error_msg')
        {!! Form::open(['route' => 'customers.orders.store', 'class' => 'form']) !!}

        <div class="form-group">
            <label>Total: <span id="total"></span></label>
            <div><a href="#" id="btnNewItem" class="btn btn-default">Novo ítem</a></div>

            <table class="table table-bordered" style="margin-top: 15px;">
                <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <select class="form-control" name="items[0][product_id]">
                            @foreach($products as $p)
                                <option value="{{ $p->id }}" data-price="{{ $p->price }}">{{ $p->name }} --
                                    {{ $p->price }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        {!! Form::text('items[0][qtd]', 1, ['class' => 'form-control']) !!}
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="form-group">
                {!! Form::submit('Criar pedido', ['class'=>'btn btn-primary', 'id' => 'bt-criar']) !!}
            </div>

        </div>


        {!! Form::close() !!}

    </div>
@endsection

@section('post-script')
    <script>
        $(function () {
            $('#btnNewItem').click(function (e) {
                e.preventDefault();
                var row = $('table tbody > tr:last ');
                var newRow = row.clone();
                var length = $('table tbody tr').length;

                newRow.find('td').each(function () {
                    var td = $(this);
                    var input = td.find('input, select');
                    var name = input.attr('name');

                    input.attr('name', name.replace((length - 1) + "", length + ""));

                });

                newRow.find('input').val(1);
                newRow.insertAfter(row);
                calculateTotal();
            })

            calculateTotal();

            $(document.body).on('click', 'select',  function () {
                calculateTotal();
            });

            $(document.body).on('blur', 'input', function () {
                calculateTotal();
            });


            function calculateTotal() {
                var total = 0,
                    trLen = $('table tbody tr').length,
                    tr = null, price, qtd;

                for (var i = 0; i < trLen; i++) {
                    tr = $('table tbody tr').eq(i);
                    price = tr.find(':selected').data('price');
                    qtd = tr.find('input').val();
                    total += price * qtd;
                }

                $('#total').html('R$ ' + total);

            }


        })
    </script>
@endsection