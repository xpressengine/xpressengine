<div class="read_footer">

<div class="bd_file_list">
    <!-- [D] 클릭시 클래스 on 적용 -->
    <a href="#" class="bd_btn_file"><i class="xi-clip"></i><span class="xe-sr-only">file attached list</span> <strong class="bd_file_num">{{ count($files) }}</strong></a>
    <ul>
        @foreach($files as $file)
            <li><a href="{{ route('editor.file.download', ['id' => $file->id])}}"><i class="xi-download"></i> {{ $file->clientname }} <span class="file_size">({{ bytes($file->size) }})</span></a></li>
        @endforeach
    </ul>
</div>

</div>