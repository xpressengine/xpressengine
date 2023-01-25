<style>
    .term-content-container {margin:20px 0;}
    .term-content-container .title {}
    .term-content-container .content {padding:20px; background:#eee; border:1px solid #ccc;}
</style>
<div class="container terms " data-term-id="{{$term->id}}">
    <div class="term-content-container">
        <h2 class="title">{{ xe_trans($term->title) }}</h2>
        <hr />
        <div class="content" >
            {!! nl2br(xe_trans($term->content)) !!}
        </div>
    </div>
</div>
