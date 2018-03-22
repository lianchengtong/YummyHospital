<div class="doctor-filter-box">
    <div class="doctor-filter">
        <div class="item department-filter" data-id="department-filter-items">全部科室</div>
        <div class="item sort-filter" data-id="sort-filter-items">默认排序</div>
    </div>
    <div class="doctor-filter-items">
        <div id="department-filter-items">23534535</div>
        <div id="sort-filter-items">123123</div>
    </div>
</div>
<script>
    $(function () {
        $("body").on("tap", ".doctor-filter .item", function () {
            msgTip("123");
        });
    })
</script>
