    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?php echo $default_url."profile/"; ?>plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- include summernote css/js -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-ext-elfinder.js"></script>

    <?php echo "
    <script>
        $(document).ready(function() {
            $('.froala-editor').summernote({
                height: 200                            
            });
        });    
        function elfinderDialog() {
            var fm = $('<div/>').dialogelfinder({
                url : ".$default_url."'_inc/db.php',  
                lang : 'en',
                width : 840,
                height: 450,
                destroyOnClose : true,
                getFileCallback : function(files, fm) {
                    console.log(files);
                    $('.editor').summernote('editor.insertImage', files.url);
                },
                commandsOptions : {
                    getfile : {
                    oncomplete : 'close',
                    folders : false
                    }
                }
            }).dialogelfinder('instance');
        }
    </script>"; ?>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo $default_url ?>profile/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="<?php echo $default_url ?>profile/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="<?php echo $default_url ?>profile/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?php echo $default_url ?>profile/js/waves.js"></script>
    <!--Counter js -->
    <script src="<?php echo $default_url ?>profile/plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
    <script src="<?php echo $default_url ?>profile/plugins/bower_components/counterup/jquery.counterup.min.js"></script>
    <!-- chartist chart -->
    <script src="<?php echo $default_url ?>profile/plugins/bower_components/chartist-js/dist/chartist.min.js"></script>
    <script src="<?php echo $default_url ?>profile/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
    <!-- Sparkline chart JavaScript -->
    <script src="<?php echo $default_url ?>profile/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="<?php echo $default_url ?>profile/js/custom.min.js"></script>
    <script src="<?php echo $default_url ?>profile/js/dashboard1.js?v=1025"></script>
    <script src="<?php echo $default_url ?>profile/plugins/bower_components/toast-master/js/jquery.toast.js"></script>
</body>

</html>
