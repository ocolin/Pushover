# Pushover
PHP Client for PushoverAPI

## Environment variables

While the auth token and API URL can be supplied when creating an object, it's easiest to use environment variables. Here are the variables used.

* $_ENV['PUSHOVER_API_TOKEN'] - Auth token
* $_ENV['PUSHOVER_API_URL'] - API URL
* $_ENV['PUSHOVER_DEFAULT_PRIORITY'] - If you want a customer priority level default

## Instantiating a class

The client is set up so that if you use environment variables you don't need to specify any parameters unless you want to customize them. Under normal operating procedures you need only instantiate a class object.

### Basic Instantiation

```
$message = new Message();
```

### Optional Instantiation parameters

* token: Authentication token.
* url: The Pushover API URL to use.
* format: Whether to return XML or JSON. JSON is default.
* verify: Verify SSL certificate. Default no.
* errors: Throwing exceptions on an HTTP protocol errors.

```
$message = new Message( format: 'xml' );
```

### Message

```
$message = new Message();
```

#### Push

Send a message to a user or group. 

* user (required)
* message (required)
* options (optional param array)

```
$output = $message->push( user: 'acb123', message: 'Test message' );
```

### Groups

```
$groups = new Groups();
```

#### Create

Create a new group.

* name (Required)

```
$output = $groups->create( name: 'Bob' );
```

### listGroups

List every group.

* No parameters

```
$output = $groups->listGroups();
```

#### Get

Get a specific group.

* group (required)

```
$output = $groups->get( group: 'abc124efc' );
```

#### addUser.

Add a user to a group.

* user (required)
* group (required)
* device (optional)
* memo (optional)

```
$output = $groups->addUser( user: 'abc123', group: 'efg456' );
```

#### removeUser.

Remove a user from a group.

* user (required)
* group (required)
* device (optional)


```
$output = $groups->removeUser( user: 'abc123', group: 'efg456' );
```

#### disableUser

Temporarily disable a user in a group.

* user (required)
* group (required)
* device (optional)

```
$output = $groups->disableUser( user: 'abc123', group: 'efg456' );
```

#### enableUser

Re-enable a temporarily disabled user in a group.

* user (required)
* group (required)
* device (optional)

```
$output = $groups->enableUser( user: 'abc123', group: 'efg456' );
```

#### Rename

Change the name of a group.

* group (required)
* name (required)

```
$output = $groups->rename( user: 'abc123', name: 'New Name' );
```

### Glances

```
$glances = new Glances();
```

#### push

Push a glance to users

* user (required)
* device (optional)
* params (at least one param required)
  * title
  * text
  * subtext
  * count
  * percent

```
$output = $glances->push( 
    user: 'abc123', params: [ 'title' => 'test title' ]
);
```

### Teams

```
$teams = new Teams();
```

#### addUser

Add a user to the team.

* email (required)
* params (optional parameters)
  * name
  * password
  * instant
  * admin
  * group

```
$output = $teams->addUser( email: 'test@test.com', params: [ admin => true ] );
```

#### removeUser

Remove a user from the team.

* email (required)

```
$output = $teams->removeUser( email: 'test@test.com' );
```