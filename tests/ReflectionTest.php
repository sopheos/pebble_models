<?php

use Pebble\Models\ModelInterface;
use Pebble\Models\Reflection;
use PHPUnit\Framework\TestCase;

/**
 * @group reflection
 */
class ReflectionTest extends TestCase
{
    public function testDefault()
    {
        $user = new User();

        $properties = ['id', 'name', 'created_at'];

        $reflection = Reflection::getInstance(User::class);

        self::assertIsObject($reflection);
        self::assertInstanceOf(Reflection::class, $reflection);
        self::assertSame($properties, $reflection->properties());
        $find = $reflection->hasProperty('nope');
        self::assertIsBool($find);
        self::assertFalse($find);
        foreach ($properties as $property) {
            $find = $reflection->hasProperty($property);
            self::assertIsBool($find);
            self::assertTrue($find);
        }
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
}
