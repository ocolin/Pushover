# Description

A PHP client for Pushover API. This is a work in progress, adding testing as endpoints are used and time allows. Each endpoint is labeled whether it has been tested yet or not in this document.

## Installation

Easily install using composer.

```
composer require ocolin/pushover --no-dev
```

## Environment Variables

There is an environment variable that can be used instead of as an argument when instantiating a new Client object. See .env.example file.

```
- $_ENV['PUSHOVER_API_TOKEN'] - API Authentication token.
```

## Instantiating an API client.

### Required Arguments

- token   - API authentication token. Defaults to environment variable.

### Optional arguments

- format  - Output format JSON or XML. Defaults to JSON.
- verify  - Verify SSL connection to API server. Defaults to true.
- timeout - Set HTTP timeout. Defaults to 20 seconds.

### Example - Using only environment variables

```php

$_ENV['PUSHOVER_API_TOKEN'] = 'yourauthtokenhere';

$client = new Ocolin\Pushover\Client();

```

### Example - Using constructor arguments

```php
$client = new Ocolin\Pushover\Client(
      token: 'yourauthtokenhere',
     format: 'json',
     verify: true,
    timeout: 20
);
```

## APIS

There are multiple Pushover APIs each with their own end points. It uses the follwing format:

```
{client}->{api}->{endpoint}({arguments})
```

### TOC

- [Devices](#Devices)
- [Glances](#Glances)
- [Groups](#Groups)
- [Licenses](#Licenses)
- [Message](#Message)
- [Receipts](#Receipts)
- [Subscriptions](#Subscriptions)
- [Teams](#Teams)
- [Sounds](#Sounds)
- [Apps](#Apps)

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

Update your widget.

Parameters:

- user (required) - the user's Pushover user key
- device (optional) a user's device name to restrict messages to the widget on that device, otherwise leave blank to send messages to all available widgets of that user

Updatable fields:

- title (100 characters) - a description of the data being shown, such as "Widgets Sold"
- text (100 characters) - the main line of data, used on most screens
- subtext (100 characters) - a second line of data
- count (integer, may be negative) - shown on smaller screens; useful for simple counts
- percent (integer 0 through 100, inclusive) - shown on some screens as a progress bar/circle

```php
$output = $client->glances->update(
    user: 'KJHjdk8h9dsf',
    params: [ 'text' => 'Message to widget' ]
);
```

### Groups

https://pushover.net/api/groups

#### Create (Tested)

Create a new group. Key will be provided in response.

Parameters:

- name (required) - the group's name

```php
$output = $client->groups->create(
    name: 'MyGroup'
);

```

#### Groups (Tested)

Fetch a list of groups.

```php
$output = $client->groups->groups();
```

#### Get (Tested)

Get information on a group, including users in it.

Parameters:

- group - (Required) Key of group to query.

```php
$output = $client->groups->get( group: 'kjhJHf7hJh72jh' );
```

#### Add User (Tested)

Add a user to a group.

Parameters:

- group (required) - Key of group to add user to
- user (required) - The user's Pushover user key
- device (optional) A user's device name to restrict messages to that device, otherwise leave blank to send messages to all devices of that user
- memo (optional) A free-text memo used to associate data with the user such as their name or e-mail address, viewable through the API and the groups editor on our website (limited to 200 characters)

```php
$output = $client->groups->addUser(
    group: 'KJHjhdfkjsd',
     user: 'gRhdnml6gsji8df'
);
```

#### Remove User (Tested)

Remove a user from a group.

Parameters:

- group (required) - Key of group to add user to
- user (required) - the user's Pushover user key
- device (optional) - the device name to match for the user's group membership; if left blank, all users with the matching user key will be removed

```php
$output = $client->groups->removeUser(
    group: 'KJHjhdfkjsd',
     user: 'gRhdnml6gsji8df'
);
```

#### Disable User (Tested)

Disable a user in a group.

Parameters:

- group (required) - Key of group to disable user in
- user (required) - the user's Pushover user key
- device (optional) - the device name to match for the user's group membership; if left blank, all users with the matching user key will be disabled

```php
$output = $client->groups->disableUser(
    group: 'KJHjhdfkjsd',
     user: 'gRhdnml6gsji8df'
);
```

#### Enable User (Tested)

Enable a user in a group.

Parameters:

- group (required) - Key of group to enable user in
- user (required) - the user's Pushover user key
- device (optional) - the device name to match for the user's group membership; if left blank, all users with the matching user key will be enabled

```php
$output = $client->groups->enableUser(
    group: 'KJHjhdfkjsd',
     user: 'gRhdnml6gsji8df'
);
```

#### Rename (Tested)

Change the name of a gorup.

Parameters:

- group (required) Key of group to modify
- name (required) New name of group
 
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
- retry - For priority 2 messages, this is required. How many seconds between resending alerts.
- expire - For priority 2 messages, this is required. How many seconds until the emergency stops alerting.
- 

#### Get (Untested)

```php
$output = $client->message->get(
    secret: 'KJHd7hsjqk3jh',
    device_id: 'kljshdf62j10'
);
```

### Receipts

https://pushover.net/api/receipts

#### Get (Tested)

```php
$output = $client->receipts->get( receipt: 'JKHk1262jhfs' );
```

#### Cancel (Tested)


An emergency-priority notification will continue to be sent to devices until it reaches its original expire value. To cancel an emergency-priority notification early, you can send a POST request to our API.

```php
$output = $client->receipts->cancel( receipt: 'JKHk1262jhfs' );
```

#### Cancel by tag (Tested)

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

Add a user to your team.

Parameters:

- email (required) - the user's e-mail address
- name (optional) - the user's full name
- password (optional) the user's password if assigning one to the user which will not be e-mailed; if not included or left blank, a random password will be assigned to the user and e-mailed to them (in cleartext)
- instant (optional) a string value of true will include an Instant Login link in the initial welcome e-mail to the user; Instant Login links allow the user to optionally download the Pushover app and then login to their new account without entering any credentials, and links are valid for 7 days
- admin (optional) a string value of true will add this user to the team as an administrator
- group (optional) by default, all users are added to your auto-updating Team Delivery Group; to add this user to another Delivery Group, put the group's name in this field (if the group does not exist, it will be created)

```php
$output = $client->teams->add(
    email: 'test@test.com',
    params: [
        'password' => 'MyPassword'
    ]
);
```

#### Remove User (Untested)

Remove a user from a team.

Parameters:

- email (required) - the user's e-mail address

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

### Sounds

#### List (Tested)

List available alert sounds.

```php
$output = $client->sounds->list();
```

### Apps

#### Limis (Tested)

Get API limit information.

```php
$output = $client->apps->limits();
```