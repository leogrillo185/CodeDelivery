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


    protected $skipPresenter = true;

    public function getByIdandDeliveryman($id, $deliverymanId)
    {
        $result = $this->model
            ->where('id', $id)
            ->where('user_deliveryman_id', $deliverymanId)
            ->first();
        if ($result) {
            return $this->parserResult($result);
        }
        throw (new ModelNotFoundException())->setModel(get_class($this->model));

        /*if($result) {
            $result->items->each(function ($item) {
                $item->product;
            });
        }*/
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


    public function presenter()
    {
        return OrderPresenter::class;
    }

}
