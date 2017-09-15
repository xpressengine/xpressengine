<!-- 사용 안하는 페이지 -->
@section('page_title')
    <h2>문서관리</h2>
@endsection

@section('page_description')
    문서를 관리하는 페이지 입니다.
@endsection

<div class="container">

    <form class="__xe_search_form" method="get">
    <div class="searchs form-inline">
        <div class="btn-group __xe_btns_search">
            <button type="button" class="btn btn-default {{ Request::get('status') == 'trash' ? 'active' : ''}}" data-key="status" data-value="trash">
                <i class="fa fa-search"></i>
                휴지통
            </button>
            <button type="button" class="btn btn-default {{ Request::get('approved') == 'wait' ? 'active' : ''}}" data-key="approved" data-value="wait">
                <i class="fa fa-search"></i>
                승인대기
            </button>
            <button type="button" class="btn btn-default {{ Request::get('display') == 'hidden' ? 'active' : ''}}" data-key="display" data-value="hidden">
                <i class="fa fa-search"></i>
                숨김
            </button>
            <button type="button" class="btn btn-default {{ Request::get('status') == 'temp' ? 'active' : ''}}" data-key="status" data-value="temp">
                <i class="fa fa-search"></i>
                임시저장
            </button>

        </div>

        <select name="searchTarget" class="form-control">
            <option value="title_content" {{Request::get('searchTarget') == 'title_content' ? 'selected="selected"' : ''}}>제목+내용</option>
            <option value="title" {{Request::get('searchTarget') == 'title' ? 'selected="selected"' : ''}}>제목</option>
            <option value="content" {{Request::get('searchTarget') == 'content' ? 'selected="selected"' : ''}}>내용</option>
            <option value="writer" {{Request::get('searchTarget') == 'writer' ? 'selected="selected"' : ''}}>글쓴이</option>
        </select>
        <input type="text" name="searchKeyword" class="form-control" value="{{Request::get('searchKeyword')}}" placeholder="검색어 입력"/>

        <button type="submit" class="btn btn-default"> <i class="fa fa-search"></i> search </button>
        <a href="{!! route('manage.document.index', Request::except('searchTarget', 'searchKeyword')) !!}" class="btn btn-default">취소</a>
    </div>
    </form>

    <div class="__xe_tools">
        <div class="text-right">
            <div class="btn-group">
                <button type="button" class="btn btn-default" data-mode="move">
                    <i class="fa fa-exchange"></i>
                    이동
                </button>
                <button type="button" class="btn btn-default" data-mode="trash">
                    <i class="fa fa-trash"></i>
                    휴지통
                </button>
                <button type="button" class="btn btn-default" data-mode="restore">
                    <i class="fa fa-recycle"></i>
                    복원
                </button>
                <button type="button" class="btn btn-default" data-mode="destroy">
                    <i class="fa fa-times"></i>
                    삭제
                </button>
                <button type="button" class="btn btn-default" data-mode="reject">
                    <i class="fa fa-ban"></i>
                    승인반려
                </button>
                <button type="button" class="btn btn-default" data-mode="approve">
                    <i class="fa fa-check-circle-o"></i>
                    게시승인
                </button>
            </div>
        </div>
    </div>
    <br>

    <form class="__xe_form_list" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>제목</th>
                <th>작성자</th>
                <th><i class="fa fa-thumbs-o-up"></i> / <i class="fa fa-thumbs-o-down"></i> / <i class="fa fa-eye"></i></th>
                <th>날짜</th>
                <th>IP</th>
                <th>상태</th>
                <th>승인</th>
                <th><input type="checkbox" class="__xe_check_all"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($documents as $document)
            <tr>
                <td><b>[{{ $document->instanceId }}]</b> {{ $document->title }}</td>
                <td>{{ $document->writer }}</td>
                <td>{{ $document->assentCount }} / {{ $document->dissentCount }} / {{ $document->readCount }}</td>
                <td>{{ $document->createdAt }}</td>
                <td>{{ $document->ipaddress }}</td>
                <td>{{ $document->display }}</td>
                <td>{{ $document->approved }}</td>
                <td><input type="checkbox" name="id[]" class="__xe_checkbox" value="{{ $document->id }}"></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </form>

    <nav class="text-center">{!! $documents->render() !!}</nav>
</div>

<div class="modal fade __xe_document_move">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">이동할 게시판을 선택하세요.</h4>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    $(function () {

        $('__xe_check_all').click(function () {
            if ($(this).is(':checked')) {
                $('input.__xe_checkbox').click();
            } else {
                $('input.__xe_checkbox').removeAttr('checked');
            }
        });

        $('.__xe_tools button').click(function () {
            var mode = $(this).attr('data-mode'), flag = false;

            $('input.__xe_checkbox').each(function () {
                if ($(this).is(':checked')) {
                    flag = true;
                }
            });

            if (flag !== true) {
                alert('select document');
                return;
            }

            var $f = $('.__xe_form_list');
            $('<input>').attr('type', 'hidden').attr('name', 'redirect').val(location.href).appendTo($f);

            eval('actions.' + mode + '($f)');
        });

        $('.__xe_btns_search').on('click', 'button', function() {
            var frm = $(this).parents('form');

            if ($(this).hasClass('active') == false) {
                frm.append(
                        $('<input>').hide()
                                .attr('type', 'text')
                                .attr('name', $(this).attr('data-key'))
                                .val($(this).attr('data-value'))
                );
            }

            frm.submit();
        });

    });

    var actions = {
        approve: function ($f) {
            $('<input>').attr('type', 'hidden').attr('name', 'appreved').val('appreved').appendTo($f);

            $f.attr('action', '{!! route('manage.document.approve', Request::all()) !!}');
            $f.submit();
        },
        reject: function ($f) {
            $('<input>').attr('type', 'hidden').attr('name', 'appreved').val('rejected').appendTo($f);

            $f.attr('action', '{!! route('manage.document.approve', Request::all()) !!}');
            $f.submit();
        },
        destroy: function ($f) {
            $f.attr('action', '{!! route('manage.document.destroy', Request::all()) !!}');
            $f.submit();
        },
        trash: function ($f) {
            $f.attr('action', '{!! route('manage.document.trash', Request::all()) !!}');
            $f.submit();
        },
        move: function ($f) {

            $('.__xe_document_move').modal('toggle');
            //moveDocument($f);
//            $f.attr('action', '{!! route('manage.document.move', Request::all()) !!}');
//            $f.submit();
        },
        restore: function ($f) {
            $f.attr('action', '{!! route('manage.document.restore', Request::all()) !!}');
            $f.submit();
        }
    };

    var moveDocument = function($f) {
            $f.attr('action', '{!! route('manage.document.move', Request::all()) !!}');
            $f.submit();
    }
</script>
