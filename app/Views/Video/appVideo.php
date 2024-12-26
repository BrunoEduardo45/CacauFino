<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo __('video.videos') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#"><?php echo __('video.home') ?></a></li>
                        <li class="breadcrumb-item active"><?php echo __('video.videos') ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row mt-3 mb=3">

                <?php
                $stmt = $pdo->prepare("SELECT * FROM video WHERE vid_status = 1");
                $stmt->execute();
                $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($list as $values) {
                ?>

                    <div class="col-lg-3 col-12 mb-1">
                        <a href="" class="text-reset" data-toggle="modal" data-info="video" data-id="1" data-titulo="<?php echo __('video.titulo_video') ?>" data-tagVideo="https://www.youtube.com/embed/<?php echo str_replace('https://www.youtube.com/watch?v=', '', $values['vid_url']) ?>" data-target="#videoModal">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fab fa-youtube"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?php echo $values['vid_titulo'] ?></span>
                                    <span class="info-box-number"></span>
                                </div>

                            </div>
                        </a>
                    </div>

                <?php } ?>

                <div class="modal fade" id="videoModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" style="color: red">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-0">
                                <div class="videoWrapper">
                                    <iframe class="lazyload" src="" frameborder="0" marginheight="0" marginwidth="0" allow="autoplay" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-2 mb-3">
                    <a href="<?php echo $baseUrl ?>" class="btn btn-warning btn-block btn-lg"><i class="fas fa-arrow-circle-left"></i> <?php echo __('video.voltar') ?></a>
                </div>
            </div>
        </div>
    </section>
</div>


<script src="https://cdn.jsdelivr.net/npm/echarts@5.4.2/dist/echarts.min.js"></script>

<script>
    //FUNCTION TO GET AND AUTO PLAY YOUTUBE VIDEO FROM DATATAG
    function autoPlayYouTubeModal() {
        var triggerOpen = $("body").find('[data-tagVideo]');
        triggerOpen.click(function() {
            var theModal = $(this).data("target"),
                videoSRC = $(this).attr("data-tagVideo"),
                videoSRCauto = videoSRC + "?autoplay=1";
            $(theModal + ' iframe').attr('src', videoSRCauto);
            $(theModal + ' button.close').click(function() {
                $(theModal + ' iframe').attr('src', '');
            });
        });
    };
    $(document).ready(function() {
        autoPlayYouTubeModal();
    });
</script>