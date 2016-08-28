<?php

namespace CodeDelivery\Http\Controllers;


use CodeDelivery\Models\Order;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use Illuminate\Http\Request;
use CodeDelivery\Http\Requests;

class OrdersController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository){
        $this->orderRepository = $orderRepository;
    }

    public function index(){
        $orders = $this->orderRepository->paginate();
        return view('admin.orders.index', compact('orders'));
    }

    public function edit($id, UserRepository $userRepository){
        $list_status = [0 => 'PENDENTE', 1 => 'A CAMINHO', 2 => 'ENTREGUE', 3 => 'CANCELADO'];
        $deliveryman =  $userRepository->getDeliveryMan();
        $order = $this->orderRepository->find($id);
        return view('admin.orders.edit', compact('order', 'list_status', 'deliveryman'));
    }

    public function update(Request $request, $id){
        try{
            $all = $request->all();
            $this->orderRepository->update($all, $id);
            return redirect()->route('admin.orders');
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

}
