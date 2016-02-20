#Documentation
##Table of content

1. [Requirements](#requirements)
2. [Installation](#installation)
3. [What are Cookie Files](#what-are-cookies-file)
4. [Example](#example)
5. [Configuration](#configuration)
	* [CookieDir](#configuration_cookiedir)
6. [Cookie File Handler](#cookiefilehandler)
	* [Handler Methods](#cookiefilehandler_methods)
7. [Cookie Jar](#cookie-jar)
    * [Jar Methods](#cookie-jar_methods)
8. [Cookie Entity](#cookie-entity)
9. [Cookie Collection](#cookie-collection)
	* [Importants Facts](#cookie-collection_importants-facts)
	* [Collection Methods](#cookie-collection_methods)

----------
<a name="requirements"></a>
##Requirements
This is library is only available for **PHP7+**
There is no other dependencies

<a name="installation"></a>
##Installation
This library is available on packagist (**Composer**)
```shell
composer require kegi/netscape-cookie-file-handler
```
<a name="what-are-cookies-file"></a>
##What are Cookies Files ?
The Netscape cookie files are widely used. Curl, by example, allows you to select a file (called the cookie jar) to save and read the cookies using this format. This library will help you to manipulate and read those cookies.

<a name="example"></a>
##Example
Simple example of reading + writing cookies

```php
/*Open and parse the cookie file*/

$configuration = (new Configuration())->setCookieDir('cookies/');
$cookieJar = (new CookieFileHandler($configuration))->parseFile('my_cookie_file');

/*Add (and save) a cookie*/

$cookieJar->add(
    (new Cookie())
        ->setHttpOnly(true)
        ->setPath('/foo')
        ->setSecure(true)
        ->setExpire(new DateTime('2020-02-20 20:20:02'))
        ->setName('foo')
        ->setValue('bar')
)->persist();
```

<a name="configuration"></a>
##Configuration
For now, the configurations are pretty easy, there is only one parameter.

<a name="configuration_cookiedir"></a>
###cookieDir
This is where the library will look for cookie files. Note that this parameter is mandatory if you want to manipulate file.
```
$configuration = new Configuration();
$configuration->setCookieDir('cookies/');
$configuration->getCookieDir(); //return "cookies/"
```

<a name="cookiefilehandler"></a>
##Cookie File Handler
This is the main library class (**CookieFileHandler**) and it implements **CookieFileHandlerInterface**. This class can receive a configuration object (**ConfigurationInterface**) and will allows you to get a cookie jar (**CookieJarInterface**).

<a name="cookiefilehandler_methods"></a>
###Handler Methods

**parseFile** ( string **$file** )
> Note: Configuration with "**cookieDir**" are needed to use this method. The file name will be searched from **cookieDir**
> Note: The cookie jar will be associated with this file, **you will be able to persist changes to that file**.

**parseContent** ( string **$content** )
> This will return a cookie collection.

###Exceptions

Those exceptions can be thrown when using the cookie jar :

**NetscapeCookieFileHandlerException**
> Illegal operation, eg. missing configuration

**ParserException**
> Error reading the cookie file

<a name="cookie-jar"></a>
##Cookie Jar
A Cookie Jar (**CookieJar**) implements "**CookieJarInterface**" and contains a collection of cookies (**CookieCollectionInterface**). A cookie jar is associated to a file. All changes applied to the cookies can be persisted using the **persist()** function.

The following collection methods are availables :

 - get
 - getAll
 - add
 - has
 - delete
 - deleteAll


Those exceptions can be thrown when using the cookie jar :

**CookieJarException**
> Cookie Jar illegal operations

**PersisterException**
> Errors when saving the cookie file

<a name="cookie-jar_methods"></a>
###Cookie Jar Methods

**getCookiesFile** ()
> To get the cookies file (to persist the cookies)

**setCookiesFile** ( string **$cookiesFile** )
> To set the cookies file (will be append to **cookieDir** from the configuration)

**persist** ()
> This method will save the current cookie collection in the cookies file

<a name="cookie-entity"></a>
##Cookie Entity
All cookies are hold inside a "**Cookie**" object and implements "**CookieInterface**", "**CookieInterface**" extends "**JsonSerializable**" which  allows you to directly convert it with "**json_encode**"..

| Parameter | Default | Description
| --- | --- | ---
| domain | NULL | Domain where the cookie is active
| httpOnly | false | If set to true, the cookie will only be enabled for http requests
| flag | true | If enable, all machines within a given domain can access the variable
| path | / | Inside the domain, this cookie will only be available for this path
| secure | false | If enable, this cookie will only be active with HTTPS requests
| expire | NULL | Expiration of the cookie. DateTime object or NULL if no expiration date
| name |  | Name of the cookie (Mandatory) |
| value |  | Value of the cookie (Empty value cookie will be discarded) |

You can access cookie data using getters and setters.


<a name="cookie-collection"></a>
##Cookie Collection
A collection of cookies is stored inside a "**CookieCollection**" and implements "**CookieCollectionInterface**". "**CookieCollectionInterface**" extends "**JsonSerializable**" which  allows you to directly convert it with "**json_encode**".

<a name="cookie-collection_importants-facts"></a>
###Importants Facts
 - The cookies are ordered by domain
 - The cookie (name) are unique by  domain
 - A cookie with empty value will be ignored

<a name="cookie-collection_methods"></a>
###Collection Methods

**getCookies** ()
> This method return the array of cookies ordered by domain and cookie name. This should be used as debugging purpose only. Use get() or getAll() instead to receive a collection of cookies.
> ```
['domain1.dev'] =>
    ['cookie_a'] => ...
    ['cookie_b'] => ...
['domain2.dev'] =>
    ['cookie_a'] => ...
 ```


**setCookies** (array **$cookies**)
> This methods set the array of cookies. SetCookie will clear all cookies, perform some tests on array items and will internally call **add()**. Please note that **all cookies need to have a name and a domain** or an exception (**CookieCollectionException**) will be thrown. You can also send your cookies to the constructor when creating a new collection.


**get** ( string **$cookieName**, string **$domain** = null )
> This will find the cookie by name on the given domain. If no domain is specified, the collection will search inside all domains. This will return a "**CookieInterface**" object or **Null** if nothing is found.


**getAll** ( string **$domain** = null )
> This will find all cookies of a given domain or all cookies if no domain is specified. This will always return a "**CookieCollectionInterface**" object.


**add** ( cookieInterface **$cookie** )
> This will add a cookie to the collection. NOTES :
>  - If the given cookie has no domain, **the cookie will be added to ALL domains** that are already inside the collection. If there is no existing cookies, an exception (**CookieCollectionException**) will be thrown.
>  - If you add an existing cookie, you will override it.


**has** ( string **$cookieName**, string **$domain** = null )
> This will return true if the cookie exists for the given domain (if specified, or in all domains). Please note that cookies with empty value are discarded.


**delete** ( string **$cookieName**, string **$domain** = null )
> This will remove a cookie from the collection for the given domain or in all domains if $domain is not set.


**deleteAll** ( string **$domain** = null )
> This will remove all cookies of the given domain or all cookies in the collection if $domain is not set.
