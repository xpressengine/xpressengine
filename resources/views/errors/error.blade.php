{{ Frontend::bodyClass('error-page')->load() }}
{{ Frontend::css('assets/error/style.css')->load() }}

<div class="error-page-contents">

{!! $errorContents !!}

</div>
