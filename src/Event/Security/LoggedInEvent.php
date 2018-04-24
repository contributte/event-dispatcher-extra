<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Security;

use Nette\Security\User;
use Symfony\Component\EventDispatcher\Event;

class LoggedInEvent extends Event
{

	public const NAME = SecurityEvents::ON_LOGGED_IN;

	/** @var User */
	private $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function getUser(): User
	{
		return $this->user;
	}

}
