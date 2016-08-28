<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Requests\AdminCategoryRequest;
use CodeDelivery\Http\Requests\AdminProductRequest;
use CodeDelivery\Repositories\CategoryRepository;
use CodeDelivery\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $repository;
    /**
     * @var CategoryRepository
     */
    private $category;

    public function __construct(ProductRepository $repository, CategoryRepository $category){
        $this->repository = $repository;
        $this->category = $category;
    }

    public function index(){
        $products  = $this->repository->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create(){
        $categories = $this->category->lists('name', 'id');
        return view('admin.products.create', compact('categories'));
    }

    public function store(AdminProductRequest $request){
        $this->repository->create($request->all());
        return redirect()->route('admin.products');
    }

    public function edit($id){
        $product = $this->repository->find($id);
        $categories = $this->category->lists('name', 'id');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(AdminProductRequest $request, $id){
        $product = $request->all();
        $this->repository->update($product, $id);
        return redirect()->route('admin.products')->with(['status' => 'Produto alterada com sucesso!']);
    }

    public function destroy($id){
        $this->repository->delete($id);
        return redirect()->route('admin.products')->with(['status' => 'Produto excluído com sucesso!']);;
    }

}
