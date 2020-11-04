<?php


namespace App\Modules\Group;


use Vinkla\Hashids\Facades\Hashids;

trait HasGroup
{
    public function getClassName()
    {
        return __CLASS__;
    }
    public function createGroup($input)
    {
        $user = getAuthUser();
        if (empty($user)){
            // trow error
        }
        $input['creator_id'] = getAuthUser()->id;
        $input['editor_id'] = getAuthUser()->id;
        $input['owner_type'] = $this->getClassName();
        $input['owner_id'] = $this->id;
        $group =  Group::create($input);
        $group->slug = Hashids::encode($user->getTenancyId(),$this->id,$group->id);
        $group->save();
    }
}