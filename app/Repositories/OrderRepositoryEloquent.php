<?php

namespace CodeDelivery\Repositories;

use CodeDelivery\Presenters\OrderPresenter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeDelivery\Models\Order;

/**
 * Class ClientRepositoryEloquent
 * @package namespace CodeDelivery\Repositories;
 */
class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{


    protected $skipPresenter  = true;

    public function getByIdandDeliveryman($id, $deliverymanId)
    {
        $result = $this->with(['client', 'items', 'cupom'])->findWhere([
            'id' => $id,
            'user_deliveryman_id' => $deliverymanId
        ]);

        if($result instanceof Collection){
            $result = $result->first();
        }else{
            if(isset($result['data']) && count($result['data']) == 1){
                $result = [
                    'data' => $result['data'][0]
                ];
            }else{
                throw new ModelNotFoundException('Esta ordem não existe');
            }
        }

        /*if($result) {
            $result->items->each(function ($item) {
                $item->product;
            });
        }*/

        return $result;
    }


    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    public function presenter(){
        return OrderPresenter::class;
    }

}
