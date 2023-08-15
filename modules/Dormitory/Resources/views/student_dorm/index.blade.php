<x-app-layout>
    <x-card>
        <x-slot name='actions'>
            <a href="javascript:void(0);" class="btn btn-success btn-sm" onclick="showCreateModal()"><i
                    class="fa fa-plus-circle"></i>&nbsp;{{ __('Add Student Dormitory') }}</a>
        </x-slot>

        <div>
            <x-data-table :dataTable="$dataTable" />
        </div>
    </x-card>
    @push('modal')
    <x-modal id="create-dorm-modal" :title="__('Create Student Dormitory')">

        <form action="javascript:void();" class="needs-validation" id="create-dorm-form">
            <div class="modal-body">
                <div class="row">

                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                        <label for="student" class="col-lg-3 col-form-label ps-0 label_student">
                            {{ __('Student') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-9 p-0">
                            <select name="user_id" id="user_id" class="form-control">
                                @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>        
          
                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                        <label for="dorm" class="col-lg-3 col-form-label ps-0 label_dorm">
                            {{ __('Dorm Name') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-9 p-0">
                            <select name="dormitories_id" id="dormitories_id" class="form-control">
                                <option disabled>select dorm</option>
                                @foreach ($dorms as $dorm)
                                    <option value="{{$dorm->id}}">{{ $dorm->dormitory_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>        
          
                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                        <label for="room" class="col-lg-3 col-form-label ps-0 label_room">
                            {{ __('Room No.') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-9 p-0">
                            <select name="room_id" id="room_id" class="form-control"></select>
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
    <x-modal id="edit-dorm-modal" :title="__('Update Student Dormitory')">
        <form action="javascript:void();" class="needs-validation" id="update-dorm-form">
            <input type="hidden" name="id" id="update_student_dorm_id">
            <div class="modal-body">
                <div class="row">
                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                        <label for="student" class="col-lg-3 col-form-label ps-0 label_student">
                            {{ __('Student') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-9 p-0">
                            <select name="user_id" id="user_id_edit" class="form-control">
                            </select>
                        </div>
                    </div>        
          
                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                        <label for="dorm" class="col-lg-3 col-form-label ps-0 label_dorm">
                            {{ __('Dorm Name') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-9 p-0">
                            <select name="dormitories_id" id="dormitories_id_edit" class="form-control">
                            </select>
                        </div>
                    </div>        
          
                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                        <label for="room" class="col-lg-3 col-form-label ps-0 label_room">
                            {{ __('Room No.') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-9 p-0">
                            <select name="room_id" id="room_id_edit" class="form-control" @readonly(true)></select>
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
    <x-modal id="delete-dorm-modal" :title="__('Delete Permission')">
        <form action="javascript:void();" class="needs-validation" id="delete-dorm-modal-form">
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
    <div id="page-axios-data" data-table-id="#student-dorm-table"
        data-create="{{ route(config('theme.rprefix').'.store') }}"
        data-edit="{{ route(config('theme.rprefix').'.edit') }}"
        data-update="{{ route(config('theme.rprefix').'.update') }}"
        data-get-rooms="{{ route(config('theme.rprefix').'.get_rooms_data') }}">
    </div>

    @push('lib-styles')
    <link href="{{ admin_asset('vendor/select2/dist/css/select2.css') }}" rel="stylesheet" type="text/css" />
    @endpush
    @push('lib-scripts')
    <script src="{{ admin_asset('vendor/select2/dist/js/select2.js') }}"></script>
    @endpush

    
    @push('js')
    <script src="{{ module_asset('js/student_dorm/index.js') }}"></script>
    @endpush
</x-app-layout>