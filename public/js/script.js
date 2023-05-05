// pour que le défilement s'arrête sur le mot "parfaite"
// mots à afficher
/* let mots = ["de marche", "de course", "de trail", "parfaite"];

// récupération de l'élément du texte
let texteElement = document.getElementById("parfaite-texte");

// fonction pour changer le texte
function changerTexte(index) {
  // arrêt de l'animation sur "parfaite"
  if (index === mots.length) {
    texteElement.textContent = mots[mots.length - 1];
    return;
  }

  // mise à jour du texte avec le mot suivant
  texteElement.textContent = mots[index];

  // fonction pour passer au mot suivant
  setTimeout(function () {
    changerTexte(index + 1);
  }, 1250);
}

// pour commencer le défilement
changerTexte(0);

/* DÉFILEMENT DES MOTS SUR LA HOME PAGE */
// mots à afficher
let mots = ["de marche", "de course", "de trail", "parfaite"];

// récupération de l'élément du texte
let texteElement = document.getElementById("parfaite-texte");

// fonction pour changer le texte
function changerTexte(index) {
  // mise à jour du texte avec le mot suivant
  texteElement.textContent = mots[index];

  // fonction pour passer au mot suivant
  setTimeout(function () {
    // incrementer l'index pour passer au mot suivant
    index = (index + 1) % mots.length;
    changerTexte(index); // appeler récursivement la fonction avec le nouvel index
  }, 1250);
}

// pour commencer le défilement
changerTexte(0);
