jQuery(function() {
    // GOGOGO
    /*
     * HEADER
     */
    $('#header').each(function(i, header) {

        $('#account', header).each(function(j, account) {
           $('.title', account).click(function() {
               $(account).toggleClass('open');
           });
        });
        $('#navigation', header).each(function(j, nav) {
           $('.league-icon', nav).click(function() {
               $(nav).toggleClass('open');
           });
        });
    });
    /*
     * DASHBOARD
     */
    $('#dashboard').each(function(base_el, dashboard) {
        $('.dashboard-chart', dashboard).each(function(i, chart_el) {
            var chartId = $(chart_el).attr('id');
            var title = $(chart_el).attr('chart-title');
            var datas = JSON.parse($(chart_el).attr('chart-data'));
            var chart = AmCharts.makeChart(chartId, {
                "type": "serial",
                "categoryField": "label",
                "fontFamily": "Lato, Verdana, sans-serif",
                "categoryAxis": {
                    "axisAlpha": 0.2,
                    "gridAlpha": 0.5,
                    "gridThickness": 0,
                    "startOnAxis": true
                },
                "valueAxes": [{
                    "axisAlpha": 0.2,
                    "precision": 0
                }],
                "titles": [
                    {
                        "text": title,
                        "bold": false,
                        "size": 18
                    }
                ],
                "graphs": [{
                    "bullet": "round",
                    "bulletBorderAlpha": 1,
                    "bulletColor": "#FFFFFF",
                    "bulletSize": 12,
                    //"type": "smoothedLine",
                    "valueField": "value"
                }],
                "allLabels": [],
                "dataProvider": datas
            });
        });
    });
    /*
     * TEAM SHEET
     */
    $('#team-sheet').each(function(base_el, sheet) {

    });
    /*
     * FORM COMPONENTS
     */
    $('#content-form').each(function(base_el, form) {
        $('select.dropdown', form)
          .dropdown()
        ;
        $('form', form).attr('novalidate', 'novalidate');
    });
});
