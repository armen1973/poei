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
        foreach($result as $cle) {
            $items[] = [
                $cle->action == 1 ? $this->t('Login') : $this->t('logout'),
                \Drupal::service('date.formatter')->format($cle->time)
            ];
        }
        $table = [
            '#type' => 'table',
            '#header' => ['Action', 'Time'],
            '#rows' =>  $items,
        ];


        return $table;


    }
}

