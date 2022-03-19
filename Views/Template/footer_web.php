<script>
    const base_url = "<?php echo base_url(); ?>";
</script>
<script src="<?php echo media() . 'js/bootstrap.min.js'; ?>"></script>
<script src="<?php echo media() . 'js/jquery.min.js'; ?>"></script>

<?php
if (isset($data['js']) && !empty($data['js'])) {
    for ($i = 0; $i < count($data['js']); $i++) {
        echo '<script src="' . media() . $data['js'][$i] . '"></script>';
    }
}
?>
</body>

</html>