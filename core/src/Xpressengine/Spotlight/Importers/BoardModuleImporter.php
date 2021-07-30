<?php

namespace Xpressengine\Spotlight\Importers;

use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Spotlight\SpotlightItem;

class BoardModuleImporter extends AbstractImporter
{
    public function convert($value)
    {
        if (! $this->checkTarget($value)) {
            throw new \InvalidArgumentException('This is not a Board Module Menu Item.');
        }

        return [
            $this->getEditItem($value),
            $this->getPermissionItem($value),
            $this->getToggleMenuItem($value),
            $this->getSkinItem($value),
            $this->getEditorIem($value),
            $this->getColumnItem($value),
            $this->getDynamicFieldItem($value),
        ];
    }

    public function checkTarget($value)
    {
        return $value instanceof MenuItem && $value->type === 'board@board';
    }

    private function getEditItem(MenuItem $item)
    {
        $title = xe_trans($item->title);

        return new SpotlightItem(
            sprintf('board_menu.%s.edit', $item->id),
            sprintf('%s 게시판 상세 설정 수정', $title),
            sprintf('%s 게시판 상세 설정 수정하기', $title),
            route('settings.board.board.config', ['boardId' => $item->id])
        );
    }

    private function getPermissionItem(MenuItem $item)
    {
        $title = xe_trans($item->title);

        return new SpotlightItem(
            sprintf('board_menu.%s.permission', $item->id),
            sprintf('%s 게시판 권한 수정', $title),
            sprintf('%s 게시판 권한 수정하기', $title),
            route('settings.board.board.permission', ['boardId' => $item->id])
        );
    }

    private function getToggleMenuItem(MenuItem $item)
    {
        $title = xe_trans($item->title);

        return new SpotlightItem(
            sprintf('board_menu.%s.toggleMenu', $item->id),
            sprintf('%s 게시판 토글 메뉴 수정', $title),
            sprintf('%s 게시판 토글 메뉴 수정하기', $title),
            route('settings.board.board.toggleMenu', ['boardId' => $item->id])
        );
    }

    private function getSkinItem(MenuItem $item)
    {
        $title = xe_trans($item->title);

        return new SpotlightItem(
            sprintf('board_menu.%s.skin', $item->id),
            sprintf('%s 게시판 스킨 수정', $title),
            sprintf('%s 게시판 스킨 수정하기', $title),
            route('settings.board.board.skin', ['boardId' => $item->id])
        );
    }

    private function getEditorIem(MenuItem $item)
    {
        $title = xe_trans($item->title);

        return new SpotlightItem(
            sprintf('board_menu.%s.editor', $item->id),
            sprintf('%s 게시판 에디터 수정', $title),
            sprintf('%s 게시판 에디터 수정하기', $title),
            route('settings.board.board.editor', ['boardId' => $item->id])
        );
    }

    private function getColumnItem(MenuItem $item)
    {
        $title = xe_trans($item->title);

        return new SpotlightItem(
            sprintf('board_menu.%s.columns', $item->id),
            sprintf('%s 게시판 출력 순서 수정', $title),
            sprintf('%s 게시판 출력 순서 수정하기', $title),
            route('settings.board.board.columns', ['boardId' => $item->id])
        );
    }

    private function getDynamicFieldItem(MenuItem $item)
    {
        $title = xe_trans($item->title);

        return new SpotlightItem(
            sprintf('board_menu.%s.dynamicField', $item->id),
            sprintf('%s 게시판 확장 필드 수정', $title),
            sprintf('%s 게시판 확장 필드 수정하기', $title),
            route('settings.board.board.dynamicField', ['boardId' => $item->id])
        );
    }
}