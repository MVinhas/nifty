<form id="post_create" class="needs-validation" action="/posts/submit/<?= $data->post->id ?? null ?>" method="POST"
      enctype="multipart/form-data">
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
    <input type="hidden" name="id" id="id" value="<?= $data->post->id ?>">
    <div class="form-group">
        <label for="title">Title
        </label>
        <input type="text" class="form-control required" id="title" name="title" aria-describedby="titleHelp"
               placeholder="Title" value="<?= $data->post->title ?? '' ?>" required>
        <small id="titleHelp" class="form-text text-muted">Try to be as sucint as you can. Maximum 90 characters
        </small>
    </div>
    <div class="form-group">
        <label for="category_id">Category
        </label>
        <select name="category_id" class="form-control" id="category_id" required>
            <option value="">Select an option...
            </option>
            <?php
            foreach ($data->categories as $category) : ?>
                <option value="<?= $category->id ?>" <?php
                if ($data->post->category_id ?? 0 === $category->id) : ?>
                    selected="selected" <?php
                endif; ?>>
                    <?= $category->name ?>
                </option>
            <?php
            endforeach; ?>
        </select>
    </div>
    <input type="hidden" name="author_id" value="<?= $data->post->author ?? $_SESSION['username'] ?? '' ?>">
    <div class="form-group">
        <label for="short_content">Short Content
        </label>
        <label for="excerpt">Excerpt</label><textarea name="excerpt" class="form-control required" rows="2" id="excerpt"
                                                      required><?= $data->post->excerpt ?? '' ?>
          </textarea>
    </div>
    <div class="form-group">
        <label for="content">Content
        </label>
        <textarea name="content" class="form-control required" rows="5" id="content"
                  required><?= $data->post->content ?? '' ?>
          </textarea>
    </div>
    <div class="form-group">
        <label for="avatar">Choose a profile picture:
        </label>
        <input type="file" id="avatar" name="avatar" accept="image/png, image/jpeg">
    </div>
    <label for="featured">Type of Post
    </label>
    <div class="form-group">

        <input type="radio" name="featured" value="0" <?php
        if (!property_exists($data->post, 'featured') || $data->post->featured === 0) : ?> checked
        <?php
        endif; ?> />
        <label>Regular
        </label>
        <br>
        <input type="radio" name="featured" value="1" <?php
        if (!property_exists($data->post, 'featured') && $data->post->featured ?? 0 === 1) : ?> checked
        <?php
        endif; ?> />
        <label>Featured
        </label>
    </div>
    <button type="submit" class="btn btn-primary">Submit
    </button>
</form>