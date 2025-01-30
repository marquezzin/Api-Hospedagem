import { defineStore } from 'pinia';
import axios from 'axios';

export const usePhoneStore = defineStore('phone', {
  state: () => ({
    phones: [], // Armazena os dados do usuário logado
  }),

  actions: {
    // Obtém a reserva pelo id do guest
    async fetchPhone(guestId) {
      try {
        const response = await axios.get(`/api/guests/${guestId}/phones`, { withCredentials: true });
        this.phones = response.data; // Atualiza o estado do usuário
      } catch (error) {
        console.error('Erro ao buscar os telefones:', error.response?.data || error.message);
        this.phones = [];
      }
    }
    
  }

});

