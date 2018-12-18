<?php

namespace Drupal\hello\Plugin\Block;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Component\Datetime\Time;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\UserInterface;

/**
 * Provides a hello block.
 * @Block(
 *   id = "sessions_block",
 *   admin_label = @Translation("Sessions actives!")
 * )
 */
class Sessions extends BlockBase
{
    /**
     * @param AccountInterface $account
     * @return AccessResult
     */
    protected function blockAccess(AccountInterface $account)
    {
        return AccessResult::allowedIfHasPermission($account, 'permission block Sessions' );
    }

    /**
     * Implements Drupal\Core\Block\Blockbase::build().
     */

    public function build()
    {

        $database = \Drupal::database();
        $session_num = $database->select('sessions',  's')
            ->countQuery()
            ->execute()
            ->fetchField();


        $build =
            [
                '#markup' => $this->t('Il y a actuellement %sessions sessions actives',
                    ['%sessions' => $session_num]),
                '#cache' =>
                    ['keys' => ['cle_buildsessions'],
                        'max-age' => '0',
                    ],
            ];


        return $build;

    }
}
