<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\DI;

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
use Nette\Application\UI\Presenter;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\ServiceDefinition;
use Nette\PhpGenerator\Literal;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

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

		if ($builder->getByType(EventDispatcherInterface::class) === null) {
			throw new LogicException(sprintf('Service of type "%s" is needed. Please register it.', EventDispatcherInterface::class));
		}

		$dispatcher = $builder->getDefinition($builder->getByType(EventDispatcherInterface::class));

		$application = $builder->getDefinition($builder->getByType(Application::class));
		assert($application instanceof ServiceDefinition);

		$application->addSetup('?->onStartup[] = function() {?->dispatch(new ?(...func_get_args()));}', [
			'@self',
			$dispatcher,
			new Literal(StartupEvent::class),
		]);

		$application->addSetup('?->onError[] = function() {?->dispatch(new ?(...func_get_args()));}', [
			'@self',
			$dispatcher,
			new Literal(ErrorEvent::class),
		]);

		$application->addSetup('?->onPresenter[] = function() {?->dispatch(new ?(...func_get_args()));}', [
			'@self',
			$dispatcher,
			new Literal(PresenterEvent::class),
		]);

		$application->addSetup('?->onPresenter[] = function($application, $presenter) {if(!$presenter instanceof ?){return;} $presenter->onStartup[] = function() {?->dispatch(new ?(...func_get_args()));};}', [
			'@self',
			new Literal(Presenter::class),
			$dispatcher,
			new Literal(PresenterStartupEvent::class),
		]);

		$application->addSetup('?->onPresenter[] = function($application, $presenter) {if(!$presenter instanceof ?){return;} $presenter->onShutdown[] = function() {?->dispatch(new ?(...func_get_args()));};}', [
			'@self',
			new Literal(Presenter::class),
			$dispatcher,
			new Literal(PresenterShutdownEvent::class),
		]);

		$application->addSetup('?->onRequest[] = function() {?->dispatch(new ?(...func_get_args()));}', [
			'@self',
			$dispatcher,
			new Literal(RequestEvent::class),
		]);

		$application->addSetup('?->onResponse[] = function() {?->dispatch(new ?(...func_get_args()));}', [
			'@self',
			$dispatcher,
			new Literal(ResponseEvent::class),
		]);

		$application->addSetup('?->onShutdown[] = function() {?->dispatch(new ?(...func_get_args()));}', [
			'@self',
			$dispatcher,
			new Literal(ShutdownEvent::class),
		]);
	}

}
