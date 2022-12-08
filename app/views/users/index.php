<?php
$page_title = "Users";
require_once __DIR__ . '/../header_layout.php';
require_once __DIR__ . '/../header_nav.php';
?>

<div class="container">
    <div class="row justify-content-center vh-100 align-items-center">
        <div class="col-xl-9 col-lg-10 col-md-11 col-sm-12">
            <?php if (isset($error)): ?>
                <h3 class="text-center"><?php echo $error; ?></h3>
            <?php elseif (isset($idErrors)): ?>
            <?php foreach ($idErrors as $idError): ?>
                    <h3 class="text-center"><?php echo $idError; ?></h3>
            <?php endforeach; ?>
            <?php else: ?>
            <?php if (isset($users) && count($users) > 0): ?>
            <div class="table-responsive">
                <form id="checkbox-form" role="form"  class="form-container" action="/users/deleteMultiple" method="post">
                    <button id="delete_selected" disabled class="btn btn-sm btn-outline-secondary m-1" type="submit"><i class="bi bi-trash"></i> Delete selected</button>
                </form>
                    <table class="table table-hover">
                        <thead class="text-center bg-light">
                        <tr>
                            <th><input type="checkbox" id="select-all" class="checkbox-all" title="Select all"></th>
                            <th>ID</th>
                            <th class="text-start">Name</th>
                            <th class="text-start">Email</th>
                            <th>Gender</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody class="text-center align-middle">
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <input form="checkbox-form" type="checkbox" class="chkbox" name="ids[]"
                                           value="<?php echo $user['id']; ?>"
                                           title="Select <?php echo $user['name']; ?>">
                                </td>
                                <td><?php echo $user['id']; ?></td>
                                <td class="text-start"><?php echo $user['name']; ?></td>
                                <td class="text-start"><?php echo $user['email']; ?></td>
                                <td><?php echo $user['gender']; ?></td>
                                <td><?php echo $user['status']; ?></td>
                                <td>
                                    <div class="container d-inline-flex justify-content-center">
                                        <a href="/users/<?php echo $user['id']; ?>">
                                            <button class="btn btn-outline-primary m-1" type="button"><i class="bi-eye"></i> Show</button>
                                        </a>
                                        <a href="/users/edit/<?php echo $user['id']; ?>">
                                            <button class="btn btn-outline-warning m-1" type="button"><i class="bi bi-pencil-square"></i> Edit</button>
                                        </a>
                                        <form role="form" class="form-container" onsubmit="delete_confirm(event)" action="/users/<?php echo $user['id']; ?>"
                                              method="post">
                                            <button id="delete_one" class="btn btn-outline-danger m-1" type="submit"><i class="bi bi-trash"></i> Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item"><a class="page-link" href="/users/?page=<?php echo $page - 1; ?>">Previous</a></li>
                        <?php else: ?>
                            <li class="page-item"><a class="page-link disabled" href="#">Previous</a></li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <?php if ($page == $i): ?>
                            <li class="page-item"><a class="page-link active" href="/users/?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <li class="page-item"><a class="page-link" href="/users/?page=<?php echo $page + 1; ?>">Next</a></li>
                        <?php else: ?>
                            <li class="page-item"><a class="page-link disabled" href="#">Next</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <?php else: ?>
                    <h3 class="text-center">There are no users yet. You can add new user.</h3>
                <?php endif; ?>
            <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../footer_layout.php'; ?>
