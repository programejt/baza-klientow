var form;

function setDisabledStatusInSection(section, status) {
  var form_elements = section.querySelectorAll('input, select, button');
  for (var i = 0, imax = form_elements.length; i < imax; ++i) {
    form_elements[i].disabled = status;
  }
}

function validateForm(form_elements) {
  let validaiton = true;

  let validators = {
    'zip_code': {regexp: /^\d{2}-\d{3}$/, errorText: 'Błędny kod pocztowy'},
    'phone_start': {regexp: /^(\+\d{2})?$/, errorText: 'Błędny numer kierunkowy'},
    'phone': {regexp: /^\d{9}$/, errorText: 'Błędny numer telefonu'},
    'email': {regexp: /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/, errorText: 'Nieprawidłowy email'},
    'person_id': {regexp: /^\d{11}$/, errorText: 'Błędny pesel'},
    'company_id': {regexp: /^\d{10}$/, errorText: 'Błędny nip'}
  };

  let form_el,
      form_value,
      validator;

  for (let i = 0, imax = form_elements.length; i < imax; ++i) {
    form_el = form_elements[i];

    switch (form_el.nodeName) {
      case 'INPUT':
      case 'SELECT': break;
      default: continue;
    }

    if (form_el.disabled) {
      continue;
    }

    form_value = form_el.value;

    if (form_value.trim() == '') {
      addErrorToFormSection(form_el, 'Pole nie może być puste');
      validaiton = false;
      continue;
    }

    validator = validators[form_el.name];
    if (validator != undefined) {
      if (! form_value.match(validator.regexp)) {
        addErrorToFormSection(form_el, validator.errorText);
        validaiton = false;
        continue;
      }
    }

    addErrorToFormSection(form_el, '');
  }

  return validaiton;
}

function setupFields(value) {
  let classes = ['only-for-person', 'only-for-company'],
      cls_index_to_show,
      cls_index_to_hide;

  switch (value) {
    case 'company':
      cls_index_to_show = 1;
      cls_index_to_hide = 0;
      break;
    case 'person':
      cls_index_to_show = 0;
      cls_index_to_hide = 1;
      break;
    default: return;
  }
  let to_show = document.getElementsByClassName(classes[cls_index_to_show]);
  let to_hide = document.getElementsByClassName(classes[cls_index_to_hide]);
  let i;

  for (i = 0, imax = to_show.length; i < imax; ++i) {
    to_show[i].style.display = '';
    setDisabledStatusInSection(to_show[i], false);
  }

  for (i = 0, imax = to_hide.length; i < imax; ++i) {
    to_hide[i].style.display = 'none';
    setDisabledStatusInSection(to_hide[i], true);
  }
}

function setupRadio() {
  let radio_inputs = document.getElementsByClassName('law-status-radio'),
      radio;

  for (var i = 0, imax = radio_inputs.length; i < imax; ++i) {
    radio = radio_inputs[i];
    if (radio.checked) {
      setupFields(radio.value);
    }
    radio.addEventListener('change', function () {
      setupFields(this.value);
    });
  }
}

function setupSelect() {
  let xhr = new XMLHttpRequest();

  xhr.open('get', '/api/regions');

  xhr.addEventListener('load', ev => {
    let data = JSON.parse(ev.target.responseText);

    let select = document.getElementById('select-region');
    let selected = select.getAttribute('data-val');
    let option;

    data.forEach(value => {
      option = document.createElement('option');
      option.value = value;
      option.textContent = value;
      if (selected == value) {
        option.selected = true;
      }
      select.appendChild(option);
    });
  });

  xhr.send();
}

function setupForm() {
  form.addEventListener('submit', function (ev) {
    ev.preventDefault();

    let form_elements = this.elements;

    if (validateForm(form_elements)) {
      let formdata = new FormData(form);
      let xhr = new XMLHttpRequest();
      xhr.open(this.method, this.action);
      xhr.setRequestHeader('X-CSRF-TOKEN', form_elements['_token'].value);
      xhr.addEventListener('load', function () {
        let res = JSON.parse(this.responseText);
        if (res.success) {
          window.location = '/client/' + res.id;
        } else {
          for (i = 0; i < form_elements.length; ++i) {
            addErrorToFormSection(form_elements[i], res.errors[form_elements[i].name] != undefined ? res.errors[form_elements[i].name] : '');
          }
        }
      });
      xhr.send(formdata);
    }
    return false;
  }, false);
}

function addErrorToFormSection(formElement, error) {
  let name = formElement.name + '-error';
  let container = formElement.parentElement.parentElement;
  let errorContainer = document.getElementById(name);
  if (errorContainer == null) {
    if (error == '') {
      return;
    }
    errorContainer = document.createElement('div');
    errorContainer.id = name;
    errorContainer.className = 'error';
    errorContainer.textContent = error;
    container.appendChild(errorContainer);
  } else {
    if (error == '') {
      container.removeChild(errorContainer);
    } else {
      errorContainer.textContent = error;
    }
  }
}

document.addEventListener('DOMContentLoaded', () => {
  form = document.getElementById('form-client');
  setupRadio();
  setupSelect();
  setupForm();

  form.querySelector('.cancel-form').addEventListener('click', function () {
    form.reset();
    setupFields(form['law_status'].value);
  }, false);
}, false);