<!DOCTYPE html>
<html>
<head>
    <!-- CUSTOM TAGS -->
    {!! XeFrontend::output('html', 'head.prepend') !!}

    <!-- META -->
    <meta charset="utf-8">
    <meta name="Generator" content="XpressEngine">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {!! XeFrontend::output('meta') !!}

    <!-- TITLE -->
    <title>{!! XeLang::trans(XeFrontend::output('title')) !!}</title>

    <!-- ICON -->
    {!! XeFrontend::output('icon') !!}

    <!-- CSS -->
    {!! XeFrontend::output('css') !!}

    <!-- JS at head.prepend -->
    <script>var xeBaseURL = '{{  url() }}';</script>
    {!! XeFrontend::output('js', 'head.prepend') !!}

    <script type="text/javascript">
        XE.setup({
            'X-CSRF-TOKEN': '{!! csrf_token() !!}',
            loginUserId: '{{ Auth::check() ? Auth::user()->getId() : ''}}'
        });

        XE.configure({
            locale: '{{ session()->get('locale') ?: app('xe.translator')->getLocale() }}',
            defaultLocale: '{{ app('xe.translator')->getLocale() }}',
            @if (in_array(Auth::user()->getRating(), [\Xpressengine\User\Rating::SUPER, \Xpressengine\User\Rating::MANAGER]))
            managePrefix: '{{ app('config')['xe.routing.settingsPrefix'] }}'
            @endif
        });

        <!-- Translation -->
        {!! XeFrontend::output('translation') !!}
    </script>

    <!-- JS at head.append -->
    {!! XeFrontend::output('js', 'head.append') !!}

    <!-- CUSTOM TAGS -->
    {!! XeFrontend::output('html', 'head.append') !!}
</head>

<body class="{{ XeFrontend::output('bodyClass') }}">

<!-- JS at body.prepend -->
{!! XeFrontend::output('js', 'body.prepend') !!}

<!-- CUSTOM TAGS -->
{!! XeFrontend::output('html', 'body.prepend') !!}

{!! $content !!}

<!-- JS at body.append -->
{!! XeFrontend::output('js', 'body.append') !!}

<!-- CUSTOM TAGS -->
{!! XeFrontend::output('html', 'body.append') !!}

<!-- Rule -->
{!! XeFrontend::output('rule') !!}

@include('common.alert')

{{--<div class="images" data-toggle="xe-lightbox" data-selector="a">--}}
    {{--<a href="http://owlgraphic.com/owlcarousel/demos/assets/fullimage1.jpg"><img src="http://owlgraphic.com/owlcarousel/demos/assets/fullimage1.jpg" width="120" height="120" alt="thumb"></a>--}}
    {{--<a href="http://getuikit.com/docs/images/placeholder_800x600_3.jpg"><img src="http://getuikit.com/docs/images/placeholder_800x600_3.jpg" width="120" height="120" alt="thumb"></a>--}}
    {{--<a href="http://owlgraphic.com/owlcarousel/demos/assets/fullimage3.jpg"><img src="http://owlgraphic.com/owlcarousel/demos/assets/fullimage3.jpg" width="120" height="120" alt="thumb"></a>--}}
    {{--<a href="http://www.responsibletravel.co.kr/travel/layouts/ts_basic/img/bg_nanum.jpg"><img src="http://www.responsibletravel.co.kr/travel/layouts/ts_basic/img/bg_nanum.jpg" width="120" height="120" alt="thumb"></a>--}}
    {{--<a href="http://getuikit.com/docs/images/placeholder_800x600_3.jpg"><img src="http://getuikit.com/docs/images/placeholder_800x600_3.jpg" width="120" height="120" alt="thumb"></a>--}}
    {{--<a href="http://owlgraphic.com/owlcarousel/demos/assets/fullimage3.jpg"><img src="http://owlgraphic.com/owlcarousel/demos/assets/fullimage3.jpg" width="120" height="120" alt="thumb"></a>--}}
{{--</div>--}}

