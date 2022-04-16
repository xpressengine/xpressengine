<div class="xe-container xe-menu-type-list">
    <div class="row">
    @foreach($types as $id => $menuType)
        <div class="xe-col-6 xe-col-sm-6 xe-col-md-6 xe-col-lg-6">
            <div class="card @if(short_module_id($selectedTypeId) === short_module_id($menuType['id'])) card--active @endif">
                <input hidden type="radio" name="selectType" value="{{ short_module_id($menuType['id']) }}" @if(short_module_id($selectedTypeId) === short_module_id($menuType['id'])) checked @endif>
                <div class="card-header">
                    <div class="card-img-top" style="background-image: url('{{ array_first($menuType['screenshot']) ?? '/assets/core/common/img/default_image_196x140.jpg' }}')"></div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $menuType['title'] }}</h5>
                    <p class="card-text">{{ $menuType['description'] }}</p>
                </div>
            </div>
        </div>
    @endforeach
    </div>
</div>

<script>
$(function () {
    var $card = $('.xe-menu-type-list .card')
    var $radio = $('.xe-menu-type-list input[type=radio]')
    $card.on('click', function () {
        $radio.attr('checked', false)
        $card.removeClass('card--active')
        $(this).addClass('card--active')
        $(this).find('input[type=radio]').attr('checked', true)
    });
});
</script>


