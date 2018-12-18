<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

class HelloController extends ControllerBase {
    /**
     * @param string $param
     * @return array
     */
    public function content($param = '') {
        $message = $this->t('Vous êtes sur la page Hello. Votre nom d\'utilisateur est %username voici le paramètre dans l’URL %param',
            ['%username' => $this->currentUser()->getAccountName(), '%param' => $param]);
        return ['#markup' => $message];
    }

    public function json() {
        $response = new JsonResponse();

        $response->setData(['1' => 'toto', '2' => 'titi', '3' => 'koko']);

        return $response;
    }
}

