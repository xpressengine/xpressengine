<style>
    .chak_button{margin-top:80px}
    .chak_button a{display:block;padding: 14px 25px;color:#359bf7;font-weight:600;border:1px solid #E4E4E4;border-radius: 48px;font-size:15px;text-align:center}
    .chak_button a .chak_txt{display:none;margin-left:20px;color:#696e7a;font-weight:normal}
    .chak_button a:hover{background-color:#F4F6F9;color:#359bf7}
    .chak_button a .chak_txt{display:inline-block}
</style>
<div class="chak_button">
    <a href="#chak_comment"><span class="chak_txt">{{xe_trans('xe::chakButtonDescription')}}</span> </a>
</div>
<script type="text/javascript">
System.import('xecore:/common/js/xe').then(function(XE) {
    XE.$(function($) {
        var s=document.createElement('script');s.type='text/javascript';s.src='//chak.it/static/service.js';s.async=true;(document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(s);

        $.ajax({
            url : "//chak.it/xpressengine_io/v1/{{$chakApiKey}}/articles/count?categories[]={{$category}}&type=forum",
            dataType : "jsonp",
            jsonp : "callback"
        }).done(function(data){
            var $button = $('a[href="#chak_comment"]');
            $button.html(data.count + ' Forums.' + $button.html());
        });


        $('a[href="#chak_comment"]').on('click', function(event) {
            event.preventDefault();

            var $container = $(this).closest('.chak_button');

            $container.addClass('chak_comment');
            $container.attr('data-chak-categories', '{{$category}}');
            $container.attr('data-chak-apikey', '{{$chakApiKey}}');

            manuallySetChakService($container[0]);
            $(event.target).closest('a').remove();
        });
    });
});
</script>
