<script>
    const base_url = "<?php echo base_url(); ?>";
</script>
<script src="<?php echo media() . 'js/plugins/jquery.min.js'; ?>"></script>
<script src="<?php echo media() . 'js/plugins/popper.min.js'; ?>"></script>
<script src="<?php echo media() . 'js/plugins/bootstrap.min.js'; ?>"></script>
<script src="<?php echo media() . 'js/plugins/sweetalert2.all.min.js'; ?>"></script>
<?php
if (isset($data['js']) && !empty($data['js'])) {
    for ($i = 0; $i < count($data['js']); $i++) {
        echo '<script src="' . media() . $data['js'][$i] . '"></script>';
    }
}
?>
</body>

</html>