Converter = {
    fields: {},
    originalValue: '',
    formulas: {
        //all values will be converted into centimeter
        length: {
            inch: {
                from: 2.54,
                to: 0.3937007874
            },
            foot: {
                from: 30.48,
                to: 0.032808399
            },
            yard: {
                from: 91.44,
                to: 0.010936133
            },
            mile: {
                from: 160935,
                to: 0.0000062137
            },
            meter: {
                from: 100,
                to: 0.01
            },
            kilometer: {
                from: 1000,
                to: 0.001
            },
            centimeter: {
                from: 1,
                to: 1
            }
        },
        //convert all weight into grams
        weight: {
            pound: {
                from: 453.592,
                to: 0.0022046244
            },
            ounce: {
                from: 28.3495,
                to: 0.0352739907
            },
            carrat: {
                from: 5,
                to: 0.2
            },
            kilogram: {
                from: 1000,
                to: 0.001
            },
            gram: {
                from: 1,
                to: 1
            }
        }
    },
    init: function () {
        for (key in this.fields) {
            this.attacheEvent(this.fields[key]);
        }
    },
    attacheEvent(element) {
        setTimeout(function () {
            if (jQuery("input[name=" + element.field_name + "]").length) {

                //add new attributes for type and unit
                jQuery("input[name=" + element.field_name + "]").attr("data-type", element.type);
                jQuery("input[name=" + element.field_name + "]").attr("data-unit", element.unit);
                jQuery("input[name=" + element.field_name + "]").keyup(function () {
                    var value = jQuery(this).val();
                    var name = jQuery(this).attr("name");
                    var type = jQuery(this).attr("data-type");
                    var unit = jQuery(this).attr("data-unit");
                    Converter.processEvent(name, type, unit, value);
                });
            }
        }, 100);
    },
    processEvent: function (name, type, unit, value) {
        Converter.processOriginalValue(value, type, unit)
        jQuery("[data-type=" + type + "]").each(function (index, item) {
            if (name != jQuery(item).attr('name')) {
                var t = jQuery(item).data("type");
                var u = jQuery(item).data("unit");
                jQuery(item).val(parseFloat(Math.round(Converter.originalValue * Converter.formulas[t][u].to * 10000) / 10000).toFixed(4));
            }
        });
    },
    processOriginalValue: function (value, type, unit) {
        Converter.originalValue = value * Converter.formulas[type][unit].from;
    }
}