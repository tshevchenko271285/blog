<?php
namespace App\Repositories;

use App\Attachment;
use App\Repositories\Contracts\IAttachmentRepo;

class AttachmentRepo implements IAttachmentRepo {

    protected $model;

    public function __construct(Attachment $model) {
        $this->model = $model;
    }

    public function create(string $path) {
        $attachment = new $this->model(['path' => $path]);
        $attachment->save();
        return $attachment;
    }

    public function removeById(int $id) {
        $this->model->destroy($id);
    }
}
