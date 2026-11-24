<?php

namespace Xpressengine\Tests\Menu;

use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\SQLiteConnection;
use PDO;
use PHPUnit\Framework\TestCase;
use Xpressengine\Database\ProxyManager;
use Xpressengine\Database\VirtualConnection;
use Xpressengine\Menu\Models\Menu;

final class MenuItemRelationshipTest extends TestCase
{
    public function testEagerLoadingFindsItemsForAStringMenuId(): void
    {
        if (!extension_loaded('pdo_sqlite')) {
            $this->markTestSkipped('The pdo_sqlite extension is required.');
        }

        $menuId = '54e311e9';
        $itemId = '8f14e45f';
        $connection = new SQLiteConnection(new PDO('sqlite::memory:'));
        $connection->statement('create table menu (id varchar(36) primary key)');
        $connection->statement('create table menu_item (id varchar(36) primary key, menu_id varchar(36) not null)');
        $connection->table('menu')->insert(['id' => $menuId]);
        $connection->table('menu_item')->insert(['id' => $itemId, 'menu_id' => $menuId]);

        $resolver = new ConnectionResolver([
            'menu-test' => new VirtualConnection($connection, $this->createMock(ProxyManager::class)),
        ]);
        $resolver->setDefaultConnection('menu-test');
        $originalResolver = Menu::getConnectionResolver();
        Menu::setConnectionResolver($resolver);

        try {
            $menu = Menu::with('items')->findOrFail($menuId);

            self::assertSame([$itemId], $menu->items->modelKeys());
        } finally {
            if ($originalResolver === null) {
                Menu::unsetConnectionResolver();
            } else {
                Menu::setConnectionResolver($originalResolver);
            }
        }
    }
}
