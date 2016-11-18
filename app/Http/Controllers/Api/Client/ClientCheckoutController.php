<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use CodeDelivery\Events\Event;
use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use Illuminate\Http\Request;
use CodeDelivery\Http\Controllers\Controller;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Prettus\Validator\Exceptions\ValidatorException;

class ClientCheckoutController extends Controller
{

    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var OrderService
     */
    private $orderService;

    public function __construct(OrderRepository $orderRepository,
                                UserRepository $userRepository,
                                ProductRepository $productRepository,
                                OrderService $orderService)

    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $id =  Authorizer::getResourceOwnerId();
        $clientId = $this->userRepository->find($id)->client->id;
        $orders = $this->orderRepository->with(['items'])->scopeQuery(function ($query) use($clientId) {
            return $query->where('client_id', '=', $clientId);
        })->paginate();

        return $orders;
    }

    public function show($id){
       $order = $this->orderRepository->with(['client','items', 'cupom'])->find($id);
       $order->items->each(function($item){
            $item->product;
       });
        return $order;
    }


    public function store(Request $request)
    {
        $data = $request->all();
        $id = Authorizer::getResourceOwnerId();
        $clientId = $this->userRepository->find($id)->client->id;
        $data['client_id'] = $clientId;
        $o = $this->orderService->create($data);
        $o = $this->orderRepository->with('items')->find($o->id);
        return $o;
    }

}
