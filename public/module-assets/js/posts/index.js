
$(document).ready(function () {
    ("use strict"); // Start of use strict

    $("#status").select2({
        dropdownParent: $("#create-post-modal"),
        tags: true,
    });

    $("#create-post-form").submit(function (e) {
        e.preventDefault();
        store($(this));
    });

    $("#update-post-form").submit(function (e) {
        e.preventDefault();
        update($(this));
    });
});

function showCreateModal() {
    // console.log("DSf");
    $("#create-post-modal").modal("show");
}

function showEditModal(id) {
    axios
        .get($("#page-axios-data").data("edit"), {
            params: {
                id: id,
            },
        })
        .then((res) => {
            // console.log(res.data.data.post);
            $("#update_post_id").val(res.data.data.post.id);
            $("#edit_title").val(res.data.data.post.title);
            $("#edit_description").val(res.data.data.post.description);
            $("#edit_publish_time").val(res.data.data.post.publish_time);

            let selected = res.data.data.post.status;

            if(selected == 1){
                $('#edit_status').val('1');
            }else{
                $('#edit_status').val('0');
            }
 

            $("#edit-post-modal").modal("show");
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
            if(response.data.data.checkPostCount != 2)
            {
                $(".btn-create").hide();
            }else{
                $(".btn-create").show();
            }

            toastr.success(response.data.message, "Success");
            $("#create-post-modal").modal("hide");
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
            $("#edit-post-modal").modal("hide");
            form.trigger("reset");
            $($("#page-axios-data").data("table-id"))
                .DataTable()
                .ajax.reload(null, false);
        })
        .catch((err) => {
            showAxiosErrors(err);
        });
}


function publishStatusUpdate(t, s, id) {
    axios
        .post(s, { is_published: $(t).val() })
        .then((t) => {
            var table = $(id);
            table.DataTable().ajax.reload();
            if (t.data.message) {
                toastr.success(t.data.message, "Success");
            } else {
                toastr.success("User Status Successfully Updated.");
            }
        })
        .catch((err) => {
            if (err.response.data.message) {
                toastr.error(err.response.data.message, "Error");
            } else {
                toastr.error("Failed to Update User Status");
            }
        });
}
