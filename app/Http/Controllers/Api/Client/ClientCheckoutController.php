<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use CodeDelivery\Http\Requests;
use CodeDelivery\Models\Order;
use CodeDelivery\Presenters\OrderPresenter;
use CodeDelivery\Repositories\OrderRepository;
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
     * @var OrderService
     */
    private $orderService;

    private $with = ['client', 'items', 'cupom'];

    public function __construct(OrderRepository $orderRepository,
                                UserRepository $userRepository,
                                OrderService $orderService)

    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->orderService = $orderService;
    }

    public function index()
    {

        $id =  Authorizer::getResourceOwnerId();
        $clientId = $this->userRepository->find($id)->client->id;
        $orders = $this->orderRepository
            ->skipPresenter(false)
            ->with($this->with)->scopeQuery(function ($query) use($clientId) {
            return $query->where('client_id', '=', $clientId);
        })->paginate();

        return $orders;

        /*return $this->orderRepository
            ->skipPresenter(false)
            ->scopeQuery(function($query){
                return $query->skip(3) //Skip é o offset
                             ->take(3); //take é o limit
            })->all();*/

    }

    public function show($id){
        /*$order = $this->orderRepository->with(['client','items', 'cupom'])->find($id);
        $order->items->each(function($item){
             $item->product;
        });
        return $order;*/

        return $this->orderRepository
            ->skipPresenter(false)
            ->with($this->with)
            ->find($id);
    }

    public function store(Requests\CheckoutRequest $request)
    {
        $data = $request->all();
        $id = Authorizer::getResourceOwnerId();
        $clientId = $this->userRepository->find($id)->client->id;
        $data['client_id'] = $clientId;
        $o = $this->orderService->create($data);
        return $this->orderRepository
            ->skipPresenter(false)
            ->with($this->with)
            ->find($o->id);

    }

}
