<?php

namespace App\Modules\Comment;

use Illuminate\Database\Eloquent\Model;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Cog\Laravel\Love\ReactionType\Models\ReactionType;

class Comment extends Model implements ReactableContract
{
    use Commentable;
    use Reactable;

    protected $fillable = ['commenter_type', 'commenter_id', 'guest_name', 'guest_email', 'commentable_id', 'commentable_type', 'comment', 'parent_id', 'status'];

    public function addDetails(){
        $this->likes = $this->getReactionCount('like');
        $this->commenter_user_id = $this->user ? $this->user->id : null;
        $this->commenter_profile_pic = $this->user ? $this->user->getProfilePicURL() : '';
        $this->commenter_gender = $this->user ? $this->user->gender : null;
        $this->commenter_name = $this->user ? $this->user->getUserName() : null;
        $this->creation_date = $this->created_at->diffForHumans();
        $this->is_liked = ($this->hasReaction('like')) ? true :  false;
        return $this;
    }
}
