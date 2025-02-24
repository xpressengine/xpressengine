@section('page_title')
    <h2>
        <a href="{{ route('manage.category.index') }}">
            <i class="xi-arrow-left"></i>
        </a>

        {{ xe_trans('xe::category') }}
    </h2>
@endsection

{!! $dynamicFieldSection !!}
