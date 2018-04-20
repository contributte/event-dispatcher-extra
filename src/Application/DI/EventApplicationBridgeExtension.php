<?php

namespace Contributte\Events\Extra\Application\DI;

use Contributte\Events\Extra\Application\Event\ApplicationEvents;
use Contributte\Events\Extra\Application\Event\ErrorEvent;
use Contributte\Events\Extra\Application\Event\PresenterEvent;
use Contributte\Events\Extra\Application\Event\RequestEvent;
use Contributte\Events\Extra\Application\Event\ResponseEvent;
use Contributte\Events\Extra\Application\Event\ShutdownEvent;
use Contributte\Events\Extra\Application\Event\StartupEvent;
use LogicException;
use Nette\Application\Application;
use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\PhpLiteral;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class EventApplicationBridgeExtension extends CompilerExtension
{

	/**
	 * Build bridge into nette application events
	 *
	 * @return void
	 */
	public function beforeCompile()
	{
		$builder = $this->getContainerBuilder();

		if (!$builder->getByType(Application::class)) {
			throw new LogicException(sprintf('Service of type "%s" is needed. Please register it.', Application::class));
		}

		if (!$builder->getByType(EventDispatcher::class)) {
			throw new LogicException(sprintf('Service of type "%s" is needed. Please register it.', EventDispatcher::class));
		}

		$application = $builder->getDefinition($builder->getByType(Application::class));
		$dispatcher = $builder->getDefinition($builder->getByType(EventDispatcher::class));

		$application->addSetup('?->onStartup[] = function() {?->dispatch(?, new ?(...func_get_args()));}', [
			'@self',
			$dispatcher,
			ApplicationEvents::ON_STARTUP,
			new PhpLiteral(StartupEvent::class),
		]);
		$application->addSetup('?->onError[] = function() {?->dispatch(?, new ?(...func_get_args()));}', [
			'@self',
			$dispatcher,
			ApplicationEvents::ON_ERROR,
			new PhpLiteral(ErrorEvent::class),
		]);
		$application->addSetup('?->onPresenter[] = function() {?->dispatch(?, new ?(...func_get_args()));}', [
			'@self',
			$dispatcher,
			ApplicationEvents::ON_PRESENTER,
			new PhpLiteral(PresenterEvent::class),
		]);
		$application->addSetup('?->onRequest[] = function() {?->dispatch(?, new ?(...func_get_args()));}', [
			'@self',
			$dispatcher,
			ApplicationEvents::ON_REQUEST,
			new PhpLiteral(RequestEvent::class),
		]);
		$application->addSetup('?->onResponse[] = function() {?->dispatch(?, new ?(...func_get_args()));}', [
			'@self',
			$dispatcher,
			ApplicationEvents::ON_RESPONSE,
			new PhpLiteral(ResponseEvent::class),
		]);
		$application->addSetup('?->onShutdown[] = function() {?->dispatch(?, new ?(...func_get_args()));}', [
			'@self',
			$dispatcher,
			ApplicationEvents::ON_SHUTDOWN,
			new PhpLiteral(ShutdownEvent::class),
		]);
	}

}
