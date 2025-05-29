<?= $this->include('layout/headers') ?>

<div class="container mt-5">
    <div class="row ">
        <div class="col-md-4" >
            <div class="panel panel-default m2" style="background: #fff; padding: 20px; border-radius: 5px;">
                <h3>Add New <?= $viewtitle; ?></h3>
                <form method="post" action="<?= site_url('position-categories/add?type=' . $requestType) ?>"
                    class="mb-4">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Add <?= $viewtitle; ?></button>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <h3>Arrange <?= $viewtitle; ?></h3>
            <ul id="sortable" class="sortable-list">
                <?php foreach ($categories as $cat): ?>
                    <li data-id="<?= $cat['id'] ?>" style="background-color: white;">
                        <strong>
                            <span class="editable" data-field="title"><?= esc($cat['title']) ?></span>
                        </strong>
                        <div class="text-muted">
                            <span class="editable" data-field="description"><?= esc($cat['description']) ?></span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <button id="saveOrder" class="btn btn-success mt-3">Save Order</button>
            <div id="orderResult" class="mt-2"></div>
        </div>

    </div>
</div>
<style>
    .sortable-list {
        list-style: none;
        padding: 0;
    }

    .sortable-list li {
        padding: 10px;
        margin-bottom: 5px;
        background: #f8f9fa;
        border: 1px solid #ddd;
        cursor: move;
    }

    .editable {
        cursor: pointer;
        border-bottom: 1px dashed #888;
    }

    .editable input {
        width: auto;
        display: inline-block;
    }
</style>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
<script>
    $(function () {
        $("#sortable").sortable();
        $("#saveOrder").click(function () {
            var order = [];
            $("#sortable li").each(function () {
                order.push($(this).data("id"));
            });
            $.post("<?= site_url('position-categories/update-order?type=' . $requestType) ?>", { order: order }, function (resp) {
                $("#orderResult").html('<div class="alert alert-success">Order saved!</div>');
            });
        });

        // Inline editing
        $('.editable').on('click', function () {
            var $span = $(this);
            if ($span.find('input').length) return; // already editing

            var oldValue = $span.text();
            var field = $span.data('field');
            var $input = $('<input type="text" class="form-control form-control-sm" />').val(oldValue);
            $span.html($input);
            $input.focus();

            $input.on('blur keydown', function (e) {
                if (e.type === 'blur' || (e.type === 'keydown' && e.key === 'Enter')) {
                    var newValue = $input.val();
                    if (newValue !== oldValue) {
                        var id = $span.closest('li').data('id');
                        $.post("<?= site_url('position-categories/inline-edit?type=' . $requestType) ?>", {
                            id: id,
                            field: field,
                            value: newValue
                        }, function (resp) {
                            if (resp.success) {
                                $span.text(newValue);
                            } else {
                                $span.text(oldValue);
                                alert('Update failed');
                            }
                        }, 'json');
                    } else {
                        $span.text(oldValue);
                    }
                }
            });
        });
    });
</script>

<?= $this->include('layout/footer') ?>