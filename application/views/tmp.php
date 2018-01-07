<section class="ui-panel ui-doctor-appointment-tab">
    <div class="ui-panel-heading">
        <ul class="ui-tiled ui-tab-list">
            <li data-id="0" class="active">预约挂号</li>
            <li data-id="1">在线咨询</li>
        </ul>
    </div>

    <div class="ui-panel-body">
        <div class="ui-tab-item-content ui-tab-item-0 ui-hide ui-show">

        </div>
        <div class="ui-tab-item-content ui-tab-item-1 ui-hide">
            在线咨询
        </div>
    </div>
</section>

<section class="ui-slide-show">
    <div class="ui-slide-show-content">
        <?php for ($i=0;$i<100;$i++):?>
        <p>slide show content</p>
        <?php endfor;?>
    </div>
</section>

<script>
    $(function(){
        $("body").on("tap",".ui-slide-show",function(){
            $(this).addClass("ui-hide");
        });

        $("body").on("tap",".ui-slide-show .ui-slide-show-content",function(e){
            e.stopPropagation();
            e.preventDefault();
        });

        $("body").on("tap",".ui-tab-list li",function(){
            var panelWrapper = $(this).closest(".ui-panel");
            if ($(this).hasClass("active")){
                return;
            }

            $(panelWrapper).find(".ui-panel-heading li").removeClass("active");
            $(this).addClass("active");

            var _tabID = $(this).attr("data-id");
            $(panelWrapper).find(".ui-panel-body .ui-tab-item-content").removeClass("ui-show");
            $(panelWrapper).find(".ui-panel-body .ui-tab-item-"+_tabID).addClass("ui-show");
        });
    })
</script>