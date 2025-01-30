// resources/js/fontawesome.js
import { library } from '@fortawesome/fontawesome-svg-core';
import { faUser, faSignOutAlt, faBars } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

// Adiciona os ícones à biblioteca
library.add(faUser, faSignOutAlt, faBars);

export default FontAwesomeIcon;
