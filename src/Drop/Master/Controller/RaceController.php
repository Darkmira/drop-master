<?php

namespace Drop\Master\Controller;

use Pimple\Container;
use Symfony\Component\HttpFoundation\Response;
use DDesrosiers\SilexAnnotations\Annotations as SLX;
use Alcalyn\SerializableApiResponse\ApiResponse;

/**
 * @SLX\Controller(prefix="/api")
 */
class RaceController
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Get all race information.
     *
     * @SLX\Route(
     *      @SLX\Request(method="GET", uri="race"),
     * )
     *
     * @return ApiResponse
     */
    public function getRace() : ApiResponse
    {
        $raceState = $this->container['app.race_state']->getRaceState();

        return new ApiResponse($raceState, Response::HTTP_OK);
    }
}
