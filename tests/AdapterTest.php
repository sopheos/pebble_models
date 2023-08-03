<?php

use PHPUnit\Framework\TestCase;

/**
 * @group adapter
 */
class AdapterTest extends TestCase
{
    public function testGet()
    {
        $user = UserAdapter::create()->get();

        self::assertIsObject($user);
        self::assertInstanceOf(User::class, $user);
        self::assertSame(1, $user->id);
        self::assertSame('toto', $user->name);
        self::assertSame(1666870648, $user->created_at);
    }

    public function testSave()
    {
        $time = time();

        $user = new User([
            'id' => 1,
            'name' => 'toto',
            'created_at' => $time,
        ]);

        UserAdapter::create()->save($user);
        self::assertFileExists(__DIR__ . '/tmp/user.json');
        $json = file_get_contents(__DIR__ . '/tmp/user.json');
        self::assertIsString($json);
        self::assertJson($json);
        $data = json_decode($json, true);
        self::assertSame([
            'id' => 1,
            'name' => 'toto',
            'created_at' => date('c', $time)
        ], $data);
    }

    /**
     * @group unique
     */
    public function testUnique()
    {
        $names = ['riri', 'fifi', 'loulou'];
        $users = [];
        for ($i = 0; $i < 9; $i++) {
            $users[] = new User([
                'id' => ($i + 1),
                'name' => $names[$i % 3]
            ]);
        }

        $ids = UserAdapter::unique($users, 'id');
        self::assertIsArray($ids);
        self::assertCount(9, $ids);
        $names = UserAdapter::unique($users, 'name');
        self::assertIsArray($names);
        self::assertCount(3, $names);
    }

    public static function tearDownAfterClass(): void
    {
        $file = __DIR__ . '/tmp/user.json';
        if (is_file($file)) {
            unlink($file);
        }
    }
}
