/**
 * Il nous faut une fonction pour récupérer le JSON des
 * messages et les afficher correctement
 */
function getMessages(){
  // Rrequête AJAX pour se connecter au serveur, et notamment au fichier handler.php
  const requeteAjax = new XMLHttpRequest();
  requeteAjax.open("GET", "handler.php");

  // Elle reçoit les données, il faut qu'elle les traite (en exploitant le JSON) et il faut qu'elle affiche ces données au format HTML
  requeteAjax.onload = function(){
    const resultat = JSON.parse(requeteAjax.responseText);
    const html = resultat.reverse().map(function(message){
      return `
        <div class="message">
          <span class="date">${message.created_at.substring(11, 16)}</span>
          <span class="author">${message.author}</span> : 
          <span class="content">${message.content}</span>
        </div>
      `
    }).join('');

    const messages = document.querySelector('.messages');

    messages.innerHTML = html;
    messages.scrollTop = messages.scrollHeight;
  }

  //  On envoie la requête
  requeteAjax.send();
}

/**
 * Il nous faut une fonction pour envoyer le nouveau
 * message au serveur et rafraichir les messages
 */

function postMessage(event){
  // Elle  stoppe le submit du formulaire
  event.preventDefault();

  //  Elle récupére les données du formulaire
  const author = document.querySelector('#author');
  const content = document.querySelector('#content');

  // Elle conditionne les données
  const data = new FormData();
  data.append('author', author.value);
  data.append('content', content.value);

  // Elle doit configurer une requête ajax en POST et envoyer les données
  const requeteAjax = new XMLHttpRequest();
  requeteAjax.open('POST', 'handler.php?task=write');
  
  requeteAjax.onload = function(){
    content.value = '';
    content.focus();
    getMessages();
  }

  requeteAjax.send(data);
}

document.querySelector('form').addEventListener('submit', postMessage);

/**
 * Il nous faut une intervale qui demande le rafraichissement
 * des messages toutes les 3 secondes et qui donne 
 * l'illusion du temps réel.
 */
const interval = window.setInterval(getMessages, 3000);

getMessages();