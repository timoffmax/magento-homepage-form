define([
    'Magento_Ui/js/form/element/select',
    'uiRegistry',
    'Timoffmax_HomepageForm/js/dictionary/countries',
], function (Field, registry) {
    'use strict';

    return Field.extend({
        initialize: function () {
            this._super();

            let countriesDictionary = registry.get('timoffmax.dictionaries.countries');
            let countries = countriesDictionary.getList();

            this.options(countries);
        },
    });
});
