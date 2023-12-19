<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        // Check if user is authenticate
        if(auth()->check()){
            // check if the user has the role of an admin
            if(auth()->user()->role->name === 'Admin'){
                // Get all permission names from the database
                $allPermissions = Permission::pluck('name')->toArray();
                // Check if the user has at least one of the required permissions
                foreach($permissions as $permission){
                    if(in_array($permission, $allPermissions)){
                        return $next($request);
                    }
                    return response()->json(['message'=> 'You dont have any permission'], 403);
                }
            }
            return response()->json(['message'=> 'Unauthorized!!'], 403);
        }
         // User is not authorized, return a response indicating unauthorized access
         return response()->json(['message' => 'Please Login first!!!'], 403);
    }
}
