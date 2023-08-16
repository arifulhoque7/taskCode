<x-app-layout>
    <x-card>
        <x-slot name='actions'>
            <input type="hidden" value="{{ $checkFreeUser }}" id="checkFreeUser">
            @if ($checkPostCount < 2 )
            <a href="javascript:void(0);" class="btn btn-success btn-sm btn-create" onclick="showCreateModal()"><i
                    class="fa fa-plus-circle"></i>&nbsp;{{ __('Add Post') }}</a>
            @endif
        </x-slot>

        <div>
            <x-data-table :dataTable="$dataTable" />
        </div>
    </x-card>
    @push('modal')
    <x-modal id="create-post-modal" :title="__('Create Post')">

        <form action="javascript:void();" class="needs-validation" id="create-post-form">
            <div class="modal-body">
                <div class="row">

                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                        <label for="title" class="col-lg-3 col-form-label ps-0 label_title">
                            {{ __('Title') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-9 p-0">
                            <input type="text" class="form-control" name="title" id="title"
                                placeholder="{{ __('Title') }}" required>
                        </div>
                    </div>

                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                        <label for="description" class="col-lg-3 col-form-label ps-0 label_description">
                            {{ __('Description') }}
                        </label>
                        <div class="col-lg-9 p-0">
                            <textarea name="description" id="description" class="form-control"
                            placeholder="{{ __('Description') }}" style="min-height: 100px;"></textarea>
                        </div>
                    </div>


                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                        <label for="publish_time" class="col-lg-3 col-form-label ps-0 label_publish_time">
                            {{ __('Publish Time') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-9 p-0">
                            <input type="datetime-local" class="form-control" name="publish_time" id="publish_time" value="{{ ($checkFreeUser) ? \Carbon\Carbon::now()->setTimezone('Asia/Dhaka')->second(0) : '' }}"
                                placeholder="{{ __('Publish Time') }}" required {{ ($checkFreeUser) ? 'readonly' : '' }}>
                        </div>
                    </div>

                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                        <label for="status" class="col-lg-3 col-form-label ps-0 label_status">
                            {{ __('Status') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-9 p-0">
                            <select name="status" id="status" class="form-control">
                                <option value="1">{{ __('Active') }}</option>
                                <option value="0">{{ __('Deactive') }}</option>
                            </select>

                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button class="btn btn-success" type="submit" id="create_submit">{{ __('Add') }}</button>
            </div>
        </form>

    </x-modal>
    <x-modal id="edit-post-modal" :title="__('Update post')">
        <form action="javascript:void();" class="needs-validation" id="update-post-form">
            <input type="hidden" name="id" id="update_post_id">
            <div class="modal-body">
                <div class="row">

                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                        <label for="edit_title" class="col-lg-3 col-form-label ps-0 label_title">
                            {{ __('Title') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-9 p-0">
                            <input type="text" class="form-control" name="title" id="edit_title"
                                placeholder="{{ __('Title') }}" required>
                        </div>
                    </div>

                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                        <label for="edit_description" class="col-lg-3 col-form-label ps-0 label_description">
                            {{ __('Description') }}
                        </label>
                        <div class="col-lg-9 p-0">
                            <textarea name="description" id="edit_description" class="form-control"
                            placeholder="{{ __('Description') }}" style="min-height: 100px;"></textarea>
                        </div>
                    </div>


                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                        <label for="edit_publish_time" class="col-lg-3 col-form-label ps-0 label_publish_time">
                            {{ __('Publish Time') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-9 p-0">
                            <input type="datetime-local" class="form-control" name="publish_time" id="edit_publish_time"
                                placeholder="{{ __('Publish Time') }}" {{ ($checkFreeUser) ? 'readonly' : '' }} required>
                        </div>
                    </div>

                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                        <label for="edit_status" class="col-lg-3 col-form-label ps-0 label_status">
                            {{ __('Status') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-9 p-0">
                            <select name="status" id="edit_status" class="form-control">
                                <option value="1">{{ __('Active') }}</option>
                                <option value="0">{{ __('Deactive') }}</option>
                            </select>

                        </div>
                    </div>
                  

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button class="btn btn-success" type="submit" id="create_submit">{{ __('Update') }}</button>
            </div>
        </form>
    </x-modal>
    <x-modal id="delete-post-modal" :title="__('Delete Permission')">
        <form action="javascript:void();" class="needs-validation" id="delete-post-modal-form">
            <input type="hidden" name="id" id="update_post_delete_id">
            <div class="modal-body">
                <p>{{ ('You won\'t be able to revert this!') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button class="btn btn-primary" type="submit" id="create_submit">{{ __('Delete') }}</button>
            </div>
        </form>
    </x-modal>
    @endpush
    <div id="page-axios-data" data-table-id="#post-table"
        data-create="{{ route(config('theme.rprefix').'.store') }}"
        data-edit="{{ route(config('theme.rprefix').'.edit') }}"
        data-update="{{ route(config('theme.rprefix').'.update') }}">
    </div>

    @push('lib-styles')
    <link href="{{ admin_asset('vendor/select2/dist/css/select2.css') }}" rel="stylesheet" type="text/css" />
    @endpush
    @push('lib-scripts')
    <script src="{{ admin_asset('vendor/select2/dist/js/select2.js') }}"></script>
    @endpush

    
    @push('js')
    <script src="{{ module_asset('js/posts/index.js') }}"></script>
    @endpush
</x-app-layout>