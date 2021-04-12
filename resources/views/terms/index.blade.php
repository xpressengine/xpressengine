<div class="container">
    <div  style="margin:20px 0;">
        <h2>{{ xe_trans($term->title) }}</h2>
        <hr />
        <div style="padding:20px; background:#eee; border:1px solid #ccc;">
            {!! nl2br(xe_trans($term->content)) !!}
        </div>
    </div>
</div>
