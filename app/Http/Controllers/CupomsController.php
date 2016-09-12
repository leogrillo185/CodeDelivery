<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Requests\AdminCupomRequest;
use CodeDelivery\Repositories\CupomRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CupomsController extends Controller
{

    /**
     * @var CupomRepository
     */
    private $repository;

    /**
     * CupomsController constructor.
     * @param CupomRepository $repository
     */
    public function __construct(CupomRepository $repository){
        $this->repository = $repository;
    }

    public function index(){
        $cupoms  = $this->repository->paginate(15);
        return view('admin.cupoms.index', compact('cupoms'));
    }

    public function create(){
        return view('admin.cupoms.create');
    }

    public function store(AdminCupomRequest $request){
        $this->repository->create($request->all());
        return redirect()->route('admin.cupoms');
    }

    public function edit($id){
        $cupom = $this->repository->find($id);
        return view('admin.cupoms.edit', compact('cupom'));
    }

    public function update(Request $request, $id){

        $roles = [
            'value' => 'required'
        ];

        $validator = Validator::make($request->all(), $roles);

        if($validator->fails()){
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $cupom = $request->all();
        $this->repository->update($cupom, $id);
        return redirect()->route('admin.cupoms')->with(['status' => 'Cupom atualizado com sucesso!']);

    }

}
