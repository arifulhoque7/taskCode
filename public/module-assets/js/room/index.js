$(document).ready(function () {
    ("use strict"); // Start of use strict

    $("#room_type_id").select2({
        dropdownParent: $("#create-room-modal"),
        tags: true,
    });
    $("#status").select2({
        dropdownParent: $("#create-room-modal"),
        tags: true,
    });

    $("#create-room-form").submit(function (e) {
        e.preventDefault();
        store($(this));
    });

    $("#update-room-form").submit(function (e) {
        e.preventDefault();
        update($(this));
    });
});

function showCreateModal() {
    // console.log("DSf");
    $("#create-room-modal").modal("show");
}

function showEditModal(id) {
    axios
        .get($("#page-axios-data").data("edit"), {
            params: {
                id: id,
            },
        })
        .then((res) => {
 
            $("#update_room_id").val(res.data.data.room.id);
            $("#no_of_beds_edit").val(res.data.data.room.no_of_beds);
            $("#description_edit").val(res.data.data.room.description);
          

            $("#room_type_id_edit").empty();
            $.each(res.data.data.roomTypes, function (key, value) {
               
                let selected =
                    value.id == res.data.data.room.room_type_id ? "selected" : null;
                $("#room_type_id_edit").append(
                    '<option value="' +
                        value.id +
                        '" ' +
                        selected +
                        ">" +
                        value.room_type +
                        "</option>"
                );
            });



            let status = res.data.data.room.status;

            if(status == 1){
                $('#edit_status').val('1');
            }else{
                $('#edit_status').val('0');
            }

         


            $("#edit-room-modal").modal("show");
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
            $("#create-room-modal").modal("hide");
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
            $("#edit-room-modal").modal("hide");
            form.trigger("reset");
            $($("#page-axios-data").data("table-id"))
                .DataTable()
                .ajax.reload(null, false);
        })
        .catch((err) => {
            showAxiosErrors(err);
        });
}
