<?php

namespace Xpressengine\Spotlight\Importers;

use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Plugins\Board\Components\Modules\BoardModule;
use Xpressengine\Spotlight\SpotlightItem;

class CommentImporter extends AbstractImporter
{
    public function convert($value)
    {
        if (! $this->checkTarget($value)) {
            throw new \InvalidArgumentException('This is not a Comment.');
        }

        return [
            $this->getConfigItem($value),
            $this->getPermissionItem($value),
            $this->addSkinItem($value),
            $this->getEditorItem($value),
            $this->getToggleMenuItem($value),
        ];
    }

    public function checkTarget($value)
    {
        if ($value instanceof MenuItem) {
            $boardConfig = app('xe.config')->get(sprintf("%s.%s", BoardModule::getId(), $value->id));

            if ($boardConfig && $boardConfig->get('comment')) {
                return true;
            }
        }

        return false;
    }
    
    private function getConfigItem(MenuItem $item)
    {
        $title = xe_trans($item->title);

        return new SpotlightItem(
            sprintf('board_comment.%s.edit', $item->id),
            sprintf('%s 게시판 댓글 상세 설정 수정', $title),
            sprintf('%s 게시판 댓글 상세 설정 수정하기', $title),
            route('comment::setting.config', ['targetInstanceId' => $item->id])
        );
    }

    private function getPermissionItem(MenuItem $item)
    {
        $title = xe_trans($item->title);

        return new SpotlightItem(
            sprintf('board_comment.%s.permission', $item->id),
            sprintf('%s 게시판 댓글 권한 수정', $title),
            sprintf('%s 게시판 댓글 권한 수정하기', $title),
            route('comment::setting.perm', ['targetInstanceId' => $item->id])
        );
    }

    protected function addSkinItem(MenuItem $item)
    {
        $title = xe_trans($item->title);

        return new SpotlightItem(
            sprintf('board_comment.%s.skin', $item->id),
            sprintf('%s 게시판 댓글 스킨 수정', $title),
            sprintf('%s 게시판 댓글 스킨 수정하기', $title),
            route('comment::setting.skin', ['targetInstanceId' => $item->id])
        );
    }

    protected function getEditorItem(MenuItem $item)
    {
        $title = xe_trans($item->title);

        return new SpotlightItem(
            sprintf('board_comment.%s.editor', $item->id),
            sprintf('%s 게시판 댓글 에디터 설정', $title),
            sprintf('%s 게시판 댓글 에디터 수정하기', $title),
            route('comment::setting.editor', ['targetInstanceId' => $item->id])
        );
    }

    protected function getToggleMenuItem(MenuItem $item)
    {
        $title = xe_trans($item->title);

        return new SpotlightItem(
            sprintf('board_comment.%s.toggleMenu', $item->id),
            sprintf('%s 게시판 댓글 토글 메뉴 수정', $title),
            sprintf('%s 게시판 댓글 토글 메뉴 수정하기', $title),
            route('comment::setting.tm', ['targetInstanceId' => $item->id])
        );
    }
}