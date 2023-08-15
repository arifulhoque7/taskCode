<x-app-layout>
    <x-card>
        <x-slot name='actions'>
            <a href="javascript:void(0);" class="btn btn-success btn-sm" onclick="showCreateModal()"><i
                    class="fa fa-plus-circle"></i>&nbsp;{{ __('Add Room Types') }}</a>
        </x-slot>

        <div>
            <x-data-table :dataTable="$dataTable" />
        </div>
    </x-card>
    @push('modal')
    <x-modal id="create-room-type-modal" :title="__('Create Room Type')">

        <form action="javascript:void();" class="needs-validation" id="create-room-type-form">
            <div class="modal-body">
                <div class="row">

                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                        <label for="room_type" class="col-lg-3 col-form-label ps-0 label_room_type">
                            {{ __('Room Type') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-9 p-0">
                            <input type="text" class="form-control" name="room_type" id="room_type"
                                placeholder="{{ __('Room Type') }} " autocomplete required>
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
    <x-modal id="edit-room-type-modal" :title="__('Update Room Type')">
        <form action="javascript:void();" class="needs-validation" id="update-room-type-form">
            <input type="hidden" name="id" id="update_room_type_id">
            <div class="modal-body">
                <div class="row">

                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                        <label for="edit_room_type" class="col-lg-3 col-form-label ps-0 label_room_type">
                            {{ __('Room Type') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-9 p-0">
                            <input type="text" class="form-control" name="edit_room_type" id="edit_room_type"
                                placeholder="{{ __('Room Type') }} " autocomplete required>
                        </div>
                    </div>

                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                        <label for="edit_status" class="col-lg-3 col-form-label ps-0 label_status">
                            {{ __('Status') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-9 p-0">
                            <select name="edit_status" id="edit_status" class="form-control">
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
    <x-modal id="delete-room-type-modal" :title="__('Delete Permission')">
        <form action="javascript:void();" class="needs-validation" id="delete-room-type-modal-form">
            <input type="hidden" name="id" id="update_room_type_delete_id">
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
    <div id="page-axios-data" data-table-id="#room-type-table"
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
    <script src="{{ module_asset('js/roomTypes/index.js') }}"></script>
    @endpush
</x-app-layout>