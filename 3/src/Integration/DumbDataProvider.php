<?php

namespace Integration;

class DumbDataProvider implements DataProviderInterface
{
    /**
     * @var string
     */
    private $host;
    /**
     * @var string
     */
    private $user;
    /**
     * @var string
     */
    private $password;

    /**
     * @param $host
     * @param $user
     * @param $password
     */
    public function __construct(string $host, string $user, string $password)
    {
        $this->host     = $host;
        $this->user     = $user;
        $this->password = $password;
    }

    /**
     * {@inheritdoc}
     */
    public function get(array $request): array
    {
        sleep(3);//todo only for SkyEngTest. Long query test

        return [
            'foo'      => 'bar',
            'hello'    => 'world',
            'host'     => $this->host,
            'user'     => $this->user,
            'password' => $this->password,
        ];
    }
}