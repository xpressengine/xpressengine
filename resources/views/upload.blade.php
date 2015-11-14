
<div>
    <form name="fupload" method="post" enctype="multipart/form-data" action="/storage/upload">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="file" name="attached">
        <button type="submit"> upload </button>
    </form>
</div>


<object type='application/x-shockwave-flash' data='/storage/app/BannerSnack-ad-336x280.swf' width='336' height='280'>
    <param name='allowScriptAccess' value='always' />
    <param name='movie' value='/storage/app/BannerSnack-ad-336x280.swf' />
    <param name='bgcolor' value='#ffffff' />
</object>



