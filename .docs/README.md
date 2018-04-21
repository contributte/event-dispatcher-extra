# Event Dispatcher Extra :recycle:

## Content :gift:

- [Usage - how to register](#usage-tada)
- [Bridge - events list](#bridge-wrench)
- [Command - example command](#subscriber-bulb)

## Usage :tada:

```yaml
extensions:
    events: Contributte\EventDispatcher\DI\EventDispatcherExtension
    events2application: Contributte\Events\Extra\Application\DI\EventApplicationBridgeExtension
    events2security: Contributte\Events\Extra\Security\DI\EventSecurityBridgeExtension
```

## Bridge :wrench:

There are several events on which you can listen to.

**Nette Application events:**

```php
use Contributte\Events\Extra\Application\Event\ApplicationEvents;
use Contributte\Events\Extra\Application\Event\ErrorEvent;
use Contributte\Events\Extra\Application\Event\PresenterEvent;
use Contributte\Events\Extra\Application\Event\RequestEvent;
use Contributte\Events\Extra\Application\Event\ResponseEvent;
use Contributte\Events\Extra\Application\Event\ShutdownEvent;
use Contributte\Events\Extra\Application\Event\StartupEvent;
```

- `StartupEvent::NAME` && `ApplicationEvents::ON_STARTUP`
- `ShutdownEvent::NAME` && `ApplicationEvents::ON_SHUTDOWN`
- `RequestEvent::NAME` && `ApplicationEvents::ON_REQUEST`
- `PresenterEvent::NAME` && `ApplicationEvents::ON_PRESENTER`
- `ResponseEvent::NAME` && `ApplicationEvents::ON_RESPONSE`
- `ErrorEvent::NAME` && `ApplicationEvents::ON_ERROR`

**Nette Security events:**

```php
use Contributte\Events\Extra\Security\Event\LoggedInEvent;
use Contributte\Events\Extra\Security\Event\LoggedOutEvent;
```

- `LoggedInEvent::NAME` && `SecurityEvents::ON_LOGGED_IN`
- `LoggedOutEvent::NAME` && `SecurityEvents::ON_LOGGED_OUT`

## Subscriber :bulb:

```php
use Contributte\EventDispatcher\EventSubscriber;
use Contributte\Events\Extra\Application\Event\RequestEvent;

final class LogRequestSubscriber implements EventSubscriber
{

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [RequestEvent::NAME => 'onLog'];
	}

	/**
	 * @param RequestEvent $event
	 * @return void
	 */
	public function onLog(RequestEvent $event)
	{
	    // Do magic..
	}
}
```
