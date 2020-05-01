define([
    'uiComponent',
    'uiRegistry',
], function (Component, registry) {
    'use strict';

    const KEY_COUNTRIES = 'timoffmax.dictionaries.countries';

    return Component.extend({
        defaults: {
            list: [],
        },

        initialize: function () {
            this._super();

            registry.set(KEY_COUNTRIES, this);
        },

        /**
         * Returns all the countries
         * @returns {*}
         */
        getList: function () {
            return this.list;
        },
    });
});
