# Description

A PHP client for Pushover API. This is a work in progress, adding testing as endpoints are used and time allows. Each endpoint is labeled whether it has been tested yet or not in this document.

Push message attachments not done yet.

## Environment Variables

There are two environment variables that can be used instead of arguments when instantiating a new Client object. See .env.example file.

```
- $_ENV['PUSHOVER_API_TOKEN'] - API Authentication token.
- $_ENV['PUSHOVER_API_URL'] - URL of API server.
```

## Instantiating an API client.

### Arguments

- url - URL of API server. Defaults to environment variable.
- token - API authentication token. Defaults to environment variable.
- format - Output format JSON or XML. Defaults to JSON.
- verify - Verify SSL connection to API server. Defaults to true.
- error - Report HTTP errors. Defaults to false.
- timeout - Set HTTP timeout. Defaults to 20 seconds.

### Example - Using only environment variables

```php

$_ENV['PUSHOVER_API_URL'] = 'https://api.pushover.net/1/';
$_ENV['PUSHOVER_API_TOKEN'] = 'yourauthtokenhere';

$client = new Ocolin\Pushover\Client();

```

### Example - Using constructor arguments

```php
$client = new Ocolin\Pushover\Client(
       url: 'https://api.pushover.net/1/',
     token: 'yourauthtokenhere',
    format: 'json',
    verify: true,
    errors: false,
    timeout: 20
);
```

## APIS

There are multiple Pushover APIs each with their own end points. It uses the follwing format:

```
{client}->{api}->{endpoint}({arguments})
```

### Devices

#### Register (Untested)

```php
$output = $client->devices->register(
    secret: 'jhdD87hKjhd8h',
      name: 'My device',
        os: 'O'
);
```

#### Delete (Untested)

```php
$output = $client->devices->delete(
    device_id: 'lkjskdjsdf',
       secret: 'sdfgsdfgdf',
      message: 2
);
```

### Glances

https://pushover.net/api/glances

#### Update (Untested)

```php
$output = $client->glances->update(
    user: 'KJHjdk8h9dsf',
    params: [ 'text' => 'Message to widget' ]
);
```

### Groups

https://pushover.net/api/groups

#### Create (Tested)

```php
$output = $client->groups->create(
    name: 'MyGroup'
);

```

#### Groups (Tested)

```php
$output = $client->groups->groups();
```

#### Get (Tested)

```php
$output = $client->groups->get( group: 'kjhJHf7hJh72jh' );
```

#### Add User (Tested)

```php
$output = $client->groups->addUser(
    group: 'KJHjhdfkjsd',
     user: 'gRhdnml6gsji8df'
);
```

#### Remove User (Tested)

```php
$output = $client->groups->removeUser(
    group: 'KJHjhdfkjsd',
     user: 'gRhdnml6gsji8df'
);
```

#### Disable User (Tested)

```php
$output = $client->groups->disableUser(
    group: 'KJHjhdfkjsd',
     user: 'gRhdnml6gsji8df'
);
```

#### Enable User (Tested)

```php
$output = $client->groups->enableUser(
    group: 'KJHjhdfkjsd',
     user: 'gRhdnml6gsji8df'
);
```

#### Rename (Tested)
 
```php
$output = $client->groups->rename(
    group: 'KJHjhdfkjsd',
     name: 'New Name'
);
```
### Licenses

https://pushover.net/api/licensing

#### Assign (Untested)

```php
$output = $client->licenses->assign(
    email: 'test@email.com'
);
```

#### Check (Tested)

```php
$output = $client->licenses->check();
```

### Message

https://pushover.net/api#messages

#### Push (Tested)

```php
$output = $client->message->push(
       user: 'kjhs6fjhk2jhsf19hj',
    message: 'This is a message body',
     params: [ 'title' => 'This is a title' ]
);
```

Optional parameters:

- attachment - a binary image attachment to send with the message (documentation)
- attachment_base64 - a Base64-encoded image attachment to send with the message (documentation)
- attachment_type - the MIME type of the included attachment or attachment_base64 (documentation)
- device - the name of one of your devices to send just to that device instead of all devices (documentation)
- html - set to 1 to enable HTML parsing (documentation)
- priority - a value of -2, -1, 0 (default), 1, or 2 (documentation)
- sound - the name of a supported sound to override your default sound choice (documentation)
- timestamp - a Unix timestamp of a time to display instead of when our API received it (documentation)
- title - your message's title, otherwise your app's name is used
- ttl - a number of seconds that the message will live, before being deleted automatically (documentation)
- url - a supplementary URL to show with your message (documentation)
- url_title - a title for the URL specified as the url parameter, otherwise just the URL is shown (documentation)

#### Get (Untested)

```php
$output = $client->message->get(
    secret: 'KJHd7hsjqk3jh',
    device_id: 'kljshdf62j10'
);
```

### Receipts

https://pushover.net/api/receipts

#### Get (Untested)

```php
$output = $client->receipts->get( receipt: 'JKHk1262jhfs' );
```

#### Cancel (Untested)


An emergency-priority notification will continue to be sent to devices until it reaches its original expire value. To cancel an emergency-priority notification early, you can send a POST request to our API.

```php
$output = $client->receipts->cancel( receipt: 'JKHk1262jhfs' );
```

#### Cancel by tag (Untested)

```php
$output = $client->receipts->cancelByTag( tag: 'MyTag' );
```

#### Acknowledge (Untested)

```php
$output = $client->receipts->acknowledge(
    receipt: 'KJHd7hsjqk3jh',
    secret: 'JKHk1262jhfs'
);
```

### Subscriptions

https://pushover.net/api/subscriptions

#### Migrate (Untested)

```php
$output = $client->subscriptions->migrate(
    subscription: 'kjh234jhf8',
            user: 'VB2bc34nfgg'
);
```

Parameters:

- subscription (required) - your subscription's code
- user (required) - the user's Pushover user key
- device_name (optional) - a user's device name that the subscription should be limited to
- sound (optional) - a user's preferred default sound

### Teams

https://pushover.net/api/teams

#### Show (Tested)

```php
$output = $client->teams->show( team: 'kjh234he8hhj' );
```

#### Add User (Untested)

```php
$output = $client->teams->add(
    email: 'test@test.com',
    params: []
);
```

#### Remove User (Untested)

```php
$output = $client->teams->remove(
    email: 'test@test.com'
);
```

### Users

#### Validate (Tested)

https://pushover.net/api#validate

As an optional step in collecting user keys for users of your application, you may validate those keys to ensure that a user has copied them properly, that the account is valid, and that there is at least one active device on the account.

```php
$output = $client->users->validate();
```

#### Login

```php
$output = $client->users->login(
    email: 'test@test.com',
    password: 'mypassword123'
);
```