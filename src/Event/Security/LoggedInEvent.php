<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Security;

use Nette\Security\User;
use Symfony\Contracts\EventDispatcher\Event;

class LoggedInEvent extends Event
{

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
