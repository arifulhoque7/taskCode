function userStatusUpdate(t, s, a) {
    axios
        .post(t, { status: $("#status_id_" + s).val() })
        .then((t) => {
            if (t.data.message) {
                toastr.success(t.data.message, "Success");
            } else {
                toastr.success("User Status Successfully Updated.");
            }
        })
        .catch((err) => {
            $("#status_id_" + s).val(a);
            if (err.response.data.message) {
                toastr.error(err.response.data.message, "Error");
            } else {
                toastr.error("Failed to Update User Status");
            }
        });
}

function userMembershipStatusUpdate(t, s, a,id) {
    axios
        .post(t, { membership: $("#mem_status_id_" + s).val() })
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
            $("#mem_status_id_" + s).val(a);
            if (err.response.data.message) {
                toastr.error(err.response.data.message, "Error");
            } else {
                toastr.error("Failed to Update User Status");
            }
        });
}
