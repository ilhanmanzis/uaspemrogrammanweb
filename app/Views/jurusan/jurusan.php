<!-- button triger -->
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah Data</button>

<?php
if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('message'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;
            </span>
        </button>
    </div>;
<?php endif;
?>


<!-- button triger -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data jurusan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <?php
                $no = 1;
                foreach ($dataJurusan as $row) :
                ?>
                    <tbody>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nama_jurusan'] ?></td>
                            <td>
                                <a href="javascript:void(0);" data="<?= $row['id_jurusan'] ?>" class="view_data btn btn-sm btn-danger item-delete">Delete</a>

                                <a href="#" class="view_data btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#myModal" data-id="<?= $row['id_jurusan'] ?>">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Jurusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('jurusan/create') ?>" method="POST">
                    <input type="text" name="name" placeholder="Nama jurusan" class="form-control mb-2 <?= (validation_show_error('name')) ? 'is-invalid' : ''; ?>" value="<?= set_value('name'); ?>" autofocus required>
                    <small class="text-danger invalid-feedback">
                        <?= validation_show_error('name') ?>
                    </small>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="Submit" name="simpan" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    <?php if (session()->getFlashdata('showModal')) : ?>
        var showModal = "<?= session()->getFlashdata('showModal') ?>";
        $('#' + showModal).modal('show');
        $('#btn-closee').click(function() {
            $('#' + showModal).modal('hide');
        });
    <?php endif; ?>
</script>


<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Jurusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close">x</button>
            </div>
            <div class="modal-body" id="datajurusan">

            </div>
        </div>
    </div>

</div>


<script>
    $('.view_data').click(function() {
        var id_jurusan = $(this).data('id');
        $.ajax({
            url: `<?= base_url() ?>jurusan/editjurusan/${id_jurusan}`,
            method: 'get',
            success: function(data) {
                $('#datajurusan').html(data);
                $('#myModal').modal('show');
            }
        });
    });
</script>





<!-- Modal dialog hapus data-->


<div class="modal fade" id="myModalDelete" tabindex="-1" aria-labelledby="myModalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalDeleteLabel">Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                Anda ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger" id="btdelete">Lanjutkan</button>
            </div>
        </div>
    </div>
</div>


<script>
    $('#dataTable').on('click', '.item-delete', function() {
        var id = $(this).attr('data');
        $('#myModalDelete').modal('show');
        $('#btdelete').off('click').on('click', function() {
            $.ajax({
                url: `<?= base_url() ?>jurusan/delete/${id}`,
                method: 'delete',
                success: function(response) {
                    $('#myModalDelete').modal('hide');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });
    });
</script>