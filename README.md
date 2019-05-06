<h1 align="center"> flysystem-aliyunoss </h1>
<p align="center"> This is a Flysystem adapter for the Aliyun OSS ~2.3 </p>

# Inspired By
- [overtrue/flysystem-qiniu](https://github.com/overtrue/flysystem-qiniu)
- [apollopy/flysystem-aliyun-oss](https://github.com/apollopy/flysystem-aliyun-oss)

# Installation

```shell
$ composer require mocode/flysystem-aliyunoss
```

# Usage

```php
use League\Flysystem\Filesystem;
use Mocode\Flysystem\AliyunOss\AliyunOssAdapter;
use OSS\OssClient;

$accessId = 'Aliyun Oss Access Id';
$accessKey = 'Aliyun Oss Access Key';
$endPoint = 'Aliyun Oss endPoint';
$bucket = 'Aliyun Oss Bucket';
$domain = 'Aliyun Oss CDN Domain';

$client = new OssClient($accessId, $accessKey, $endPoint);
$adapter = new AliyunOssAdapter($client, $bucket, $domain);

$flysystem = new Filesystem($adapter);

```

## API

```php
bool $flysystem->write('file.md', 'contents');

bool $flysystem->writeStream('file.md', fopen('path/to/your/local/file.jpg', 'r'));

bool $flysystem->update('file.md', 'new contents');

bool $flysystem->updateStream('file.md', fopen('path/to/your/local/file.jpg', 'r'));

bool $flysystem->rename('foo.md', 'bar.md');

bool $flysystem->copy('foo.md', 'foo2.md');

bool $flysystem->delete('file.md');

bool $flysystem->has('file.md');

string|false $flysystem->read('file.md');

array $flysystem->listContents();

array $flysystem->getMetadata('file.md');

int $flysystem->getSize('file.md');

string $flysystem->getAdapter()->getUrl('file.md'); 

string $flysystem->getMimetype('file.md');

int $flysystem->getTimestamp('file.md');

```
[Full API documentation.](http://flysystem.thephpleague.com/api/)

### Plugins

File Url: 

```php
use Mocode\Flysystem\AliyunOss\\Plugins\PutFile;

$flysystem->addPlugin(new PutFile());

bool $flysystem->putFile('file.md', 'contents');
```

# for Laravel
edit .env 
> add aliyun oss config
```
OSS_ACCESS_ID=xxxxxxxxxxxx
OSS_ACCESS_KEY=xxxxxxxxxxxxxxxxxxxxxx
OSS_BUCKET=xxxxxxxxxx
OSS_ENDPOINT=xxxxxxxxx
OSS_DOMAIN=xxxxxxxxxxxx
```

edit the config file: config/filesystems.php
> add config
```php
'oss' => [
    'driver'     => 'oss',
    'access_id'  => env('OSS_ACCESS_ID'), // Aliyun OSS AccessKeyId
    'access_key' => env('OSS_ACCESS_KEY'), // Aliyun OSS AccessKeySecret
    'bucket'     => env('OSS_BUCKET'), // OSS bucket name
    'endpoint'   => env('OSS_ENDPOINT'), // OSS 节点或自定义外部域名
    'domain'     => env('OSS_DOMAIN'), // CDN domain
],
```

> change default to oss
```php
'default' => 'oss'
```

### use
see [Laravel wiki](https://laravel.com/docs/5.8/filesystem)

# License

MIT