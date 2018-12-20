<?php

namespace Drupal\hello\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Determines access to routes based on login status of current user.
 */

/**
 * Class Modifrouting
 * @package Drupal\hello\Routing
 */
class Modifrouting extends RouteSubscriberBase {

    public  function alterRoutes(RouteCollection $collection)
    {
        $collection->get('entity.user.canonical')->setRequirements(['_access_hello' => '10']);
    }
}
