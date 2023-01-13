<form id="category_create" class="needs-validation" action="/Admin/categories/submit/<?= $data->category->id ?? null?>"
    method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Name
        </label>
        <input type="hidden" id="id" name="id" value="<?= $data->category->id ?? 0 ?>">
        <input type="text" class="form-control required" id="name" name="name" aria-describedby="nameHelp"
            placeholder="Name" value="<?= $data->category->name ?? ''?>" required>
        <small id="nameHelp" class="form-text text-muted">Maximum 64 characters
        </small>
    </div>
    <button type="submit" class="btn btn-primary">Submit
    </button>
</form>