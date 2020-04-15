<?php

namespace App;


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
            if ($this->isNotRegisteredAsLoveReactant()){
                $this->registerAsLoveReactant();
            }
            if (is_null($type)){
                $type = 'like';
            }
            if ($user->isNotRegisteredAsLoveReacter()){ // register the user as love reacter
                $user->registerAsLoveReacter();
            }
            $reacter = $user->viaLoveReacter();
            if ($reacter->hasReactedTo($this, 'Like')){
                return true;
            }

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
            if ($this->isNotRegisteredAsLoveReactant()){
                $this->registerAsLoveReactant();
            }
            if (is_null($type)){
                $type = 'like';
            }
            if ($user->isNotRegisteredAsLoveReacter()){ // register the user as love reacter
                $user->registerAsLoveReacter();
            }
            $reacter = $user->viaLoveReacter();
            if ($reacter->hasNotReactedTo($this, $type)){
                $reacter->reactTo($this, $type, $weight);
                return true;
            }
            return false;
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
            if ($this->isNotRegisteredAsLoveReactant()){
                $this->registerAsLoveReactant();
            }
            if (is_null($type)){
                $type = 'like';
            }
            if ($user->isNotRegisteredAsLoveReacter()){ // register the user as love reacter
                $user->registerAsLoveReacter();
            }
            $reacter = $user->viaLoveReacter();
            if ($reacter->hasReactedTo($this, $type)){
                $reacter->unreactTo($this, $type, $weight);
                return true;
            }
            return false;
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
        if (is_null($type)){
            $type = 'like';
        }
        $reactantFacade = $this->viaLoveReactant();
        $reactionCounter = $reactantFacade->getReactionCounterOfType($type);
        if ($reactantFacade->getReactionCounters()->count() > 0){
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
