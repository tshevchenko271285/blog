<?php
namespace App\Repositories;
use App\Repositories\Contracts\IProfileRepo;
use App\User;

class ProfileRepo implements IProfileRepo {

    /**
     * @var User
     */
    protected $model;

    /**
     * ProfileRepo constructor.
     * @param User $model
     */
    public function __construct( User $model ) {
        $this->model = $model;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getForUserId( $id ) {
        return $this->model->with('avatar')->find( $id );
    }

    /**
     * @param array $user_data
     * @return mixed
     */
    public function update(array $user_data) {

        if( ! isset($user_data['id']) || empty($user_data['id']) ) throw new Exception('No user_id for profile update!');

        $user = $this->model->find( $user_data['id'] );

        unset($user_data['id']);

        $user->update($user_data);

        return $user;
    }

}
