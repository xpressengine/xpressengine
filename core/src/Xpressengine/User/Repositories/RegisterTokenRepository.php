<?php
/**
 * This file is user register token repository.
 *
 * PHP version 5
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Repositories;

use Carbon\Carbon;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Fluent;
use Xpressengine\Keygen\Keygen;

/**
 * 회원가입시 회원가입 자격을 인증하는 register token의 Repository
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class RegisterTokenRepository
{
    /**
     * The database connection instance.
     *
     * @var \Illuminate\Database\ConnectionInterface
     */
    private $connection;

    /**
     * The register-token database table.
     *
     * @var string
     */
    private $table;

    /**
     * The number of seconds a token should last.
     *
     * @var int
     */
    private $expires;

    /**
     * @var Keygen
     */
    private $keygen;

    /**
     * Create a new token repository instance.
     *
     * @param ConnectionInterface $connection db connection
     * @param Keygen              $keygen     token id generator
     * @param string              $table      token table name
     * @param int                 $expires    duration that token is valid
     */
    public function __construct(ConnectionInterface $connection, Keygen $keygen, $table, $expires = 60)
    {
        $this->table = $table;
        $this->expires = $expires * 60;
        $this->connection = $connection;
        $this->keygen = $keygen;
    }

    /**
     * Create a new token record.
     *
     * @param string $guard register guard
     * @param array  $data  token data
     *
     * @return Fluent token entity
     */
    public function create($guard, $data)
    {
        // We will create a new, random token for the user so that we can e-mail them
        // a safe link to the password reset form. Then we will insert a record in
        // the database so that we can verify the token within the actual reset.
        $id = $this->createNewToken();

        $payload = ['id' => $id, 'guard' => $guard, 'data' => serialize($data), 'createdAt' => new Carbon];

        $result = $this->getTable()->insert($payload);

        $token = $this->resolveToken($id, $guard, $data);

        return $token;
    }

    /**
     * find token
     *
     * @param string $id token id
     *
     * @return Fluent|null token
     */
    public function find($id)
    {
        $token = (array) $this->getTable()->where('id', $id)->first();

        if ($token === null || $this->tokenExpired($token)) {
            return null;
        }
        $token = $this->resolveToken($token['id'], $token['guard'], @unserialize($token['data']));
        return $token;
    }

    /**
     * Determine if a token record exists and is valid.
     *
     * @param string $id token id
     *
     * @return bool
     */
    public function exists($id)
    {
        $token = (array) $this->getTable()->where('id', $id)->first();

        return $token && !$this->tokenExpired($token);
    }

    /**
     * Determine if the token has expired.
     *
     * @param  array $token token info
     *
     * @return bool
     */
    private function tokenExpired($token)
    {
        $expirationTime = strtotime($token['createdAt']) + $this->expires;

        return $expirationTime < $this->getCurrentTime();
    }

    /**
     * Get the current UNIX timestamp.
     *
     * @return int
     */
    private function getCurrentTime()
    {
        return time();
    }

    /**
     * Delete a token record by token.
     *
     * @param string $id token id
     *
     * @return void
     */
    public function delete($id)
    {
        $this->getTable()->where('id', $id)->delete();
    }

    /**
     * Delete expired tokens.
     *
     * @return void
     */
    public function deleteExpired()
    {
        $expiredAt = Carbon::now()->subSeconds($this->expires);

        $this->getTable()->where('createdAt', '<', $expiredAt)->delete();
    }

    /**
     * Create a new token id
     *
     * @return string
     */
    private function createNewToken()
    {
        return $this->keygen->generate();
    }

    /**
     * Begin a new database query against the table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    private function getTable()
    {
        return $this->connection->table($this->table);
    }

    /**
     * Get the database connection instance.
     *
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * convert token info to token entity
     *
     * @param string $id    token id
     * @param string $guard the guard creating token
     * @param array  $data  token data
     *
     * @return Fluent
     */
    protected function resolveToken($id, $guard, $data)
    {
        $token = new Fluent($data);
        $token->id = $id;
        $token->guard = $guard;
        return $token;
    }
}
