<h2>Simple PHP Logger 1.1.3</h2>

<h3>Requirements</h3>
<ul>
    <li>PHP >= 7.1</li>
    <li>PHPMailer >= 6.0</li>
</ul>

<hr/>

<h3>Installation</h3>

Download it manually from GitHub or by composer: `composer require mosetek/logger:dev-master`

<hr/>

<h3>Usage</h3>
<b>Initializing the logger</b><br/>

If you want to initialize logger with default path and filename (`logs/.log`) just use:

```php
$logger = new Logger();
```

<br/>

If you want to initialize logger on another path with another filename you can do this by defining those while creating new object.

```php
$logger = new Logger('some/path/', 'filename'); 
```

<br/>

Also you can initialize logger with custom date format as the last parameter. Logger's using the <a href="https://www.php.net/manual/en/function.date.php">standard PHP date() formats</a>.

```php
$logger = new Logger('some/path', 'filename', 'H:i:s');
```

<br/>

<b>Another path and filename options</b><br/>
You can get path, full path to file, filename or date format any time you need:

```php
$logger->getPath();        //Returns: some/path/to/
$logger->getFullPath();    //Returns: some/path/to/file.txt
$logger->getFilename();    //Returns: file.txt
$logger->getDateFormat();  //Returns: Y-m-d H:i:s
```

You can also set another filename or path:

```php
$logger->setPath('some/new/path');
$logger->setFilename('new_filename.txt');
$logger->setDateFormat('Y-m');
```


<br/>

<b>Write and read files</b><br/>
To put some content into file (defined in object creation) simply use `log()` method.
You can log into file text, numbers and more complicated data structures like arrays and objects

```php
$logger->log('some log content');
$logger->log(['some' => ['nice', 'array']);
```

You can also put some information into file, with some label next to it by adding information level as second parameter;

```php
$logger->log('some log content', 3);
//That makes your log file looks like that:
// 2019-09-01 12:02:32 | [WARNING] | some log content
```

There are three supported labels for information leveling:

```
1 => [INFO]
2 => [DEBUG]
3 => [WARNING]
4 => [ERROR]
5 => [FATAL]
6 => [TRACE]
```

If you want to put data on different path you can declare it in third argument:

```php
$logger->log('some log content on custom path', 0, 'custom/path/to/log.txt');
```

<br/>

You can also put simple text without any date or special characters into your file by using `text()` method.

```php
$logger->text('Hello world');
```

`text()` allows you to specify ending of line or text by adding additional param like that:
```php
$logger->text('Hello world', ', ');
$logger->text('bye world.', PHP_EOL);
$logger->text('New line, world');
```

<br/>

If you want to read contents of your log file use `read($path): string`.

```php
$logger->read();
```

You can also read content of any other text files by adding a path parameter to read method.

```php
$logger->read('some/path/to/file.txt');
```

<br/>

<b>Putting variables into log file (deprecated: use log() instead)</b><br/>
You can put more complicated structures like variables into log file by using this:

```php
$logger->dump(['some' => ['example', 'array']]);
```

<br/>

<b>Send file by email (deprecated)</b><br/>
You can send your log file by email use `send($to)`. Method will grab contents of your log file and send it as message of email.

```php
$logger->send('somebody@email.com');
```
Your server must support `sendmail` to use the above. If you're using UNIX-like systems please take care of installing <a href="http://www.postfix.org">postfix</a>. 

<br/>

<b>Move and copy files</b><br/>

You can move your file to another destination.

```php
$logger->move('new/path/to/file.log');
```

If you want to move another file than active log file use second argument to point what other file you want to move.

```php
$logger->move('new/path/to/file.log', 'file/to/move.log');
```

If you want to just copy file some place else use `copy()` method:

```php
$logger->copy('where/to/copy/file.txt');
``` 

And similar to the `move` method you can point another file to copy, if you don't want to copy your current log file.

```php
$logger->copy('where/to/copy/file.txt', 'what/file/to/copy.txt);
```

<br/>

<b>Wiping and deleting log file</b><br/>
If you want to empty content of your current file use:

```php
$logger->wipe();
```

You can also wipe any other text file by using `$path` parameter:

```php
$logger->wipe('some/path/to/file.txt');
```

<br/>

Interface allows you to deleting files by using `drop()` method.

```php
$logger->drop();
```

Of course you can determine path to another file to drop as well

```php
$logger->drop('some/path/to/file.txt');
```

<br/>

<b>Checking size of file</b><br/>
You can check the size of a file by using below:

```php
$logger->getFilesize();
```

Method by default returns size in megabytes. You can determine another unit by passing argument.

```php
$logger->getFilezise();       //Returns in megabytes
$logger->getFilezise('B');    //Returns in bytes
$logger->getFilezise('KB');   //Returns in kilobytes
$logger->getFilezise('GB');   //Returns in gigabytes
```

If you want you can check size of any other file by passing path in second argument:

```php
$logger->getFilesize('MB', 'path/to/file.txt');
```

