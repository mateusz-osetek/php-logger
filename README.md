<h2>Simple PHP Logger</h2>
<hr/>

<h3>Requirements</h3>
Logger running on PHP >= 7.1.

<h3>Installation</h3>
For now you have to download it manually from GitHub.

<h3>Usage</h3>
<b>Initializing the logger</b><br/>
If you want to initialize logger with default path and filename (`logs/.log`) just use:

```
$logger = new Logger();
```

<br/>

If you want to initalize logger on another path with another filename you can do this by defining those while creating new object.

```
$logger = new Logger('some/path/', 'filename'); 
```

<br/>

Also you can initialize logger with custom date format as the last parameter. Logger's using the <a href="https://www.php.net/manual/en/function.date.php">standard PHP date() formats</a>.

```
$logger = new Logger('some/path', 'filename', 'H:i:s');
```

<br/><br/>

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

<br/><br/>

<b>Send file by email</b><br/>
You can send your log file by email use `send($to)`. Method will grab contents of your log file and send it as message of email.

```
$logger->send('somebody@email.com');
```

<br/><br/>

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

<br/><br/>

<b>Get path to log file</b><br/>
If you need to check or determine somewhere the full path to your current log file just use:

```
$logger->getPath();
```
