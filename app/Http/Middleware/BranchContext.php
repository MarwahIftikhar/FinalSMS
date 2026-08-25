<?php

namespace App\Http\Middleware;

use App\Models\Branch;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class BranchContext
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Schema::hasTable('branches')) {
            return $next($request);
        }

        $branches = Branch::where('status', true)->orderBy('name')->get();
        $activeBranchId = (int) $request->session()->get('active_branch_id', 1);

        if (! $branches->contains('id', $activeBranchId)) {
            $activeBranchId = (int) ($branches->first()?->id ?? 0);
            $request->session()->put('active_branch_id', $activeBranchId);
        }

        View::share([
            'availableBranches' => $branches,
            'activeBranch' => $branches->firstWhere('id', $activeBranchId),
        ]);

        return $next($request);
    }
}
