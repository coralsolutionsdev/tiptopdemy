<?php


namespace App\Services;


class ReactionManagerService
{
    /**
     * @param $reactable
     * @param $reaction
     * @param int $mass
     * @return mixed
     */
    public static function react($reactable, $reaction, $mass = 1)
    {
        $addReaction = $removeReaction = false;
        if ($reaction == 'like'){
            // check if the $reactable has been liked.
            if ($reactable->hasReaction($reaction)){
                $removeReaction = true;
            }else{
                $addReaction = true;
            }
        } elseif ($reaction == 'rate'){
            if ($reactable->hasReaction($reaction)){
                $removeReaction = true;
            }
            $addReaction = true;
        }
        // remove reaction
        if ($removeReaction){
            $reactable->removeReaction($reaction);
        }
        // add reaction
        if ($addReaction){
            $reactable->addReaction($reaction, $mass);
        }
        return $reactable->id;
    }
}