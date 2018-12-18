<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;

class ListenoeudsController extends ControllerBase {
    /**
     * @param null $nodetype
     * @return array
     * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
     * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
     * @throws \Drupal\Core\Entity\EntityMalformedException
     */
    public function listenoeuds($nodetype = NULL) {

        $query = $this->entityTypeManager()->getStorage('node')->getQuery();

        if($nodetype) {
            $query->condition('type', $nodetype);
        }

        $ids = $query->pager('10')->execute();

        $nodes = $this->entityTypeManager()->getStorage('node')->loadMultiple($ids);
//ksm($nodes);
        $items = [];
        foreach($nodes as $node) {
            $items[] = $node->toLink();
        }
        $list = [
            '#theme' => 'item_list',
            '#items' => $items,
            '#title' => $this->t('Node list'),
        ];

        $pager = ['#type' => 'pager'];

        return ['list' => $list,
                'pager' => $pager,
            '#cache' => [
                'keys' =>['hello:node_list', 'node_type_list'],
                'tags' => ['node_list'],
                'contexts' => ['url'],
            ],
            ];

    }


}

