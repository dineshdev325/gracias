import './bootstrap';

const phoneInputField = document.querySelector("#phone");
function getIp(callback) {
fetch('https://ipinfo.io/json?token=af99e3dad456d9', { headers: { 'Accept': 'application/json' }})
 .then((resp) => resp.json())
 .catch(() => {
 return {
 country: 'us',
 };
 })
 .then((resp) => callback(resp.country));
 }
const phoneInput = window.intlTelInput(phoneInputField, {
 initialCountry: "auto",
 geoIpLookup: getIp,
 utilsScript:
 "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
 });

Livewire.on('process',(event)=>{

const phoneNumber = phoneInput.getNumber();
let component = Livewire.first()
component.phoneNumber=phoneNumber})