{{--<div class="images" >--}}
    {{--<img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTgIjFUOm55lE51OyoHhVspKSF05Qm8uVTaf_huAwjmfC3yx87a"--}}
         {{--data-origin="http://flexslider.woothemes.com/images/kitchen_adventurer_caramel.jpg" width="120" height="120" alt="thumb">--}}
    {{--<img src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcQe3iQEWJnEaupbWiztj6CPA4BmB3TH0iKE4yhtauZlIjb64Ma9"--}}
         {{--data-origin="http://webdae.uta.cl/images/slide4.jpg" width="120" height="120" alt="thumb">--}}
    {{--<img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTShhpbR6qA84Ui3lqRczYKZCQzlozfmvmbRrs_9Gi-l9FT_tEw"--}}
         {{--data-origin="http://memocarilog.info/wp-content/uploads/2012/02/slides.png" width="120" height="120" alt="thumb">--}}
    {{--<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTbWJHOJ49A6b1TNuufXpPzZC2UcDHHMGHsNVJ9TozXYg2uRSpf"--}}
         {{--data-origin="http://www.fergusweb.net/wp-content/plugins/flexslider/images/inacup_samoa.jpg" width="120" height="120" alt="thumb">--}}
    {{--<img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcSxsb5rpIrnP97QdqwSA_UbeZXt1NlRI5T9Os4OiDx36JxGxfbR"--}}
         {{--data-origin="http://www.ie.edu/es/valores/images/mocks/inacup_donut.jpg" width="120" height="120" alt="thumb">--}}
    {{--<img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTgBFGmplPxC8V0RYiL1BNw0UnrJAmqy8mx96fh6FtM_i46oqk9"--}}
         {{--data-origin="http://pixelosaur.com/blog/wp-content/uploads/2015/01/flex-slider.png" width="120" height="120" alt="thumb">--}}
{{--</div>--}}

<div class="images" >
    <img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTgIjFUOm55lE51OyoHhVspKSF05Qm8uVTaf_huAwjmfC3yx87a"
         data-origin="http://flexslider.woothemes.com/images/kitchen_adventurer_caramel.jpg" width="120" height="120" alt="thumb">
    <img src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcQe3iQEWJnEaupbWiztj6CPA4BmB3TH0iKE4yhtauZlIjb64Ma9"
         data-origin="http://webdae.uta.cl/images/slide4.jpg" width="120" height="120" alt="thumb">
    <img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTShhpbR6qA84Ui3lqRczYKZCQzlozfmvmbRrs_9Gi-l9FT_tEw"
         data-origin="http://memocarilog.info/wp-content/uploads/2012/02/slides.png" width="120" height="120" alt="thumb">
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTbWJHOJ49A6b1TNuufXpPzZC2UcDHHMGHsNVJ9TozXYg2uRSpf"
         data-origin="http://www.fergusweb.net/wp-content/plugins/flexslider/images/inacup_samoa.jpg" width="120" height="120" alt="thumb">
    <img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcSxsb5rpIrnP97QdqwSA_UbeZXt1NlRI5T9Os4OiDx36JxGxfbR"
         data-origin="http://www.ie.edu/es/valores/images/mocks/inacup_donut.jpg" width="120" height="120" alt="thumb">
    <img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTgBFGmplPxC8V0RYiL1BNw0UnrJAmqy8mx96fh6FtM_i46oqk9"
         data-origin="http://pixelosaur.com/blog/wp-content/uploads/2015/01/flex-slider.png" width="120" height="120" alt="thumb">
</div>

{{--<div class="images">--}}
    {{--<img src="http://owlgraphic.com/owlcarousel/demos/assets/fullimage1.jpg" width="120" height="120" alt="thumb">--}}
    {{--<img src="http://getuikit.com/docs/images/placeholder_800x600_3.jpg" width="120" height="120" alt="thumb">--}}
    {{--<img src="http://owlgraphic.com/owlcarousel/demos/assets/fullimage3.jpg" width="120" height="120" alt="thumb">--}}
    {{--<img src="http://www.responsibletravel.co.kr/travel/layouts/ts_basic/img/bg_nanum.jpg" width="120" height="120" alt="thumb">--}}
    {{--<img src="http://getuikit.com/docs/images/placeholder_800x600_3.jpg" width="120" height="120" alt="thumb">--}}
    {{--<img src="http://owlgraphic.com/owlcarousel/demos/assets/fullimage3.jpg" width="120" height="120" alt="thumb">--}}
{{--</div>--}}
<script type="text/javascript" src="/assets/core/xe-ui-component/js/xe-lightbox.js"></script>
</body>
</html>
