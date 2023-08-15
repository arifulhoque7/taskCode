$(document).ready(function () {
    ("use strict"); // Start of use strict

    $("#status").select2({
        dropdownParent: $("#create-room-type-modal"),
        tags: true,
    });

    $("#create-room-type-form").submit(function (e) {
        e.preventDefault();
        store($(this));
    });

    $("#update-room-type-form").submit(function (e) {
        e.preventDefault();
        update($(this));
    });
});

function showCreateModal() {
    // console.log("DSf");
    $("#create-room-type-modal").modal("show");
}

function showEditModal(id) {
    axios
        .get($("#page-axios-data").data("edit"), {
            params: {
                id: id,
            },
        })
        .then((res) => {
            $("#edit_room_type").val(res.data.data.roomType.room_type);
            $("#update_room_type_id").val(res.data.data.roomType.id);

            let selected = res.data.data.roomType.status;

            if(selected == 1){
                $('#edit_status').val('1');
            }else{
                $('#edit_status').val('0');
            }
 

            $("#edit-room-type-modal").modal("show");
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
            $("#create-room-type-modal").modal("hide");
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
            $("#edit-room-type-modal").modal("hide");
            form.trigger("reset");
            $($("#page-axios-data").data("table-id"))
                .DataTable()
                .ajax.reload(null, false);
        })
        .catch((err) => {
            showAxiosErrors(err);
        });
}
