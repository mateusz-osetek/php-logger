<h2>Simple PHP Logger</h2>

<h3>Requirements</h3>
Logger running on PHP >= 7.1.

<hr/>

<h3>Installation</h3>

Download it manually from GitHub or by composer: `composer require mosetek/logger:dev-master`

<hr/>

<h3>Usage</h3>
<b>Initializing the logger</b><br/>

If you want to initialize logger with default path and filename (`logs/.log`) just use:

```
$logger = new Logger();
```

<br/>

If you want to initialize logger on another path with another filename you can do this by defining those while creating new object.

```
$logger = new Logger('some/path/', 'filename'); 
```

<br/>

Also you can initialize logger with custom date format as the last parameter. Logger's using the <a href="https://www.php.net/manual/en/function.date.php">standard PHP date() formats</a>.

```
$logger = new Logger('some/path', 'filename', 'H:i:s');
```

<br/>

<b>Another path and filename options</b><br/>
You can get path, full path to file, filename or date format any time you need:

```
$logger->getPath();        //Returns: some/path/to/
$logger->getFullPath();    //Returns: some/path/to/file.txt
$logger->getFilename();    //Returns: file.txt
$logger->getDateFormat();  //Returns: Y-m-d H:i:s
```

You can also set another filename or path:

```
$logger->setPath('some/new/path');
$logger->setFilename('new_filename.txt');
$logger->setDateFormat('Y-m');
```


<br/>

<b>Write and read files</b><br/>
To put some content into file (defined in object creation) simply use `put()` method. 

```
$logger->put('some log content');
```

<br/>

If you want to read contents of your log file use `read($path): string`.

```
$logger->read();
```

You can also read content of any other text files by adding a path parameter to read method.

```
$logger->read('some/path/to/file.txt');
```

<br/>

<b>Send file by email</b><br/>
You can send your log file by email use `send($to)`. Method will grab contents of your log file and send it as message of email.

```
$logger->send('somebody@email.com');
```
Your server must support `sendmail` to use the above. If you're using UNIX-like systems please take care of installing <a href="http://www.postfix.org">postfix</a>. 

<br/>

<b>Wiping and deleting log file</b><br/>
If you want to empty content of your current file use:

```
$logger->wipe();
```

You can also wipe any other text file by using `$path` parameter:

```
$logger->wipe('some/path/to/file.txt');
```

<br/>

Interface allows you to deleting files by using `drop()` method.

```
$logger->drop();
```

Of course you can determine path to another file to drop as well

```
$logger->drop('some/path/to/file.txt');
```

<br/>

<b>Checking size of file</b><br/>
You can check the size of a file by using below:

```
$logger->getFilesize();
```

Method by default returns size in megabytes. You can determine another unit by passing argument.

```
$logger->getFilezise();       //Returns in megabytes
$logger->getFilezise('B');    //Returns in bytes
$logger->getFilezise('KB');   //Returns in kilobytes
$logger->getFilezise('GB');   //Returns in gigabytes
```

If you want you can check size of any other file by passing path in second argument:

```
$logger->getFilesize('MB', 'path/to/file.txt');
```

