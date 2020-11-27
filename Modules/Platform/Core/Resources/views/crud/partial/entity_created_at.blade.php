<div class="col-lg-12 col-md-12 col-sm-12 text-right entity-created-at">
    <div>
        @lang('core::core.created_on'): <strong>{{ \Modules\Platform\Core\Helper\UserHelper::formatUserDateTime($entity->created_at) }}</strong>
        @if($actityLogDatatable != null )
            @lang('core::core.by') <strong>{{ $entity->activity->first()->causer->name }}</strong>
        @endif

    </div>
    <div>
        @lang('core::core.updated_at'): <strong>{{ \Modules\Platform\Core\Helper\UserHelper::formatUserDateTime($entity->updated_at) }}</strong>
        @if($actityLogDatatable != null )
            @lang('core::core.by') <strong>{{ $entity->activity->last()->causer->name }}</strong>
        @endif
    </div>
</div>