<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\UserRepository;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class UsersController extends Controller
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository){

        $this->userRepository = $userRepository;
    }

    public function authenticated(){
        $id = Authorizer::getResourceOwnerId();
        return $this->userRepository
            ->skipPresenter(false)
            ->find($id);
    }


}
