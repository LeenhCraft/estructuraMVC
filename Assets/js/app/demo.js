function demo() {
  // Consultar política de contraseña
  // var url_pwd_policy = App.getRootUrl("/identity/v2.0/security-policies/");

  var pwd_minlength = 6; // El valor predeterminado de longitud más corta
  // $.ajax({
  //   type: "GET",
  //   async: false,
  //   url: url_pwd_policy + "pwd_minlength",
  //   success: function (data) {
  //     pwd_minlength = data.value;
  //   },
  // });
  var pwd_maxlength = 15; // La longitud máxima predeterminada
  // $.ajax({
  //   type: "GET",
  //   async: false,
  //   url: url_pwd_policy + "pwd_maxlength",
  //   success: function (data) {
  //     pwd_maxlength = data.value;
  //   },
  // });
  var pwd_include_num = false; // si debe incluir un número
  // $.ajax({
  //   type: "GET",
  //   async: false,
  //   url: url_pwd_policy + "pwd_include_num",
  //   success: function (data) {
  //     pwd_include_num = data.value;
  //   },
  // });
  var pwd_include_lowercase_letter = false; // si se deben incluir letras minúsculas
  // $.ajax({
  //   type: "GET",
  //   async: false,
  //   url: url_pwd_policy + "pwd_include_lowercase_letter",
  //   success: function (data) {
  //     pwd_include_lowercase_letter = data.value;
  //   },
  // });
  var pwd_include_uppercase_letter = false; // si debe incluir letras mayúsculas
  // $.ajax({
  //   type: "GET",
  //   async: false,
  //   url: url_pwd_policy + "pwd_include_uppercase_letter",
  //   success: function (data) {
  //     pwd_include_uppercase_letter = data.value;
  //   },
  // });
  var pwd_include_special_char = false; // si se deben incluir letras especiales
  // $.ajax({
  //   type: "GET",
  //   async: false,
  //   url: url_pwd_policy + "pwd_include_special_char",
  //   success: function (data) {
  //     pwd_include_special_char = data.value;
  //   },
  // });

  // detección china
  var regChineseCode = new RegExp("[\\u4E00-\\u9FFF]+", "g");
  jQuery.validator.addMethod(
    "isChineseCode",
    function (value, element) {
      return !regChineseCode.test(value);
    },
    "No se permite chino para la contraseña"
  );

  // Detección digital
  var regNum = /[0-9]/;
  jQuery.validator.addMethod(
    "includeNum",
    function (value, element) {
      return regNum.test(value);
    },
    "Debe contener números"
  );

  // detección de letras minúsculas
  var regLower = /[a-z]/;
  jQuery.validator.addMethod(
    "includeLowercaseLetter",
    function (value, element) {
      return regLower.test(value);
    },
    "Debe contener letras minúsculas"
  );

  // Detección de mayúsculas
  var regUpper = /[A-Z]/;
  jQuery.validator.addMethod(
    "includeUppercasecaseLetter",
    function (value, element) {
      return regUpper.test(value);
    },
    "Debe contener letras mayúsculas"
  );

  // Detección de caracteres especiales
  var regSpecial = /[^A-Za-z0-9]/;
  jQuery.validator.addMethod(
    "includeSpecialChar",
    function (value, element) {
      return regSpecial.test(value);
    },
    "Debe contener letras especiales"
  );

  // Inicializar elementos de configuración de verificación
  var validateOpts = {
    errorContainer: '',
    errorPlacement: "left bottom",
    rules: {},
    messages: {},
  };

  // Las reglas de verificación de contraseña originales
  validateOpts.rules["password" + suffix] = {
    required: true,
  };
  validateOpts.messages["password" + suffix] = {
    requerido: "Por favor complete la contraseña original",
  };

  // Nuevas reglas de verificación de contraseña
  validateOpts.rules["newPassword" + suffix] = {
    required: true,
    isChineseCode: true,
    minlength: pwd_minlength,
    maxlength: pwd_maxlength,
    notEqualTo: "#password" + suffix,
  };
  // De acuerdo con la política de seguridad de contraseña, se agregaron dinámicamente reglas de verificación
  if (pwd_include_lowercase_letter == "true") {
    validateOpts.rules["newPassword" + suffix].includeLowercaseLetter = true;
  }
  if (pwd_include_uppercase_letter == "true") {
    validateOpts.rules[
      "newPassword" + suffix
    ].includeUppercasecaseLetter = true;
  }
  if (pwd_include_special_char == "true") {
    validateOpts.rules["newPassword" + suffix].includeSpecialChar = true;
  }
  if (pwd_include_num == "true") {
    validateOpts.rules["newPassword" + suffix].includeNum = true;
  }
  // Reescribe el mensaje de solicitud
  validateOpts.messages["newPassword" + suffix] = {
    requerido: "Ingrese una nueva contraseña",
    notEqualTo:
      "La nueva contraseña no puede ser la misma que la contraseña original",
  };

  // Confirmar reglas de verificación de contraseña
  validateOpts.rules["confirmPassword" + suffix] = {
    required: true,
    isChineseCode: true,
    minlength: pwd_minlength,
    maxlength: pwd_maxlength,
    equalTo: "#newPassword" + suffix,
  };
  // De acuerdo con la política de seguridad de contraseña, se agregaron dinámicamente reglas de verificación
  if (pwd_include_lowercase_letter == "true") {
    validateOpts.rules[
      "confirmPassword" + suffix
    ].includeLowercaseLetter = true;
  }
  if (pwd_include_uppercase_letter == "true") {
    validateOpts.rules[
      "confirmPassword" + suffix
    ].includeUppercasecaseLetter = true;
  }
  if (pwd_include_special_char == "true") {
    validateOpts.rules["confirmPassword" + suffix].includeSpecialChar = true;
  }
  if (pwd_include_num == "true") {
    validateOpts.rules["confirmPassword" + suffix].includeNum = true;
  }
  // Reescribe el mensaje de solicitud
  validateOpts.messages["confirmPassword" + suffix] = {
    requerido: "Confirme la nueva contraseña",
    equalTo: "Las contraseñas ingresadas dos veces son diferentes",
  };

  // Reglas de validación vinculantes para el formulario
  var $form = $("#form-resetpwd");
  // $form.validate(validateOpts);
  console.log(validate(validateOpts));
}
