</div>
<!-- / Content -->

<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
        <div class="mb-2 mb-md-0">
            ©
            <script>
                document.write(new Date().getFullYear());
            </script>
            , power by
            <a href="https://leenhcraft.com" target="_blank" class="footer-link fw-bolder">LeenhCraft</a>
        </div>
    </div>
</footer>
<!-- / Footer -->

<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->
<script>
    const base_url = "<?php echo base_url(); ?>";
</script>

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<!-- <script src="/assets/vendor/libs/jquery/jquery.js"></script> -->
<script src="/assets/js/plugins/jquery.min.js"></script>
<!-- <script src="/assets/vendor/libs/popper/popper.js"></script> -->
<script src="/assets/js/plugins/popper.min.js"></script>

<script src="/assets/vendor/js/bootstrap.js"></script>

<script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="/assets/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="/assets/vendor/libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="/assets/js/plugins/template_web/main.js"></script>

<!-- Page JS -->
<script src="/assets/js/plugins/template_web/dashboards-analytics.js"></script>
<!-- <script async defer src="https://buttons.github.io/buttons.js"></script> -->

<script src="/assets/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/js/plugins/dataTables.bootstrap.min.js"></script>

<script src="/assets/js/plugins/sweetalert2.all.min.js"></script>
<script src="/assets/js/app/general.js"></script>
<?php
if (isset($data['js']) && !empty($data['js'])) {
    for ($i = 0; $i < count($data['js']); $i++) {
        echo '<script src="' . media() . $data['js'][$i] . '"></script>';
    }
}
?>

</body>

</html>