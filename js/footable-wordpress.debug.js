jQuery.fn.attrAppendWithComma = function (key, value) {
    var c;
    return this.each(function () {
        c = jQuery(this), void 0 !== c.attr(key) && "" != c.attr(key) ?
            c.attr(key, c.attr(key) + "," + value) :
            c.attr(key, value)
    });
};

jQuery.fn.footableAttr = function (tabletCount, phoneCount) {
    return this.each(function () {
        var $t = jQuery(this);
        if ($t.data("auto-columns") !== false) {
            $t.find("thead th:gt(" + tabletCount + ")").attrAppendWithComma("data-hide", "tablet");
            $t.find("thead th:gt(" + phoneCount + ")").attrAppendWithComma("data-hide", "phone");
        }
    });
};

jQuery.fn.footableFilter = function (searchText) {
    return this.each(function () {
        var $t = jQuery(this);
        if (!$t.data("filter") && $t.data("filter") !== false) {
            $t.data("filter-text-only","true")
                .before('<div class="footable-filter-container"><input placeholder="'+searchText+'" style="float:right" type="text" class="footable-filter" /></div>');
        }
    });
};

jQuery.fn.footablePager = function () {
    return this.each(function () {
        var $t = jQuery(this);
        if ($t.find(".pagination").length) return;
        if ($t.data("page") !== false) {
            var $pager = jQuery('<tfoot class="hide-if-no-paging"><tr><td><div class="pagination pagination-centered"></div></td></tr></tfoot>');
            $pager.find("td").attr("colspan", $t.find("thead th").length);
            $t.find("tbody:last").after($pager);
        }
    });
};