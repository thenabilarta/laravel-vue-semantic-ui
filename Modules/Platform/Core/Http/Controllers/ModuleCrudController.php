<?php

namespace Modules\Platform\Core\Http\Controllers;

use Cog\Contracts\Ownership\Ownable;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Modules\Core\Notifications\GenericNotification;
use Modules\Platform\Core\Datatable\ActivityLogDataTable;
use Modules\Platform\Core\Datatable\Scope\OwnableEntityScope;
use Modules\Platform\Core\Helper\StringHelper;
use Modules\Platform\Core\Helper\ValidationHelper;
use Modules\Platform\Core\Repositories\GenericRepository;
use Modules\Platform\Core\Traits\ModuleOwnableTrait;
use Modules\Platform\Notifications\Entities\NotificationPlaceholder;
use Modules\Platform\User\Entities\Group;
use Modules\Platform\User\Entities\User;
use Stringy\Stringy;

/**
 * Class ModuleCrudController
 *
 * @package Modules\Platform\Core\Http\Controllers
 */
abstract class ModuleCrudController extends AppBaseController
{
    use FormBuilderTrait, ModuleOwnableTrait;

    const ACTIVITY_LOG_EXTENSION = 'Spatie\Activitylog\Traits\LogsActivity';

    const COMMENTS_EXTENSION = 'Modules\Platform\Core\Traits\Commentable';

    const ATTACHMENT_EXTENSION = 'Bnb\Laravel\Attachments\HasAttachment';

    const FORM_MODE_FULL = 'full';

    const FORM_MODE_SIMPLE = 'modal';


    /**
     * DataTable in list view (index)
     * @var
     */
    protected $datatable;

    protected $formModalCssClass = null;

    protected $formModalCssId = null;

    protected $disableNextPrev = false;

    /**
     * Default Crud view
     * @var array
     */
    protected $views = [
        'index' => 'core::crud.module.index',
        'show' => 'core::crud.module.show',
        'create' => 'core::crud.module.create',
        'edit' => 'core::crud.module.edit',
    ];

    /**
     * Link for settings in module
     * @var array
     */
    protected $moduleSettingsLinks = [

    ];
    /**
     * Permission for settings
     * @var string
     */
    protected $settingsPermission = '';
    /**
     * Link for back button from settings to main module
     * @var string
     */
    protected $settingsBackRoute = '';
    /**
     * Permissions
     * @var array
     */
    protected $permissions = [
        'browse' => '',
        'create' => '',
        'update' => '',
        'destroy' => ''
    ];
    /**
     * Path to language files
     * @var
     */
    protected $languageFile;
    /**
     * All routes
     * @var array
     */
    protected $routes = [

    ];
    /**
     * Show fields in show view and create/edit view
     *
     * Example @UserController
     *
     * @var array
     */
    protected $showFields = [

    ];

    /**
     * Related Tabs
     * @var array
     */
    protected $relationTabs = [

    ];

    protected $baseIcons = [
        'details_icon' => true,
        'details_label' => true,
        'comments_icon' => true,
        'comments_label' => true,
        'attachments_icon' => true,
        'attachments_label' => true,
        'activity_log_icon' => true,
        'activity_log_label' => true
    ];

    /**
     * Show custom buttons in show view
     * Example @UserController
     * @var array
     */
    protected $customShowButtons = [];

    /**
     * Show action button on show view
     * Default action button (copy)
     * @var array
     */
    protected $actionButtons = [];

    /***
     * Form section buttons
     * Example @InvoiceController
     * @var array
     */
    protected $sectionButtons = [];

    /**
     * Module Repository
     * @var
     */
    protected $repository = GenericRepository::class;

    /**
     * Module Entity Class
     * @var
     */
    protected $entityClass;

    /**
     * Module Store Request
     * @var
     */
    protected $storeRequest;
    /**
     * Module Update Request
     * @var
     */
    protected $updateRequest;
    /**
     * Entity Form Class
     * @var
     */
    protected $formClass;
    /**
     * Module name - same as module folder
     * Example
     * - User Module = "expenses"
     * @var
     */
    protected $moduleName;

    /**
     * Module Entity
     * @var
     */
    protected $entity;

    /**
     * @var
     */
    protected $entityIdentifier;

    /**
     * Additional JavaScript Files to include
     * @var array
     */
    protected $jsFiles = [];

    /**
     * Additioanl CSS Files to include
     * @var array
     */
    protected $cssFiles = [];

