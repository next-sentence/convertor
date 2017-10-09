<?php

namespace AppBundle\Controller;

use AppBundle\Adapter\SQLAdapter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $eq = $this->get(SQLAdapter::class)->find(['test' => 'value']);

        return JsonResponse::create(['eq' => $eq]);
    }
}
