<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\ProductRepository;
use PhpParser\Node\Expr\Cast\Int_;

class ClientProductController extends Controller
{

    /**
     * @var ProductRepository
     */
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        /*$products = $this->repository->skipPresenter(false)->all();
        return $products;*/

        return $this->repository->skipPresenter(false)->paginate(20);

    }

}
