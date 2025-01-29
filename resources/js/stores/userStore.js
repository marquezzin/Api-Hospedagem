import { defineStore } from 'pinia';
import axios from 'axios';


export const useUserStore = defineStore('user', {
  state: () => ({
    user: null, // Armazena os dados do usuário logado
  }),

  actions: {
    // Realiza o login do usuário
    async login(credentials) {
      try {
        // Obtém o token CSRF
        await axios.get('/sanctum/csrf-cookie', { withCredentials: true }); 

        // Faz o login e armazena os dados do usuário
        const response = await axios.post('/login', credentials, {
          headers: {
            'Accept': 'application/json',
          },
          withCredentials: true,
        });

        if (response.status === 200) {
          this.user = response.data.user; // Atualiza o estado do usuário
          return true;
        }
      } catch (error) {
        console.error('Erro ao realizar login:', error.response?.data || error.message);
        throw error;
      }
    },

    //Realiza o logout do usuário
    async logout() {
        try {
        // Obtém o token CSRF antes de fazer o logout
        await axios.get('/sanctum/csrf-cookie', { withCredentials: true });

        // Faz a requisição de logout
        const response = await axios.post('/logout', {}, {
            headers: {
            'Accept': 'application/json',
            },
            withCredentials: true,
        });

        if (response.status === 204) {
            this.user = null; // Reseta o estado do usuário
                       
            return true;
        }
        } catch (error) {
        console.error('Erro ao realizar logout:', error.response?.data || error.message);
        throw error;
        }
    },

    // Obtém o usuário autenticado ao carregar a aplicação
    async fetchUser() {
      try {
        const response = await axios.get('/api/user', { withCredentials: true });
        this.user = response.data; // Atualiza o estado do usuário
      } catch (error) {
        console.error('Erro ao buscar usuário autenticado:', error.response?.data || error.message);
        this.user = null;
      }
    },
  },

  getters: {
    // Verifica se o usuário está autenticado
    isAuthenticated: (state) => !!state.user,
  },
});


//OBS: Quando você faz uma requisição ao endpoint /sanctum/csrf-cookie, o Laravel retorna um cookie chamado XSRF-TOKEN que será usado para proteger requisições futuras.
//     Para que o navegador armazene esse cookie, a requisição ao /sanctum/csrf-cookie precisa incluir withCredentials: true