    /**
     * Additional view to include
     * Works with show,create,edit - use for modals!
     * @var array
     */
    protected $includeViews = [

    ];

    /**
     * SettingsCrudController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        \View::share('language_file', $this->languageFile);
        \View::share('routes', $this->routes);
        \View::share('jsFiles', $this->jsFiles);
        \View::share('cssFiles', $this->cssFiles);
        \View::share('moduleName', $this->moduleName);
        \View::share('includeViews', $this->includeViews);
        \View::share('moduleSettingsLinks', $this->moduleSettingsLinks);
        \View::share('settingsPermission', $this->settingsPermission);
        \View::share('settingsBackRoute', $this->settingsBackRoute);
        \View::share('permissions', $this->permissions);

        $this->validateModule();
    }

    /**
     * Validate module controller setup
     * @throws \Exception
     */
    public function validateModule()
    {
        if ($this->repository == null && $this->entityClass == null) {
            throw new \Exception('Please set repository or entityClass in Controller');
        }
        if ($this->datatable == null) {
            throw new \Exception('Please set DataTableClass');
        }
        if ($this->formClass == null) {
            throw new \Exception('Please set FormClass');
        }
        if ($this->storeRequest == null || $this->updateRequest == null) {
            throw new \Exception('Please set storeRequest and updateRequest');
        }
    }

    /**
     * Show module DataTable
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $datatable = \App::make($this->datatable);

        if ($this->scopedAccess()) {
            $datatable->addScope(new OwnableEntityScope(\Auth::user(), $this->moduleName));
        }

        $indexView = $this->views['index'];

        if ($request->get('mode', self::FORM_MODE_FULL) == self::FORM_MODE_SIMPLE) {
            $indexView = 'core::crud.module.modal-datatable';

            $datatable->setTableId('RelatedModalTable');
            $datatable->setAjaxSource(route($this->routes['index']));

            return $datatable->render($indexView);
        }

        return $datatable->render($indexView);
    }


    /**
     * Show entity create form
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        if ($this->permissions['create'] != '' && !\Auth::user()->hasPermissionTo($this->permissions['create'])) {
            flash(trans('core::core.you_dont_have_access'))->error();
            return redirect()->route($this->routes['index']);
        }

        $fillModel = $request->all();

        $copy = $request->get('copy', null);
        if ($copy) {

            $repository = $this->getRepository();

            $copyFrom = $repository->findWithoutFailForCopy((int)$copy);

            if (!empty($copy)) {
                $fillModel = $copyFrom;
            }
        }

        $createForm = $this->form($this->formClass, [
            'method' => 'POST',
            'url' => route($this->routes['store']),
            'id' => 'module_form',
            'model' => $fillModel
        ]);

        $createView = $this->views['create'];

        $mode = $request->get('mode', 'full');

        if ($mode == self::FORM_MODE_SIMPLE) {
            $createView = 'core::crud.module.create_form';
        }

        $view = view($createView);

        $view->with('modal_form', false);

        if ($mode == self::FORM_MODE_SIMPLE) {
            $formId = uniqid('form_');

            $view->with('modal_form', true);
            $createForm->setFormOption('id', $formId);
            if ($this->formModalCssClass != null) {
                $createForm->setFormOption('class', $this->formModalCssClass);
            } else {
                $createForm->setFormOption('class', 'module_form related-modal-form');
            }
            if ($this->formModalCssId != null) {
                $createForm->setFormOption('id', $this->formModalCssId);
            }

            $view->with('formId', $formId);
            $createForm->add('entityCreateMode', 'hidden', [
                'value' => 'modal'
            ]);
            $createForm->add('relationType', 'hidden', [
                'value' => $request->get('relationType')
            ]);
            $createForm->add('relatedField', 'hidden', [
                'value' => $request->get('relatedField')
            ]);
            $createForm->add('relatedEntityId', 'hidden', [
                'value' => $request->get('relatedEntityId')
            ]);

            $createForm->add('relatedEntity', 'hidden', [
                'value' => $request->get('relatedEntity')
            ]);
        }


        $view->with('form_request', $this->storeRequest);
        $view->with('show_fields', $this->showFields);
        $view->with('sectionButtons', $this->sectionButtons);

        return $view->with('form', $createForm);
    }

    /**
     * Show entity details
     *
     * @param $identifier
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($identifier)
    {
        if ($this->permissions['browse'] != '' && !\Auth::user()->hasPermissionTo($this->permissions['browse'])) {
            flash(trans('core::core.you_dont_have_access'))->error();
            return redirect()->route($this->routes['index']);
        }

        $repository = $this->getRepository();


        $entity = $repository->find($identifier);


        $this->entity = $entity;

        if (empty($entity)) {
            flash(trans('core::core.entity.entity_not_found'))->error();

            return redirect(route($this->routes['index']));
        }

        if ($this->blockEntityOwnableAccess()) {
            flash(trans('core::core.you_dont_have_access'))->error();
            return redirect()->route($this->routes['index']);
        }

        $this->entityIdentifier = $entity->id;


        $showView = $this->views['show'];

        $this->entity = $entity;

        $view = view($showView);
        $view->with('entity', $entity);
        $view->with('show_fields', $this->showFields);
        $view->with('show_fileds_count', count($this->showFields));

        $view->with('next_record', $repository->next($entity));
        $view->with('prev_record', $repository->prev($entity));
        $view->with('disableNextPrev', $this->disableNextPrev);

        $this->setupCustomButtons();
        $this->setupActionButtons();
        $view->with('customShowButtons', $this->customShowButtons);
        $view->with('actionButtons', $this->actionButtons);
        $view->with('commentableExtension', false);
        $view->with('actityLogDatatable', null);
        $view->with('attachmentsExtension', false);
        $view->with('entityIdentifier', $this->entityIdentifier);


        $view->with('hasExtensions', false);

        $view->with('relationTabs', $this->setupRelationTabs($entity));

        $view->with('baseIcons', $this->baseIcons);

        /*
         * Extensions
         */
        if (in_array(self::COMMENTS_EXTENSION, class_uses($this->entity))) {
            $view->with('commentableExtension', true);
            $view->with('hasExtensions', true);
        }
        if (in_array(self::ACTIVITY_LOG_EXTENSION, class_uses($this->entity))) {
            $activityLogDataTable = \App::make(ActivityLogDataTable::class);
            $activityLogDataTable->setEntityData(get_class($entity), $entity->id);
            $view->with('actityLogDatatable', $activityLogDataTable->html());
            $view->with('hasExtensions', true);
        }
        if (in_array(self::ATTACHMENT_EXTENSION, class_uses($this->entity))) {
            $view->with('attachmentsExtension', true);
            $view->with('hasExtensions', true);
        }

