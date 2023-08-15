$(document).ready(function () {
    ("use strict"); // Start of use strict

    $("#room_id").select2({
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
            var rooms = res.data.data.rooms;
            var assigned_rooms = res.data.data.rooms_assigned;

            $("#update_dorm_id").val(res.data.data.dorm.id);
            $("#dormitory_name_edit").val(res.data.data.dorm.dormitory_name);
            $("#type_edit").val(res.data.data.dorm.type);
            $("#address_edit").val(res.data.data.dorm.address);


            $("#room_id_edit").empty();
            $.each(rooms, function (key, value) {
                //    console.log(value.id);
                let selected = assigned_rooms.includes(value.id) ? "selected" : null;

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

