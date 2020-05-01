define([
    'jquery',
    'Magento_Ui/js/form/form',
], function($, form) {
    'use strict';

    return form.extend({
        initialize: function () {
            this._super();

            return this;
        },

        getTitle() {
            return 'Homepage Form';
        },

        /**
         * Validates each element and returns true, if all elements are valid.
         */
        validate: function () {
            let isValid = true;

            for (let field of this.elems()) {
                let isNotInput = (typeof field.validate === 'undefined');
                isValid = isNotInput || field.validate().valid;

                if (!isValid && field.error()) {
                    break;
                }
            }

            if (false === isValid) {
                this.focusInvalid();
            }

            return isValid;
        },

        reset: function () {
            console.log('reset');

            this.source.trigger('data.reset');
            $('[data-bind*=datepicker]').val('');
        },
    });
});