        return $view;
    }

    /**
     * Create instance of module repository or use generic repository
     *
     * @return mixed
     */
    protected function getRepository()
    {
        if ($this->repository == GenericRepository::class) {
            $repository = \App::make($this->repository);
            $repository->setupModel($this->entityClass);
        } else {
            $repository = \App::make($this->repository);
        }

        return $repository;
    }

    /**
     * Setup custom buttons
     */
    protected function setupCustomButtons()
    {

    }

    protected function setupActionButtons()
    {
        $this->actionButtons[] = array(
            'href' => route($this->routes['create'], ['copy' => $this->entity->id]),
            'attr' => [

            ],
            'label' => trans('core::core.btn.copy')
        );
    }


    /**
     * Setup entity relations to other modules
     *
     * @param mixed $entity Entity object
     *
     * @return array
     */
    protected function setupRelationTabs($entity)
    {
        foreach ($this->relationTabs as $tabKey => $tab) {

            /// Related elements Datatable
            $linkedDataTable = \App::make($tab['datatable']['datatable']);

            $entityId = $entity->id;

            $linkedDataTable->setEntityData(get_class($entity), $entityId, $tab['route']['linked']);

            if (\Auth::user()->hasPermissionTo($tab['permissions']['update'])) {
                $linkedDataTable->allowUnlink = true;
            }
            $this->relationTabs[$tabKey]['htmlTable'] = $linkedDataTable->html();
            $this->relationTabs[$tabKey]['create']['post_create_bind']['mode'] = 'modal';
            $this->relationTabs[$tabKey]['create']['post_create_bind']['relatedEntityId'] = $this->entityIdentifier;
            $this->relationTabs[$tabKey]['create']['post_create_bind']['relatedEntity'] = $this->entityClass;

            if ($this->relationTabs[$tabKey]['create']['post_create_bind']['relationType'] == 'oneToMany') {
                $this->relationTabs[$tabKey]['create']['post_create_bind'][$this->relationTabs[$tabKey]['create']['post_create_bind']['relatedField']] = $this->entityIdentifier;
            }

            /// Link new elements Datatable
            $newRecordsDataTable = \App::make($tab['datatable']['datatable']);
            $newRecordsDataTable->setEntityData(get_class($entity), $entityId, $tab['route']['select']);
            $newRecordsDataTable->selectMode();
            $newRecordsDataTable->allowSelect = true;
            //$newRecordsDataTable->allowSelect = true;

            $this->relationTabs[$tabKey]['newRecordsTable'] = $newRecordsDataTable->html();
        }

        return $this->relationTabs;
    }

    /**
     * Store entity
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store()
    {
        $request = \App::make($this->storeRequest ?? Request::class);

        $mode = $request->get('entityCreateMode', self::FORM_MODE_FULL);

        if ($this->permissions['create'] != '' && !\Auth::user()->hasPermissionTo($this->permissions['create'])) {
            if ($mode == self::FORM_MODE_SIMPLE) {
                return response()->json([
                    'type' => 'error',
                    'message' => trans('core::core.entity.you_dont_have_access'),
                    'action' => 'show_message'
                ]);
            }
            flash(trans('core::core.you_dont_have_access'))->error();
            return redirect()->route($this->routes['index']);
        }

        $repository = $this->getRepository();

        $storeValues = $this->form($this->formClass)->getFieldValues(true);

        if ($mode == self::FORM_MODE_SIMPLE) {

            //Bind related element
            $relatedEntityId = $request->get('relatedEntityId');
            $relationType = $request->get('relationType', null);
            $relatedField = $request->get('relatedField');
            $relatedEntity = $request->get('relatedEntity');

            if ($relationType != null) { // Relation type is not null

                $relationEntityRepos = \App::make(GenericRepository::class);
                $relationEntityRepos->setupModel($relatedEntity);

                $relationEntity = $relationEntityRepos->findWithoutFail($relatedEntityId);

                if ($relationType == 'oneToMany') {
                    $storeValues[$relatedField] = $relationEntity->id;
                }
            }
        }


        $entity = $repository->createEntity($storeValues, \App::make($this->entityClass));


        $entity = $this->setupAssignedTo($entity, $request, true);
        $entity->save();


        if (config('bap.record_assigned_notification_enabled')) {

            if ($entity instanceof Ownable) {
                if ($entity->getOwner() != null && $entity->getOwner() instanceof User) {
                    if ($entity->getOwner()->id != \Auth::user()->id) { // Dont send notification for myself
                        try {
                            $commentOn = $entity->name;
                            $commentOn = ' - ' . $commentOn;
                        } catch (\Exception $exception) {
                            $commentOn = '';
                        }

                        $placeholder = new NotificationPlaceholder();

                        $placeholder->setRecipient($entity->getOwner());
                        $placeholder->setAuthorUser(\Auth::user());
                        $placeholder->setAuthor(\Auth::user()->name);
                        $placeholder->setColor('bg-green');
                        $placeholder->setIcon('assignment');
                        $placeholder->setContent(trans('notifications::notifications.new_record', ['user' => \Auth::user()->name]) . $commentOn);

                        $placeholder->setUrl(route($this->routes['show'], $entity->id));

                        $entity->getOwner()->notify(new GenericNotification($placeholder));
                    }
                }
            }
        }

        if ($mode == self::FORM_MODE_SIMPLE) {

            //Bind related element
            $relatedEntityId = $request->get('relatedEntityId');
            $relationType = $request->get('relationType', null);
            $relatedField = $request->get('relatedField');
            $relatedEntity = $request->get('relatedEntity');

            if ($relationType != null) { // Relation type is not null

                $relationEntityRepos = \App::make(GenericRepository::class);
                $relationEntityRepos->setupModel($relatedEntity);


                $relationEntity = $relationEntityRepos->findWithoutFail($relatedEntityId);


                if ($relationType == 'manyToMany') {
                    $entity->{$relatedField}()->attach($relationEntity->id);
                }
            }

            return response()->json([
                'type' => 'success',
                'message' => trans('core::core.entity.created'),
                'action' => 'refresh_datatable'
            ]);
        }

        flash(trans('core::core.entity.created'))->success();

        return redirect(route($this->routes['index']));
    }

    /**
     * Setup Assigned (User|Group)
     *
     * @param mixed $entity - Entity object
     * @param array $input Values from request
     * @param bool $creating - creating mode
     *
     * @return mixed
     */
    protected function setupAssignedTo($entity, $input, $creating = false)
    {
        if ($entity instanceof Ownable) {
            if (isset($input['owned_by'])) {
                $owner = Stringy::create($input['owned_by']);
            } else {
                $owner = '';
            }

            if ($owner != '') {
                if ($owner->startsWith('user-')) {
                    $owner = $owner->replace('user-', '');

                    $entity->changeOwnerTo(User::find($owner));
                } else {
                    $owner = $owner->replace('group-', '');
                    $entity->changeOwnerTo(Group::find($owner));
                }
            } else {
                if (!$creating) {
                    $entity->abandonOwner();
                }
            }
        }

        return $entity;
    }

    /**
     * Show entity edit form
     *
     * @param $identifier
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit($identifier)
    {
        if ($this->permissions['update'] != '' && !\Auth::user()->hasPermissionTo($this->permissions['update'])) {
            flash(trans('core::core.you_dont_have_access'))->error();
            return redirect()->route($this->routes['index']);
        }

        $repository = $this->getRepository();

        $entity = $repository->find($identifier);

        $this->entity = $entity;

        if (empty($entity)) {
            flash(trans('core::core.entity.entity_not_found'))->error();

            return redirect(route($this->routes['index']));
        }

        if ($this->blockEntityOwnableAccess()) {
            flash(trans('core::core.you_dont_have_access'))->error();
            return redirect()->route($this->routes['index']);
        }

        $updateForm = $this->form($this->formClass, [
            'method' => 'PATCH',
            'url' => route($this->routes['update'], $entity),
            'id' => 'module_form',
            'model' => $entity
        ]);

        $updateView = $this->views['edit'];

        $this->entity = $entity;

        $view = view($updateView);
        $view->with('form_request', $this->storeRequest);
        $view->with('entity', $entity);
        $view->with('show_fields', $this->showFields);
        $view->with('sectionButtons', $this->sectionButtons);


        $view->with('form', $updateForm);

        return $view;
    }

    /**
     * Update entity
     *
     * @param $identifier
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($identifier)
    {
        if ($this->permissions['update'] != '' && !\Auth::user()->hasPermissionTo($this->permissions['update'])) {
            flash(trans('core::core.you_dont_have_access'))->error();
            return redirect()->route($this->routes['index']);
        }

        $repository = $this->getRepository();

        $entity = $repository->find($identifier);

        $this->entity = $entity;

        if (empty($entity)) {
            flash(trans('core::core.entity.entity_not_found'))->error();

            return redirect(route($this->routes['index']));
        }

        if ($this->blockEntityOwnableAccess()) {
            flash(trans('core::core.you_dont_have_access'))->error();
            return redirect()->route($this->routes['index']);
        }

        $input = $this->form($this->formClass)->getFieldValues(true);

        $currentOwner = null;
        if ($entity instanceof Ownable && $entity->hasOwner()) {
            $currentOwner = $entity->getOwner();
        }

        $entity = $this->setupAssignedTo($entity, $input);

        $repository = $this->getRepository();

        $entity = $repository->updateEntity($input, $entity);

        $this->entity = $entity;

        flash(trans('core::core.entity.updated'))->success();

        return redirect(route($this->routes['show'], $entity));
    }

    /**
     * @param $identifier
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($identifier)
    {
        if ($this->permissions['destroy'] != '' && !\Auth::user()->hasPermissionTo($this->permissions['destroy'])) {
            flash(trans('core::core.you_dont_have_access'))->error();
            return redirect()->route($this->routes['index']);
        }

        $repository = $this->getRepository();

        $entity = $repository->find($identifier);

        $this->entity = $entity;

        if (empty($entity)) {
            flash(trans('core::core.entity.entity_not_found'))->error();

            return redirect(route($this->routes['index']));
        }

        if ($this->blockEntityOwnableAccess()) {
            flash(trans('core::core.you_dont_have_access'))->error();
            return redirect()->route($this->routes['index']);
        }

        if (config('bap.validate_fk_on_soft_delete')) {
            $validator = ValidationHelper::validateForeignKeys($entity);

            if (count($validator) > 0) {

                flash(trans('core::core.cant_delete_check_fk_keys', ['fk_keys' => StringHelper::validationArrayToString($validator)]))->error();

                return redirect(route($this->routes['index']));
            }
        }

        $repository->delete($entity->id);

        flash(trans('core::core.entity.deleted'))->success();

        return redirect(route($this->routes['index']));
    }
}
