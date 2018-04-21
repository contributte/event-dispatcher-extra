<?php

/**
 * Test: DI\EventSecurityBridgeExtension
 */

use Contributte\EventDispatcher\DI\EventDispatcherExtension;
use Contributte\Events\Extra\Security\DI\EventSecurityBridgeExtension;
use Nette\Bridges\SecurityDI\SecurityExtension;
use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;
use Nette\Security\Identity;
use Nette\Security\User;
use Tester\Assert;
use Tester\FileMock;
use Tests\Fixtures\FakeLoggedInSubscriber;

require_once __DIR__ . '/../../bootstrap.php';

test(function () {
	Assert::exception(function () {
		$loader = new ContainerLoader(TEMP_DIR, TRUE);
		$loader->load(function (Compiler $compiler) {
			$compiler->addExtension('events2security', new EventSecurityBridgeExtension());
		}, 1);
	}, LogicException::class, 'Service of type "Nette\Security\User" is needed. Please register it.');
});

test(function () {
	$loader = new ContainerLoader(TEMP_DIR, TRUE);
	$class = $loader->load(function (Compiler $compiler) {
		$compiler->loadConfig(FileMock::create('
			services:
				security.userStorage: Tests\Fixtures\FakeUserStorage
				fake.loggedin.subscriber: Tests\Fixtures\FakeLoggedInSubscriber
		', 'neon'));
		$compiler->addExtension('security', new SecurityExtension());
		$compiler->addExtension('events', new EventDispatcherExtension());
		$compiler->addExtension('events2security', new EventSecurityBridgeExtension());
	}, 2);

	/** @var Container $container */
	$container = new $class;

	// Subscriber is still not created
	Assert::false($container->isCreated('fake.loggedin.subscriber'));

	/** @var User $user */
	$user = $container->getByType(User::class);
	Assert::count(1, $user->onLoggedIn);

	/** @var FakeLoggedInSubscriber $subscriber */
	$subscriber = $container->getByType(FakeLoggedInSubscriber::class);
	$user->login(new Identity(1));

	Assert::count(1, $subscriber->onCall);
	Assert::equal($user, $subscriber->onCall[0]->getUser());
});
