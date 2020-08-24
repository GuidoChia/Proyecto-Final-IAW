<?php


namespace App\Services;


use App\Address;
use Illuminate\Support\Collection;

interface RouteOptimizationService
{
    /**
     * Optimizes the route, starting from $origin, and ending in $destination.
     * @param Collection $addresses
     * @return Collection the addreses in the order that should be visited.
     * The first one is the origin, the last the destination.
     */
    function optimizeRoute(Address $origin, Address $destination, Collection $addresses);
}