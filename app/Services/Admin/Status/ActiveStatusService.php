<?php

namespace App\Services\Admin\Status;

use App\Traits\Global\AllModelNameTrait;
use App\Traits\UnHashed\UnHashedTrait;

/**
 * Class ActiveStatusService.
 */
class ActiveStatusService
{
    /**
     * Update Active Status
     *
     * @incomingParam $payloads contains Validated Array Record with id & updateFor as Model Name
     * */
    public function updateActiveStatus($model)
    {
        $model->update([
            "is_active" => !$model->is_active
        ]);

        return $model;
    }

    public function updateStatus($model, $id)
    {
        $model->where("id", $id)->update([
            "is_active" => !$model->is_active
        ]);

        return $model;
    }
}
