# Event Dispatcher > Nette Application Bridge

## Content :gift:

- [Usage - how to register](#usage-tada)
- [Bridge - nette application](#bridge-wrench)
- [Command - example command](#subscriber-bulb)

## Usage :tada:

```yaml
extensions:
    events: Contributte\EventDispatcher\DI\EventDispatcherExtension
    events2application: Contributte\Events\Extra\Application\DI\EventApplicationBridgeExtension
```

## Bridge :wrench:

There are several Nette Application events on which you can listen to.

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
