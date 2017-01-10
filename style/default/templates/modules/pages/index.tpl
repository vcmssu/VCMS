<section class="section section-inner section-articles">
    <div class="container">
        <ul class="list list-breadcrumb font-pt-sans-regular">
            <li>
                <a href="{$home}">Главная страница</a>
                <!-- /.font-pt-sans-regular -->
            </li>
            <li class="active">
                {$title}
            </li>
        </ul>
        <!-- /.list list-breadcrumb -->
        <div class="row">
            {include file='system/sidebar.tpl'}
            <!-- /.col-md-12 -->
            <div class="col-md-45">
                <h5 class="section-title font-pt-sans-bold section-title-article">
                    <span class="text">{$title}</span>
                </h5>
                {$row.text|esc}
            </div>
            <!-- /.col-md-48 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>