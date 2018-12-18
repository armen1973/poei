<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\user\UserInterface;

class UserstatisticsController extends ControllerBase {

    public function content(UserInterface $user) {
        $database = \Drupal::database();
        $result = $database->select('hello_user_statistics', 'hus')
                ->fields('hus', [])
                ->condition('uid', $user->id())
                ->execute();

        $items = [];
        $connexions = 0;
        foreach($result as $cle) {
            $items[] = [
                $cle->action == 1 ? $this->t('Login') : $this->t('logout'),
                \Drupal::service('date.formatter')->format($cle->time)
            ];
            $connexions = $connexions + $cle->action;
        }

        $message = [
            '#theme' => 'hello',
            '#user' => $user,
            '#count' => $connexions,
        ];



        $table = [
            '#type' => 'table',
            '#header' => ['Action', 'Time'],
            '#rows' =>  $items,
        ];


        return [
            'message' => $message,
            'table' => $table
            ];
    }
}

