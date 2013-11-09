<script>
    $('#SearchButton').click(function() {
        $('#SearchForm').prop('action', '<?php echo $this->GetPageUrl() ?>/search/' + $('#Search').val());
    });
    function delData(id) {
        if (!window.confirm("Data supplier dengan kode '" + id + "' ini akan dihapus,\ndata pembelian dari supplier ini juga akan ikut dihapus.\nLanjutkan menghapus?")) {
            return;
        }
        window.location = "<?php echo $this->GetPageUrl() ?>/delete/" + id;
    }

    function editData(id) {
        window.location = "<?php echo $this->GetPageUrl() ?>/edit/" + id;
    }
</script>

