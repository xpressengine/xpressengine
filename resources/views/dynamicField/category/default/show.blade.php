@if($data['categoryItem'] != null && !empty($data['categoryItem']->word))
<span>{{ xe_trans($data['categoryItem']->word) }}</span>
@endif
