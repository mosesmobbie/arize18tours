function initBookingForm() {
  var form = document.querySelector('#booking form');
  var serviceTypeSelect = document.querySelector('select[name="service_type"]');
  var bookingTabs = Array.prototype.slice.call(document.querySelectorAll('.booking-tab'));
  var vehicleTypeSelect = document.querySelector('select[name="vehicle_type"]');
  var nameInput = document.querySelector('input[name="name"]');
  var emailInput = document.querySelector('input[name="email"]');
  var phoneInput = document.querySelector('input[name="phone"]');
  var pickupAddressInput = document.querySelector('input[name="pickup_address"]');
  var dropoffAddressInput = document.querySelector('input[name="dropoff_address"]');
  var pickupDateInput = document.querySelector('input[name="pickup_date"]');
  var pickupTimeDisplayInput = document.querySelector('[name="pickup_time_display"]');
  var pickupTimeInput = document.querySelector('input[name="pickup_time"]');
  var dropoffDateInput = document.querySelector('input[name="dropoff_date"]');
  var dropoffTimeDisplayInput = document.querySelector('[name="dropoff_time_display"]');
  var dropoffTimeInput = document.querySelector('input[name="dropoff_time"]');
  var passengersInput = document.querySelector('input[name="passengers"]');
  var transmissionInput = document.querySelector('[name="transmission"]');
  var flightNumberInput = document.querySelector('input[name="flight_number"]');
  var reservationNumberInput = document.querySelector('input[name="reservation_number"]');
  var idNumberInput = document.querySelector('input[name="id_number"]');
  var notesInput = document.querySelector('input[name="notes"]');
  var passengersRow = document.getElementById('field-passengers-row');
  var dropoffAddressRow = document.getElementById('field-dropoff-address-row');
  var dropoffDateRow = document.getElementById('field-dropoff-date-row');
  var dropoffTimeRow = document.getElementById('field-dropoff-time-row');
  var transmissionRow = document.getElementById('field-transmission-row');
  var flightNumberRow = document.getElementById('field-flight-number-row');
  var reservationNumberRow = document.getElementById('field-reservation-number-row');
  var idNumberRow = document.getElementById('field-id-number-row');
  var dropoffAddressLabel = document.getElementById('dropoff-address-label');
  var dropoffDateLabel = document.getElementById('dropoff-date-label');
  var dropoffTimeLabel = document.getElementById('dropoff-time-label');

  if (!serviceTypeSelect || !form) {
    return;
  }

  var baseRequiredFields = [
    serviceTypeSelect,
    vehicleTypeSelect,
    nameInput,
    emailInput,
    phoneInput,
    pickupAddressInput,
    pickupDateInput,
    pickupTimeDisplayInput,
    notesInput,
  ];

  function setVisible(element, isVisible) {
    if (!element) {
      return;
    }

    element.style.display = isVisible ? '' : 'none';
  }

  function setRequired(field, isRequired) {
    if (!field) {
      return;
    }

    field.required = isRequired;
  }

  function setFieldState(row, field, isVisible, isRequired) {
    setVisible(row, isVisible);
    setRequired(field, isVisible && isRequired);
  }

  function setBaseRequiredFields() {
    baseRequiredFields.forEach(function (field) {
      setRequired(field, true);
    });
  }

  function validateSouthAfricanPhone() {
    if (!phoneInput) {
      return;
    }

    var phonePattern = /^0[6-8][0-9]{8}$/;
    var phoneValue = phoneInput.value.trim();

    if (phoneValue.length === 0 || phonePattern.test(phoneValue)) {
      phoneInput.setCustomValidity('');
      return;
    }

    phoneInput.setCustomValidity('Enter a valid South African phone number (e.g. 0821234567).');
  }

  function validateNameLength() {
    if (!nameInput) {
      return;
    }

    var nameValue = nameInput.value.trim();

    if (nameValue.length === 0) {
      nameInput.setCustomValidity('');
      return;
    }

    if (nameValue.length < 5 || nameValue.length > 75) {
      nameInput.setCustomValidity('Name must be between 5 and 75 characters.');
      return;
    }

    nameInput.setCustomValidity('');
  }

  function validatePassengers() {
    if (!passengersInput) {
      return;
    }

    var serviceType = serviceTypeSelect.value;
    var isVisible = serviceType !== 'car-hire';
    var isRequired = serviceType === 'tours_safaris' || serviceType === 'trips';
    var value = passengersInput.value.trim();

    if (!isVisible) {
      passengersInput.setCustomValidity('');
      return;
    }

    if (isRequired && value.length === 0) {
      passengersInput.setCustomValidity('Passengers is required for this service type.');
      return;
    }

    if (value.length > 0 && !/^\d+$/.test(value)) {
      passengersInput.setCustomValidity('Passengers must be a whole number.');
      return;
    }

    passengersInput.setCustomValidity('');
  }

  function isValidSouthAfricanIdNumber(value) {
    if (!/^\d{13}$/.test(value)) {
      return false;
    }

    var yearPart = parseInt(value.substring(0, 2), 10);
    var month = parseInt(value.substring(2, 4), 10);
    var day = parseInt(value.substring(4, 6), 10);
    var currentYearTwoDigits = new Date().getFullYear() % 100;
    var fullYear = yearPart <= currentYearTwoDigits ? 2000 + yearPart : 1900 + yearPart;
    var date = new Date(fullYear, month - 1, day);

    if (
      date.getFullYear() !== fullYear ||
      date.getMonth() !== month - 1 ||
      date.getDate() !== day
    ) {
      return false;
    }

    var oddSum = 0;
    for (var i = 0; i < 12; i += 2) {
      oddSum += parseInt(value.charAt(i), 10);
    }

    var evenDigits = '';
    for (var j = 1; j < 12; j += 2) {
      evenDigits += value.charAt(j);
    }

    var evenNumber = (parseInt(evenDigits, 10) * 2).toString();
    var evenSum = 0;

    for (var k = 0; k < evenNumber.length; k++) {
      evenSum += parseInt(evenNumber.charAt(k), 10);
    }

    var total = oddSum + evenSum;
    var checkDigit = (10 - (total % 10)) % 10;

    return checkDigit === parseInt(value.charAt(12), 10);
  }

  function validateIdOrPassport() {
    if (!idNumberInput) {
      return;
    }

    var serviceType = serviceTypeSelect.value;
    var isVisible = serviceType === 'car-hire';
    var value = idNumberInput.value.trim();

    if (!isVisible || value.length === 0) {
      idNumberInput.setCustomValidity('');
      return;
    }

    var isValidSouthAfricanId = isValidSouthAfricanIdNumber(value);
    var isValidPassport = /^[A-Za-z]\d{9}$/.test(value);

    if (!isValidSouthAfricanId && !isValidPassport) {
      idNumberInput.setCustomValidity('Enter a valid South African ID number or a passport number (letter + 9 digits).');
      return;
    }

    idNumberInput.setCustomValidity('');
  }

  function validateBeforeSubmit() {
    updateConditionalFields();
    validateNameLength();
    validateSouthAfricanPhone();
    validatePassengers();
    validateIdOrPassport();
    syncPickupDateTime();
    syncDropoffDateTime();

    return form.checkValidity();
  }

  function syncPickupDateTime() {
    if (!pickupTimeInput) {
      return;
    }

    var pickupDate = pickupDateInput ? pickupDateInput.value.trim() : '';
    var pickupTime = pickupTimeDisplayInput ? pickupTimeDisplayInput.value.trim() : '';

    if (pickupDate && pickupTime) {
      pickupTimeInput.value = pickupDate + 'T' + pickupTime;
      return;
    }

    pickupTimeInput.value = '';
  }

  function syncDropoffDateTime() {
    if (!dropoffTimeInput) {
      return;
    }

    var dropoffDate = dropoffDateInput ? dropoffDateInput.value.trim() : '';
    var dropoffTime = dropoffTimeDisplayInput ? dropoffTimeDisplayInput.value.trim() : '';

    if (dropoffDate && dropoffTime) {
      dropoffTimeInput.value = dropoffDate + 'T' + dropoffTime;
      return;
    }

    dropoffTimeInput.value = '';
  }

  function updateConditionalFields() {
    var serviceType = serviceTypeSelect.value;
    var passengersRequired = serviceType === 'tours_safaris' || serviceType === 'trips';
    var isCarHire = serviceType === 'car-hire';
    var hasDropoffAddress = serviceType === 'airport-transfers' || serviceType === 'hotel-transfers';

    setBaseRequiredFields();

    setFieldState(dropoffAddressRow, dropoffAddressInput, hasDropoffAddress, true);
    setFieldState(dropoffDateRow, dropoffDateInput, isCarHire, true);
    setFieldState(dropoffTimeRow, dropoffTimeDisplayInput, isCarHire, true);
    setFieldState(passengersRow, passengersInput, serviceType !== 'car-hire', passengersRequired);
    setFieldState(transmissionRow, transmissionInput, serviceType === 'car-hire', true);
    setFieldState(flightNumberRow, flightNumberInput, serviceType === 'airport-transfers', true);
    setFieldState(reservationNumberRow, reservationNumberInput, serviceType === 'hotel-transfers', true);
    setFieldState(idNumberRow, idNumberInput, serviceType === 'car-hire', true);

    if (passengersInput && serviceType === 'car-hire') {
      passengersInput.value = '';
    }

    if (dropoffAddressInput && !hasDropoffAddress) {
      dropoffAddressInput.value = '';
      dropoffAddressInput.setCustomValidity('');
    }

    if (dropoffDateInput && !isCarHire) {
      dropoffDateInput.value = '';
    }

    if (dropoffTimeDisplayInput && !isCarHire) {
      dropoffTimeDisplayInput.value = '';
      dropoffTimeDisplayInput.setCustomValidity('');
    }

    if (dropoffTimeInput && !isCarHire) {
      dropoffTimeInput.value = '';
      dropoffTimeInput.setCustomValidity('');
    }

    if (idNumberInput && serviceType !== 'car-hire') {
      idNumberInput.setCustomValidity('');
    }

    if (dropoffAddressLabel) {
      if (serviceType === 'airport-transfers') {
        dropoffAddressLabel.textContent = 'Airport Name';
      } else if (serviceType === 'hotel-transfers') {
        dropoffAddressLabel.textContent = 'Hotel Name';
      } else {
        dropoffAddressLabel.textContent = 'Drop Off Address';
      }
    }

    if (dropoffDateLabel) {
      dropoffDateLabel.textContent = serviceType === 'car-hire' ? 'Return Date' : 'Drop Off Date';
    }

    if (dropoffTimeLabel) {
      dropoffTimeLabel.textContent = serviceType === 'car-hire' ? 'Return Time' : 'Drop Off Time';
    }

    syncDropoffDateTime();
    validateSouthAfricanPhone();
    validateIdOrPassport();
  }

  function updateActiveTab(serviceType) {
    if (!bookingTabs.length) {
      return;
    }

    bookingTabs.forEach(function (tab) {
      var isActive = tab.getAttribute('data-service-type') === serviceType;
      tab.classList.toggle('active', isActive);
    });
  }

  function selectServiceType(serviceType) {
    if (!serviceTypeSelect) {
      return;
    }

    var optionExists = Array.prototype.some.call(serviceTypeSelect.options, function (option) {
      return option.value === serviceType;
    });

    if (!optionExists) {
      return;
    }

    serviceTypeSelect.value = serviceType;
    updateConditionalFields();
    updateActiveTab(serviceType);
  }

  if (phoneInput) {
    phoneInput.setAttribute('pattern', '^0[6-8][0-9]{8}$');
    phoneInput.addEventListener('input', validateSouthAfricanPhone);
  }

  if (nameInput) {
    nameInput.addEventListener('input', validateNameLength);
  }

  if (passengersInput) {
    passengersInput.addEventListener('input', validatePassengers);
  }

  if (idNumberInput) {
    idNumberInput.addEventListener('input', validateIdOrPassport);
  }

  if (emailInput) {
    emailInput.addEventListener('input', function () {
      if (emailInput.validity.typeMismatch) {
        emailInput.setCustomValidity('Enter a valid email address.');
        return;
      }

      emailInput.setCustomValidity('');
    });
  }

  if (pickupDateInput) {
    pickupDateInput.addEventListener('input', syncPickupDateTime);
  }

  if (pickupTimeDisplayInput) {
    pickupTimeDisplayInput.addEventListener('input', syncPickupDateTime);
  }

  if (dropoffDateInput) {
    dropoffDateInput.addEventListener('input', syncDropoffDateTime);
  }

  if (dropoffTimeDisplayInput) {
    dropoffTimeDisplayInput.addEventListener('input', syncDropoffDateTime);
  }

  updateConditionalFields();
  updateActiveTab(serviceTypeSelect.value);
  syncPickupDateTime();
  syncDropoffDateTime();

  serviceTypeSelect.addEventListener('change', function () {
    updateConditionalFields();
    updateActiveTab(serviceTypeSelect.value);
  });

  bookingTabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      var serviceType = tab.getAttribute('data-service-type');
      selectServiceType(serviceType);
    });
  });

  form.addEventListener('submit', function (event) {
    if (!validateBeforeSubmit()) {
      event.preventDefault();
      form.reportValidity();
    }
  });
}

document.addEventListener('DOMContentLoaded', initBookingForm);
