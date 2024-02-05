<?php declare(strict_types = 1);

use Contributte\EventDispatcher\DI\EventDispatcherExtension;
use Contributte\Events\Extra\DI\EventLatteBridgeExtension;
use Contributte\Tester\Environment;
use Contributte\Tester\Toolkit;
use Contributte\Tester\Utils\ContainerBuilder;
use Contributte\Tester\Utils\Neonkit;
use Latte\Runtime\Template;
use Nette\Application\Application;
use Nette\Bridges\ApplicationDI\ApplicationExtension;
use Nette\Bridges\ApplicationDI\LatteExtension;
use Nette\Bridges\ApplicationLatte\LatteFactory;
use Nette\Bridges\ApplicationLatte\TemplateFactory;
use Nette\Bridges\HttpDI\HttpExtension;
use Nette\DI\Compiler;
use Tester\Assert;
use Tests\Fixtures\FakeLatteSubscriber;
use Tests\Fixtures\FakeTemplateCreateSubscriber;

require_once __DIR__ . '/../../bootstrap.php';

Toolkit::test(function (): void {
	Assert::exception(function (): void {
		ContainerBuilder::of()
			->withCompiler(function (Compiler $compiler): void {
				$compiler->addExtension('events2latte', new EventLatteBridgeExtension());
			})->build();
	}, LogicException::class, 'Service of type "Nette\Bridges\ApplicationLatte\LatteFactory" is needed. Please register it.');
});

Toolkit::test(function (): void {
	$container = ContainerBuilder::of()
		->withCompiler(function (Compiler $compiler): void {
			$compiler->addConfig(Neonkit::load(<<<'NEON'
				services:
					- Nette\Application\Routers\RouteList
					fake.latte.compile.subscriber: Tests\Fixtures\FakeLatteSubscriber
			NEON
			));
			$compiler->addExtension('application', new ApplicationExtension());
			$compiler->addExtension('http', new HttpExtension());
			$compiler->addExtension('latte', new LatteExtension(Environment::getTestDir()));
			$compiler->addExtension('events', new EventDispatcherExtension());
			$compiler->addExtension('events2latte', new EventLatteBridgeExtension());
		})->build();

	// Subscriber is still not created
	Assert::false($container->isCreated('fake.latte.compile.subscriber'));

	/** @var Application $application */
	$application = $container->getByType(Application::class);
	/** @var LatteFactory $factory */
	$factory = $container->getByType(LatteFactory::class);
	$engine = $factory->create();
	Assert::count(3, $engine->getExtensions());

	/** @var FakeLatteSubscriber $subscriber */
	$subscriber = $container->getByType(FakeLatteSubscriber::class);
	$application->run();

	$engine->renderToString(__DIR__ . '/../../Fixtures/LatteTestFile.latte'); //trigger onCompile
	Assert::count(2, $subscriber->onCall);
	Assert::equal($engine, $subscriber->onCall[0]->getEngine());
	Assert::type(Template::class, $subscriber->onCall[1]->getTemplate());
});

Toolkit::test(function (): void {
	$container = ContainerBuilder::of()
		->withCompiler(function (Compiler $compiler): void {
			$compiler->addConfig(Neonkit::load(<<<'NEON'
				services:
					- Nette\Application\Routers\RouteList
					fake.template.create.subscriber: Tests\Fixtures\FakeTemplateCreateSubscriber
			NEON
			));
			$compiler->addExtension('application', new ApplicationExtension());
			$compiler->addExtension('http', new HttpExtension());
			$compiler->addExtension('latte', new LatteExtension(Environment::getTestDir()));
			$compiler->addExtension('events', new EventDispatcherExtension());
			$compiler->addExtension('events2latte', new EventLatteBridgeExtension());
		})->build();

	// Subscriber is still not created
	Assert::false($container->isCreated('fake.template.create.subscriber'));

	/** @var TemplateFactory $factory */
	$factory = $container->getByType(TemplateFactory::class);
	Assert::count(1, $factory->onCreate);

	/** @var FakeTemplateCreateSubscriber $subscriber */
	$subscriber = $container->getByType(FakeTemplateCreateSubscriber::class);

	$template = $factory->createTemplate(); // trigger onCreate
	Assert::count(1, $subscriber->onCall);
	Assert::equal($template, $subscriber->onCall[0]->getTemplate());
});
