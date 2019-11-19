(function ($) {
    function addToProperties(term, label) {
        var id = 'hproperty-' + term;
        if (document.getElementById(id)) {
            return;
        }
        var hPropertyRow = $('<div class="h-property row"></div>');
        hPropertyRow.attr('id', id);
        hPropertyRow.append($('<span>', {'class': 'property-label', 'text': label}));
        hPropertyRow.append($('<ul class="actions"><li><a class="o-icon-delete remove-h-property" href="#"></a></li></ul>'));
        hPropertyRow.append($('<input>', {'type': 'h', 'name': 'h-properties[]', 'value': term}));
        $('#hier-properties-list').append(hPropertyRow);
    }
    function hierProperty(propertySelectorChild) {
        var term = $(propertySelectorChild).data('propertyTerm');
        var label = $(propertySelectorChild).data('childSearch');
        addToProperties(term, label);
    }
    $(document).ready(function () {
        $('#property-selector li.selector-child').on('click', function(e) {
            e.stopPropagation();
            hierProperty(this);
        });
        $('#hier-properties-list').on('click', '.remove-h-property', function (e) {
            e.preventDefault();
            $(this).closest('.h-property').remove();
        });
        $.each($('#hier-properties-list').data('hProperties'), function(index, value) {
            var propertySelectorChild = $('#property-selector li.selector-child[data-property-term="' + value + '"]');
            if (propertySelectorChild.length) {
                hierProperty(propertySelectorChild);
            }
        });
    });
})(jQuery);