<?php include '../resources/views/admin/header.php' ?>
<?php include '../resources/views/admin/sidebar.php' ?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Posts
        </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-plus-circle">
                    <circle cx="12" cy="12" r="10">
                    </circle>
                    <line x1="12" y1="8" x2="12" y2="16">
                    </line>
                    <line x1="8" y1="12" x2="16" y2="12">
                    </line>
                </svg>
                <a href="/Admin/posts/new">New Post
                </a>
            </button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm" id="table">
            <thead>
                <tr>
                    <th>#
                    </th>
                    <th>Title
                    </th>
                    <th>Actions
                    </th>
                    <th>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data->posts as $post) : ?>
                <tr>
                    <td><?= $post->id ?>
                    </td>
                    <td data-label="title"><?= $post->title ?>
                    </td>
                    <td>
                        <a type="button" href="/Admin/posts/edit/<?= $post->id ?>" class="btn btn-secondary">Edit
                        </a>
                    </td>
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-id="<?= $post->id ?>" data-bs-target="#deleteModal">
                            Delete
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Tem a certeza que pretende eliminar este artigo?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a type="button" href="#" class="btn btn-primary delete">Save changes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include '../resources/views/admin/footer.php' ?>
<script>
const deleteModal = document.getElementById('deleteModal')
deleteModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget
    const id = button.getAttribute('data-bs-id')
    const modalTitle = deleteModal.querySelector('.delete')
    modalTitle.href = `/Admin/posts/delete/${id}`
})
</script>