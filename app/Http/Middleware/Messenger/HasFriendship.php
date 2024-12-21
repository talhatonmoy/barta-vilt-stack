<?php
namespace App\Http\Middleware\Messenger;

use Closure;
use App\Models\User;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasFriendship
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $friend = $request->route('user');
        $currentUser = auth()->user();

        if($this->isMyFriend($currentUser, $friend)){
            return $next($request);
        }

        return redirect('/messenger');
    }

    // Logic to check friendhsip
    protected function isMyFriend(User $currentUser, User $friend) : bool
    {
        $friendship = Friendship::where('user_id', $currentUser->id)
                      ->where('friend_id', $friend->id)
                      ->first();
        if($friendship){
            return true;
        }
        return false;
    }
}
