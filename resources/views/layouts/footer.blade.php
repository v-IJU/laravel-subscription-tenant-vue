<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                 Copyrights {{date('Y')}} | Powered by <span>{{isset(Configurations::getConfig('site')->site_name) ? Configurations::getConfig('site')->site_name : 'Laravel Cms'}}</span>
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">

                </div>
            </div>
        </div>
    </div>
</footer>
