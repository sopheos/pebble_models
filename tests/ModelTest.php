<?php

use Pebble\Models\ModelInterface;
use Pebble\Models\Reflection;
use PHPUnit\Framework\TestCase;

/**
 * @group model
 */
class ModelTest extends TestCase
{
    public function testDefault()
    {
        $start = time();
        $user = new User();
        $end = time();

        self::assertIsObject($user);
        self::assertInstanceOf(ModelInterface::class, $user);
        self::assertInstanceOf(User::class, $user);
        self::assertObjectHasAttribute('created_at', $user);
        self::assertIsInt($user->created_at);
        self::assertTrue($user->created_at >= $start && $user->created_at <= $end);
    }

    public function testConstructor()
    {
        $input = [
            'id' => 1,
            'name' => 'toto',
            'created_at' => time(),
        ];

        $user = new User($input);

        self::assertIsObject($user);
        self::assertInstanceOf(ModelInterface::class, $user);
        self::assertInstanceOf(User::class, $user);
        foreach ($input as $key => $value) {
            self::assertObjectHasAttribute($key, $user);
            self::assertSame($value, $user->{$key});
        }
    }

    public function testImport()
    {
        $input = [
            'id' => 1,
            'name' => 'toto',
            'created_at' => time(),
        ];

        $user = new User();
        $user->import($input);

        self::assertIsObject($user);
        self::assertInstanceOf(ModelInterface::class, $user);
        self::assertInstanceOf(User::class, $user);
        foreach ($input as $key => $value) {
            self::assertObjectHasAttribute($key, $user);
            self::assertSame($value, $user->{$key});
        }
    }

    public function testExport()
    {
        $input = [
            'id' => 1,
            'name' => 'toto',
            'created_at' => time(),
        ];

        $user = new User($input);
        $export = $user->export();

        self::assertIsArray($export);
        self::assertSame($input, $export);
    }

    public function testCustomData()
    {
        $input = [
            'id' => 1,
            'name' => 'toto',
            'created_at' => time(),
            'custom' => 'custom'
        ];

        $user = new User($input);
        $export = $user->export();

        self::assertIsArray($export);
        self::assertNotSame($input, $export);
    }

    public function testJsonEncode()
    {
        $input = [
            'id' => 1,
            'name' => 'toto',
            'created_at' => time()
        ];

        $user = new User($input);
        $json = json_encode($user);

        self::assertIsString($json);
        self::assertJson($json);
        self::assertJsonStringEqualsJsonString(json_encode($input), $json);
    }

    public function testProperties()
    {
        $user = new User();
        self::assertSame($user->properties(), Reflection::getInstance(User::class)->properties());
    }
}
