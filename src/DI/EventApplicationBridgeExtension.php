<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\DI;

use Contributte\Events\Extra\Event\Application\ApplicationEvents;
use Contributte\Events\Extra\Event\Application\ErrorEvent;
use Contributte\Events\Extra\Event\Application\PresenterEvent;
use Contributte\Events\Extra\Event\Application\PresenterShutdownEvent;
use Contributte\Events\Extra\Event\Application\PresenterStartupEvent;
use Contributte\Events\Extra\Event\Application\RequestEvent;
use Contributte\Events\Extra\Event\Application\ResponseEvent;
use Contributte\Events\Extra\Event\Application\ShutdownEvent;
use Contributte\Events\Extra\Event\Application\StartupEvent;
use LogicException;
use Nette\Application\Application;
use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\PhpLiteral;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EventApplicationBridgeExtension extends CompilerExtension
{

	/**
	 * Build bridge into nette application events
	 */
	public function beforeCompile(): void
	{
		$builder = $this->getContainerBuilder();

		if ($builder->getByType(Application::class) === null) {
			throw new LogicException(sprintf('Service of type "%s" is needed. Please register it.', Application::class));
		}

		if ($builder->getByType(EventDispatcher::class) === null) {
			throw new LogicException(sprintf('Service of type "%s" is needed. Please register it.', EventDispatcher::class));
		}

		$dispatcher = $builder->getDefinition($builder->getByType(EventDispatcher::class));

		$application = $builder->getDefinition($builder->getByType(Application::class));

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

		$application->addSetup('?->onPresenter[] = function($application, $presenter) {if(!property_exists($presenter, "onStartup")){return;} $presenter->onStartup[] = function() use ($presenter) {?->dispatch(?, new ?($presenter));};}', [
			'@self',
			$dispatcher,
			ApplicationEvents::ON_PRESENTER_STARTUP,
			new PhpLiteral(PresenterStartupEvent::class),
		]);

		$application->addSetup('?->onPresenter[] = function($application, $presenter) {if(!property_exists($presenter, "onShutdown")){return;} $presenter->onShutdown[] = function() use ($presenter) {?->dispatch(?, new ?($presenter));};}', [
			'@self',
			$dispatcher,
			ApplicationEvents::ON_PRESENTER_SHUTDOWN,
			new PhpLiteral(PresenterShutdownEvent::class),
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
