jQuery(document).ready(function () {
    var $teamRuleForm = $('#team-rule-choice');

    $teamRuleForm.each(function(i, el) {
        $('input[name="team_rules_selector_form[rule]', el).on('change', function() {
            $('input[name="team_rules_selector_form[championship]"]', el).first().prop( "checked", true );
        });
        $('input[name="team_rules_selector_form[championship]', el).on('change', function() {
            $('input[name="team_rules_selector_form[rule]"]', el).first().prop( "checked", true );
        });
        $('select.dropdown', el)
            .dropdown()
        ;
    });
});