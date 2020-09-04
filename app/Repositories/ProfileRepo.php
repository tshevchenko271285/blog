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
     * @param int $user_id
     * @param array $user_data
     * @return mixed
     */
    public function update(int $user_id, array $user_data) {
        return $this->model->find( $user_id )->update($user_data);
    }

}
