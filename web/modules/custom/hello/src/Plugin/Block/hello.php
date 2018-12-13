<?php

namespace Drupal\hello\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Component\Datetime\Time;
use Drupal\user\UserInterface;

/**
 * Provides a hello block.
 * @Block(
 *   id = "hello_block",
 *   admin_label = @Translation("Hello!")
 * )
 */
class Hello extends BlockBase {

/**
 * Implements Drupal\Core\Block\Blockbase::build().
 */

    public function build() {
        $username = \Drupal::service('current_user')->getAccountName();
        $date = \Drupal::service('datetime.time')->getCurrentTime();
        $dateformat = \Drupal::service('date.formatter')->format($date, 'custom', 'H:i:s');

        $build =
            [
                '#markup' => $this->t('Welcom! %username - %date',
                ['%date' => $dateformat, '%username' => $username]),
                '#cache' =>
                    ['keys' => ['cle_build'],
                        'max-age' => '1000',
                        'contexts' => ['user', 'timezone']
                    ],
        ];
        return $build;

}
}
