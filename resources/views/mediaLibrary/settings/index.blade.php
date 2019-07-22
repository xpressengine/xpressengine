@section('page_title')
    <h2>미디어 라이브러리</h2>
@endsection

<div class="row">
    <div class="col-sm-12">
        <form method="post" action="{{route('settings.mediaLibrary.storeFileSetting')}}" class="plugin-install-form">
            {!! csrf_field() !!}
            이미지 크기 설정
            <table class="xe-table">
                <tr>
                    <th>small 폭</th>
                    <th>small 높이</th>
                </tr>
                <tr>
                    <td><input type="text" name="dimensions_s_width" value="{{config('xe.media.thumbnail.dimensions')['S']['width']}}"></td>
                    <td><input type="text" name="dimensions_s_height" value="{{config('xe.media.thumbnail.dimensions')['S']['height']}}"></td>
                </tr>

                <tr>
                    <th>medium 폭</th>
                    <th>medium 높이</th>
                </tr>
                <tr>
                    <td><input type="text" name="dimensions_m_width" value="{{config('xe.media.thumbnail.dimensions')['M']['width']}}"></td>
                    <td><input type="text" name="dimensions_m_height" value="{{config('xe.media.thumbnail.dimensions')['M']['height']}}"></td>
                </tr>

                <tr>
                    <th>large 폭</th>
                    <th>large 높이</th>
                </tr>
                <tr>
                    <td><input type="text" name="dimensions_l_width" value="{{config('xe.media.thumbnail.dimensions')['L']['width']}}"></td>
                    <td><input type="text" name="dimensions_l_height" value="{{config('xe.media.thumbnail.dimensions')['L']['height']}}"></td>
                </tr>

                <tr>
                    <th>최대 크기 폭</th>
                    <th>최대 크기 높이</th>
                </tr>
                <tr>
                    <td><input type="text" name="dimensions_max_width" value="{{config('xe.media.thumbnail.dimensions')['MAX']['width']}}"></td>
                    <td><input type="text" name="dimensions_max_height" value="{{config('xe.media.thumbnail.dimensions')['MAX']['height']}}"></td>
                </tr>

                <tr>
                    <th>업로드 최대 용량(MB)</th>
                    <td><input type="text" name="max_size" value="{{config('xe.media.mediaLibrary.max_size')}}"></td>
                </tr>

                <tr>
                    <th>제한 파일 <small>업로드 제한할 확장자</small></th>
                    <td><input type="text" name="disallow_extensions" value="{{config('xe.media.mediaLibrary.disallow_extensions')}}"></td>
                </tr>
            </table>

            <button type="submit" class="xe-btn xe-btn-positive">저장</button>
        </form>
    </div>
</div>
