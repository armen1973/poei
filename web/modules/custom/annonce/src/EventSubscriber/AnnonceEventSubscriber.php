<?php

namespace Drupal\annonce\EventSubscriber;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Routing\CurrentRouteMatch;



class AnnonceEventSubscriber implements EventSubscriberInterface {
	
	protected $current_user;

	protected $current_route_match;

    protected $database;

    protected $time;

	public function __construct(AccountProxyInterface $current_user, CurrentRouteMatch $current_route_match, Connection $database, TimeInterface $time){

		$this->current_user = $current_user;
		$this->current_route_match = $current_route_match;
		$this->database = $database;
		$this->time = $time;
	}

	public static function getSubscribedEvents(){
		$events[KernelEvents::REQUEST][] = ['onRequest'];
		return $events;
	}


public function onRequest(Event $event){ 
	if($this->current_route_match->getRouteName() == 'entity.annonce.canonical') {
		drupal_set_message(t('On request ! @name', ['@name' => $this->current_user->getAccountName()]));

		$uid = $this->current_user->id();
		$date= $this->time->getRequestTime();
		$aid = $this->current_route_match->getParameter('annonce')->id();

        $this->database->insert('annonce_history')
            ->fields([
                'uid' => $uid,
                'time' => $date,
                'aid' => $aid,
            ])
            ->execute();

    }
}
}
