<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        // Check if the user is authenticated
        if (auth()->check()) {
            // Get the authenticated user
            $user = auth()->user();

            // Get all permission names from the database
            $allPermissions = Permission::pluck('name')->toArray();

            // Check if the user has at least one of the required permissions
            foreach ($permissions as $permission) {
                if (in_array($permission, $allPermissions)) {
                    // Check if the user is the author of the post or is an admin
                    $postId = $request->route('id');
                    $post = Post::find($postId);

                    if ($user->role->name === 'Admin' ||  ($post && $post->user_id === auth()->id())) {
                        // Allow the request to proceed
                        return $next($request);
                    }
                }
            }

            // If none of the required permissions are found
            return response()->json(['message' => 'You don\'t have the required permissions'], 403);
        }

        // User is not authenticated, return a response indicating unauthorized access
        return response()->json(['message' => 'Please Login first!!!'], 403);
    }
}
    

