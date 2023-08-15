

$(document).ready(function () {
    ("use strict"); // Start of use strict

    $("#user_id").select2({
        dropdownParent: $("#create-dorm-modal"),
        tags: true,
    });
    $("#dorm_id").select2({
        dropdownParent: $("#create-dorm-modal"),
        tags: true,
    });


    $("#create-dorm-form").submit(function (e) {
        e.preventDefault();
        store($(this));
    });

    $("#update-dorm-form").submit(function (e) {
        e.preventDefault();
        update($(this));
    });

    $('#dormitories_id').on('change', function() {

        var dorm_id =  $(this).find(":selected").val();
        $("#room_id").empty();
        axios
        .get($("#page-axios-data").data("get-rooms"), {
            params: {
                dorm_id: dorm_id,
            },
        })
        .then((res) => {
            var rooms = res.data.data.allRooms;
          
            $.each(rooms, function (key, value) {
                   
                $("#room_id").append(
                    '<option value="' +
                        value.id +
                        '" ' +
                        ">" +
                        value.room_number +
                        "</option>"
                );
            });
            $("#room_id").select2();
        })
        .catch((err) => {
            showAxiosErrors(err);
        });

    });
    $('#dormitories_id_edit').on('change', function() {

        var dorm_id =  $(this).find(":selected").val();
        $("#room_id_edit").empty();
        axios
        .get($("#page-axios-data").data("get-rooms"), {
            params: {
                dorm_id: dorm_id,
            },
        })
        .then((res) => {
            var rooms = res.data.data.allRooms;
          
            $.each(rooms, function (key, value) {
                   
                $("#room_id_edit").append(
                    '<option value="' +
                        value.id +
                        '" ' +
                        ">" +
                        value.room_number +
                        "</option>"
                );
            });
            $("#room_id_edit").select2();
        })
        .catch((err) => {
            showAxiosErrors(err);
        });

    });

});



function showCreateModal() {
    $("#create-dorm-modal").modal("show");
}

function showEditModal(id) {
    axios
        .get($("#page-axios-data").data("edit"), {
            params: {
                id: id,
            },
        })
        .then((res) => {
            console.log(res.data.data);

            $("#update_student_dorm_id").val(res.data.data.studentDorm.id);
            var dorms = res.data.data.dorms;
            var rooms = res.data.data.rooms;
            var users = res.data.data.users;
          
            $("#user_id_edit").empty();
            $.each(users, function (key, value) {
               
                let selected =
                    value.id == res.data.data.studentDorm.user_id ? "selected" : null;
                $("#user_id_edit").append(
                    '<option value="' +
                        value.id +
                        '" ' +
                        selected +
                        ">" +
                        value.name +
                        "</option>"
                );
            });
            $("#user_id_edit").select2();


            $("#dormitories_id_edit").empty();
            $.each(dorms, function (key, value) {
               
                let selected =
                    value.id == res.data.data.studentDorm.dormitories_id ? "selected" : null;
                $("#dormitories_id_edit").append(
                    '<option value="' +
                        value.id +
                        '" ' +
                        selected +
                        ">" +
                        value.dormitory_name +
                        "</option>"
                );
            });
            $("#dormitories_id_edit").select2();


            
            $("#room_id_edit").empty();
            $.each(rooms, function (key, value) {
               
                let selected =
                    value.id == res.data.data.studentDorm.room_id ? "selected" : null;
                $("#room_id_edit").append(
                    '<option value="' +
                        value.id +
                        '" ' +
                        selected +
                        ">" +
                        value.room_number +
                        "</option>"
                );
            });
            $("#room_id_edit").select2();



            $("#edit-dorm-modal").modal("show");
        })
        .catch((err) => {
            showAxiosErrors(err);
        });
}

/**
 * Store data
 * @param form
 */
function store(form) {
    var data = form.serialize();
    axios
        .post($("#page-axios-data").data("create"), data)
        .then(function (response) {
            toastr.success(response.data.message, "Success");
            $("#create-dorm-modal").modal("hide");
            form.trigger("reset");
            $($("#page-axios-data").data("table-id"))
                .DataTable()
                .ajax.reload(null, false);
        })
        .catch((err) => {
            showAxiosErrors(err);
        });
}

/**
 * Update data
 * @param form
 */
function update(form) {
    var data = form.serialize();
    axios
        .put($("#page-axios-data").data("update"), data)
        .then(function (response) {
            toastr.success(response.data.message, "Success");
            $("#edit-dorm-modal").modal("hide");
            form.trigger("reset");
            $($("#page-axios-data").data("table-id"))
                .DataTable()
                .ajax.reload(null, false);
        })
        .catch((err) => {
            showAxiosErrors(err);
        });
}

