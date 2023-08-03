<?php

use Pebble\Models\AdapterAbstract;

class UserAdapter extends AdapterAbstract
{

    public static function create(): static
    {
        return new static;
    }

    public function get()
    {
        $csv = file_get_contents(__DIR__ . '/user.csv');
        return $this->decode($csv);
    }

    public function save(User $user)
    {
        file_put_contents(__DIR__ . '/../tmp/user.json', $this->encode($user));
    }

    /**
     * @param User $input
     * @return string
     */
    public function encode(mixed $input): mixed
    {
        $data = $input->export();
        $data['created_at'] = date('c', $data['created_at']);

        return json_encode($data);
    }

    /**
     * @param string $input
     * @return User
     */
    public function decode(mixed $input): mixed
    {
        $data = array_combine(['id', 'name', 'created_at'], str_getcsv($input));
        $data['id'] = (int) $data['id'];
        $data['created_at'] = strtotime($data['created_at']);
        return new User($data);
    }
}
