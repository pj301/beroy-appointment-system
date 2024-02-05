// function clearPatient() {
//   const name = document.getElementById('name').value='';
//   const dob = document.getElementById('dob').value='';
//   const age = document.getElementById('age').value='';
//   const gender = document.getElementById('gender').value='';
//   const bloodType = document.getElementById('bloodType').value='';
//   const otherBloodType = document.getElementById('otherBloodType').value='';
// }
// function clearSchedule() {
//    const scheduleDate = document.getElementById('scheduleDate').value='';
//   const status = document.getElementById('status').value='';
// }
document.getElementById('patientButton').addEventListener("click", function () {
    document.getElementById('patientList').style.display = "none";
    document.getElementById('patientForm').style.display = "block";
    document.getElementById('scheduleForm').style.display = "none";
});

document.getElementById('scheduleButton').addEventListener("click", function () {
    document.getElementById('patientList').style.display = "none";
    document.getElementById('patientForm').style.display = "none";
    document.getElementById('scheduleForm').style.display = "block";
});

document.getElementById('patientListButton').addEventListener("click", function () {
    document.getElementById('patientList').style.display = "block";
    document.getElementById('patientForm').style.display = "none";
    document.getElementById('scheduleForm').style.display = "none";
});

document.getElementById('appointmentJoinButton').addEventListener("click", function () {
    document.getElementById('patientList').style.display = "none";
    document.getElementById('patientForm').style.display = "none";
    document.getElementById('scheduleForm').style.display = "none";
});

function addPatient() {
  document.getElementById('patientForm').style.display = "block";
  document.getElementById('patientList').style.display = "none";
}

function checkBloodType() {
const bloodTypeSelect = document.getElementById('bloodType');
const otherBloodTypeContainer = document.getElementById('otherBloodTypeContainer');
const otherBloodTypeInput = document.getElementById('otherBloodType');

if (bloodTypeSelect.value === 'other') {
  otherBloodTypeContainer.style.display = 'block';
  otherBloodTypeInput.required = true;
} else {
  otherBloodTypeContainer.style.display = 'none';
  otherBloodTypeInput.required = false;
}
}

document.getElementById('patient').addEventListener('submit', function (event) {
const name = document.getElementById('name').value;
const email = document.getElementById('email').value;
const dob = document.getElementById('dob').value;
const age = document.getElementById('age').value;
const gender = document.getElementById('gender').value;
const bloodTypeSelect = document.getElementById('bloodType');
const otherBloodType = document.getElementById('otherBloodType').value;

const selectedBloodType = otherBloodType || bloodTypeSelect.value;

if (name && email && dob && age && gender && (selectedBloodType !== '' && ((selectedBloodType !== 'other') || (selectedBloodType === 'other' && otherBloodType.value === selectedBloodType)))) {
  document.getElementById('scheduleForm').style.display = "block";
  document.getElementById('patientForm').style.display = "none";
  document.getElementById('patientForm').style.display = "none";
  // alert("");
} else {
  const errorMessage = document.getElementById('errorMessage');
  errorMessage.innerHTML = "Please fill in all fields";
  event.preventDefault(); // Prevent form submission
}
});


document.getElementById('schedule').addEventListener('submit', function (event) {
  const date = document.getElementById('scheduleDate').value; // Updated ID
  const time = document.getElementById('scheduleTime').value;
  const status = document.getElementById('status').value;
  const errorMessage = document.getElementById('errorMessage'); // Declare errorMessage

  if (!date || !time || !status) {
    errorMessage.innerHTML = "Please fill in all fields";
  } else {
    errorMessage.innerHTML = "Submitted";
  }
});

function calculateAge() {
  const dobInput = document.getElementById('dob');
  const ageInput = document.getElementById('age');
  const dobValue = dobInput.value;

  if (dobValue) {
    const dob = new Date(dobValue);
    const today = new Date();
    const age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));
    ageInput.value = age;
  } else {
    ageInput.value = '';
  }
}

function checkBloodType() {
  const bloodTypeSelect = document.getElementById('bloodType');
  const otherBloodTypeContainer = document.getElementById('otherBloodTypeContainer');
  const otherBloodTypeInput = document.getElementById('otherBloodType');

  if (bloodTypeSelect.value === 'other') {
    otherBloodTypeContainer.style.display = 'block';
    otherBloodTypeInput.required = true;
  } else {
    otherBloodTypeContainer.style.display = 'none';
    otherBloodTypeInput.required = false;
  }
}

