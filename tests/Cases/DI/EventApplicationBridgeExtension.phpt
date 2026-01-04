<?php declare(strict_types = 1);

use Contributte\EventDispatcher\DI\EventDispatcherExtension;
use Contributte\Events\Extra\DI\EventApplicationBridgeExtension;
use Contributte\Tester\Toolkit;
use Contributte\Tester\Utils\ContainerBuilder;
use Contributte\Tester\Utils\Neonkit;
use Nette\Application\Application;
use Nette\Application\Responses\VoidResponse;
use Nette\Bridges\ApplicationDI\ApplicationExtension;
use Nette\Bridges\HttpDI\HttpExtension;
use Nette\DI\Compiler;
use Nette\Utils\Arrays;
use Tester\Assert;
use Tests\Fixtures\FakePresenter;
use Tests\Fixtures\FakePresenterShutdownSubscriber;
use Tests\Fixtures\FakePresenterStartupSubscriber;
use Tests\Fixtures\FakeStartupSubscriber;

require_once __DIR__ . '/../../bootstrap.php';

Toolkit::test(function (): void {
	Assert::exception(function (): void {
		ContainerBuilder::of()
			->withCompiler(function (Compiler $compiler): void {
				$compiler->addExtension('events2application', new EventApplicationBridgeExtension());
			})->build();
	}, LogicException::class, 'Service of type "Nette\Application\Application" is needed. Please register it.');
});

Toolkit::test(function (): void {
	$container = ContainerBuilder::of()
		->withCompiler(function (Compiler $compiler): void {
			$compiler->addConfig(Neonkit::load(<<<'NEON'
				services:
					- Nette\Application\Routers\RouteList
					fake.startup.startupSubscriber: Tests\Fixtures\FakeStartupSubscriber
					fake.presenter.startup.startupSubscriber: Tests\Fixtures\FakePresenterStartupSubscriber
					fake.presenter.startup.shutdownSubscriber: Tests\Fixtures\FakePresenterShutdownSubscriber
			NEON
			));
			$compiler->addExtension('application', new ApplicationExtension());
			$compiler->addExtension('http', new HttpExtension());
			$compiler->addExtension('events', new EventDispatcherExtension());
			$compiler->addExtension('events2application', new EventApplicationBridgeExtension());
		})->build();

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
	Arrays::invoke($application->onPresenter, $application, $presenter);
	Arrays::invoke($presenter->onStartup, $presenter);
	$response = new VoidResponse();
	Arrays::invoke($presenter->onShutdown, $presenter, $response);

	/** @var FakePresenterStartupSubscriber $presenterStartupSubscriber */
	$presenterStartupSubscriber = $container->getByType(FakePresenterStartupSubscriber::class);
	Assert::count(1, $presenterStartupSubscriber->onCall);
	Assert::same($presenter, $presenterStartupSubscriber->onCall[0]->getPresenter());

	/** @var FakePresenterShutdownSubscriber $presenterShutdownSubscriber */
	$presenterShutdownSubscriber = $container->getByType(FakePresenterShutdownSubscriber::class);
	Assert::count(1, $presenterShutdownSubscriber->onCall);
	Assert::same($presenter, $presenterShutdownSubscriber->onCall[0]->getPresenter());
	Assert::same($response, $presenterShutdownSubscriber->onCall[0]->getResponse());
});
