<?php


namespace App\Modules\Group;


use Hashids\Hashids;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        $hashids = new Hashids();
        $group->slug = $hashids->encode($user->getTenancyId(),$this->id,$group->id);
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