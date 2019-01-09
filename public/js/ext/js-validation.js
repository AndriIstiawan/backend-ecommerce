//add method validate "slugOnly"
jQuery.validator.addMethod("slugOnly", function (value, elem) {
    return /^[a-z0-9]+(?:-[a-z0-9]+)*$/.test(value);
});