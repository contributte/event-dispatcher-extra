<?php declare(strict_types = 1);

use Contributte\EventDispatcher\DI\EventDispatcherExtension;
use Contributte\Events\Extra\DI\EventSecurityBridgeExtension;
use Contributte\Tester\Toolkit;
use Contributte\Tester\Utils\ContainerBuilder;
use Contributte\Tester\Utils\Neonkit;
use Nette\Bridges\HttpDI\HttpExtension;
use Nette\Bridges\HttpDI\SessionExtension;
use Nette\Bridges\SecurityDI\SecurityExtension;
use Nette\DI\Compiler;
use Nette\Security\SimpleIdentity;
use Nette\Security\User;
use Tester\Assert;
use Tests\Fixtures\FakeLoggedInSubscriber;

require_once __DIR__ . '/../../bootstrap.php';

Toolkit::test(function (): void {
	Assert::exception(function (): void {
		ContainerBuilder::of()
			->withCompiler(function (Compiler $compiler): void {
				$compiler->addExtension('events2security', new EventSecurityBridgeExtension());
			})->build();
	}, LogicException::class, 'Service of type "Nette\Security\User" is needed. Please register it.');
});

Toolkit::test(function (): void {
	$container = ContainerBuilder::of()
		->withCompiler(function (Compiler $compiler): void {
			$compiler->addConfig(Neonkit::load(<<<'NEON'
				services:
					fake.loggedin.subscriber: Tests\Fixtures\FakeLoggedInSubscriber
			NEON
			));
			$compiler->addExtension('security', new SecurityExtension());
			$compiler->addExtension('session', new SessionExtension());
			$compiler->addExtension('http', new HttpExtension());
			$compiler->addExtension('events', new EventDispatcherExtension());
			$compiler->addExtension('events2security', new EventSecurityBridgeExtension());
		})->build();

	// Subscriber is still not created
	Assert::false($container->isCreated('fake.loggedin.subscriber'));

	/** @var User $user */
	$user = $container->getByType(User::class);
	Assert::count(1, $user->onLoggedIn);

	/** @var FakeLoggedInSubscriber $subscriber */
	$subscriber = $container->getByType(FakeLoggedInSubscriber::class);
	$user->login(new SimpleIdentity(1));

	Assert::count(1, $subscriber->onCall);
	Assert::equal($user, $subscriber->onCall[0]->getUser());
});
