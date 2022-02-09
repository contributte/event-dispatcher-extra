<?php declare(strict_types = 1);

/**
 * Test: DI\EventLatteBridgeExtension
 */

use Contributte\EventDispatcher\DI\EventDispatcherExtension;
use Contributte\Events\Extra\DI\EventLatteBridgeExtension;
use Nette\Application\Application;
use Nette\Application\UI\ITemplateFactory;
use Nette\Bridges\ApplicationDI\ApplicationExtension;
use Nette\Bridges\ApplicationDI\LatteExtension;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\Bridges\ApplicationLatte\TemplateFactory;
use Nette\Bridges\HttpDI\HttpExtension;
use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;
use Tester\Assert;
use Tester\FileMock;
use Tests\Fixtures\FakeLatteCompileSubscriber;
use Tests\Fixtures\FakeTemplateCreateSubscriber;

require_once __DIR__ . '/../../bootstrap.php';

test(function (): void {
	Assert::exception(function (): void {
		$loader = new ContainerLoader(TEMP_DIR, true);
		$loader->load(function (Compiler $compiler): void {
			$compiler->addExtension('events2latte', new EventLatteBridgeExtension());
		}, __FILE__ . '1');
	}, LogicException::class, 'Service of type "Nette\Bridges\ApplicationLatte\ILatteFactory" is needed. Please register it.');
});

test(function (): void {
	$loader = new ContainerLoader(TEMP_DIR, true);
	$class = $loader->load(function (Compiler $compiler): void {
		$compiler->loadConfig(FileMock::create('
			services:
				- Nette\Application\Routers\RouteList
				fake.latte.compile.subscriber: Tests\Fixtures\FakeLatteCompileSubscriber
		', 'neon'));
		$compiler->addExtension('application', new ApplicationExtension());
		$compiler->addExtension('http', new HttpExtension());
		$compiler->addExtension('latte', new LatteExtension(TEMP_DIR));
		$compiler->addExtension('events', new EventDispatcherExtension());
		$compiler->addExtension('events2latte', new EventLatteBridgeExtension());
	}, __FILE__ . '2');

	/** @var Container $container */
	$container = new $class();

	// Subscriber is still not created
	Assert::false($container->isCreated('fake.latte.compile.subscriber'));

	/** @var Application $application */
	$application = $container->getByType(Application::class);
	/** @var ILatteFactory $factory */
	$factory = $container->getByType(ILatteFactory::class);
	$engine = $factory->create();
	Assert::count(1, $engine->onCompile);

	/** @var FakeLatteCompileSubscriber $subscriber */
	$subscriber = $container->getByType(FakeLatteCompileSubscriber::class);
	$application->run();

	$engine->renderToString(__DIR__ . '/../../Fixtures/LatteCompileTestFile.latte'); //trigger onCompile
	Assert::count(1, $subscriber->onCall);
	Assert::equal($engine, $subscriber->onCall[0]->getEngine());
});

test(function (): void {
	$loader = new ContainerLoader(TEMP_DIR, true);
	$class = $loader->load(function (Compiler $compiler): void {
		$compiler->loadConfig(FileMock::create('
			services:
				- Nette\Application\Routers\RouteList
				fake.template.create.subscriber: Tests\Fixtures\FakeTemplateCreateSubscriber
		', 'neon'));
		$compiler->addExtension('application', new ApplicationExtension());
		$compiler->addExtension('http', new HttpExtension());
		$compiler->addExtension('latte', new LatteExtension(TEMP_DIR));
		$compiler->addExtension('events', new EventDispatcherExtension());
		$compiler->addExtension('events2latte', new EventLatteBridgeExtension());
	}, __FILE__ . '3');

	/** @var Container $container */
	$container = new $class();

	// Subscriber is still not created
	Assert::false($container->isCreated('fake.template.create.subscriber'));

	/** @var TemplateFactory $factory */
	$factory = $container->getByType(ITemplateFactory::class);
	Assert::count(1, $factory->onCreate);

	/** @var FakeTemplateCreateSubscriber $subscriber */
	$subscriber = $container->getByType(FakeTemplateCreateSubscriber::class);

	$template = $factory->createTemplate(); // trigger onCreate
	Assert::count(1, $subscriber->onCall);
	Assert::equal($template, $subscriber->onCall[0]->getTemplate());
});
