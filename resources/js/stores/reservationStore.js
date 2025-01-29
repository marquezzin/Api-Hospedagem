import { defineStore } from 'pinia';
import axios from 'axios';

export const useReservationStore = defineStore('reservation', {
  state: () => ({
    reservations: [], // Armazena os dados do usuário logado
  }),

  actions: {
    // Obtém a reserva pelo id do guest
    async fetchReservation(id) {
      try {
        const response = await axios.get(`/api/guests/${id}/reservations`, { withCredentials: true });
        this.reservations = response.data; // Atualiza o estado do usuário
      } catch (error) {
        console.error('Erro ao buscar a reserva:', error.response?.data || error.message);
        this.reservations = [];
      }
    },
  }

  
});

