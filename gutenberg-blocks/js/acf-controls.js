const sleep = (delay) => new Promise((resolve) => setTimeout(resolve, delay));

// Reset value of display title to null when Reset Title button is clicked
const resetTitle = async function (response, $el) {
  const inputField = $el.parent().find('[data-name=title] input');
  inputField.val(' ');
  inputField.keyup();
  sleep(100);
  inputField.val('');
  inputField.keyup();
};

acf.addAction('acfe/fields/button/success/name=refresh_title', resetTitle);
