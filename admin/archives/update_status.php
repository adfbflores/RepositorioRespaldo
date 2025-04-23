<div class="container-fluid">
    <form action="" id="update_status_form">
        <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id'] ?? '') ?>">
        <div class="form-group">
            <label for="status" class="control-label text-navy">Estado</label>
            <select name="status" id="status" class="form-control form-control-border" required>
                <option value="0" <?= ($_GET['status'] ?? '') == '0' ? 'selected' : '' ?>>Despublicar</option>
                <option value="1" <?= ($_GET['status'] ?? '') == '1' ? 'selected' : '' ?>>Publicar</option>
            </select>
        </div>
    </form>
</div>
<script>
    $(function(){
        $('#update_status_form').submit(function(e){
            e.preventDefault();
            start_loader();
            var el = $('<div>');
            el.addClass("pop-msg alert");
            el.hide();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=update_status",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                error: function(err){
                    console.log(err);
                    alert_toast("Ocurrió un error al guardar los datos.", "error");
                    end_loader();
                },
                success: function(resp){
                    console.log(resp);
                    if(resp.status === 'success'){
                        location.reload();
                    } else if(resp.msg){
                        el.addClass("alert-danger");
                        el.text(resp.msg);
                        $('#update_status_form').prepend(el);
                    } else {
                        el.addClass("alert-danger");
                        el.text("Ocurrió un error debido a una razón desconocida.");
                        $('#update_status_form').prepend(el);
                    }
                    el.show('slow');
                    end_loader();
                }
            });
        });
    });
</script>
