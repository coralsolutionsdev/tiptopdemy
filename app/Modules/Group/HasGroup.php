<?php


namespace App\Modules\Group;


use Illuminate\Database\Eloquent\Relations\HasMany;
use Vinkla\Hashids\Facades\Hashids;

trait HasGroup
{

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
        return $group;
    }

    public function getGroupsWithType($type)
    {
        return $this->groups()->where('type', $type)->get();
    }

    /**
     * @return HasMany
     */
    public function groups(): HasMany
    {
        return $this->hasMany('App\Modules\Group\Group', 'owner_id')->where('owner_type', $this->getClassName())->orderBy('position');
    }
}