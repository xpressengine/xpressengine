<li class="active">
    <a href="#" class="list-card__link">
        <span class="blind">카드 이미지</span>
        <div class="list-card__image">
            <div class="list-card__image-content" style="background-image: url({{$theme->icon}})"></div>
        </div>
        <div class="list-card__search-icon">
            <i class="xi-search"></i>
        </div>
        <div class="list-card-info">
            <div class="list-card-info__title-box">
                <p class="list-card-info__title">{{ $theme->title }}</p>
                @if ($theme->price > 0)
                    <span class="list-card-info__price">{{'￦ ' . number_format($theme->price) }}</span>
                @endif
            </div>
            <div class="list-card-info__sub-text-box">
                <span class="list-card-info__sub-text">{{ $theme->author }}</span>
                <span class="list-card-info__sub-text">{{ $theme->category_titles[0] }}</span>
            </div>
        </div>
    </a>
    <div class="list-card-footer">
        <div class="list-card-download">
            <i class="xi-download"></i>
            <span class="list-card-download__text">{{ number_format($theme->downloadeds) }}</span>
        </div>
        <div class="list-card-button-box">
            <button type="button" class="btn btn-default">미리보기</button>
            <button type="button" class="btn btn-default">비활성화</button>
        </div>
    </div>
</li>
