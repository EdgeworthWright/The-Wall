// Krijg modale vensters
const modaalContent = document.querySelectorAll('.modaalContent');

// Verwijder modaal content uit DOM
for (let i = 0; i < modaalContent.length; i++) {
  let modaalNode = modaalContent[i];
  modaalNode.parentElement.removeChild(modaalNode);
}

// Nodelist knoppen
const modaalKnoppen = document.querySelectorAll('.modaalKnop');
const modaalKnoppenArray = [];

// Node elementen aanmaken in vars
let modaalAchtergrond = document.createElement('div');
modaalAchtergrond.className = "modaalAchtergrond";
let modaal = document.createElement('div');
modaal.className = "modaal";
let modaalSluitKnop = document.createElement('button');
modaalSluitKnop.className = "sluitKnop";
modaalSluitKnop.innerHTML = "&#x00D7";

// Voeg content terug
const voegInhoudToe = (event) => {
  document.body.style.overflow = "hidden";
  const teller = modaalKnoppenArray.indexOf(event.target);
  console.log(teller);
  modaal.appendChild(modaalSluitKnop);
  modaal.appendChild(modaalContent[teller]);
  modaalAchtergrond.appendChild(modaal);
  document.body.appendChild(modaalAchtergrond);
}

for (let i = 0; i < modaalKnoppen.length; i++) {
  modaalKnoppenArray.push(modaalKnoppen[i]);
  modaalKnoppen[i].addEventListener('click', voegInhoudToe);
}

// Sluit modaal
const sluitModaal = () => {
  document.body.style.overflow = "auto";
  modaalAchtergrond.innerHTML = '';
  modaal.innerHTML = '';
  document.body.removeChild(modaalAchtergrond);
}

modaalSluitKnop.addEventListener('click', sluitModaal);
