<?php declare(strict_types = 1);

/**
 * Test: DI\EventApplicationBridgeExtension
 */

use Contributte\EventDispatcher\DI\EventDispatcherExtension;
use Contributte\Events\Extra\DI\EventApplicationBridgeExtension;
use Nette\Application\Application;
use Nette\Bridges\ApplicationDI\ApplicationExtension;
use Nette\Bridges\HttpDI\HttpExtension;
use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;
use Tester\Assert;
use Tester\FileMock;
use Tests\Fixtures\FakePresenter;
use Tests\Fixtures\FakePresenterShutdownSubscriber;
use Tests\Fixtures\FakePresenterStartupSubscriber;
use Tests\Fixtures\FakeStartupSubscriber;

require_once __DIR__ . '/../../bootstrap.php';

test(function (): void {
	Assert::exception(function (): void {
		$loader = new ContainerLoader(TEMP_DIR, true);
		$loader->load(function (Compiler $compiler): void {
			$compiler->addExtension('events2application', new EventApplicationBridgeExtension());
		}, 1);
	}, LogicException::class, 'Service of type "Nette\Application\Application" is needed. Please register it.');
});

test(function (): void {
	$loader = new ContainerLoader(TEMP_DIR, true);
	$class = $loader->load(function (Compiler $compiler): void {
		$compiler->loadConfig(FileMock::create('
			services:
				- Nette\Application\Routers\RouteList
				fake.startup.startupSubscriber: Tests\Fixtures\FakeStartupSubscriber
				fake.presenter.startup.startupSubscriber: Tests\Fixtures\FakePresenterStartupSubscriber
				fake.presenter.startup.shutdownSubscriber: Tests\Fixtures\FakePresenterShutdownSubscriber
		', 'neon'));
		$compiler->addExtension('application', new ApplicationExtension());
		$compiler->addExtension('http', new HttpExtension());
		$compiler->addExtension('events', new EventDispatcherExtension());
		$compiler->addExtension('events2application', new EventApplicationBridgeExtension());
	}, 2);

	/** @var Container $container */
	$container = new $class();

	// Subscriber is still not created
	Assert::false($container->isCreated('fake.startup.startupSubscriber'));

	/** @var Application $application */
	$application = $container->getByType(Application::class);
	Assert::count(1, $application->onStartup);
	Assert::count(3, $application->onPresenter); // onPresenter, onPresenterStartup, onPresenterShutdown

	$application->run();

	/** @var FakeStartupSubscriber $startupSubscriber */
	$startupSubscriber = $container->getByType(FakeStartupSubscriber::class);
	Assert::count(1, $startupSubscriber->onCall);
	Assert::same($application, $startupSubscriber->onCall[0]->getApplication());

	$presenter = new FakePresenter();
	$application->onPresenter($application, $presenter);
	$presenter->onStartup($presenter);
	$presenter->onShutdown($presenter, null);

	/** @var FakePresenterStartupSubscriber $presenterStartupSubscriber */
	$presenterStartupSubscriber = $container->getByType(FakePresenterStartupSubscriber::class);
	Assert::count(1, $presenterStartupSubscriber->onCall);
	Assert::same($presenter, $presenterStartupSubscriber->onCall[0]->getPresenter());

	/** @var FakePresenterShutdownSubscriber $presenterShutdownSubscriber */
	$presenterShutdownSubscriber = $container->getByType(FakePresenterShutdownSubscriber::class);
	Assert::count(1, $presenterShutdownSubscriber->onCall);
	Assert::same($presenter, $presenterShutdownSubscriber->onCall[0]->getPresenter());
	Assert::null($presenterShutdownSubscriber->onCall[0]->getResponse());
});
