<?php
/**
 * This file is draft repository class
 *
 * PHP version 5
 *
 * @category    Draft
 * @package     Xpressengine\Draft
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Draft;

use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Keygen\Keygen;

/**
 * 데이터베이스에 임시저장 데이터 입출력 처리
 *
 * @category    Draft
 * @package     Xpressengine\Draft
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class DraftRepository
{
    /**
     * Connection instance
     *
     * @var VirtualConnectionInterface
     */
    protected $conn;

    /**
     * Keygen instance
     *
     * @var Keygen
     */
    protected $keygen;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'draft';

    /**
     * Constructor
     *
     * @param VirtualConnectionInterface $conn   Connection instance
     * @param Keygen                     $keygen Keygen instance
     */
    public function __construct(VirtualConnectionInterface $conn, Keygen $keygen)
    {
        $this->conn = $conn;
        $this->keygen = $keygen;
    }

    /**
     * 하나의 임시저장 객채를 반환
     *
     * @param string $id 임시저장 아이디
     * @return DraftEntity
     */
    public function find($id)
    {
        $row = $this->conn->table($this->table)->where('id', $id)->first();

        if ($row !== null) {
            return $this->createItem((array)$row);
        }

        return null;
    }

    /**
     * 임시저장 데이터 목록을 반환
     *
     * @param array $options 검색할 조건
     * @return array
     */
    public function fetch(array $options)
    {
        $query = $this->conn->table($this->table);
        foreach ($options as $column => $value) {
            $query->where($column, $value);
        }
        $rows = $query->get();

        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->createItem((array)$row);
        }

        return $items;
    }

    /**
     * 새로운 임시저장 데이터 레코드를 삽입
     *
     * @param DraftEntity $draft 임시저장 객체
     * @return DraftEntity
     */
    public function insert(DraftEntity $draft)
    {
        $attributes = array_merge($draft->getAttributes(), [
            'id' => $this->keygen->generate(),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $this->conn->table($this->table)->insert($attributes);

        return $this->createItem($attributes);
    }

    /**
     * 임시저장 데이터를 수정
     *
     * @param DraftEntity $draft 임시저장 객체
     * @return DraftEntity
     */
    public function update(DraftEntity $draft)
    {
        $diff = array_merge($draft->getDirty(), ['created_at' => date('Y-m-d H:i:s')]);

        $this->conn->table($this->table)->where('id', $draft->id)->update($diff);

        return $this->createItem(array_merge($draft->getOriginal(), $diff));
    }

    /**
     * 임시저장 데이터 삭제
     *
     * @param DraftEntity $draft 임시저장 객체
     * @return int 삭제된 레코드 수(정상적인 경우 '1')
     */
    public function delete(DraftEntity $draft)
    {
        return $this->conn->table($this->table)->where('id', $draft->id)->delete();
    }

    /**
     * 임시저장 객체를 생성
     *
     * @param array $attributes 객체 속성 값들
     * @return DraftEntity
     */
    protected function createItem(array $attributes)
    {
        return new DraftEntity($attributes);
    }
}
