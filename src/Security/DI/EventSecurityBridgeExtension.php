<?php

namespace Contributte\Events\Extra\Security\DI;

use Contributte\Events\Extra\Security\Event\LoggedInEvent;
use Contributte\Events\Extra\Security\Event\LoggedOutEvent;
use Contributte\Events\Extra\Security\Event\SecurityEvents;
use LogicException;
use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\PhpLiteral;
use Nette\Security\User;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class EventSecurityBridgeExtension extends CompilerExtension
{

	/**
	 * Build bridge into nette application events
	 *
	 * @return void
	 */
	public function beforeCompile()
	{
		$builder = $this->getContainerBuilder();

		if (!$builder->getByType(User::class)) {
			throw new LogicException(sprintf('Service of type "%s" is needed. Please register it.', User::class));
		}

		if (!$builder->getByType(EventDispatcher::class)) {
			throw new LogicException(sprintf('Service of type "%s" is needed. Please register it.', EventDispatcher::class));
		}

		$user = $builder->getDefinition($builder->getByType(User::class));
		$dispatcher = $builder->getDefinition($builder->getByType(EventDispatcher::class));

		$user->addSetup('?->onLoggedIn[] = function() {?->dispatch(?, new ?(...func_get_args()));}', [
			'@self',
			$dispatcher,
			SecurityEvents::ON_LOGGED_IN,
			new PhpLiteral(LoggedInEvent::class),
		]);
		$user->addSetup('?->onLoggedOut[] = function() {?->dispatch(?, new ?(...func_get_args()));}', [
			'@self',
			$dispatcher,
			SecurityEvents::ON_LOGGED_OUT,
			new PhpLiteral(LoggedOutEvent::class),
		]);
	}

}
