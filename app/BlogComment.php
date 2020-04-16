<?php

namespace App;


use Cog\Laravel\Love\ReactionType\Models\ReactionType;
use Illuminate\Database\Eloquent\Model;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Cog\Contracts\Love\Reactant\Facades\Reactant as ReactantFacade;
use Cog\Contracts\Love\Reactant\Models\Reactant;

class BlogComment extends Model implements ReactableContract
{
    //
    use Reactable;

    protected $fillable = ['post_id', 'user_id', 'parent_id', 'content', 'status'];

    /**
     * check if user has reacted to item
     * @param $type
     * @return bool
     */
    function isReacted($type)
    {
        $user = getAuthUser();
        if ($user){
            // get reaction type
            if (is_null($type)){
                $type = 'like';
            }
            $reactionType = ReactionType::fromName($type);
            $typeName = $reactionType->getName(); // 'Like'

            if ($user->isNotRegisteredAsLoveReacter()){ // false
                $user->registerAsLoveReacter();
            }
            $reacterFacade = $user->viaLoveReacter();
            $isReacted = $reacterFacade->hasReactedTo($this);
            return $isReacted;

        }
        return false;
    }

    /**
     * assign reaction to item
     * @param $type
     * @param int $weight
     * @return bool
     */
    function reactTo($type,  $weight = 1)
    {
        $user = getAuthUser();
        if ($user){
            // get reaction type
            if (is_null($type)){
                $type = 'like';
            }
            $reactionType = ReactionType::fromName($type);
            $typeName = $reactionType->getName(); // 'Like'

            //model should ne registered ad love reactant
            if ($this->isNotRegisteredAsLoveReactant()){
                $this->registerAsLoveReactant();
            }

            if ($user->isNotRegisteredAsLoveReacter()){ // false
                $user->registerAsLoveReacter();
            }
            $reacterFacade = $user->viaLoveReacter();

            $isNotReacted = $reacterFacade->hasNotReactedTo($this);
            if ($isNotReacted){
                $reacterFacade->reactTo($this, $typeName, $weight);
            }
        }
        return false;
    }

    /**
     * remove reaction from item
     * @param $type
     * @param int $weight
     * @return bool
     */
    function unReactTo($type,  $weight = 1)
    {
        $user = getAuthUser();
        if ($user){
            if ($user){
                // get reaction type
                if (is_null($type)){
                    $type = 'like';
                }
                $reactionType = ReactionType::fromName($type);
                $typeName = $reactionType->getName(); // 'Like'

                //model should ne registered ad love reactant
                if ($this->isNotRegisteredAsLoveReactant()){
                    $this->registerAsLoveReactant();
                }

                if ($user->isNotRegisteredAsLoveReacter()){ // false
                    $user->registerAsLoveReacter();
                }
                $reacterFacade = $user->viaLoveReacter();

                $isReacted = $reacterFacade->hasReactedTo($this);
                if ($isReacted){
                    $reacterFacade->unreactTo($this, $typeName);
                }
            }
        }
        return false;
    }

    /**
     * return reaction count
     * @param null $type
     * @return int
     */
    public function getReactCount($type =  null)
    {
        if ($this->isNotRegisteredAsLoveReactant()){
            $this->registerAsLoveReactant();
        }
        // get reaction type
        if (is_null($type)){
            $type = 'like';
        }
        $reactionType = ReactionType::fromName($type);
        $typeName = $reactionType->getName(); // 'Like'
        $reactantFacade = $this->viaLoveReactant();
        $reactionCounter = $reactantFacade->getReactionCounterOfType($typeName);
        if (!empty($reactionCounter)){
            return $reactionCounter->count;

        }
        return 0;
    }

    /*
     |--------------------------------------------------------------------------
     | Relationship Methods
     |--------------------------------------------------------------------------
     */

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function comments()
    {
        return $this->hasMany('App\BlogComment','parent_id');
    }

//    public function getLoveReactant(): Reactant
//    {
//        // TODO: Implement getLoveReactant() method.
//    }
//
//    public function viaLoveReactant(): ReactantFacade
//    {
//        // TODO: Implement viaLoveReactant() method.
//    }
//
//    public function isRegisteredAsLoveReactant(): bool
//    {
//        // TODO: Implement isRegisteredAsLoveReactant() method.
//    }
//
//    public function isNotRegisteredAsLoveReactant(): bool
//    {
//        // TODO: Implement isNotRegisteredAsLoveReactant() method.
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function registerAsLoveReactant(): void
//    {
//        // TODO: Implement registerAsLoveReactant() method.
//    }
}
