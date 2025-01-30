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
     // Criar uma nova reserva (guestId é passado como parâmetro)
    async createReservation({ checkin_date, checkout_date }, guestId) {
      try {
        if (!guestId) {
          throw new Error('O ID do hóspede deve ser fornecido pelo componente.');
        }

        // Criar reserva
        const response = await axios.post('/api/reservations', {
          checkin_date,
          checkout_date,
        });

        const reservation = response.data; 
        const reservationId = reservation.data?.id; 

        await this.addTitularToReservation(reservationId, guestId, 'TITULAR');

        this.reservations.push(reservation);
        return reservation;
      } catch (error) {
        console.error('Erro ao criar reserva:', error);
        throw error;
      }
    },

    // Adicionar hóspede a uma reserva existente (guestId é passado pelo componente)
    async addTitularToReservation(reservationId, guestId, type = 'TITULAR') {
      try {
        const response = await axios.post(`/api/reservations/${reservationId}/guests/${guestId}/add-guest`, {
          type,
        });

        return response.data;
      } catch (error) {
        console.error('Erro ao adicionar hóspede à reserva:', error);
        throw error;
      }
    }
  }

});

