define([
    'Magento_Ui/js/form/element/single-checkbox',
], function (Field) {
    'use strict';

    return Field.extend({
        initialize: function () {
            this._super();

            let isChecked = (Math.random() >= 0.5);
            this.initialValue = isChecked;

            if (true === isChecked) {
                this.value(isChecked);
            }
        },
    });
});
