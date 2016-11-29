<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 11/09/2016
 * Time: 10:13
 */

namespace CodeDelivery\Services;

use CodeDelivery\Models\Order;
use CodeDelivery\Repositories\CupomRepository;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;

class OrderService
{


    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var CupomRepository
     */
    private $cupomRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(
        OrderRepository $orderRepository,
        CupomRepository $cupomRepository,
        ProductRepository $productRepository)
    {

        $this->orderRepository = $orderRepository;
        $this->cupomRepository = $cupomRepository;
        $this->productRepository = $productRepository;
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try{

            $data['status'] = 0;

            if(isset($data['cupom_id'])){
                unset($data['cupom_id']);
            }

            if(isset($data['cupom_code'])){
                $cupom = $this->cupomRepository->findByField('code', $data['cupom_code'])->first();
                $data['cupom_id'] = $cupom->id;
                $cupom->used = 1;
                $cupom->save();
                unset($data['cupom_code']);
            }

            $items = $data['items'];
            unset ($data['items']);

            $order = $this->orderRepository->create($data);
            $total = 0;
            foreach($items as $item){
                $item['price'] = $this->productRepository->find($item['product_id'])->price;
                $order->items()->create($item);
                $total += $item['price'] * $item['qtd'];
            }

            $order->total = $total;
            //se existe o cupom subtrai o valor do total
            if(isset($cupom)){
                $order->total = $total - $cupom->value;
            }

            $order->save();
            DB::commit();
            return $order;
        }catch(\Exception $e){
            //desfaz as alterações no banco
            DB::rollback();
            //Exibe a mensagem de erro
            throw $e;
        }
    }

    public function updateStatus($id, $deliverymanId, $status){
        $order = $this->orderRepository->getByIdandDeliveryman($id, $deliverymanId);
        if($order instanceof Order){
            $order->status = $status;
            $order->save();
            return $order;
        }
        return false;
    }

}