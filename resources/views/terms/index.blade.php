<div class="container">
    <div style="margin:20px 0;">
        <h2>{{ xe_trans($term->title) }}</h2>
        <hr />
        <div class="xf-term-content">
            {!! nl2br(xe_trans($term->content)) !!}
        </div>
    </div>
</div>
