angular.module('starter.services')
    .service('$cart', ['$localStorage', function ($localStorage) {

        var key = 'carts';
        var cartAux = $localStorage.getObject(key);

        if (!cartAux) {
            initCart();
        }

        this.clear = function () {
            initCart();
        };

        this.get = function () {
            return $localStorage.getObject(key);
        };

        this.getItem = function (i) {
            return this.get().items[i];
        };

        this.addItem = function (item) {
            var cart = this.get();
            var itemAux;
            var exists = false;

            for (var index in cart.items) {
                itemAux = cart.items[index];
                if (itemAux.id == item.id) {
                    itemAux.qtd = itemAux.qtd + item.qtd;
                    itemAux.subtotal = calculateSubTotal(itemAux);
                    exists = true;
                    break;
                }
            }

            if (!exists) {
                //calcular o subtotal
                item.subtotal = calculateSubTotal(item);
                //console.log(cart);
                //incluir o item no carrinho
                cart.items.push(item);//adicionando o item ao array
            }
            //Recalcula o total
            cart.total = getTotal(cart.items);
            //Atualizar o cart no local storage
            $localStorage.setObject(key, cart);
        };

        this.removeItem = function (i) {
            //remover o item do array
            var cart = this.get();
            cart.items.splice(i, 1);
            //atualizar total
            cart.total = getTotal(cart.items);
            //atualizar o local storage
            $localStorage.setObject(key, cart);
        };

        this.updateQtd = function (i, qtd) {
            var cart = this.get(),
                itemAux = cart.items[i];
            //atualiza a qunatidade no elemento selecionado
            itemAux.qtd = qtd;
            //atualiza o subtotal do elemento selecionado
            itemAux.subtotal = calculateSubTotal(itemAux);
            //atualixa o total do carrinho
            cart.total = getTotal(cart.items);
            //atualixa o carrinho no localStorage
            $localStorage.setObject(key, cart);
        };

        function calculateSubTotal(item) {
            return item.price * item.qtd;
        }

        function getTotal(items) {
            var sum = 0;
            angular.forEach(items, function (item) {
                sum += item.subtotal;
            });
            return sum;
        }

        function initCart() {
            $localStorage.setObject(key, {
                items: [],
                total: 0
            })
        }

    }]);