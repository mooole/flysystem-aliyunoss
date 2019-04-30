<?php

namespace Mocode\Flysystem\AliyunOss\Tests;

use League\Flysystem\Config;
use League\Flysystem\Filesystem;
use Mocode\Flysystem\AliyunOss\Plugins\PutFile;
use OSS\OssClient;
use Mocode\Flysystem\AliyunOss\AliyunOssAdapter;
use PHPUnit\Framework\TestCase;

class AliyunOssAdapterTest extends TestCase
{

    protected $adapter;

    protected $config;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        /*
         * TODO 测试依赖
         */
        $this->config = new Config();

        $accessId = 'Aliyun Oss Access Id';
        $accessKey = 'Aliyun Oss Access Key';
        $endPoint = 'Aliyun Oss endPoint';
        $bucket = 'Aliyun Oss Bucket';
        $domain = 'Aliyun Oss CDN Domain';

        $client = new OssClient($accessId, $accessKey, $endPoint);
        $this->adapter = new AliyunOssAdapter($client, $bucket, $domain);
    }

    public function testPutFile()
    {
        $this->assertNotFalse($this->adapter->putFile('test/test.png', dirname(__FILE__) . '/test.png', $this->config));
    }

    public function testWrite()
    {
        $this->assertNotFalse($this->adapter->write('test/test.md', 'test write', $this->config));
    }

    public function testWriteStream()
    {
        $stream = fopen(dirname(__FILE__) . '/test.png', 'r');

        $this->assertNotFalse($this->adapter->writeStream('test/test_stream.png', $stream, $this->config));
    }

    public function testUpdate()
    {
        $this->assertNotFalse($this->adapter->write('test/test.md', 'test update', $this->config));
    }

    public function testUpdateStream()
    {
        $stream = fopen(dirname(__FILE__) . '/test_update.png', 'r');

        $this->assertNotFalse($this->adapter->updateStream('test/test.png', $stream, $this->config));
    }

    public function testCopy()
    {
        $this->assertNotFalse($this->adapter->copy('test/test.png', 'test/test_copy.png'));
    }

    public function testRenameCopy()
    {
        $this->assertNotFalse($this->adapter->rename('test/test.png', 'test/test_rename.png'));
    }

    public function testDelete()
    {
        $this->assertNotFalse($this->adapter->delete('test/test_update.png'));
    }

    public function testCreateDir()
    {
        $this->assertNotFalse($this->adapter->createDir('test/create_dir', $this->config));
    }

    public function testDeleteDir()
    {
        $this->assertNotFalse($this->adapter->createDir('test/create_dir', $this->config));
    }

    public function testHas()
    {
        $this->assertNotFalse($this->adapter->has('test/test_rename.png'));
    }

    public function testRead()
    {
        $this->assertNotFalse($this->adapter->read('test/test_rename.png'));
    }

    public function testListContents()
    {
        $this->assertNotFalse($this->adapter->listContents());
        $this->assertIsArray($this->adapter->listContents());
    }

    public function testGetUrl()
    {
        $this->assertNotFalse($this->adapter->getUrl('test/test_copy.png'));
        $this->assertIsString($this->adapter->getUrl('test/test_copy.png'));
    }

    public function testPluginsPutFile()
    {
        $filesystem = new Filesystem($this->adapter);
        $filesystem->addPlugin(new PutFile());
        $this->filesystem = $filesystem;

        $this->assertTrue($this->filesystem->putFile('test/plugins.png', __DIR__ . '/test.png'));
    }

}