<?php

namespace Drupal\hello\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Access\AccessCheckInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Determines access to routes based on login status of current user.
 */
class HelloAccessCheck implements AccessCheckInterface {

    public function applies(Route $route)
    {
        return NULL;
    }

    public function access(Route $route, Request $request = NULL, AccountInterface $account) {

        $param = $route->getRequirement('_access_hello');

        if(!$account->isAnonymous() && (REQUEST_TIME - $account->getAccount()->created ) > $param * 3600) {

            return AccessResult::allowed();
        }

        return AccessResult::forbidden()->cachePerUser();
    }
}
