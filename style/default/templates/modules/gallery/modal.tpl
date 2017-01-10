<div class="modal fade galleryModal" id="galleryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href="#" class="close-button" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times"></i>
            </a>
            <!-- /.close-button -->
            <div class="image-box text-center">
                <img src="{$home}/files/gallery/{$row.id_gallery}/{$row.photo}" alt="about picture" class="img-responsive-inline">
            </div>
            <!-- /.text-info -->
            <div class="controller-box">
            {if $next.id}<a href="javascript:void(0);" class="left-controller controller" data-id="{$next.id}"><i class="fa fa-arrow-circle-left"></i></a>{/if}
            {if $back.id}<a href="javascript:void(0);" class="right-controller controller" data-id="{$back.id}"><i class="fa fa-arrow-circle-right"></i></a>{/if}
    </div>
    <!-- /.controller-box -->
</div>
</div>
</div>