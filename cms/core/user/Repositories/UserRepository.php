<?php

namespace cms\core\user\Repositories;

use cms\core\usergroup\Models\UserGroupModel;

class UserRepository
{
    // Repository methods go here

    public function Getgroups()
    {
        try {
            $data = UserGroupModel::where("status", 1)
                ->orderBy("group", "Asc")
                ->pluck("group", "id");
            return $data;
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }
}
