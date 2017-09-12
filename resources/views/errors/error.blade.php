{{-- deprecated --}}


{{ XeFrontend::bodyClass('error-page')->load() }}
{{ XeFrontend::css('assets/core/error/style.css')->load() }}

<div class="error-page-contents">

{!! $errorContents !!}

</div>
