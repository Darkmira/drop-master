<?php

namespace Drop\Master\Controller;

use Pimple\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DDesrosiers\SilexAnnotations\Annotations as SLX;
use Alcalyn\SerializableApiResponse\ApiResponse;
use Drop\Master\Entity\Player;
use Drop\Master\Entity\Team;
use Drop\Master\Event\RaceEvent;

/**
 * @SLX\Controller(prefix="/api")
 */
class OrderController
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
     * Process players votes posted from observers.
     *
     * @SLX\Route(
     *      @SLX\Request(method="POST", uri="orders"),
     * )
     *
     * @param Request $request
     *
     * @return ApiResponse
     */
    public function postOrders(Request $request) : ApiResponse
    {
        $orders = $this
            ->container['serializer']
            ->deserialize($request->getContent(), 'array<Drop\Master\Entity\Order>', 'json')
        ;

        $this->container['app.orders_processor']->processOrders($orders);

        $this->container['orm.em']->flush();

        $race = $this->container['app.race_state']->getRaceState();

        $this->container['dispatcher']->dispatch(RaceEvent::RACE_CHANGED, new RaceEvent($race));

        return new ApiResponse(null, Response::HTTP_OK);
    }
}
